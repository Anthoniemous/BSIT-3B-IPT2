<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerifyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\PasswordController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');


Route::get('/dashboard', function () {
    return view('auth.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = User::findOrFail($id);

    if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        abort(403, 'Invalid verification link.');
    }

    if ($user->hasVerifiedEmail()) {
        return redirect()->route('dashboard')->with('success', 'Email already verified.');
    }
    $user->is_verified = '1';
    $user->markEmailAsVerified();
    $user->status = 'active';
    $user->save();

    event(new Verified($user));

    Auth::login($user);

    return redirect()->route('dashboard')->with('success', 'Your email has been verified and your account is now active.');
})->middleware(['signed', 'web'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
Route::put('/password', [PasswordController::class, 'update'])->name('password.update');

Route::get("auth/google", [GoogleController::class, 'redirectToGoogle'])->name('redirect.google');
Route::get("auth/google/callback", [GoogleController::class, 'handleGoogleCallback']);