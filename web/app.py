from flask import Flask, render_template
from flask_sqlalchemy import SQLAlchemy
from forms import RegistrationForm
from models import User

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql://flask_user:flask_password@db/flask_app_db'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
db = SQLAlchemy(app)

@app.route('/')
def index():
    return render_template('/app/index.html')

@app.route('/newuser', methods=['GET', 'POST'])
def new_user():
    form = RegistrationForm()
    if form.validate_on_submit():
        user = User(username=form.username.data, email=form.email.data)
        user.set_password(form.password.data)
        db.session.add(user)
        db.session.commit()
        return 'User registered successfully!'
    return render_template('/app/register.html', form=form)

if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0')

