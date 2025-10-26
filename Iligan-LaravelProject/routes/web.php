<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\Admin\ProductController;

Route::get('/', function () {
    return view('welcome');
});

// Enable auth + email verification routes
Auth::routes(['verify' => true]);

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

Route::post('/profile/soft-destroy', [ProfileController::class, 'softDestroy'])
    ->middleware(['auth', 'verified'])
    ->name('profile.softDestroy');

require __DIR__.'/auth.php';
