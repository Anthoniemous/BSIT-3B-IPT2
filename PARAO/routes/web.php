<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
})->name('login.submit');

Route::get('/dashboard', function () {
    return view('auth.dashboard');
})->name('dashboard');
