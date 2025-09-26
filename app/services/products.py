from __future__ import annotations

from dataclasses import dataclass

from app.models import Product
from app.repositories import products as product_repo


@dataclass
class ProductData:
    name: str
    description: str | None
    minimum_stock: int


def list_products() -> list[Product]:
    return product_repo.list_products()


def get_product(product_id: int) -> Product | None:
    return product_repo.get_product(product_id)


def create_product(data: ProductData) -> Product:
    if data.minimum_stock < 0:
        raise ValueError("Estoque mínimo não pode ser negativo.")
    if product_repo.get_product_by_name(data.name):
        raise ValueError("Já existe um produto com esse nome.")
    return product_repo.create_product(data.name, data.description, data.minimum_stock)


def update_product(product_id: int, data: ProductData) -> Product:
    product = product_repo.get_product(product_id)
    if product is None:
        raise LookupError("Produto não encontrado")

    if data.minimum_stock < 0:
        raise ValueError("Estoque mínimo não pode ser negativo.")

    existing = product_repo.get_product_by_name(data.name)
    if existing and existing.id != product.id:
        raise ValueError("Já existe um produto com esse nome.")

    return product_repo.update_product(
        product, name=data.name, description=data.description, minimum_stock=data.minimum_stock
    )


def delete_product(product_id: int) -> None:
    product = product_repo.get_product(product_id)
    if product is None:
        raise LookupError("Produto não encontrado")
    if product.movements:
        raise ValueError("Não é possível remover um produto com movimentações.")
    product_repo.delete_product(product)
