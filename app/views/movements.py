from __future__ import annotations

from flask import Blueprint, flash, redirect, render_template, request, url_for

from app.models import MovementType
from app.services import movements as movement_service
from app.services import products as product_service
from app.services.movements import MovementData


movements_bp = Blueprint("movements", __name__)


@movements_bp.get("/")
def list_movements() -> str:
    movements = movement_service.list_movements()
    return render_template("movements/list.html", movements=movements)


@movements_bp.route("/new", methods=["GET", "POST"])
def create_movement():  # type: ignore[override]
    products = product_service.list_products()
    if request.method == "POST":
        data = MovementData(
            product_id=int(request.form["product_id"]),
            movement_type=MovementType(request.form["movement_type"]),
            quantity=int(request.form.get("quantity") or 0),
            notes=request.form.get("notes"),
        )
        try:
            movement_service.create_movement(data)
        except (LookupError, ValueError) as exc:
            flash(str(exc), "danger")
        else:
            flash("Movimentação registrada com sucesso!", "success")
            return redirect(url_for("movements.list_movements"))
    return render_template("movements/form.html", products=products, MovementType=MovementType)
