<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function create()
    {
        return view('auth.admin-login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();

            if (!$admin->hasVerifiedEmail()) {
                return redirect()->route('verification.notice');
            }

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid email or password.']);
    }

    public function destroy()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
