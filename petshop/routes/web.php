<?php
// routes/web.php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/shop', [PetController::class, 'shop'])->name('shop');
Route::get('/pets/{id}', [PetController::class, 'show'])->name('pets.show');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'contactSubmit'])->name('contact.submit');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Google OAuth routes
Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

// Email Verification Routes
Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');
    
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{pet}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{pet}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{pet}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    
    // User Profile
    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
    Route::put('/profile', [HomeController::class, 'profileUpdate'])->name('profile.update');
    Route::get('/orders', [HomeController::class, 'orders'])->name('orders');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Pets Management
    Route::get('/pets', [AdminController::class, 'index'])->name('pets.index');
    Route::post('/pets', [AdminController::class, 'store'])->name('pets.store');
    Route::put('/pets/{pet}', [AdminController::class, 'update'])->name('pets.update');
    Route::delete('/pets/{pet}', [AdminController::class, 'destroy'])->name('pets.destroy');
    
    // Species Management
    Route::get('/species', [AdminController::class, 'speciesIndex'])->name('species.index');
    Route::post('/species', [AdminController::class, 'speciesStore'])->name('species.store');
    Route::put('/species/{species}', [AdminController::class, 'speciesUpdate'])->name('species.update');
    Route::delete('/species/{species}', [AdminController::class, 'speciesDestroy'])->name('species.destroy');
    
    // Suppliers Management
    Route::get('/suppliers', [AdminController::class, 'suppliersIndex'])->name('suppliers.index');
    Route::post('/suppliers', [AdminController::class, 'suppliersStore'])->name('suppliers.store');
    Route::put('/suppliers/{supplier}', [AdminController::class, 'suppliersUpdate'])->name('suppliers.update');
    Route::delete('/suppliers/{supplier}', [AdminController::class, 'suppliersDestroy'])->name('suppliers.destroy');
    
    // Sales Management
    Route::get('/sales', [AdminController::class, 'salesIndex'])->name('sales.index');
    Route::put('/sales/{sale}/status', [AdminController::class, 'updateSaleStatus'])->name('sales.updateStatus');
});