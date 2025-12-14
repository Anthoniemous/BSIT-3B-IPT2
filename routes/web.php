<?php
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Root & Auth Routes
|--------------------------------------------------------------------------
*/

// Root route: main homepage
Route::get('/', [PageController::class, 'home'])->name('homepage');

// Authentication routes
Auth::routes([
    'register' => true,
    'reset' => false,
    'verify' => false,
]);

// Home page (for logged-in users)
Route::get('/home', [HomeController::class, 'index'])
    ->middleware(['auth'])
    ->name('home');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Google Login
Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('google-auth');
Route::get('auth/google/call-back', [GoogleAuthController::class, 'callbackGoogle']);



Route::middleware('auth')->group(function () {
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
});


Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
});
/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/

// User product list with filter and sort
Route::get('/products', [ProductController::class, 'userProducts'])->name('products');

// Single product
Route::get('/single-product/{id?}', [PageController::class, 'singleProduct'])->name('single-product');

// Other pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact/send', [PageController::class, 'sendContact'])->name('contact.send');

/*
|--------------------------------------------------------------------------
| Admin Routes (Only for Admins)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // ✅ Admin Dashboard (Main Page)
    Route::get('/', [AdminController::class, 'index'])->name('index');

    // ✅ Products Management Page
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    
    // Product CRUD Routes
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::put('/products/update/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
});


Route::middleware('auth')->group(function () {
    Route::put('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
});

Route::middleware(['auth', 'is_admin'])->group(function() {
    Route::get('/admin/orders', [OrderController::class, 'adminIndex'])->name('admin.orders.index');
});

// Wishlist Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/wishlist/add/{id}', [WishlistController::class, 'add'])->name('wishlist.add');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::get('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::get('/wishlist/move/{id}', [WishlistController::class, 'moveToCart'])->name('wishlist.move');


// Cart Routes
Route::post('/cart/add/{id}', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update/{id}', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');

Route::get('/cart/remove/{id}', [\App\Http\Controllers\CartController::class, 'remove'])->middleware('auth');
Route::delete('/cart/remove/{id}', [\App\Http\Controllers\CartController::class, 'remove'])
    ->middleware('auth')
    ->name('cart.remove');



});
/*
|--------------------------------------------------------------------------
| Auth Extra Routes
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
