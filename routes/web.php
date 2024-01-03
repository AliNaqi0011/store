<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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
Route::get('/verify', [VerificationController::class, 'verifyUser'])->name('verify.user');
Route::get('/email/verify', [VerificationController::class, 'emailVerifyUser'])->name('email.verification.notice')->middleware('auth');
Route::post('/resend/email/verify', [VerificationController::class, 'resendEmailVerifyUser'])->name('verification.resend')->middleware('auth');
// Route::get('/verify','Auth\RegisterController@verifyUser')->name('verify.user');

Route::middleware(['check.session.data'])->group(function () {
    // Routes that require session data check
    Route::get('/verification', [VerificationController::class, 'verification'])->name('verification');
    Route::post('/verification', [VerificationController::class, 'VerifyEmaiLPhoneOtp'])->name('verify.email.phone.otp');

    Route::get('/2fa-verification', [VerificationController::class, 'two_fa_verification'])->name('two.fa.verification');
    Route::post('/verify-2fa-vemail-otp', [VerificationController::class, 'verify_two_fa_email_otp'])->name('verify.email.otp.two.fa');

    Route::get('/2fa-phone-verification', [VerificationController::class, 'two_fa_phone_verification'])->name('two.fa.phone.verification');
    Route::post('/verify-2fa-phone-otp', [VerificationController::class, 'verify_two_fa_phone_otp'])->name('verify.phone.otp.two.fa');

});




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'check.email.verify'])->name('dashboard');

Route::middleware(['auth', 'check.email.verify'])->group(function () {


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

        Route::get('/', [UserController::class, 'index'])->name('users');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/store', [UserController::class, 'store'])->name('users.store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
        Route::post('/update', [UserController::class, 'update'])->name('users.update');
        Route::get('/delete/{id}', [UserController::class, 'delete'])->name('users.delete');



    });

    Route::group(['prefix' => '/blog'], function () {
        Route::get('/listing',[BlogController::class, 'listing'])->name('blog.listing');
        Route::get('/create',[BlogController::class, 'create'])->name('blog.create');
        Route::post('/store',[BlogController::class, 'store'])->name('blog.store');
        Route::get('/edit/{id}', [BlogController::class, 'edit'])->name('blog.edit');
        Route::post('/update', [BlogController::class, 'update'])->name('blog.update');
        Route::get('/delete/{id}', [BlogController::class, 'delete'])->name('blog.delete');
    });



    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
