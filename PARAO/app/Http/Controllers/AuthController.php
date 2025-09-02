<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if ($email === 'admin@example.com' && $password === 'password') {
            return redirect()->route('dashboard')->with('success', 'Login successful!');
        } else {
            return back()->with('error', 'Invalid credentials');
        }
    }
}
