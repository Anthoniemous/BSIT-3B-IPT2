<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// Show login page
Route::get('/login', function () {
    return view('login');
})->name('login');

// Handle login form (for now just testing)
Route::post('/login', function (Illuminate\Http\Request $request) {
    // For now, just return the submitted data
    return $request->all();
})->name('login.submit');

