from __future__ import annotations

from app.models import MovementType
from app.services.products import create_product, ProductData


def test_list_products_api(client):
    with client.application.app_context():
        create_product(ProductData(name="Teclado", description="Mecânico", minimum_stock=1))
    response = client.get("/api/products")
    assert response.status_code == 200
    payload = response.get_json()
    assert any(item["name"] == "Teclado" for item in payload)


def test_create_movement_api(client):
    with client.application.app_context():
        product = create_product(
            ProductData(name="Headset", description="", minimum_stock=1)
        )
        product_id = product.id
    response = client.post(
        "/api/movements",
        json={
            "product_id": product_id,
            "movement_type": MovementType.ENTRY.value,
            "quantity": 5,
        },
    )
    assert response.status_code == 201
    body = response.get_json()
    assert "id" in body
