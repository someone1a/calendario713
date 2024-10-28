from flask import Flask, render_template, request, redirect, url_for, session
from flask_sqlalchemy import SQLAlchemy
from flask_migrate import Migrate
from models import db, User, Event
from routes import main_routes, auth_routes, event_routes

app = Flask(__name__)
app.config.from_object('config.Config')

db.init_app(app)
migrate = Migrate(app, db)

app.register_blueprint(main_routes)
app.register_blueprint(auth_routes)
app.register_blueprint(event_routes)

if __name__ == '__main__':
    app.run(debug=True)
