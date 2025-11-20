<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\User;

// 🔸 Default redirect to Login
Route::get('/', function () {
    return redirect()->route('login');
});

// 🔸 Laravel built-in auth (with email verification enabled)
Auth::routes(['verify' => true]);

/*
|--------------------------------------------------------------------------|
| AUTHENTICATION ROUTES
|--------------------------------------------------------------------------|
*/

// ✅ Register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// ✅ Login / Logout
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------|
| EMAIL VERIFICATION ROUTES
|--------------------------------------------------------------------------|
*/

// ✅ Show verification notice
Route::get('/email/verify', [VerificationController::class, 'notice'])
    ->middleware('auth')
    ->name('verification.notice');

// ✅ Verify email via link (Laravel 12 compatible)
Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = User::findOrFail($id);

    if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        abort(403, 'Invalid verification link.');
    }

    if (! $user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
    }

    Auth::login($user);
    $request->session()->regenerate();

    return redirect()->route('customer.dashboard')
        ->with('success', 'Email verified successfully! Welcome!');
})->middleware('signed')->name('verification.verify');

// ✅ Resend verification link
Route::post('/email/resend', [VerificationController::class, 'resend'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.resend');

/*
|--------------------------------------------------------------------------|
| DASHBOARD ROUTES
|--------------------------------------------------------------------------|
*/

// ✅ Customer Dashboard with sorting (verified users only)
Route::get('/customer/dashboard', [ProductController::class, 'customerDashboard'])
    ->middleware(['auth', 'verified'])
    ->name('customer.dashboard');

// ✅ Admin Dashboard (pass products to view)
Route::get('/admin/dashboard', [ProductController::class, 'mainDashboard'])
    ->name('admin.dashboard');

/*
|--------------------------------------------------------------------------|
| ADMIN PRODUCT MANAGEMENT ROUTES
|--------------------------------------------------------------------------|
*/
Route::prefix('admin')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});

/*
|--------------------------------------------------------------------------|
| GOOGLE LOGIN ROUTES
|--------------------------------------------------------------------------|
*/
Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('google-auth');
Route::get('auth/google/call-back', [GoogleAuthController::class, 'callbackGoogle']);

/*
|--------------------------------------------------------------------------|
| TEST MAIL (Mailtrap or Mailpit)
|--------------------------------------------------------------------------|
*/
Route::get('/test-mail', function () {
    Mail::raw('Test email from Coffee Shop system.', function ($message) {
        $message->to('test@example.com')->subject('Test Email');
    });
    return '✅ Test email sent successfully!';
});

// Add to Cart
Route::post('/cart/add/{id}', [CartController::class, 'add'])->middleware(['auth'])->name('cart.add');

// View Cart
Route::get('/cart', [CartController::class, 'index'])->middleware(['auth'])->name('cart.index');

// Update quantity
Route::post('/cart/update/{id}', [CartController::class, 'update'])->middleware(['auth'])->name('cart.update');

// Remove from cart
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->middleware(['auth'])->name('cart.remove');

// PROFILE CUSTOMER
Route::get('/profile', function () {
    return view('customer.profile');
})->name('customer.profile')->middleware('auth');

Route::get('/profile', [CustomerController::class, 'showProfile'])
    ->name('customer.profile')
    ->middleware('auth');

Route::put('/profile/update', [CustomerController::class, 'updateProfile'])
    ->name('profile.update')
    ->middleware('auth');

Route::post('/profile/store', [ProfileController::class, 'store'])->name('profile.store');

// Auth middleware group for customer profile & home
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'index'])->name('customer.home');
    Route::post('/save-profile', [CustomerController::class, 'saveProfile'])->name('customer.profile.save');
});
