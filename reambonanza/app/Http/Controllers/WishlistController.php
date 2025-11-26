<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use App\Models\Cart;
use Auth;

class WishlistController extends Controller
{
    // SHOW WISHLIST PAGE
    public function index()
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
                            ->with('product')
                            ->get();

        return view('wishlist', compact('wishlist'));
    }

    // ADD PRODUCT TO WISHLIST
    public function add($id)
    {
        Wishlist::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $id
        ]);

        return back()->with('success', 'Added to your Wishlist!');
    }

    // REMOVE PRODUCT FROM WISHLIST
    public function remove($id)
    {
        Wishlist::where('user_id', Auth::id())
                ->where('product_id', $id)
                ->delete();

        return back()->with('success', 'Removed from Wishlist!');
    }

    // MOVE PRODUCT TO CART
    public function moveToCart($id)
    {
        // REMOVE FROM WISHLIST
        Wishlist::where('user_id', Auth::id())
                ->where('product_id', $id)
                ->delete();

        // ADD TO CART
        Cart::create([
            'user_id' => Auth::id(),
            'product_id' => $id,
            'quantity' => 1,
        ]);

        return back()->with('success', 'Moved to Cart!');
    }
}
