<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CheckoutController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\WishlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Authentication routes (rate limited)
Route::middleware('throttle:10,1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});
Route::middleware(['auth:sanctum', 'throttle:120,1'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
});

// Public routes
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/featured', [ProductController::class, 'featured']);
Route::get('/products/{slug}', [ProductController::class, 'show']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{slug}', [CategoryController::class, 'show']);

// Cart routes (session-based) - using Sanctum stateful middleware
Route::middleware([\Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class])->prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index']);
    Route::post('/', [CartController::class, 'store']);
    Route::put('/{id}', [CartController::class, 'update']);
    Route::delete('/{id}', [CartController::class, 'destroy']);
    Route::delete('/', [CartController::class, 'clear']);
});

// Checkout also needs web middleware for session access
Route::middleware(['web', 'auth:sanctum'])->group(function () {
    Route::post('/checkout', [CheckoutController::class, 'store']);
});

// Checkout routes
Route::post('/checkout/validate-coupon', [CheckoutController::class, 'validateCoupon']);
Route::post('/checkout/stripe-webhook', [CheckoutController::class, 'stripeWebhook']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // User Profile
    Route::get('/profile', [\App\Http\Controllers\API\UserController::class, 'profile']);
    Route::put('/profile', [\App\Http\Controllers\API\UserController::class, 'updateProfile']);
    Route::put('/profile/password', [\App\Http\Controllers\API\UserController::class, 'changePassword']);
    
    // Orders
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{orderNumber}', [OrderController::class, 'show']);
    Route::post('/orders/{orderNumber}/cancel', [OrderController::class, 'cancel']);
    
    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist/{productId}', [WishlistController::class, 'store']);
    Route::delete('/wishlist/{productId}', [WishlistController::class, 'destroy']);
});

// Public Settings
Route::get('/settings', [\App\Http\Controllers\API\SettingsController::class, 'getPublicSettings']);

// Contact Form
Route::post('/contact', [\App\Http\Controllers\API\ContactController::class, 'store']);

// Newsletter
Route::post('/newsletter/subscribe', [\App\Http\Controllers\Api\NewsletterController::class, 'subscribe']);
Route::post('/newsletter/unsubscribe', [\App\Http\Controllers\Api\NewsletterController::class, 'unsubscribe']);

// Deals
Route::get('/deals', [\App\Http\Controllers\API\DealController::class, 'index']);
Route::get('/deals/featured', [\App\Http\Controllers\API\DealController::class, 'featured']);
Route::get('/deals/products', [\App\Http\Controllers\Api\DealsController::class, 'index']);

// New Arrivals
Route::get('/new-arrivals', [\App\Http\Controllers\Api\NewArrivalsController::class, 'index']);

// Product Image Upload (for testing)
Route::post('/products/{product}/upload-image', [\App\Http\Controllers\Admin\AdminProductController::class, 'uploadImage']);

// Product Management API
Route::post('/products/create', [\App\Http\Controllers\API\ProductManagementController::class, 'store']);
Route::get('/products/categories', [\App\Http\Controllers\API\ProductManagementController::class, 'getCategories']);
Route::get('/products/brands', [\App\Http\Controllers\API\ProductManagementController::class, 'getBrands']);

// Product Reviews
Route::get('/products/{product}/reviews', [\App\Http\Controllers\API\ReviewController::class, 'index']);
Route::middleware('auth:sanctum')->post('/products/{product}/reviews', [\App\Http\Controllers\API\ReviewController::class, 'store']);

// CSRF Cookie route for Sanctum
Route::get('/sanctum/csrf-cookie', function () {
    return response()->json(['message' => 'CSRF cookie set']);
});

// Admin routes
Route::prefix('admin')->group(base_path('routes/admin.php'));