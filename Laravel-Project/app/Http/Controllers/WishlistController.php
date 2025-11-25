<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Show wishlist items
   public function index()
{
    $wishlistItems = Wishlist::with('product')->where('user_id', Auth::id())->get();

    // Make sure these IDs correspond to your actual product IDs in the DB
    $availableSizes = [
        1 => ['40', '41', '42', '43', '44', '45'],
        2 => ['38', '39', '40', '41'],
        // add sizes for other products as needed
    ];

    return view('wishlist.index', [
        'wishlistItems' => $wishlistItems,
        'availableSizes' => $availableSizes,
    ]);
}

    // Add product to wishlist
        public function add(Product $product)
        {
            $exists = Wishlist::where('user_id', Auth::id())
                            ->where('product_id', $product->product_id)
                            ->first();

            if ($exists) {
                return back()->with('error', 'Product already in wishlist!');
            }

            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $product->product_id 
            ]);

            return back()->with('success', 'Product added to wishlist!');
        }

    // Remove product from wishlist
    public function remove($id)
    {
        $wishlistItem = Wishlist::findOrFail($id);
        if ($wishlistItem->user_id !== Auth::id()) {
            abort(403);
        }
        $wishlistItem->delete();
        return back()->with('success', 'Product removed from wishlist!');
    }

    // Move wishlist item to cart
    public function moveToCart($id)
    {
        $wishlistItem = Wishlist::findOrFail($id);
        if ($wishlistItem->user_id !== Auth::id()) {
            abort(403);
        }

        // Assuming you have a Cart model
        \App\Models\Cart::create([
            'user_id' => Auth::id(),
            'product_id' => $wishlistItem->product_id,
            'quantity' => 1
        ]);

        $wishlistItem->delete();

        return back()->with('success', 'Product moved to cart!');
    }
}
