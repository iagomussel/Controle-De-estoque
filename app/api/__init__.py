from __future__ import annotations

from flask import Blueprint, jsonify, request

from app.models import MovementType
from app.services import movements as movement_service
from app.services import products as product_service
from app.services.movements import MovementData
from app.services.products import ProductData


api_bp = Blueprint("api", __name__)


@api_bp.get("/products")
def api_list_products():
    products = product_service.list_products()
    return jsonify(
        [
            {
                "id": product.id,
                "name": product.name,
                "description": product.description,
                "minimum_stock": product.minimum_stock,
                "stock": product.stock,
                "is_below_minimum": product.is_below_minimum,
            }
            for product in products
        ]
    )


@api_bp.post("/products")
def api_create_product():
    payload = request.get_json(force=True)
    data = ProductData(
        name=payload["name"],
        description=payload.get("description"),
        minimum_stock=int(payload.get("minimum_stock", 0)),
    )
    try:
        product = product_service.create_product(data)
    except ValueError as exc:
        return jsonify({"error": str(exc)}), 400
    return jsonify({"id": product.id}), 201


@api_bp.post("/movements")
def api_create_movement():
    payload = request.get_json(force=True)
    data = MovementData(
        product_id=int(payload["product_id"]),
        movement_type=MovementType(payload["movement_type"]),
        quantity=int(payload["quantity"]),
        notes=payload.get("notes"),
    )
    try:
        movement = movement_service.create_movement(data)
    except LookupError as exc:
        return jsonify({"error": str(exc)}), 404
    except ValueError as exc:
        return jsonify({"error": str(exc)}), 400
    return jsonify({"id": movement.id}), 201
