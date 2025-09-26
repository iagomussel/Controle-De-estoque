from __future__ import annotations

from flask import Blueprint, render_template

from app.services import movements as movement_service
from app.services import products as product_service


dashboard_bp = Blueprint("dashboard", __name__)


@dashboard_bp.get("/")
def index() -> str:
    summary = movement_service.summarize_stock()
    recent_movements = movement_service.list_movements(limit=5)
    products = product_service.list_products()
    return render_template(
        "dashboard.html",
        summary=summary,
        recent_movements=recent_movements,
        products=products,
    )
