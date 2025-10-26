<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerProfileController extends Controller
{
    public function edit()
    {
        if (session('role') !== 'customer') {
            return redirect('/login')->with('error', 'Please log in as a customer.');
        }

        $customer = DB::table('customer')->where('customer_id', session('customer_id'))->first();
        return view('customer_profile', compact('customer'));
    }

    public function update(Request $request)
    {
        if (session('role') !== 'customer') {
            return redirect('/login');
        }

        $request->validate([
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $imagePath = null;

        // Handle image upload
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/profile_images'), $imageName);
            $imagePath = 'uploads/profile_images/' . $imageName;
        }

        // Update database
        DB::table('customer')->where('customer_id', session('customer_id'))->update([
            'profile_image' => $imagePath,
        ]);

        // Update session for instant display
        session(['customer_image' => $imagePath]);

        return redirect()->route('profile.edit')->with('success', 'Profile image updated successfully!');
    }
}
