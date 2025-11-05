<?php

use App\Models\Admin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AdminAuthController;

// Enable auth + email verification routes
//Auth::routes(['verify' => true]);

Route::get('/', function(){
    return view ('welcome');
})->name('welcome');

Route::get('/user_welcome', function(){
    return view ('user_welcome');
})->name('user_welcome');

Route::get('/admin_welcome', function(){
    return view('admin_welcome');
})->name('admin_welcome');

Route::get('/usertype', function () {
    return view('usertype');    
})->name('usertype');

Route::get('/admin_login', [AdminAuthController::class, 'showLoginForm'])->name('admin_login');
Route::post('/admin_login', [AdminAuthController::class, 'login'])->name('admin_login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
Route::get('/admin/google', [AdminAuthController::class, 'redirectToGoogle'])->name('google-auth');
Route::get('/admin/google/callback', [AdminAuthController::class, 'handleGoogleCallback']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Welcome / Login page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('admin_dashboard', [ProductController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('admin_dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/profile/soft-destroy', [ProfileController::class, 'softDestroy'])
    ->middleware(['auth', 'verified'])
    ->name('profile.softDestroy');

Route::prefix('admin')->group(function() {
    Route::get('/dashboard', [ProductController::class, 'index'])->name('admin_dashboard');
    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::get('/products/search', [ProductController::class, 'search'])->name('admin.products.search');
    Route::put('/products/{product}/soft-delete', [ProductController::class, 'softDelete'])
    ->name('admin.products.softDelete');
});

Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('google-auth');
Route::get('auth/google/call-back', [GoogleAuthController::class, 'callback']);

require __DIR__.'/auth.php';
