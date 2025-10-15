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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
// Hardcoded Admin Login
if ($credentials['email'] === 'eljohn@gmail.com' && $credentials['password'] === 'admin123') {
    $request->session()->put('role', 'admin');
    $request->session()->put('admin_name', 'Eljohn Sodoso'); // Add this
    $request->session()->regenerate();
    return redirect()->route('admin.dashboard')->with('success', 'Welcome Admin!');
}

        // ✅ Customer Login via Database
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $request->session()->put('role', 'customer');

            // Check if email is verified
            if (Auth::user()->hasVerifiedEmail()) {
                return redirect()->route('customer.dashboard')->with('success', 'Welcome to your dashboard!');
            } else {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Please verify your email first.');
            }
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
   // ✅ Customer Dashboard with Search
public function dashboard(Request $request)
{
    $search = trim($request->input('search'));

    $products = Product::query();

    if ($search) {
        $products->where('name', 'like', "%{$search}%")
                 ->orWhere('description', 'like', "%{$search}%");
    }

    $products = $products->get();

    return view('customer.dashboard', compact('products'));
}
     // ✅ Admin Dashboard
    public function adminDashboard() {
        $products = Product::all();
        return view('admin.main-dashboard', compact('products'));
    }
}
