<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

// Default landing → login page
Route::get('/', [Controller::class, 'showLogin']);

// Login routes
Route::get('/login', [Controller::class, 'showLogin'])->name('login');
Route::post('/login', [Controller::class, 'login']);

// Register routes
Route::get('/register', [Controller::class, 'showRegister'])->name('register');
Route::post('/register', [Controller::class, 'register']);

// Protected routes → must be logged in
Route::middleware('auth')->group(function() {
    Route::get('/dashboard', function() {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/logout', [Controller::class, 'logout'])->name('logout');
});
