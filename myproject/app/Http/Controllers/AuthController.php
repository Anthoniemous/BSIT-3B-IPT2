<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ✅ Show Register Form
    public function showRegister()
    {
        return view('auth.register');
    }

    // ✅ Handle Registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer',
        ]);

        // Send email verification link
        $user->sendEmailVerificationNotification();

        return redirect()->route('verification.notice')
            ->with('message', 'Verification link sent! Check your email.');
    }

    // ✅ Show Login Page
    public function showLogin()
    {
        return view('auth.login');
    }

    // ✅ Handle Login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // ✅ Hardcoded Admin Login
        if ($credentials['email'] === 'eljohn@gmail.com' && $credentials['password'] === 'admin123') {
            $request->session()->put('role', 'admin');
            $request->session()->regenerate();

            // Redirect to Admin Dashboard
            return redirect()->route('admin.dashboard')->with('success', 'Welcome Admin!');
        }

        // ✅ Customer Login via Database
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $request->session()->put('role', 'customer');

            return redirect()->route('customer.dashboard')->with('success', 'Welcome to your dashboard!');
        }

        // ❌ Invalid credentials
        return back()->withErrors([
            'email' => 'Incorrect email or password!',
        ]);
    }

    // ✅ Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // ✅ Customer Dashboard
    public function dashboard()
    {
        $products = Product::all();
        return view('customer.dashboard', compact('products'));
    }
}
