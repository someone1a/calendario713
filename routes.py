from flask import Blueprint, render_template, request, redirect, url_for, session
from models import db, User, Event

main_routes = Blueprint('main', __name__)
auth_routes = Blueprint('auth', __name__)
event_routes = Blueprint('event', __name__)

@main_routes.route('/')
def index():
    return render_template('index.html')

@main_routes.route('/inicio')
def inicio():
    if 'rol' in session:
        rol = session['rol']
        if rol == 'Admin':
            return redirect(url_for('admin.view'))
        elif rol == 'Profesor':
            return redirect(url_for('teacher.view'))
        elif rol == 'Estudiante':
            return redirect(url_for('alumnos.view'))
        elif rol == 'Director':
            return redirect(url_for('directivo.view'))
    return render_template('inicio.html')

@auth_routes.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
        username = request.form['username']
        password = request.form['password']
        user = User.query.filter_by(username=username).first()
        if user and user.check_password(password):
            session['user_id'] = user.id
            session['rol'] = user.role
            return redirect(url_for('main.index'))
        else:
            return render_template('login.html', error='Invalid username or password')
    return render_template('login.html')

@auth_routes.route('/register', methods=['GET', 'POST'])
def register():
    if request.method == 'POST':
        username = request.form['username']
        password = request.form['password']
        email = request.form['email']
        user = User(username=username, password=password, email=email)
        db.session.add(user)
        db.session.commit()
        return redirect(url_for('auth.login'))
    return render_template('register.html')

@auth_routes.route('/logout')
def logout():
    session.clear()
    return redirect(url_for('auth.login'))

@event_routes.route('/events')
def events():
    events = Event.query.all()
    return render_template('events.html', events=events)

@event_routes.route('/events/add', methods=['GET', 'POST'])
def add_event():
    if request.method == 'POST':
        title = request.form['title']
        description = request.form['description']
        date = request.form['date']
        event = Event(title=title, description=description, date=date)
        db.session.add(event)
        db.session.commit()
        return redirect(url_for('event.events'))
    return render_template('add_event.html')
