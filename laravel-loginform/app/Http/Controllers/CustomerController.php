<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class CustomerController extends Controller
{
    // Dashboard
    public function index()
    {
        $products = Product::all();
        return view('customer.dashboard', compact('products'));
    }

    // Show Profile View Page (optional separate view)
    public function showProfile()
    {
        $user = Auth::user();
        return view('customer.profile', compact('user'));
    }

    public function updateProfile(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name' => 'required|string|max:255',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    if ($request->hasFile('profile_image')) {
        $path = $request->file('profile_image')->store('profiles', 'public');
        $user->profile_image = $path;
    }

    $user->name = $request->name;
    $user->save();

    return redirect()->route('customer.dashboard')->with('success', 'Profile updated successfully!');
}
}
