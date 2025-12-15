<?php

use App\Models\Customer;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\AdminGoogleAuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerProductController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ActivityLogController;
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
// Admin Registration (Manual)
Route::get('/admin/register', [AdminController::class, 'showRegister'])->name('admin.register');
Route::post('/admin/register', [AdminController::class, 'register'])->name('admin.register.post');


// ===================================================
// EMAIL VERIFICATION ROUTES
// ===================================================

// Notice (shown after registration)
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth:customer')->name('verification.notice');


// Verification link (from email)

Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {

    $customer = Customer::where('customer_id', $id)->firstOrFail();

    // validate hash
    if (! hash_equals(sha1($customer->getEmailForVerification()), (string) $hash)) {
        abort(403, 'Invalid verification link.');
    }

    // update DB
    if (! $customer->hasVerifiedEmail()) {
        $customer->markEmailAsVerified(); // sets email_verified_at
        event(new Verified($customer));
    }

    // auto-login after verifying
    Auth::guard('customer')->login($customer);
    $request->session()->regenerate();

    return redirect()->route('customer.dashboard')->with('success', 'Email verified successfully!');
})->middleware(['signed'])->name('verification.verify');

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
    Route::get('/customer/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('/customer/place-order', [CheckoutController::class, 'placeOrder'])->name('place.order');
    Route::get('/customer/checkout/cod-info', [CheckoutController::class, 'showCodInfo'])->name('cod.info');
    Route::post('/customer/checkout/cod-confirm', [CheckoutController::class, 'confirmCodOrder'])->name('cod.confirm');

    // Bank checkout routes
    Route::get('/customer/checkout/bank-info', [CheckoutController::class, 'showBankInfo'])->name('bank.info');
    Route::post('/customer/checkout/bank-confirm', [CheckoutController::class, 'confirmBankOrder'])->name('bank.confirm');

    // My Purchases
Route::get('/customer/purchases', [CheckoutController::class, 'myPurchases'])
    ->name('purchases.index');

Route::get('/customer/purchases/{orderId}', [CheckoutController::class, 'showPurchase'])
    ->name('purchases.show');

});

// ===================================================
// Admin Dashboard
// ===================================================

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
    ->name('admin.dashboard');

// Admin Products page (your current dashboard.blade.php content goes here)
Route::get('/admin/products', [ProductController::class, 'index'])
    ->name('admin.products');

// Admin Orders page
Route::get('/admin/orders', [AdminController::class, 'orders'])
    ->name('admin.orders');

    

// Update order status (from Orders page)
Route::put('/admin/orders/{id}/status', [AdminController::class, 'updateOrderStatus'])
    ->name('admin.orders.status');

Route::get('/admin/activity-logs', [ActivityLogController::class, 'index'])
    ->name('admin.activity_logs');


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



