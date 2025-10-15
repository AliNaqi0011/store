<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingsController;

// Public admin routes
Route::post('/login', [AuthController::class, 'login']);
Route::get('/settings/public', [SettingsController::class, 'getPublicSettings']);

// Protected admin routes
Route::middleware(['auth:sanctum'])->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);
    
    // Products Management
    Route::apiResource('products', ProductController::class);
    Route::patch('/products/{product}/toggle-status', [ProductController::class, 'toggleStatus']);
    Route::post('/products/bulk-action', [ProductController::class, 'bulkAction']);
    
    // Product Images
    Route::post('/products/{product}/images', [\App\Http\Controllers\Admin\AdminProductController::class, 'uploadImage']);
    Route::delete('/product-images/{image}', [\App\Http\Controllers\Admin\AdminProductController::class, 'deleteImage']);
    Route::patch('/product-images/{image}/primary', [\App\Http\Controllers\Admin\AdminProductController::class, 'setPrimaryImage']);
    
    // Settings Management
    Route::get('/settings', [SettingsController::class, 'index']);
    Route::put('/settings', [SettingsController::class, 'update']);
    
    // Contact Management
    Route::get('/contacts', [\App\Http\Controllers\Admin\AdminContactController::class, 'index'])->name('admin.contacts.index');
    Route::get('/contacts/{contact}', [\App\Http\Controllers\Admin\AdminContactController::class, 'show'])->name('admin.contacts.show');
    Route::patch('/contacts/{contact}/status', [\App\Http\Controllers\Admin\AdminContactController::class, 'updateStatus'])->name('admin.contacts.status');
    Route::delete('/contacts/{contact}', [\App\Http\Controllers\Admin\AdminContactController::class, 'destroy'])->name('admin.contacts.destroy');
    
    // Deal Management
    Route::resource('deals', \App\Http\Controllers\Admin\AdminDealController::class)->names([
        'index' => 'admin.deals.index',
        'create' => 'admin.deals.create',
        'store' => 'admin.deals.store',
        'show' => 'admin.deals.show',
        'edit' => 'admin.deals.edit',
        'update' => 'admin.deals.update',
        'destroy' => 'admin.deals.destroy'
    ]);
});