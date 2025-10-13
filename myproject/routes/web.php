<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\GoogleAuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

// Default redirect to login
Route::get('/', function () {
    return redirect()->route('login');
});

// ✅ Auth Routes with Email Verification
Auth::routes(['verify' => true]);

// ✅ Register Routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// ✅ Email Verification Routes
Route::get('/email/verify', [VerificationController::class, 'notice'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::post('/email/resend', [VerificationController::class, 'resend'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.resend');

// ✅ Login / Logout
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ✅ Customer Dashboard (must be verified)
Route::get('/customer/dashboard', [AuthController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('customer.dashboard');

// ✅ Admin Dashboard — hardcoded access (no auth middleware needed)
Route::get('/admin/dashboard', [ProductController::class, 'index'])
    ->name('admin.dashboard');

// ✅ Admin Product Management CRUD
Route::prefix('admin')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});

// ✅ Google Login Routes
Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('google-auth');
Route::get('auth/google/call-back', [GoogleAuthController::class, 'callbackGoogle']);

// ✅ Test Mail Route (Mailpit)
Route::get('/test-mail', function () {
    Mail::raw('Test email from Coffee Shop system.', function ($message) {
        $message->to('test@example.com')->subject('Test Email');
    });

    return 'Email sent!';
});
