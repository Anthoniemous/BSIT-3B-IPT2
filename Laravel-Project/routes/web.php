<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\OrderController;
use App\Models\Product;
use Illuminate\Http\Request;




// ====================== HOME ======================
Route::get('/', function () {
    $products = Product::latest()->take(6)->get();
    return view('welcome', compact('products'));
})->name('welcome');

// ====================== AUTHENTICATION ======================
Route::get('/login', [Controller::class, 'showLogin'])->name('login');
Route::post('/login', [Controller::class, 'login'])->name('login.post');

Route::get('/register', [Controller::class, 'showRegister'])->name('register');
Route::post('/register', [Controller::class, 'register'])->name('register.post');

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

// ====================== DASHBOARDS ======================
// Admin Dashboard
Route::get('/dashboard', function () {
    $products = Product::all();
    return view('dashboard', compact('products'));
})->middleware(['auth', 'is_admin'])->name('dashboard');

// User Dashboard
Route::get('/userdashboard', [ProductController::class, 'userDashboard'])
    ->middleware(['auth', 'verified'])
    ->name('user.dashboard');

// ====================== PRODUCTS ======================
// Admin Products
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::resource('admin/products', ProductController::class);
});

// ====================== CART ======================
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

    // Updated route for Add to Cart (Route Model Binding)
   Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');

    Route::delete('/cart/remove/{cart}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});

// ====================== EMAIL VERIFICATION ======================
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->intended(
        auth()->user()->role === 'admin' ? route('dashboard') : route('user.dashboard')
    );
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// ====================== LOGOUT & PROFILE ======================
Route::middleware('auth')->group(function () {
    Route::post('/logout', [Controller::class, 'logout'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ====================== GOOGLE AUTH ======================
Route::get('auth/google', [Controller::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [Controller::class, 'handleGoogleCallback']);
