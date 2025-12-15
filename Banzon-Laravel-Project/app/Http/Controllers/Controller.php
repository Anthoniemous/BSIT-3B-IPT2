<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Customer; 
use Illuminate\Auth\Events\Registered;

class Controller extends BaseController
{
    use \Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    use \Illuminate\Foundation\Bus\DispatchesJobs;
    use \Illuminate\Foundation\Validation\ValidatesRequests;

    // ===================================================
    // Show Login Form
    // ===================================================
    public function showLogin()
    {
        return view('login');
    }

    // ===================================================
    // Handle Login (Admin or Customer)
    // ===================================================
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        $email = $request->email;
        $password = $request->password;

        // ✅ 1. Check if the email belongs to an admin
        $admin = DB::table('admin')->where('email', $email)->first();
        if ($admin && Hash::check($password, $admin->password)) {
            // Clear any old session data first
            $request->session()->invalidate();
            $request->session()->regenerate();

            $request->session()->put('role', 'admin');
            $request->session()->put('admin_id', $admin->admin_id);

            return redirect()->route('admin.dashboard')->with('success', 'Welcome back, Admin!');
        }


            $customer = \App\Models\Customer::where('email', $email)->first();

            if ($customer && Hash::check($password, $customer->password)) {

                // ✅ Prevent login if email not verified
                if (!$customer->hasVerifiedEmail()) {
                    return redirect()->back()->with('warning', 'Please verify your email before logging in.');
                }

                // ✅ Log in via customer guard
                Auth::guard('customer')->login($customer);

                $request->session()->regenerate();
                $request->session()->put('role', 'customer');
                $request->session()->put('customer_id', $customer->customer_id);
                $request->session()->put('customer_name', $customer->name);
                $request->session()->put('customer_email', $customer->email);
                $request->session()->put('customer_image', $customer->profile_image ?? 'img/default-profile.png');

                return redirect()->route('customer.dashboard')->with('success', 'Welcome back!');
            }


        // ❌ Invalid credentials
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // ===================================================
    // Show Registration Form (Customers Only)
    // ===================================================
    public function showRegister()
    {
        return view('register');
    }

    // ===================================================
    // Handle Customer Registration
    // ===================================================
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:100|unique:customer,email',
            'password' => 'required|confirmed|min:8',
        ]);

        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // ✅ sends verification email
        event(new Registered($customer));

        // ✅ log them in so they can see the verify notice page
        Auth::guard('customer')->login($customer);
        $request->session()->regenerate();
        $request->session()->put('role', 'customer');
        $request->session()->put('customer_id', $customer->customer_id);

        return redirect()->route('verification.notice')
            ->with('success', 'Account created! Please check your email to verify.');
    }
    // ===================================================
    // Handle Logout (for Admin & Customer)
    // ===================================================
    public function logout(Request $request)
    {
        $request->session()->flush();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'You have been logged out.');
    }

    // ===================================================
    // Forgot Password (optional)
    // ===================================================
    public function showForgotPassword()
    {
        return view('forgotpassword');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        return back()->with('success', 'If your email exists, a password reset link has been sent.');
    }
}
