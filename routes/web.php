<?php

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

    // Admin Dashboard
    Route::get('/', [AdminController::class, 'index'])->name('index');

    // Product CRUD Routes
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::put('/products/update/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
});

// Wishlist Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/wishlist/add/{id}', [WishlistController::class, 'add'])->name('wishlist.add');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::get('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::get('/wishlist/move/{id}', [WishlistController::class, 'moveToCart'])->name('wishlist.move');


    // Cart Routes
    Route::post('/cart/add/{id}', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/remove/{id}', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
});
/*
|--------------------------------------------------------------------------
| Auth Extra Routes
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
