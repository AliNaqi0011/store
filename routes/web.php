<?php

use App\Http\Controllers\VerificationController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['check.session.data'])->group(function () {
    // Routes that require session data check
    Route::get('/verification', [VerificationController::class, 'verification'])->name('verification');
    Route::post('/verification', [VerificationController::class, 'VerifyEmaiLPhoneOtp'])->name('verify.email.phone.otp');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {


    Route::group(['prefix' => '/user'], function () {
        Route::get('/profile', [UserProfileController::class, 'index'])->name('user.profile');
        Route::get('/profile/edit/{id}', [UserProfileController::class, 'edit'])->name('user.profile.edit');
        Route::post('/profile/update/{id}', [UserProfileController::class, 'update'])->name('user.profile.update');

        Route::get('/profile/social/create}', [UserProfileController::class, 'SocialCreate'])->name('user.profile.social.create');
        Route::post('/profile/social/store}', [UserProfileController::class, 'SocialStore'])->name('user.profile.social.store');
        Route::get('/profile/social/edit/{id}', [UserProfileController::class, 'SocialEdit'])->name('user.profile.social.edit');
        Route::post('/profile/social/update/{id}', [UserProfileController::class, 'SocialUpdate'])->name('user.profile.social.update');

        Route::get('/settings', [UserSettingsController::class, 'index'])->name('user.settings');
        Route::get('/settings/create', [UserSettingsController::class, 'create'])->name('user.settings.create');
        Route::post('/settings/store', [UserSettingsController::class, 'store'])->name('user.settings.store');
        Route::get('/settings/edit/{id}', [UserSettingsController::class, 'edit'])->name('user.settings.edit');
        Route::post('/settings/update/{id}', [UserSettingsController::class, 'update'])->name('user.settings.update');
    });




    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
