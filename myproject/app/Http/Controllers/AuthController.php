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
    // ✅ Validate inputs
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    $credentials = $request->only('email', 'password');

    // 🔹 Hardcoded Admin Login
    if ($credentials['email'] === 'eljohn@gmail.com' && $credentials['password'] === 'admin123') {
        // Check if admin exists in DB, if not, create
        $admin = User::firstOrCreate(
            ['email' => 'eljohn@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        Auth::login($admin);
        $request->session()->put('role', 'admin');
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard')
                         ->with('success', 'Welcome Admin!');
    }

    // 🔹 Normal login attempt
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        $user = Auth::user();

        // ✅ Role-based redirect
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard')
                                 ->with('success', 'Welcome Admin!');
            
            case 'customer':
                if (!$user->hasVerifiedEmail()) {
                    Auth::logout();
                    return redirect()->route('login')
                                     ->with('error', 'Please verify your email first.');
                }
                return redirect()->route('customer.dashboard')
                                 ->with('success', 'Welcome to your dashboard!');
            
            default:
                Auth::logout();
                return redirect()->route('login')
                                 ->with('error', 'Role not recognized.');
        }
    }

    // ❌ Invalid credentials
    return back()->withErrors([
        'email' => 'Incorrect email or password!',
    ]);
}

    // ✅ Logout
 // AuthController.php
public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/'); // 👈 Dapat ani na
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
