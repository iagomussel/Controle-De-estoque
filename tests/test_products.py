from __future__ import annotations

from app.models import MovementType
from app.services import movements as movement_service
from app.services.movements import MovementData
from app.services.products import ProductData, create_product, list_products


def test_create_product(client):
    with client.application.app_context():
        data = ProductData(name="Notebook", description="Dell XPS", minimum_stock=2)
        product = create_product(data)
        assert product.id is not None
    response = client.get("/products/")
    assert response.status_code == 200
    assert b"Notebook" in response.data


def test_prevent_duplicate_product(app):
    with app.app_context():
        data = ProductData(name="Mouse", description=None, minimum_stock=1)
        create_product(data)
        try:
            create_product(data)
        except ValueError as exc:
            assert "Já existe" in str(exc)
        else:
            raise AssertionError("Expected duplicate product error")


def test_stock_updates_with_movements(app):
    with app.app_context():
        product = create_product(ProductData(name="Monitor", description=None, minimum_stock=1))
        movement_service.create_movement(
            MovementData(
                product_id=product.id,
                movement_type=MovementType.ENTRY,
                quantity=10,
                notes=None,
            )
        )
        movement_service.create_movement(
            MovementData(
                product_id=product.id,
                movement_type=MovementType.EXIT,
                quantity=4,
                notes=None,
            )
        )
        products = list_products()
        assert products[0].stock == 6
