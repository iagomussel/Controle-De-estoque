from __future__ import annotations

from pathlib import Path

from flask import Flask

from app.config import Config
from app.database import db, migrate
from app.views.dashboard import dashboard_bp
from app.views.products import products_bp
from app.views.movements import movements_bp
from app.api import api_bp


def create_app(config: type[Config] | None = None) -> Flask:
    app_config = config or Config

    app = Flask(__name__, template_folder="templates", static_folder="static")
    app.config.from_object(app_config)

    # Ensure the instance directory exists when using the default SQLite database.
    Path(app_config.INSTANCE_DIR).mkdir(parents=True, exist_ok=True)

    db.init_app(app)
    migrate.init_app(app, db)

    app.register_blueprint(dashboard_bp)
    app.register_blueprint(products_bp, url_prefix="/products")
    app.register_blueprint(movements_bp, url_prefix="/movements")
    app.register_blueprint(api_bp, url_prefix="/api")

    @app.shell_context_processor
    def shell_context() -> dict[str, object]:
        return {"db": db}

    return app
