<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\GoogleAuthController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Auth routes
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/')->with('success', 'You have been logged out successfully.');
})->name('logout');

Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Product routes
Route::get('/product', [ProductController::class, 'index'])->name('product.index'); 
Route::resource('products', ProductController::class);
Route::get('/storage-products', [ProductController::class, 'storage'])->name('products.storage');
Route::put('/products/{product}/deactivate', [ProductController::class, 'deactivate'])->name('products.deactivate');
Route::put('/products/{product}/activate', [ProductController::class, 'activate'])->name('products.activate');


// Protected route example (for logged-in users only)
Route::middleware(['auth'])->group(function () {
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
});

// Google Login (optional)
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');

// Temporary forgot password placeholder
Route::get('/forgot-password', function () {
    return 'Forgot password feature coming soon!';
})->name('password.request');
