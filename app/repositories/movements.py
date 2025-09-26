from __future__ import annotations

from sqlalchemy.orm import joinedload

from app.database import db
from app.models import MovementType, StockMovement


def list_movements(limit: int | None = None) -> list[StockMovement]:
    query = StockMovement.query.options(joinedload(StockMovement.product)).order_by(
        StockMovement.created_at.desc()
    )
    if limit is not None:
        query = query.limit(limit)
    return query.all()


def create_movement(
    *, product_id: int, movement_type: MovementType, quantity: int, notes: str | None
) -> StockMovement:
    movement = StockMovement(
        product_id=product_id,
        movement_type=movement_type,
        quantity=quantity,
        notes=notes,
    )
    db.session.add(movement)
    db.session.commit()
    return movement
