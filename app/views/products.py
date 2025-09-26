from __future__ import annotations

from flask import Blueprint, flash, redirect, render_template, request, url_for

from app.services import products as product_service
from app.services.products import ProductData


products_bp = Blueprint("products", __name__)


@products_bp.get("/")
def list_products() -> str:
    products = product_service.list_products()
    return render_template("products/list.html", products=products)


@products_bp.route("/new", methods=["GET", "POST"])
def create_product():  # type: ignore[override]
    if request.method == "POST":
        data = ProductData(
            name=request.form["name"],
            description=request.form.get("description"),
            minimum_stock=int(request.form.get("minimum_stock") or 0),
        )
        try:
            product_service.create_product(data)
        except ValueError as exc:
            flash(str(exc), "danger")
        else:
            flash("Produto criado com sucesso!", "success")
            return redirect(url_for("products.list_products"))
    return render_template("products/form.html", product=None)


@products_bp.route("/<int:product_id>/edit", methods=["GET", "POST"])
def edit_product(product_id: int):  # type: ignore[override]
    product = product_service.get_product(product_id)
    if product is None:
        flash("Produto não encontrado", "danger")
        return redirect(url_for("products.list_products"))

    if request.method == "POST":
        data = ProductData(
            name=request.form["name"],
            description=request.form.get("description"),
            minimum_stock=int(request.form.get("minimum_stock") or 0),
        )
        try:
            product_service.update_product(product_id, data)
        except ValueError as exc:
            flash(str(exc), "danger")
        else:
            flash("Produto atualizado com sucesso!", "success")
            return redirect(url_for("products.list_products"))

    return render_template("products/form.html", product=product)


@products_bp.post("/<int:product_id>/delete")
def delete_product(product_id: int):
    try:
        product_service.delete_product(product_id)
    except (LookupError, ValueError) as exc:
        flash(str(exc), "danger")
    else:
        flash("Produto removido com sucesso!", "success")
    return redirect(url_for("products.list_products"))
