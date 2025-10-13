import hmac
import os
import secrets
from datetime import datetime, date
from functools import wraps
from typing import Optional, Tuple

from dotenv import load_dotenv
from flask import (
    Flask,
    abort,
    flash,
    redirect,
    render_template,
    request,
    session,
    url_for,
)
from sqlalchemy import (
    Column,
    DateTime,
    Float,
    ForeignKey,
    Integer,
    String,
    Text,
    create_engine,
    func,
)
from sqlalchemy.exc import NoResultFound
from sqlalchemy.orm import declarative_base, relationship, scoped_session, sessionmaker
from werkzeug.security import check_password_hash, generate_password_hash


load_dotenv()

DATABASE_URL = os.environ.get("DATABASE_URL", "sqlite:///dernek.db")


def require_env(
    name: str,
    *,
    min_length: Optional[int] = None,
    disallowed_values: Tuple[str, ...] = (),
) -> str:
    """Fetch a required environment variable and enforce basic security constraints."""

    raw_value = os.environ.get(name, "")
    value = raw_value.strip()
    if not value:
        raise RuntimeError(
            f"{name} environment variable must be configured before starting the app."
        )

    for disallowed in disallowed_values:
        if disallowed and hmac.compare_digest(value, disallowed):
            raise RuntimeError(
                f"{name} environment variable cannot use the insecure default value."
            )

    if min_length is not None and len(value) < min_length:
        raise RuntimeError(
            f"{name} environment variable must be at least {min_length} characters long."
        )

    return value


SECRET_KEY = require_env("SECRET_KEY", min_length=16, disallowed_values=("change-this-secret",))
ADMIN_USERNAME = require_env("ADMIN_USERNAME", min_length=3)
ADMIN_PASSWORD = require_env("ADMIN_PASSWORD", min_length=12, disallowed_values=("admin123",))

app = Flask(__name__)
app.config["SECRET_KEY"] = SECRET_KEY

engine = create_engine(DATABASE_URL, connect_args={"check_same_thread": False} if DATABASE_URL.startswith("sqlite") else {})
SessionLocal = scoped_session(sessionmaker(bind=engine))
Base = declarative_base()


class AdminUser(Base):
    __tablename__ = "admin_users"

    id = Column(Integer, primary_key=True)
    username = Column(String(50), unique=True, nullable=False)
    password_hash = Column(String(255), nullable=False)

    def set_password(self, password: str) -> None:
        self.password_hash = generate_password_hash(password)

    def check_password(self, password: str) -> bool:
        return check_password_hash(self.password_hash, password)


class Product(Base):
    __tablename__ = "products"

    id = Column(Integer, primary_key=True)
    name = Column(String(120), nullable=False)
    description = Column(Text, nullable=False)
    price = Column(Float, nullable=False)
    is_active = Column(Integer, default=1)
    orders = relationship("Order", back_populates="product")


class Customer(Base):
    __tablename__ = "customers"

    id = Column(Integer, primary_key=True)
    full_name = Column(String(120), nullable=False)
    email = Column(String(120), unique=True, nullable=False)
    phone = Column(String(40))
    created_at = Column(DateTime, default=datetime.utcnow)

    orders = relationship("Order", back_populates="customer", cascade="all, delete-orphan")
    notes = relationship("CustomerNote", back_populates="customer", cascade="all, delete-orphan")


class Order(Base):
    __tablename__ = "orders"

    id = Column(Integer, primary_key=True)
    customer_id = Column(Integer, ForeignKey("customers.id"), nullable=False)
    product_id = Column(Integer, ForeignKey("products.id"), nullable=False)
    amount = Column(Float, nullable=False)
    status = Column(String(40), default="pending")
    created_at = Column(DateTime, default=datetime.utcnow)
    note = Column(Text)

    customer = relationship("Customer", back_populates="orders")
    product = relationship("Product", back_populates="orders")


class CustomerNote(Base):
    __tablename__ = "customer_notes"

    id = Column(Integer, primary_key=True)
    customer_id = Column(Integer, ForeignKey("customers.id"), nullable=False)
    content = Column(Text, nullable=False)
    created_at = Column(DateTime, default=datetime.utcnow)

    customer = relationship("Customer", back_populates="notes")


