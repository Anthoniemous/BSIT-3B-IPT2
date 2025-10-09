<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        // ✅ 1. Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // ✅ 2. Check if it reaches here
        // (For testing: uncomment next line)
        // dd($request->all());

        // ✅ 3. Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // ✅ 4. Auto login
        Auth::login($user);

        // ✅ 5. Redirect
        return redirect('/product')->with('success', 'Registration successful! Welcome ' . $user->name);
    }
}
