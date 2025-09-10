<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\studentController;
use App\Http\Controllers\doctorsController;
use App\Http\Controllers\aboutController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Socialite\ProviderRedirectController;
use App\Http\Controllers\Socialite\ProviderCallbackController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Auth::routes([
    'verify' => true
]);
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/auth/{provider}/redirect', ProviderRedirectController::class)->name('auth.redirect');
Route::get('/auth/{provider}/callback', ProviderCallbackController::class)->name('auth.callback');
Route::view('/privacy-policy', 'privacy-policy')->name('privacy.policy');


Route::get('/patients',[studentController::class, 'displayStudent'])->name('patients');
Route::get('/sales',[studentController::class, 'displayStudent'])->name('sales');
Route::get('/patients/list',[studentController::class, 'patientsList'])->name('patients.list');
Route::get('/doctors',[doctorsController::class, 'displayDoctor'])->name('doctors');
Route::get('/about',[aboutController::class, 'about'])->name('about');
Route::get('/add-student', [studentController::class, 'addStudent'])->name('add.student');
Route::post('/patients/store', [PatientController::class, 'store'])->name('patients.store');


require __DIR__.'/auth.php';
