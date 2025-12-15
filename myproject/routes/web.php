<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Models\User; // <-- KINI ANG GIDUGANG ARON MA-FIX ANG "Class 'User' not found" ERROR
// ... (ubang uses)
use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
// ... (ubang uses)
use App\Http\Controllers\CheckoutController;
use Illuminate\Http\Request; // Gidugang usab kini kung wala pa (para sa Route closure)
use Illuminate\Support\Facades\Auth; // Gidugang usab kini kung wala pa
use Illuminate\Support\Facades\Mail; // Gidugang usab kini kung wala pa


// 🔸 Root Route Logic (FIXED: Dili na mag-loop sa login)
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        // Role-based redirect para sa root /
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('customer.dashboard');
    }
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
// Logout (Use the correct, fixed logout in AuthController)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); 

/*
|--------------------------------------------------------------------------|
| EMAIL VERIFICATION ROUTES
|--------------------------------------------------------------------------|
*/
// (Verification routes here are unchanged)
Route::get('/email/verify', [VerificationController::class, 'notice'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    // Karon, gi-recognize na sa PHP ang "User" tungod sa import sa taas.
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

Route::post('/email/resend', [VerificationController::class, 'resend'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.resend');

/*
|--------------------------------------------------------------------------|
| DASHBOARD ROUTES (Protected by Auth and Verification)
|--------------------------------------------------------------------------|
*/

// ✅ Customer Dashboard (The main product list view)
Route::get('/customer/dashboard', [ProductController::class, 'customerDashboard'])
    ->middleware(['auth', 'verified'])
    ->name('customer.dashboard');

// ✅ Admin Dashboard (Protected by admin middleware)
Route::get('/admin/dashboard', [ProductController::class, 'mainDashboard'])
    ->middleware(['auth', 'admin']) 
    ->name('admin.dashboard');

/*
|--------------------------------------------------------------------------|
| ADMIN PRODUCT MANAGEMENT ROUTES (Protected by admin middleware)
|--------------------------------------------------------------------------|
*/
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});

/*
|--------------------------------------------------------------------------|
| CUSTOMER ROUTES (Protected by Auth and Verification)
|--------------------------------------------------------------------------|
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // 🛒 Cart Routes
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/buy/{id}', [CartController::class, 'buyNow'])->name('buy.now'); // 👈 ADDED THIS ROUTE
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // 👤 Profile Routes
    Route::get('/profile', [CustomerController::class, 'showProfile'])->name('customer.profile');
    Route::put('/profile/update', [CustomerController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/store', [ProfileController::class, 'store'])->name('profile.store');

    // 🏠 Customer Home (Alternative dashboard route)
    Route::get('/dashboard', [CustomerController::class, 'index'])->name('customer.home'); 
    Route::post('/save-profile', [CustomerController::class, 'saveProfile'])->name('customer.profile.save');

    // ❤️ Wishlist Routes
    Route::get('/wishlist', [CustomerController::class, 'wishlist'])->name('customer.wishlist');
    Route::post('/wishlist/toggle/{id}', [CustomerController::class, 'toggleWishlist'])->name('customer.wishlist.toggle');
    Route::post('/wishlist/remove/{id}', [CustomerController::class, 'removeFromWishlist'])->name('wishlist.remove');

    // 💳 Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
});

/*
|--------------------------------------------------------------------------|
| GOOGLE LOGIN ROUTES
|--------------------------------------------------------------------------|
*/
// Siguradoha nga gi-import nimo ang GoogleAuthController sa taas kung gigamit nimo kini
// Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('google-auth');
// Route::get('auth/google/call-back', [GoogleAuthController::class, 'callbackGoogle']);

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