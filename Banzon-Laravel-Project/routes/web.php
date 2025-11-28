<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\AdminGoogleAuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerProductController;
use App\Http\Controllers\CustomerProfileController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\WishlistController;

// ===================================================
// Default landing → welcome page
// ===================================================
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// ===================================================
// Google Auth (Customer)
// ===================================================
Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('google-auth');
Route::get('auth/google/callback', [GoogleAuthController::class, 'callbackGoogle'])->name('google-callback');

// ===================================================
// Google Auth (Admin)
// ===================================================
Route::get('admin/auth/google', [AdminGoogleAuthController::class, 'redirect'])->name('admin.google.redirect');
Route::get('admin/auth/google/callback', [AdminGoogleAuthController::class, 'callback'])->name('admin.google.callback');

// ===================================================
// Admin Manual Login (Optional)
// ===================================================
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.post');

// ===================================================
// EMAIL VERIFICATION ROUTES
// ===================================================

// Notice (shown after registration)
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth:customer')->name('verification.notice');


// Verification link (from email)
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->user('customer')->markEmailAsVerified(); 
    return redirect()->route('customer.dashboard');
})->middleware(['auth:customer', 'signed'])->name('verification.verify');


// Resend verification link
Route::post('/email/verification-notification', function (Request $request) {
    $request->user('customer')->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth:customer', 'throttle:6,1'])->name('verification.send');


// ===================================================
// Authentication Routes (General)
// ===================================================
Route::get('/login', [Controller::class, 'showLogin'])->name('login');
Route::post('/login', [Controller::class, 'login']);
Route::get('/register', [Controller::class, 'showRegister'])->name('register');
Route::post('/register', [Controller::class, 'register']);
Route::post('/logout', [Controller::class, 'logout'])->name('logout');

// ===================================================
// Customer Dashboard & Profile (Protected with auth:customer & verified)
// ===================================================
Route::middleware(['auth:customer', 'verified'])->group(function () {
    // Dashboard
    Route::get('/customer/dashboard', [CustomerProductController::class, 'index'])
        ->name('customer.dashboard');

    // Profile
    Route::get('/customer/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/customer/profile/update-image', [ProfileController::class, 'updateImage'])->name('profile.updateImage');
    Route::post('/customer/profile/update-email', [ProfileController::class, 'updateEmail'])->name('profile.updateEmail');
    Route::post('/customer/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');

    // Cart management
    Route::get('/customer/cart', [CustomerProductController::class, 'viewCart'])->name('cart.view');
    Route::post('/customer/cart/add/{id}', [CustomerProductController::class, 'addToCart'])->name('cart.add');
    Route::delete('/customer/cart/remove/{id}', [CustomerProductController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/customer/cart/update', [CustomerProductController::class, 'updateCart'])->name('cart.update');
    Route::get('/customer/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::get('/customer/contact', [ContactController::class, 'index'])->name('contact');
});

// ===================================================
// Admin Dashboard
// ===================================================
Route::get('/admin/dashboard', [ProductController::class, 'index'])
    ->name('dashboard');

// ===================================================
// Product Routes (for Admin)
// ===================================================
Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');
Route::put('/product/{id}/toggle-status', [ProductController::class, 'toggleStatus'])->name('product.toggleStatus');

// Wishlist routes
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
Route::post('/wishlist/add/{id}', [WishlistController::class, 'add'])->name('wishlist.add');
Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::post('/wishlist/move-to-cart/{id}', [WishlistController::class, 'moveToCart'])->name('wishlist.moveToCart');

