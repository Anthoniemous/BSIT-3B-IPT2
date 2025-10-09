<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\AdminGoogleAuthController;
use App\Http\Controllers\ProductController;

// ===================================================
// Default landing → welcome page
// ===================================================
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// ===================================================
// Authentication Routes
// ===================================================
Route::get('/login', [Controller::class, 'showLogin'])->name('login');
Route::post('/login', [Controller::class, 'login']);

Route::get('/register', [Controller::class, 'showRegister'])->name('register');
Route::post('/register', [Controller::class, 'register']);

// ===================================================
// Dashboard (Protected)
// ===================================================
Route::get('/dashboard', [ProductController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// ===================================================
// Email Verification
// ===================================================
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// ===================================================
// Protected routes (auth required)
// ===================================================
Route::middleware('auth')->group(function () {
    Route::post('/logout', [Controller::class, 'logout'])->name('logout');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===================================================
// Google Auth (User + Admin)
// ===================================================
Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('google-auth');
Route::get('auth/google/callback', [GoogleAuthController::class, 'callbackGoogle'])->name('google-callback');

Route::get('/admin/auth/google', [AdminGoogleAuthController::class, 'redirect'])->name('admin.google.redirect');
Route::get('/admin/auth/google/callback', [AdminGoogleAuthController::class, 'callback']);

// ===================================================
// Product Routes
// ===================================================
Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
