from __future__ import annotations

from dataclasses import dataclass

from app.models import MovementType, StockMovement
from app.repositories import movements as movement_repo
from app.repositories import products as product_repo


@dataclass
class MovementData:
    product_id: int
    movement_type: MovementType
    quantity: int
    notes: str | None


def list_movements(limit: int | None = None) -> list[StockMovement]:
    return movement_repo.list_movements(limit=limit)


def create_movement(data: MovementData) -> StockMovement:
    product = product_repo.get_product(data.product_id)
    if product is None:
        raise LookupError("Produto não encontrado")

    if data.quantity <= 0:
        raise ValueError("Quantidade deve ser positiva.")

    if data.movement_type == MovementType.EXIT and product.stock - data.quantity < 0:
        raise ValueError("Saída excede o estoque disponível.")

    return movement_repo.create_movement(
        product_id=data.product_id,
        movement_type=data.movement_type,
        quantity=data.quantity,
        notes=data.notes,
    )


def summarize_stock() -> dict[str, int]:
    products = product_repo.list_products()
    total_stock = sum(product.stock for product in products)
    low_stock = sum(1 for product in products if product.is_below_minimum)
    return {
        "products": len(products),
        "total_stock": total_stock,
        "low_stock": low_stock,
    }
