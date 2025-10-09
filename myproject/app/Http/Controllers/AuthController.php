<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class AuthController extends Controller
{
    // Show register form
    public function showRegister()
    {
        return view('auth.register');
    }

    // Handle registration → save user then redirect to login
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
        ]);

        // auto-login user after registration
        Auth::login($user);

        // send only one verification email
        $user->sendEmailVerificationNotification();

        // redirect to verify notice page
        return redirect()->route('verification.notice')
                        ->with('message', 'We sent you a verification link! Please check your email.');
    }

    // Show login form
    public function showLogin()
    {
        return view('auth.login');
    }

    // Handle login (updated with admin logic)
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // ✅ Hardcoded admin credentials
     if ($credentials['email'] === 'eljohn@gmail.com' && $credentials['password'] === 'admin123') {
    $request->session()->put('role', 'admin');
    $request->session()->regenerate();

    return redirect()->route('admin.dashboard')->with('success', 'Welcome back, Admin!');
}
        // ✅ Existing customer login (from database)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $request->session()->put('role', 'customer');
            return redirect()->route('dashboard');
        }

        // ❌ Invalid credentials
        return back()->withErrors([
            'email' => 'BUGO MALI MANA! USABA.',
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // Dashboard for customer
    public function dashboard()
    {
        $products = Product::all(); // kuha tanan products
    return view('dashboard', compact('products'));
    }
}
