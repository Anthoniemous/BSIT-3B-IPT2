<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // ✅ Show profile
  public function edit()
    {
        $customerId = session('customer_id');
        $customer = DB::table('customer')->where('customer_id', $customerId)->first();

        if (!$customer) {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        return view('customer_profile', compact('customer'));
    }


    // ✅ Update profile image
    public function updateImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|max:2048',
        ]);

        $customerId = session('customer_id');
       $imagePath = $request->file('profile_image')->store('uploads/profile_images', 'public');

        DB::table('customer')
            ->where('customer_id', $customerId)
            ->update(['profile_image' => $imagePath]);

        session(['customer_image' => 'storage/' . $imagePath]);

        return back()->with('success', 'Profile image updated successfully!');
    }

    // ✅ Update email
    public function updateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|unique:customer,email,' . session('customer_id') . ',customer_id']);

        DB::table('customer')
            ->where('customer_id', session('customer_id'))
            ->update(['email' => $request->email]);

        session(['customer_email' => $request->email]);

        return back()->with('success', 'Email updated successfully!');
    }

    // ✅ Change password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
        ]);

        $customer = DB::table('customer')->where('customer_id', session('customer_id'))->first();

        if (!$customer || !Hash::check($request->current_password, $customer->password)) {
            return back()->with('error', 'Your current password is incorrect.');
        }

        DB::table('customer')
            ->where('customer_id', session('customer_id'))
            ->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', 'Password changed successfully!');
    }
}
