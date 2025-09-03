<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProfileController;

// 🔹 Default landing → login page
Route::get('/', [Controller::class, 'showLogin']);

// 🔹 Login routes
Route::get('/login', [Controller::class, 'showLogin'])->name('login');
Route::post('/login', [Controller::class, 'login']);

// 🔹 Register routes
Route::get('/register', [Controller::class, 'showRegister'])->name('register');
Route::post('/register', [Controller::class, 'register']);

// 🔹 Protected routes → must be logged in
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile (para dili na mag error sa route('profile.edit'))
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Logout
    Route::POST('/logout', [Controller::class, 'logout'])->name('logout');
});

// 🔹 Auth routes (kung naa ka gi-generate gamit Breeze o Jetstream)

