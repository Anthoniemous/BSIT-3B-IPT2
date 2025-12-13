<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Admin\DashboardController;

use App\Models\Product;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $products = Product::latest()->take(6)->get();
    return view('welcome', compact('products'));
})->name('welcome');

/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/
Route::get('/login', [Controller::class, 'showLogin'])->name('login');
Route::post('/login', [Controller::class, 'login'])->name('login.post');

Route::get('/register', [Controller::class, 'showRegister'])->name('register');
Route::post('/register', [Controller::class, 'register'])->name('register.post');

Route::post('/logout', [Controller::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| FORGOT / RESET PASSWORD
|--------------------------------------------------------------------------
*/
Route::get('/forgotpassword', [PasswordController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgotpassword', [PasswordController::class, 'sendResetLink'])->name('password.email');

Route::get('/reset-password/{token}', [PasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordController::class, 'reset'])->name('password.update');

/*
|--------------------------------------------------------------------------
| EMAIL VERIFICATION
|--------------------------------------------------------------------------
*/
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = User::findOrFail($id);

    if (! hash_equals(sha1($user->getEmailForVerification()), $hash)) {
        abort(403);
    }

    if (! $user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
        event(new Verified($user));
    }

    return redirect()->route('login')->with('message', 'Email verified successfully!');
})->middleware('signed')->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

/*
|--------------------------------------------------------------------------
| USER DASHBOARD & PRODUCTS
|--------------------------------------------------------------------------
*/
Route::get('/userdashboard', [ProductController::class, 'userDashboard'])
    ->middleware(['auth', 'verified'])
    ->name('user.dashboard');

Route::get('/userdashboard/search', [ProductController::class, 'userDashboard'])
    ->middleware('auth')
    ->name('user.search');

/*
|--------------------------------------------------------------------------
| CART
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/update/{cart}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::post('/cart/update-size/{cart_id}', [CartController::class, 'updateSize'])->name('cart.updateSize');

    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});

/*
|--------------------------------------------------------------------------
| ORDERS (USER)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // View all orders
    Route::get('/orders', [OrderController::class, 'index'])
        ->name('orders.index');

    // ✅ STORE ORDER (FIX FOR YOUR ERROR)
    Route::post('/orders', [OrderController::class, 'store'])
        ->name('orders.store');

    // View single order
    Route::get('/orders/{order}', [OrderController::class, 'show'])
        ->name('orders.show');

    // Cancel order
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])
        ->name('orders.cancel');
});

/*
|--------------------------------------------------------------------------
| WISHLIST
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add/{product}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::post('/wishlist/move-to-cart/{id}', [WishlistController::class, 'moveToCart'])->name('wishlist.moveToCart');
});

/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
});

/*
|--------------------------------------------------------------------------
| ADMIN PANEL (NO DUPLICATES)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Orders
    Route::get('/orders', [OrderController::class, 'adminIndex'])->name('orders.index');
    Route::patch('/orders/{order}/status', [OrderController::class, 'adminUpdateStatus'])->name('orders.updateStatus');
    Route::delete('/orders/{order}', [OrderController::class, 'adminRemove'])->name('orders.remove');
});

/*
|--------------------------------------------------------------------------
| GOOGLE AUTH
|--------------------------------------------------------------------------
*/
Route::get('auth/google', [Controller::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [Controller::class, 'handleGoogleCallback']);