def init_db() -> None:
    Base.metadata.create_all(engine)
    db = SessionLocal()
    try:
        # Ensure admin user exists
        try:
            db.query(AdminUser).filter_by(username=ADMIN_USERNAME).one()
        except NoResultFound:
            admin = AdminUser(username=ADMIN_USERNAME)
            admin.set_password(ADMIN_PASSWORD)
            db.add(admin)

        # Seed example products
        if db.query(Product).count() == 0:
            products = [
                Product(
                    name="Dijital Eğitim Paketi",
                    description="Uzman eğitmenlerden hazırlanan kapsamlı video eğitim içerikleri.",
                    price=149.0,
                ),
                Product(
                    name="Profesyonel Şablon Seti",
                    description="Hazır e-posta, sunum ve doküman şablonlarından oluşan koleksiyon.",
                    price=89.0,
                ),
                Product(
                    name="Premium Destek Üyeliği",
                    description="7/24 danışmanlık ve özel içeriklere erişim sağlayan üyelik paketi.",
                    price=199.0,
                ),
            ]
            db.add_all(products)
        db.commit()
    finally:
        db.close()


init_db()


def get_db_session():
    db = SessionLocal()
    try:
        yield db
    finally:
        db.close()


def generate_csrf_token() -> str:
    token = session.get("_csrf_token")
    if not token:
        token = secrets.token_urlsafe(32)
        session["_csrf_token"] = token
    return token


def validate_csrf_token() -> None:
    session_token = session.get("_csrf_token")
    form_token = request.form.get("csrf_token", "")
    if not session_token or not form_token or not hmac.compare_digest(session_token, form_token):
        abort(400, description="Invalid or missing CSRF token.")


def csrf_protect(view):
    @wraps(view)
    def wrapped_view(*args, **kwargs):
        if request.method == "POST":
            validate_csrf_token()
        return view(*args, **kwargs)

    return wrapped_view


def login_required(view):
    @wraps(view)
    def wrapped_view(**kwargs):
        if not session.get("admin_user"):
            flash("Admin paneline erişmek için giriş yapmalısınız.", "warning")
            return redirect(url_for("admin_login"))
        return view(**kwargs)

    return wrapped_view


@app.route("/")
def landing():
    db = SessionLocal()
    try:
        products = db.query(Product).filter_by(is_active=1).all()
    finally:
        db.close()
    return render_template("landing.html", products=products)


@app.route("/start-order", methods=["GET", "POST"])
def start_order():
    db = SessionLocal()
    try:
        products = db.query(Product).filter_by(is_active=1).all()
        if request.method == "POST":
            product_id = int(request.form.get("product_id"))
            full_name = request.form.get("full_name", "").strip()
            email = request.form.get("email", "").strip().lower()
            phone = request.form.get("phone", "").strip()
            note = request.form.get("note", "").strip()

            if not full_name or not email:
                flash("Lütfen adınızı ve e-posta adresinizi belirtin.", "danger")
                return render_template("start_order.html", products=products)

            product = db.get(Product, product_id)
            if not product:
                flash("Seçtiğiniz ürün bulunamadı.", "danger")
                return render_template("start_order.html", products=products)

            customer = db.query(Customer).filter_by(email=email).one_or_none()
            if customer is None:
                customer = Customer(full_name=full_name, email=email, phone=phone)
                db.add(customer)
                db.flush()
            else:
                customer.full_name = full_name
                customer.phone = phone

            order = Order(
                customer=customer,
                product=product,
                amount=product.price,
                status="pending",
                note=note,
            )
            db.add(order)
            db.commit()
            flash("Talebiniz başarıyla alındı. En kısa sürede sizinle iletişime geçeceğiz.", "success")
            return redirect(url_for("thank_you"))
    finally:
        db.close()
    return render_template("start_order.html", products=products)


@app.route("/thank-you")
def thank_you():
    return render_template("thank_you.html")


