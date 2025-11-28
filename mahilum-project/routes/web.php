<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\PasswordController;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\WishlistController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Events\Verified;

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

// Forgot / Reset Password
Route::get('/forgotpassword', [\App\Http\Controllers\Auth\PasswordController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgotpassword', [\App\Http\Controllers\Auth\PasswordController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [PasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordController::class, 'reset'])->name('password.update');

// ====================== ORDERS ======================
Route::middleware('auth')->group(function () {
    // User: create order from cart
    Route::get('/order/{cart_id}', [OrderController::class, 'create'])->name('orders.order');

    // Store order
    Route::post('/order/store', [OrderController::class, 'store'])->name('orders.store');

    // User: view their own orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
});

// ✅ ADMIN: View all orders
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/orders', [OrderController::class, 'adminIndex'])->name('admin.orders');
});

// ====================== DASHBOARDS ======================

// Admin Dashboard
Route::get('/dashboard', function () {
    $products = Product::all();
    return view('dashboard', compact('products'));
})->middleware(['auth:admin'])->name('dashboard');

// User Dashboard
Route::get('/userdashboard', [ProductController::class, 'userDashboard'])
    ->middleware(['auth', 'verified'])
    ->name('user.dashboard');
Route::get('/user/dashboard', [ProductController::class, 'userDashboard'])->name('user.dashboard');


// ====================== PRODUCTS ======================
Route::middleware(['auth:admin'])->group(function () {
    Route::resource('admin/products', ProductController::class);
});

// ====================== CART ======================
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});

Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add/{product}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::post('/wishlist/move-to-cart/{id}', [WishlistController::class, 'moveToCart'])->name('wishlist.moveToCart');
});

// ====================== EMAIL VERIFICATION ======================
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// ✅ Guest-safe version (no need to log in first)
Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = User::findOrFail($id);

    if (! hash_equals(sha1($user->getEmailForVerification()), (string) $hash)) {
        abort(403, 'Invalid verification link.');
    }

    if ($user->hasVerifiedEmail()) {
        return redirect()->route('login')->with('message', 'Email already verified.');
    }

    if ($user->markEmailAsVerified()) {
        event(new Verified($user));
    }

    return redirect()->route('login')->with('message', 'Email verified successfully!');
})->middleware('signed')->name('verification.verify');

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

    // 👉 ADD THIS
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
});

// ====================== GOOGLE AUTH ======================
Route::get('auth/google', [Controller::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [Controller::class, 'handleGoogleCallback']);
