from __future__ import annotations

from sqlalchemy import select
from sqlalchemy.orm import joinedload

from app.database import db
from app.models import Product


def list_products() -> list[Product]:
    statement = select(Product).options(joinedload(Product.movements)).order_by(Product.name)
    return list(db.session.execute(statement).unique().scalars())


def get_product(product_id: int) -> Product | None:
    statement = (
        select(Product)
        .options(joinedload(Product.movements))
        .where(Product.id == product_id)
    )
    return db.session.execute(statement).unique().scalar_one_or_none()


def get_product_by_name(name: str) -> Product | None:
    statement = select(Product).where(Product.name == name)
    return db.session.execute(statement).scalar_one_or_none()


def create_product(name: str, description: str | None, minimum_stock: int) -> Product:
    product = Product(name=name, description=description, minimum_stock=minimum_stock)
    db.session.add(product)
    db.session.commit()
    return product


def update_product(
    product: Product, *, name: str, description: str | None, minimum_stock: int
) -> Product:
    product.name = name
    product.description = description
    product.minimum_stock = minimum_stock
    db.session.commit()
    return product


def delete_product(product: Product) -> None:
    db.session.delete(product)
    db.session.commit()
