# NexShop - E-commerce Platform

A full-stack e-commerce platform built with Laravel (Backend) and Vue.js (Frontend).

## 🚀 Features

### Frontend (Vue.js)
- Modern responsive design
- Product catalog with search and filtering
- Shopping cart functionality
- User authentication (Login/Register)
- Order management
- Product reviews and ratings
- Wishlist functionality
- Contact forms
- Newsletter subscription

### Backend (Laravel)
- RESTful API architecture
- Admin panel for complete store management
- Product management with variants and images
- Order processing and tracking
- User management
- Category and brand management
- Coupon and deal management
- Analytics and reporting
- Email notifications
- Payment integration (Stripe)

## 🛠️ Tech Stack

### Backend
- **Framework:** Laravel 10
- **Database:** MySQL
- **Authentication:** Laravel Sanctum
- **File Storage:** Local/Cloud storage
- **Email:** SMTP (Mailtrap for development)
- **Payment:** Stripe

### Frontend
- **Framework:** Vue.js 3
- **State Management:** Pinia
- **Routing:** Vue Router
- **HTTP Client:** Axios
- **Styling:** Tailwind CSS
- **Build Tool:** Vite

## 📋 Prerequisites

- PHP >= 8.1
- Composer
- Node.js >= 16
- MySQL
- Git

## 🔧 Installation

### 1. Clone the repository
```bash
git clone https://github.com/AliNaqi0011/store.git
cd store
```

### 2. Backend Setup (Laravel)
```bash
# Install PHP dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure database in .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nexshop_db
DB_USERNAME=root
DB_PASSWORD=

# Run migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed

# Create storage link
php artisan storage:link

# Start Laravel server
php artisan serve
```

### 3. Frontend Setup (Vue.js)
```bash
# Navigate to frontend directory
cd frontend

# Install dependencies
npm install

# Start development server
npm run dev
```

## 🌐 Access URLs

- **Frontend:** http://localhost:3000
- **Backend API:** http://127.0.0.1:8000/api
- **Admin Panel:** http://127.0.0.1:8000/admin/login

## 👤 Default Admin Credentials

- **Email:** ali@gmail.com
- **Password:** password

## 📁 Project Structure

```
├── app/                    # Laravel application files
├── database/              # Migrations, seeders, factories
├── frontend/              # Vue.js frontend application
│   ├── src/
│   │   ├── components/    # Reusable Vue components
│   │   ├── views/         # Page components
│   │   ├── stores/        # Pinia stores
│   │   └── router/        # Vue Router configuration
├── public/                # Public assets
├── resources/             # Laravel views and assets
├── routes/                # API and web routes
└── storage/               # File storage
```

## 🔗 API Endpoints

### Authentication
- `POST /api/register` - User registration
- `POST /api/login` - User login
- `POST /api/logout` - User logout

### Products
- `GET /api/products` - Get all products
- `GET /api/products/{slug}` - Get product details
- `GET /api/products/featured` - Get featured products

### Categories
- `GET /api/categories` - Get all categories

### Cart
- `GET /api/cart` - Get cart items
- `POST /api/cart` - Add item to cart
- `PUT /api/cart/{id}` - Update cart item
- `DELETE /api/cart/{id}` - Remove cart item

### Orders
- `GET /api/orders` - Get user orders
- `POST /api/checkout` - Process checkout

## 🚀 Deployment

### Production Environment Variables
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database
DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_DATABASE=your-db-name
DB_USERNAME=your-db-username
DB_PASSWORD=your-db-password

# Mail
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password

# Stripe
STRIPE_KEY=pk_live_...
STRIPE_SECRET=sk_live_...
```

### Build for Production
```bash
# Backend
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Frontend
cd frontend
npm run build
```

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 📞 Support

For support, email alinaqiofficial@gmail.com or create an issue on GitHub.

## 🙏 Acknowledgments

- Laravel Framework
- Vue.js Framework
- Tailwind CSS
- All contributors and supporters