@app.route("/admin/login", methods=["GET", "POST"])
@csrf_protect
def admin_login():
    if request.method == "POST":
        username = request.form.get("username", "").strip()
        password = request.form.get("password", "")
        db = SessionLocal()
        try:
            user = db.query(AdminUser).filter_by(username=username).one_or_none()
            if user and user.check_password(password):
                session["admin_user"] = user.username
                session["_csrf_token"] = secrets.token_urlsafe(32)
                flash("Hoş geldiniz!", "success")
                return redirect(url_for("admin_dashboard"))
            flash("Kullanıcı adı veya şifre hatalı.", "danger")
        finally:
            db.close()
    return render_template("admin/login.html")


@app.route("/admin/logout")
def admin_logout():
    session.pop("admin_user", None)
    session.pop("_csrf_token", None)
    flash("Güvenli çıkış yapıldı.", "info")
    return redirect(url_for("admin_login"))


@app.route("/admin/dashboard")
@login_required
def admin_dashboard():
    db = SessionLocal()
    try:
        total_revenue = (
            db.query(func.coalesce(func.sum(Order.amount), 0.0))
            .filter(Order.status.in_(["paid", "completed"]))
            .scalar()
        )
        total_orders = db.query(func.count(Order.id)).scalar()
        daily_orders = (
            db.query(func.count(Order.id))
            .filter(func.date(Order.created_at) == date.today())
            .scalar()
        )
        active_customers = db.query(func.count(func.distinct(Order.customer_id))).scalar()
        recent_orders = (
            db.query(Order)
            .order_by(Order.created_at.desc())
            .limit(5)
            .all()
        )
    finally:
        db.close()
    return render_template(
        "admin/dashboard.html",
        total_revenue=total_revenue,
        total_orders=total_orders,
        daily_orders=daily_orders,
        active_customers=active_customers,
        recent_orders=recent_orders,
    )


@app.route("/admin/customers")
@login_required
def admin_customers():
    db = SessionLocal()
    try:
        customers = (
            db.query(Customer)
            .order_by(Customer.created_at.desc())
            .all()
        )
    finally:
        db.close()
    return render_template("admin/customers.html", customers=customers)


@app.route("/admin/customers/<int:customer_id>", methods=["GET", "POST"])
@login_required
@csrf_protect
def admin_customer_detail(customer_id):
    db = SessionLocal()
    try:
        customer = db.get(Customer, customer_id)
        if customer is None:
            flash("Müşteri bulunamadı.", "danger")
            return redirect(url_for("admin_customers"))

        if request.method == "POST":
            content = request.form.get("content", "").strip()
            if content:
                note = CustomerNote(customer=customer, content=content)
                db.add(note)
                db.commit()
                flash("Not kaydedildi.", "success")
            else:
                flash("Not içeriği boş olamaz.", "warning")
            return redirect(url_for("admin_customer_detail", customer_id=customer.id))

        orders = (
            db.query(Order)
            .filter_by(customer_id=customer.id)
            .order_by(Order.created_at.desc())
            .all()
        )
        notes = (
            db.query(CustomerNote)
            .filter_by(customer_id=customer.id)
            .order_by(CustomerNote.created_at.desc())
            .all()
        )
    finally:
        db.close()
    return render_template(
        "admin/customer_detail.html",
        customer=customer,
        orders=orders,
        notes=notes,
    )


@app.route("/admin/orders", methods=["GET", "POST"])
@login_required
@csrf_protect
def admin_orders():
    db = SessionLocal()
    try:
        if request.method == "POST":
            order_id = int(request.form.get("order_id"))
            status = request.form.get("status", "pending")
            order = db.get(Order, order_id)
            if order:
                order.status = status
                db.commit()
                flash("Sipariş durumu güncellendi.", "success")
            else:
                flash("Sipariş bulunamadı.", "danger")
            return redirect(url_for("admin_orders"))

        orders = (
            db.query(Order)
            .order_by(Order.created_at.desc())
            .all()
        )
    finally:
        db.close()
    return render_template("admin/orders.html", orders=orders)


@app.context_processor
def inject_now():
    return {
        "current_year": datetime.utcnow().year,
        "csrf_token": generate_csrf_token,
    }


if __name__ == "__main__":
    app.run(debug=True)
