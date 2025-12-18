<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Models\User;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AddressLookupController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        return $user->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('customer.dashboard');
    }
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| REMOVE built-in auth routes (AYAW I-MIX)
|--------------------------------------------------------------------------
*/
// ❌ tanggalon ni kay naa kay custom AuthController
// Auth::routes(['verify' => true]);

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (CUSTOM)
|--------------------------------------------------------------------------
*/
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| EMAIL VERIFICATION ROUTES (NO VerificationController)
|--------------------------------------------------------------------------
*/

// ✅ Notice page (you have resources/views/auth/verify.blade.php)
Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

// ✅ Verify link (signed)
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

    // ✅ role-based redirect after verify
    return $user->role === 'admin'
        ? redirect()->route('admin.dashboard')->with('success', 'Email verified! Welcome Admin!')
        : redirect()->route('customer.dashboard')->with('success', 'Email verified! Welcome!');
})->middleware('signed')->name('verification.verify');

// ✅ Resend verification
Route::post('/email/resend', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');

/*
|--------------------------------------------------------------------------
| DASHBOARDS (Protected)
|--------------------------------------------------------------------------
*/
Route::get('/customer/dashboard', [ProductController::class, 'customerDashboard'])
    ->middleware(['auth', 'verified'])
    ->name('customer.dashboard');

Route::get('/admin/dashboard', [ProductController::class, 'mainDashboard'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admin.dashboard');


/*
|--------------------------------------------------------------------------
| ADMIN PRODUCT MANAGEMENT
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/orders', [\App\Http\Controllers\AdminOrderController::class, 'index'])->name('admin.orders.index');
Route::get('/orders/{order}', [\App\Http\Controllers\AdminOrderController::class, 'show'])->name('admin.orders.show');
Route::put('/orders/{order}/status', [\App\Http\Controllers\AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
Route::get('/logs', [\App\Http\Controllers\AdminLogController::class, 'index'])->name('admin.logs');


// activity logs page
Route::get('/logs', [\App\Http\Controllers\AdminLogController::class, 'index'])->name('admin.logs');

});

/*
|--------------------------------------------------------------------------
| CUSTOMER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Cart
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/buy/{id}', [CartController::class, 'buyNow'])->name('buy.now');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // Profile
    Route::get('/profile', [CustomerController::class, 'showProfile'])->name('customer.profile');
    Route::put('/profile/update', [CustomerController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/store', [ProfileController::class, 'store'])->name('profile.store');

    // Home
    Route::get('/dashboard', [CustomerController::class, 'index'])->name('customer.home');
    Route::post('/save-profile', [CustomerController::class, 'saveProfile'])->name('customer.profile.save');

    // Wishlist
    Route::get('/wishlist', [CustomerController::class, 'wishlist'])->name('customer.wishlist');
    Route::post('/wishlist/toggle/{id}', [CustomerController::class, 'toggleWishlist'])->name('customer.wishlist.toggle');
    Route::post('/wishlist/remove/{id}', [CustomerController::class, 'removeFromWishlist'])->name('wishlist.remove');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');

    // My Purchases
Route::get('/my-purchases', [CheckoutController::class, 'myPurchases'])->name('customer.purchases');
Route::get('/my-purchases/{order}', [CheckoutController::class, 'purchaseShow'])->name('customer.purchases.show');

});

/*
|--------------------------------------------------------------------------
| TEST MAIL
|--------------------------------------------------------------------------
*/
Route::get('/test-mail', function () {
    Mail::raw('Test email from Coffee Shop system.', function ($message) {
        $message->to('test@example.com')->subject('Test Email');
    });
    return '✅ Test email sent successfully!';
});

Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/call-back', [GoogleAuthController::class, 'callbackGoogle'])->name('google.callback');
Route::prefix('addr')->group(function () {
    Route::get('/regions',    [AddressLookupController::class, 'regions']);
    Route::get('/provinces',  [AddressLookupController::class, 'provinces']);
    Route::get('/cities',     [AddressLookupController::class, 'cities']);
  
});