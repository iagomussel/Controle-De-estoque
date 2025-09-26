# Controle de Estoque Modernizado

Aplicação web moderna para controle de estoque, construída com Flask, SQLAlchemy e SQLite. Inclui API REST, interface responsiva e suíte de testes automatizados.

## Requisitos

- Python 3.11+
- Pipx/pip para instalar dependências

## Configuração

1. Crie e ative um ambiente virtual:

```bash
python -m venv .venv
source .venv/bin/activate
```

2. Instale as dependências:

```bash
pip install -r requirements.txt
```

3. Inicialize o banco de dados SQLite:

```bash
flask --app run.py shell
from app import create_app
from app.database import db
from app.config import Config
app = create_app()
with app.app_context():
    db.create_all()
exit()
```

Ou execute o comando utilitário:

```bash
flask --app run.py db upgrade
```

4. Execute a aplicação localmente:

```bash
flask --app run.py run --reload
```

Acesse `http://localhost:5000` no navegador.

## Testes

Execute a suíte de testes com:

```bash
pytest
```

Os testes utilizam um banco de dados SQLite em memória para isolamento total.

## Estrutura do projeto

```
app/
├── api/          # Endpoints REST
├── services/     # Regras de negócio
├── repositories/ # Acesso a dados
├── templates/    # Camada de apresentação
└── static/       # Recursos estáticos
```

## Variáveis de ambiente

- `DATABASE_URL`: URL do banco (padrão: SQLite em `instance/app.db`)
- `SECRET_KEY`: chave de sessão Flask

## Licença

Distribuído sob a licença MIT.
