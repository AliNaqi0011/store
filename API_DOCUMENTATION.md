# NexShop E-Commerce API Documentation

## Overview
NexShop is a full-featured e-commerce API built with Laravel, featuring products, categories, cart management, orders, and user authentication.

## Base URL
```
http://127.0.0.1:8000/api
```

## Authentication
The API uses Laravel Sanctum for authentication. Include the Bearer token in the Authorization header:
```
Authorization: Bearer {your-token}
```

## Endpoints

### Authentication
- `POST /register` - Register new user
- `POST /login` - User login
- `POST /logout` - User logout (requires auth)
- `GET /user` - Get current user (requires auth)

### Products
- `GET /products` - List products with filtering and pagination
- `GET /products/featured` - Get featured products
- `GET /products/{slug}` - Get product details

### Categories
- `GET /categories` - List all categories (hierarchical)
- `GET /categories/{slug}` - Get category with products

### Cart (Session-based)
- `GET /cart` - Get cart contents
- `POST /cart` - Add item to cart
- `PUT /cart/{id}` - Update cart item quantity
- `DELETE /cart/{id}` - Remove item from cart
- `DELETE /cart` - Clear entire cart

### Checkout & Orders
- `POST /checkout/validate-coupon` - Validate coupon code
- `POST /checkout` - Create order with COD/Stripe (requires auth)
- `POST /checkout/stripe-webhook` - Stripe webhook for payment completion
- `GET /orders` - List user orders (requires auth)
- `GET /orders/{orderNumber}` - Get order details (requires auth)

### Wishlist
- `GET /wishlist` - Get user wishlist (requires auth)
- `POST /wishlist/{productId}` - Add to wishlist (requires auth)
- `DELETE /wishlist/{productId}` - Remove from wishlist (requires auth)

## Sample Requests

### Register User
```bash
curl -X POST http://127.0.0.1:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

### Get Products
```bash
curl http://127.0.0.1:8000/api/products?category=electronics&sort=price_low
```

### Add to Cart
```bash
curl -X POST http://127.0.0.1:8000/api/cart \
  -H "Content-Type: application/json" \
  -d '{
    "product_id": 1,
    "quantity": 2
  }'
```

### Checkout with COD
```bash
curl -X POST http://127.0.0.1:8000/api/checkout \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer {token}" \
  -d '{
    "billing_address": {
      "first_name": "John",
      "last_name": "Doe",
      "email": "john@example.com",
      "phone": "1234567890",
      "address_line_1": "123 Main St",
      "city": "New York",
      "state": "NY",
      "postal_code": "10001",
      "country": "USA"
    },
    "shipping_address": {
      "first_name": "John",
      "last_name": "Doe",
      "phone": "1234567890",
      "address_line_1": "123 Main St",
      "city": "New York",
      "state": "NY",
      "postal_code": "10001",
      "country": "USA"
    },
    "payment_method": "cod",
    "notes": "Please call before delivery"
  }'
```

## Database Schema
The system includes the following main entities:
- Users (with Stripe Billable trait)
- Categories (hierarchical)
- Brands
- Products (with variants, images, reviews)
- Orders & Order Items
- Cart (session-based)
- Wishlists
- Coupons

## Features Implemented
✅ User authentication with Sanctum
✅ Product catalog with categories and brands
✅ Product variants and attributes
✅ Session-based shopping cart
✅ Order management with stock reduction
✅ Cash on Delivery (COD) payment
✅ Stripe payment integration
✅ Comprehensive checkout validations
✅ Wishlist functionality
✅ Coupon system
✅ Product search (Scout ready)
✅ Image management
✅ Review system
✅ Webhook handling for payment completion

## Setup Instructions
1. Run `php artisan migrate` to create database tables
2. Run `php artisan db:seed --class=CategorySeeder` for sample categories
3. Run `php artisan db:seed --class=BrandSeeder` for sample brands
4. Run `php artisan db:seed --class=ProductSeeder` for sample products
5. Start server: `php artisan serve`

## Testing
Run the test script: `php test_api.php`