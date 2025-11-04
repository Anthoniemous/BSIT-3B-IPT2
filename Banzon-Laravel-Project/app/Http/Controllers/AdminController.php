<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // ===================================================
    // Show Admin Login Form
    // ===================================================
    public function showLogin()
    {
        return view('admin.login'); // make sure this view exists
    }

    // ===================================================
    // Handle Admin Login (manual)
    // ===================================================
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $admin = DB::table('admin')->where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            $request->session()->invalidate();
            $request->session()->regenerate();
            $request->session()->put('role', 'admin');
            $request->session()->put('admin_id', $admin->admin_id);

            return redirect()->route('dashboard')->with('success', 'Welcome back, Admin!');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials. Please try again.',
        ]);
    }

    // ===================================================
    // (Optional) Admin Registration (if needed)
    // ===================================================
    public function showRegister()
    {
        return view('admin.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admin,email',
            'password' => 'required|min:8|confirmed',
        ]);

        DB::table('admin')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_at' => now(),
        ]);

        return redirect()->route('admin.login')->with('success', 'Admin registered successfully!');
    }
}
