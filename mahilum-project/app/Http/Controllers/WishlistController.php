<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Show all wishlist items for current user
    public function index()
    {
        $wishlistItems = Wishlist::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return view('wishlist', compact('wishlistItems'));
    }

    // Add product to wishlist
    public function add(Request $request, $productId)
    {
        $exists = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if (!$exists) {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
            ]);
        }

        return back()->with('success', 'Product added to wishlist!');
    }

    // Remove product from wishlist
    public function remove($id)
    {
        $item = Wishlist::findOrFail($id);
        if ($item->user_id == Auth::id()) {
            $item->delete();
        }

        return back()->with('success', 'Product removed from wishlist!');
    }

    // Move product from wishlist to cart
    public function moveToCart($id)
    {
        $item = Wishlist::findOrFail($id);

        if ($item->user_id == Auth::id()) {
            // Add to cart (assuming you have CartController)
            \App\Models\Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $item->product_id,
                'quantity' => 1,
            ]);

            // Remove from wishlist
            $item->delete();
        }

        return back()->with('success', 'Product moved to cart!');
    }
}
