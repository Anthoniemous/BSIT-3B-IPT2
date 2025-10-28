<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        // ✅ Validate input fields
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // ✅ Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $imageName = time() . '.' . $request->profile_image->extension();
            // ❌ old: $request->profile_image->storeAs('public/profile', $imageName);
            // ✅ fixed:
            $request->profile_image->storeAs('profile', $imageName, 'public');

            $user->profile_image = $imageName;
        }

        // ✅ Update other profile details
        $user->name = $validated['name'];
        $user->address = $validated['address'];
        $user->save();

        // ✅ Redirect back to dashboard & hide modal
        return redirect()
            ->route('customer.dashboard')
            ->with('success', 'Profile saved successfully!');
    }
}
