<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Wishlist;

class CustomerController extends Controller
{
    // === Dashboard ===
    public function index(Request $request)
    {
        $query = Product::query();

        // Optional: sorting
        switch ($request->sort) {
            case 'featured':
                $query->where('featured', 1);
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            default:
                $query->orderBy('name', 'asc');
        }

        $products = $query->get();

        // Get user's wishlist product IDs
        $wishlistProductIds = Auth::check() 
            ? Auth::user()->wishlists()->pluck('product_id')->toArray() 
            : [];

        // Optional: wishlist count for navbar
        $wishlistCount = count($wishlistProductIds);

        return view('customer.dashboard', compact('products', 'wishlistProductIds', 'wishlistCount'));
    }

    // === Profile ===
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

    // === Wishlist Toggle (AJAX) ===
   // Toggle wishlist
public function toggleWishlist($productId)
{
    $user = auth()->user();

    $wishlist = $user->wishlists()->where('product_id', $productId)->first();

    if ($wishlist) {
        $wishlist->delete();
        return response()->json(['status' => 'removed']);
    } else {
        $user->wishlists()->create(['product_id' => $productId]);
        return response()->json(['status' => 'added']);
    }


}

// View wishlist
public function wishlist()
{
    $user = auth()->user();
    $products = $user->wishlists()->with('product')->get()->pluck('product');

    $wishlistCount = $user->wishlists()->count();

    return view('customer.wishlist', compact('products', 'wishlistCount'));
}
public function removeFromWishlist($id)
{
    $user = auth()->user();
    $user->wishlists()->where('product_id', $id)->delete(); // or detach if pivot table
    return response()->json(['status' => 'removed']);
}



}
