<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered; // ✅ import for event
use App\Models\Customer;

class Controller extends BaseController
{
    use \Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    use \Illuminate\Foundation\Bus\DispatchesJobs;
    use \Illuminate\Foundation\Validation\ValidatesRequests;

    // Show login form
    public function showLogin()
    {
        return view('login'); // /views/login.blade.php
    }

    // Handle login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // ✅ If user not verified → redirect to verification notice
            if (! Auth::user()->hasVerifiedEmail()) {
                return redirect()->route('verification.notice');
            }

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Show registration form
    public function showRegister()
    {
        return view('register'); // /views/register.blade.php
    }

    // Handle registration
public function register(Request $request)
{
    $request->validate([
        'username' => 'required|string|max:50|unique:admin,username',
        'email'    => 'required|email|max:100|unique:admin,email',
        'password' => 'required|confirmed|min:8',
    ]);

    $admin = \App\Models\Admin::create([
        'username' => $request->username,
        'email'    => $request->email,
        'password' => bcrypt($request->password),
    ]);

    Auth::login($admin);

    return redirect()->route('dashboard');
}



    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // ✅ Show forgot password form
    public function showForgotPassword()
    {
        return view('forgotpassword'); // /views/forgotpassword.blade.php
    }

    // ✅ Handle forgot password submission
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // For demo purposes: simulate sending reset link
        return back()->with('success', 'If your email exists, a password reset link has been sent.');
    }
}
