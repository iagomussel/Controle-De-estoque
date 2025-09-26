from __future__ import annotations

from datetime import UTC, datetime
from enum import Enum

from sqlalchemy import CheckConstraint, Enum as SQLEnum, func
from sqlalchemy.orm import Mapped, mapped_column, relationship

from app.database import CRUDMixin, db


class MovementType(str, Enum):
    ENTRY = "ENTRY"
    EXIT = "EXIT"


class Product(db.Model, CRUDMixin):
    __tablename__ = "products"

    id: Mapped[int] = mapped_column(primary_key=True)
    name: Mapped[str] = mapped_column(nullable=False, unique=True)
    description: Mapped[str | None]
    minimum_stock: Mapped[int] = mapped_column(default=0, server_default="0")

    movements: Mapped[list["StockMovement"]] = relationship(
        back_populates="product", cascade="all, delete-orphan", lazy="selectin"
    )

    @property
    def stock(self) -> int:
        inbound = sum(
            m.quantity for m in self.movements if m.movement_type == MovementType.ENTRY
        )
        outbound = sum(
            m.quantity for m in self.movements if m.movement_type == MovementType.EXIT
        )
        return inbound - outbound

    @property
    def is_below_minimum(self) -> bool:
        return self.stock < self.minimum_stock


class StockMovement(db.Model, CRUDMixin):
    __tablename__ = "stock_movements"
    __table_args__ = (
        CheckConstraint("quantity > 0", name="ck_quantity_positive"),
    )

    id: Mapped[int] = mapped_column(primary_key=True)
    product_id: Mapped[int] = mapped_column(db.ForeignKey("products.id"), nullable=False)
    movement_type: Mapped[MovementType] = mapped_column(
        SQLEnum(MovementType, name="movement_type"), nullable=False
    )
    quantity: Mapped[int] = mapped_column(nullable=False)
    notes: Mapped[str | None]
    created_at: Mapped[datetime] = mapped_column(
        default=lambda: datetime.now(UTC),
        server_default=func.now(),
    )

    product: Mapped[Product] = relationship(back_populates="movements", lazy="joined")

    def is_entry(self) -> bool:
        return self.movement_type == MovementType.ENTRY

    def is_exit(self) -> bool:
        return self.movement_type == MovementType.EXIT
