# 🛒 Full Stack E-Commerce System

> **Built with Laravel + Vue.js**  
> By Teacher YEN YON

A complete full-stack e-commerce platform featuring an Admin Panel (Laravel Blade), a RESTful API (Laravel + Sanctum), and a Customer Website (Vue.js).

---

## 📋 Table of Contents

- [Overview](#overview)
- [Tech Stack](#tech-stack)
- [Project Structure](#project-structure)
- [System Architecture](#system-architecture)
- [Backend Setup](#backend-setup)
- [Swagger API Documentation](#swagger-api-documentation)
- [Frontend Setup](#frontend-setup)
- [API Endpoints](#api-endpoints)
- [Features](#features)
- [Bonus Features](#bonus-features)
- [Student Rules](#student-rules)

---

## Overview

This project simulates a real-world e-commerce system. It consists of three main parts:

| Part | Technology | Purpose |
|------|-----------|---------|
| Admin Panel | Laravel Blade | Manage products, categories, orders, users |
| REST API | Laravel + Sanctum | Serve data to the Vue frontend |
| Customer Website | Vue.js + Axios | Shopping experience for users |

---

## Tech Stack

**Backend**

- PHP / Laravel
- Laravel Sanctum (API Authentication)
- MySQL (Database)
- Laravel Blade (Admin Panel)
- L5-Swagger (API Documentation)

**Frontend**

- Vue.js 3
- Axios (HTTP Client)
- Vue Router (Page Navigation)
- LocalStorage (Token Storage)

---

## Project Structure

```
ecommerce/
│
├── backend/                        # Laravel Backend
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   │   ├── Admin/          # Admin Blade controllers
│   │   │   │   │   ├── AdminAuthController.php
│   │   │   │   │   ├── DashboardController.php
│   │   │   │   │   ├── CategoryController.php
│   │   │   │   │   ├── ProductController.php
│   │   │   │   │   └── OrderController.php
│   │   │   │   └── API/            # API controllers (for Vue)
│   │   │   │       ├── AuthController.php
│   │   │   │       ├── CategoryController.php
│   │   │   │       ├── ProductController.php
│   │   │   │       ├── WishlistController.php
│   │   │   │       ├── CartController.php
│   │   │   │       ├── CheckoutController.php
│   │   │   │       ├── OrderController.php
│   │   │   │       ├── ProfileController.php
│   │   │   │       └── ReviewController.php
│   │   │   └── Middleware/
│   │   │       └── AdminMiddleware.php
│   │   ├── Models/
│   │   │   ├── User.php
│   │   │   ├── Category.php
│   │   │   ├── Product.php
│   │   │   ├── Wishlist.php
│   │   │   ├── Cart.php
│   │   │   ├── Order.php
│   │   │   ├── OrderItem.php
│   │   │   └── Review.php
│   │   └── Providers/
│   │       └── AppServiceProvider.php
│   │
│   ├── database/
│   │   └── migrations/
│   │       ├── create_users_table.php
│   │       ├── create_categories_table.php
│   │       ├── create_products_table.php
│   │       ├── create_wishlists_table.php
│   │       ├── create_carts_table.php
│   │       ├── create_orders_table.php
│   │       ├── create_order_items_table.php
│   │       └── create_reviews_table.php
│   │
│   ├── resources/
│   │   └── views/
│   │       └── admin/              # Blade views for Admin Panel
│   │           ├── auth/
│   │           │   └── login.blade.php
│   │           ├── dashboard/
│   │           │   └── index.blade.php
│   │           ├── categories/
│   │           │   ├── index.blade.php
│   │           │   ├── create.blade.php
│   │           │   └── edit.blade.php
│   │           ├── products/
│   │           │   ├── index.blade.php
│   │           │   ├── create.blade.php
│   │           │   └── edit.blade.php
│   │           └── orders/
│   │               └── index.blade.php
│   │
│   ├── routes/
│   │   ├── web.php                 # Admin Blade routes
│   │   └── api.php                 # API routes for Vue
│   │
│   ├── config/
│   │   └── l5-swagger.php          # Swagger config (auto-generated)
│   │
│   ├── storage/
│   │   └── app/public/images/      # Uploaded product images
│   │
│   ├── .env                        # Environment variables
│   ├── composer.json
│   └── artisan
│
└── frontend/                       # Vue.js Frontend
    ├── src/
    │   ├── assets/                 # Images, icons, CSS
    │   │
    │   ├── components/             # Reusable Vue components
    │   │   ├── Navbar.vue
    │   │   ├── Footer.vue
    │   │   ├── ProductCard.vue
    │   │   ├── CartItem.vue
    │   │   └── ReviewCard.vue
    │   │
    │   ├── pages/                  # Vue page views
    │   │   ├── Home.vue
    │   │   ├── Products.vue
    │   │   ├── ProductDetail.vue
    │   │   ├── Login.vue
    │   │   ├── Register.vue
    │   │   ├── Wishlist.vue
    │   │   ├── Cart.vue
    │   │   ├── Checkout.vue
    │   │   ├── Orders.vue
    │   │   └── Profile.vue
    │   │
    │   ├── router/
    │   │   └── index.js            # Vue Router (route guards for private pages)
    │   │
    │   ├── services/
    │   │   └── api.js              # Axios instance + API call functions
    │   │
    │   ├── store/                  # App state (token, user, cart count)
    │   │   └── index.js
    │   │
    │   ├── App.vue
    │   └── main.js
    │
    ├── public/
    │   └── index.html
    │
    ├── .env                        # Vue environment variables (API base URL)
    └── package.json
```

---

## System Architecture

```
[ Admin Browser ]
       |
       ▼
[ Laravel Blade (Admin Panel) ]
       |
       ▼
[ Laravel Controllers (Admin) ]
       |
       ▼
[ MySQL Database ]
       ▲
       |
[ Laravel API (REST) ] ◄──── [ Vue.js Frontend ] ◄──── [ Customer Browser ]
       ▲
       |
[ Laravel Sanctum (Auth Token) ]
```

---

## Backend Setup

```bash
# 1. Create Laravel project
composer create-project laravel/laravel backend

cd backend

# 2. Install Sanctum
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"

# 3. Configure .env
DB_DATABASE=system_DB
DB_USERNAME=root
DB_PASSWORD=

# 4. Run migrations
php artisan migrate

# 5. Create storage link (for image uploads)
php artisan storage:link

# 6. Start server
php artisan serve
```

---

## Swagger API Documentation

This project uses **L5-Swagger** to auto-generate interactive API docs from annotations in your controllers.

### Step 1 — Install L5-Swagger

```bash
composer require darkaonline/l5-swagger
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
```

This creates `config/l5-swagger.php` automatically.

---

### Step 2 — Add OpenAPI Info (one time only)

Open `app/Http/Controllers/Controller.php` and add this block inside the class:

```php
/**
 * @OA\Info(
 *     title="E-Commerce API",
 *     version="1.0.0",
 *     description="Full Stack E-Commerce API Documentation"
 * )
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer"
 * )
 */
```

---

### Step 3 — Add Annotations to Each API Controller

Add a Swagger comment block above every method you want documented.

**Example — `app/Http/Controllers/API/ProductController.php`:**

```php
/**
 * @OA\Get(
 *     path="/api/products",
 *     summary="Get all products",
 *     tags={"Products"},
 *     @OA\Response(response=200, description="Success")
 * )
 */
public function index() { ... }

/**
 * @OA\Get(
 *     path="/api/products/{id}",
 *     summary="Get product detail",
 *     tags={"Products"},
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Success"),
 *     @OA\Response(response=404, description="Not Found")
 * )
 */
public function show($id) { ... }
```

**Example — `app/Http/Controllers/API/AuthController.php`:**

```php
/**
 * @OA\Post(
 *     path="/api/login",
 *     summary="Login user",
 *     tags={"Auth"},
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             required={"email","password"},
 *             @OA\Property(property="email", type="string"),
 *             @OA\Property(property="password", type="string")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Returns token")
 * )
 */
public function login() { ... }
```

**Example — Protected route (requires Bearer token):**

```php
/**
 * @OA\Get(
 *     path="/api/cart",
 *     summary="View cart",
 *     tags={"Cart"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(response=200, description="Success"),
 *     @OA\Response(response=401, description="Unauthenticated")
 * )
 */
public function index() { ... }
```

---

### Step 4 — Which Files to Annotate

| Controller File | Tags to use | Routes covered |
|----------------|-------------|----------------|
| `Controller.php` | — | `@OA\Info` + `@OA\SecurityScheme` (one time) |
| `API/AuthController.php` | `Auth` | register, login, logout |
| `API/CategoryController.php` | `Categories` | list categories |
| `API/ProductController.php` | `Products` | list, detail, search |
| `API/WishlistController.php` | `Wishlist` | view, add, remove |
| `API/CartController.php` | `Cart` | view, add, update, remove |
| `API/CheckoutController.php` | `Checkout` | place order |
| `API/OrderController.php` | `Orders` | list, detail |
| `API/ProfileController.php` | `Profile` | view, update, change password |
| `API/ReviewController.php` | `Reviews` | list, submit |

---

### Step 5 — Generate & View Docs

```bash
php artisan l5-swagger:generate
```

Then open in your browser:

```
http://localhost:8000/api/documentation
```

You will see all your API endpoints listed with the ability to test them directly in the browser — including sending Bearer tokens for protected routes.

---

```bash
# 1. Create Vue project
npm create vue@latest frontend

cd frontend

# 2. Install dependencies
npm install axios vue-router

# 3. Configure API base URL in .env
VITE_API_URL=http://localhost:8000/api

# 4. Start dev server
npm run dev
```

---

## API Endpoints

### Public (No Login Required)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/categories` | Get all categories |
| GET | `/api/products` | Get all products |
| GET | `/api/products/{id}` | Get product detail |
| GET | `/api/products/search?q=` | Search products |

### Authentication

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/register` | Register new user |
| POST | `/api/login` | Login and get token |
| POST | `/api/logout` | Logout (token required) |
| GET | `/api/profile` | Get user profile |

### Protected (Login Required — Bearer Token)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/wishlist` | View wishlist |
| POST | `/api/wishlist` | Add to wishlist |
| DELETE | `/api/wishlist/{id}` | Remove from wishlist |
| GET | `/api/cart` | View cart |
| POST | `/api/cart` | Add to cart |
| PUT | `/api/cart/{id}` | Update cart quantity |
| DELETE | `/api/cart/{id}` | Remove cart item |
| POST | `/api/checkout` | Place order |
| GET | `/api/orders` | View order history |
| GET | `/api/orders/{id}` | View order detail |
| PUT | `/api/profile` | Update profile |
| PUT | `/api/profile/password` | Change password |
| POST | `/api/products/{id}/reviews` | Submit review |
| GET | `/api/products/{id}/reviews` | Get product reviews |

---

## Features

### Admin Panel (Blade)
- Admin login / logout
- Dashboard with statistics
- Category CRUD (create, read, update, delete)
- Product CRUD with image upload
- View all orders
- View all users

### Customer Website (Vue.js)
- Home page with featured products
- Product listing with category filter
- Product detail page with reviews
- Search products
- User registration and login
- Wishlist management
- Shopping cart with quantity control
- Checkout and order creation
- Order history with details
- Profile page (update info, change password)

---

## Bonus Features

- Product filter by price and category
- Pagination on product listing
- Order status tracking (pending, completed)
- Multiple product image upload
- Admin dashboard charts (sales, orders)

---

## Student Rules

| Do | Do Not |
|----|--------|
| Test every API in Postman first | Copy-paste without understanding |
| Show screenshots for each feature | Ask AI for a full direct solution |
| Understand the request → response flow | |

---

## Final Output

By the end of this project, you will have built:

- ✅ Full Admin Panel (Laravel Blade)
- ✅ Full REST API (Laravel + Sanctum)
- ✅ Full Customer Website (Vue.js)
- ✅ Token-based Authentication System
- ✅ Real e-commerce workflow (Browse → Cart → Checkout → Orders)
