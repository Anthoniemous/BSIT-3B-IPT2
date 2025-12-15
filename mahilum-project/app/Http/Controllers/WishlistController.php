<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display all wishlist items for the current user.
     */
    public function index()
    {
        // Load wishlist with related products for the logged-in user
        $wishlist = Wishlist::with('product')
            ->where('user_id', Auth::id())
            ->get();

        // Return view with $wishlist (matches Blade variable)
        return view('wishlist', compact('wishlist'));
    }

    /**
     * Add a product to the wishlist.
     */
    public function add(Request $request, $productId)
    {
        // Check if the product is already in the wishlist
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

    /**
     * Remove a product from the wishlist.
     */
    public function remove($id)
    {
        $item = Wishlist::findOrFail($id);

        if ($item->user_id == Auth::id()) {
            $item->delete();
        }

        return back()->with('success', 'Product removed from wishlist!');
    }

    /**
     * Move a wishlist item to the cart.
     */
    public function moveToCart($id)
    {
        $item = Wishlist::findOrFail($id);

        if ($item->user_id == Auth::id()) {
            // Add to cart (assuming you have a Cart model)
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
