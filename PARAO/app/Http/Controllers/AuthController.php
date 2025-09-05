<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;  
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
        {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                $user = Auth::user();

                if (!$user->hasVerifiedEmail()) {
                    Auth::logout();
                    return redirect()->route('verification.notice')
                                    ->with('error', 'Please verify your email before logging in.');
                }

                return redirect()->route('dashboard')->with('success', 'Login successful!');
            }

            return back()->with('error', 'Invalid credentials.');
        }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if (DB::table('users')->count() === 0) {
            DB::statement('ALTER TABLE users AUTO_INCREMENT = 1;');
        }


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 'pending',
        ]);

        event(new Registered($user));

        // Redirect to verification notice
        $user->sendEmailVerificationNotification();
        return redirect()->route('verification.notice')->with('status', 'verification-link-sent');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome')->with('success', 'You have been logged out.');
    }
}
