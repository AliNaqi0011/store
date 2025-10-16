<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Default login route (check admin auth first)
Route::get('/login', function () {
    if (auth('admin')->check()) {
        return redirect()->route('admin.dashboard');
    }
    // Serve Vue.js app for frontend login
    return response(file_get_contents(public_path('index.html')))
        ->header('Content-Type', 'text/html');
})->name('login');

// Dashboard redirect to admin dashboard
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
});

// Serve Vue.js frontend (must be last)
Route::get('/{any}', function () {
    return file_get_contents(public_path('index.html'));
})->where('any', '^(?!api|admin|storage|login|dashboard).*$');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminController::class, 'login']);
    });
    
    // Authenticated routes
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
        
        // Products Management
        Route::resource('products', AdminProductController::class);
        Route::patch('/products/{product}/toggle-status', [AdminProductController::class, 'toggleStatus'])->name('products.toggle-status');
        
        // Settings Management
        Route::get('/settings', [\App\Http\Controllers\Admin\AdminSettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings', [\App\Http\Controllers\Admin\AdminSettingsController::class, 'update'])->name('settings.update');
        Route::get('/settings/theme', [\App\Http\Controllers\Admin\AdminSettingsController::class, 'theme'])->name('settings.theme');
        Route::post('/settings/theme', [\App\Http\Controllers\Admin\AdminSettingsController::class, 'updateTheme'])->name('settings.theme.update');
        
        // Order Management
        Route::get('/orders', [\App\Http\Controllers\Admin\AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [\App\Http\Controllers\Admin\AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status', [\App\Http\Controllers\Admin\AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
        
        // Category Management
        Route::resource('categories', \App\Http\Controllers\Admin\AdminCategoryController::class);
        Route::patch('/categories/{category}/toggle-status', [\App\Http\Controllers\Admin\AdminCategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
        
        // Customer Management
        Route::get('/customers', [\App\Http\Controllers\Admin\AdminCustomerController::class, 'index'])->name('customers.index');
        Route::get('/customers/{user}', [\App\Http\Controllers\Admin\AdminCustomerController::class, 'show'])->name('customers.show');
        
        // Analytics
        Route::get('/analytics', [\App\Http\Controllers\Admin\AdminAnalyticsController::class, 'index'])->name('analytics.index');
        Route::get('/analytics/sales-report', [\App\Http\Controllers\Admin\AdminAnalyticsController::class, 'salesReport'])->name('analytics.sales-report');
        Route::get('/analytics/customers', [\App\Http\Controllers\Admin\AdminAnalyticsController::class, 'customerAnalytics'])->name('analytics.customers');
        Route::get('/analytics/products', [\App\Http\Controllers\Admin\AdminAnalyticsController::class, 'productAnalytics'])->name('analytics.products');
        
        // Contact Messages
        Route::get('/contacts', [\App\Http\Controllers\Admin\AdminContactController::class, 'index'])->name('contacts.index');
        Route::get('/contacts/{contact}', [\App\Http\Controllers\Admin\AdminContactController::class, 'show'])->name('contacts.show');
        Route::patch('/contacts/{contact}/status', [\App\Http\Controllers\Admin\AdminContactController::class, 'updateStatus'])->name('contacts.status');
        Route::delete('/contacts/{contact}', [\App\Http\Controllers\Admin\AdminContactController::class, 'destroy'])->name('contacts.destroy');
        
        // Deal Management
        Route::resource('deals', \App\Http\Controllers\Admin\AdminDealController::class);
        
        // Brand Management
        Route::resource('brands', \App\Http\Controllers\Admin\AdminBrandController::class);
        Route::patch('/brands/{brand}/toggle-status', [\App\Http\Controllers\Admin\AdminBrandController::class, 'toggleStatus'])->name('brands.toggle-status');
        
        // Coupon Management
        Route::resource('coupons', \App\Http\Controllers\Admin\AdminCouponController::class);
        Route::patch('/coupons/{coupon}/toggle-status', [\App\Http\Controllers\Admin\AdminCouponController::class, 'toggleStatus'])->name('coupons.toggle-status');
        
        // Review Management
        Route::get('/reviews', [\App\Http\Controllers\Admin\AdminReviewController::class, 'index'])->name('reviews.index');
        Route::get('/reviews/{review}', [\App\Http\Controllers\Admin\AdminReviewController::class, 'show'])->name('reviews.show');
        Route::patch('/reviews/{review}/approve', [\App\Http\Controllers\Admin\AdminReviewController::class, 'approve'])->name('reviews.approve');
        Route::patch('/reviews/{review}/reject', [\App\Http\Controllers\Admin\AdminReviewController::class, 'reject'])->name('reviews.reject');
        Route::delete('/reviews/{review}', [\App\Http\Controllers\Admin\AdminReviewController::class, 'destroy'])->name('reviews.destroy');
        Route::post('/reviews/bulk-action', [\App\Http\Controllers\Admin\AdminReviewController::class, 'bulkAction'])->name('reviews.bulk-action');
        
        // Marketing Tools
        Route::get('/marketing/newsletter', [\App\Http\Controllers\Admin\AdminMarketingController::class, 'newsletter'])->name('marketing.newsletter');
        Route::get('/marketing/export-subscribers', [\App\Http\Controllers\Admin\AdminMarketingController::class, 'exportSubscribers'])->name('marketing.export-subscribers');
        Route::patch('/marketing/unsubscribe/{subscriber}', [\App\Http\Controllers\Admin\AdminMarketingController::class, 'unsubscribeNewsletter'])->name('marketing.unsubscribe');
        Route::get('/marketing/seo', [\App\Http\Controllers\Admin\AdminMarketingController::class, 'seo'])->name('marketing.seo');
        Route::post('/marketing/seo', [\App\Http\Controllers\Admin\AdminMarketingController::class, 'storeSeo'])->name('marketing.store-seo');
        Route::get('/marketing/social-media', [\App\Http\Controllers\Admin\AdminMarketingController::class, 'socialMedia'])->name('marketing.social-media');
        Route::post('/marketing/social-media', [\App\Http\Controllers\Admin\AdminMarketingController::class, 'updateSocialMedia'])->name('marketing.update-social-media');
    });
});