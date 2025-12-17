<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'address'       => 'nullable|string|max:255', // ✅ not required (para di mo fail)
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // ✅ Upload image if present
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');

            $imageName = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());

            // delete old image if exists
            if ($user->profile_image && Storage::disk('public')->exists('profile/' . $user->profile_image)) {
                Storage::disk('public')->delete('profile/' . $user->profile_image);
            }

            // store new image
            $file->storeAs('profile', $imageName, 'public');

            // save filename to DB
            $user->profile_image = $imageName;
        }

        // ✅ Update fields
        $user->name = $validated['name'];

        // update address only if provided (optional)
        if ($request->filled('address')) {
            $user->address = $validated['address'];
        }

        $user->save();

        return redirect()->route('customer.dashboard')->with('success', 'Profile saved successfully!');
    }
}
