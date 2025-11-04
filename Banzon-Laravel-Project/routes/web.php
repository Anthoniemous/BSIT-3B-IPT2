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


// ===================================================
// Default landing → welcome page
// ===================================================
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// ===================================================
// Admin Manual Login (Optional)
// ===================================================
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.post');


// ===================================================
// Authentication Routes (General)
// ===================================================
Route::get('/login', [Controller::class, 'showLogin'])->name('login');
Route::post('/login', [Controller::class, 'login']);
Route::get('/register', [Controller::class, 'showRegister'])->name('register');
Route::post('/register', [Controller::class, 'register']);
Route::post('/logout', [Controller::class, 'logout'])->name('logout');

// ===================================================
// Customer Dashboard
// ===================================================
Route::get('/customer/dashboard', function () {
    if (session('role') !== 'customer') {
        return redirect('/login')->with('error', 'Please log in as a customer.');
    }
    return view('customer_dashboard');
})->name('customer.dashboard');

Route::get('/customer/profile', function () {
    if (session('role') !== 'customer') {
        return redirect('/login')->with('error', 'Please log in as a customer.');
    }

    $customer = DB::table('customer')->where('customer_id', session('customer_id'))->first();
    return view('customer_profile', compact('customer'));
})->name('profile.edit');

// Customer Profile Management
Route::get('/customer/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/customer/profile/update-image', [ProfileController::class, 'updateImage'])->name('profile.updateImage');
Route::post('/customer/profile/update-email', [ProfileController::class, 'updateEmail'])->name('profile.updateEmail');
Route::post('/customer/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');

// ===================================================
// Admin Dashboard
// ===================================================
Route::get('/admin/dashboard', [ProductController::class, 'index'])
    ->name('dashboard');

// ===================================================
// Google Auth (Customer)
// ===================================================
Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('google-auth');
Route::get('auth/google/callback', [GoogleAuthController::class, 'callbackGoogle'])->name('google-callback');

// ===================================================
// Google Auth (Admin)
// ===================================================
Route::get('/admin/auth/google', [AdminGoogleAuthController::class, 'redirect'])->name('admin.google.redirect');
Route::get('/admin/auth/google/callback', [AdminGoogleAuthController::class, 'callback'])->name('admin.google.callback');

// ===================================================
// Product Routes (for Admin)
// ===================================================
Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');
Route::put('/product/{id}/toggle-status', [ProductController::class, 'toggleStatus'])->name('product.toggleStatus');

// Customer Dashboard (shows all active products)
Route::get('/customer/dashboard', [CustomerProductController::class, 'index'])
    ->name('customer.dashboard');

// Cart management
Route::post('/customer/cart/add/{id}', [CustomerProductController::class, 'addToCart'])
    ->name('cart.add');
Route::delete('/customer/cart/remove/{id}', [CustomerProductController::class, 'removeFromCart'])
    ->name('cart.remove');
