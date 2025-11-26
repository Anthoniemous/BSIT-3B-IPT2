<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Cart; 

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = Wishlist::where('user_id', auth()->id())->with('product')->get();
        return view('wishlist.index', compact('wishlist'));
    }

    public function add($id)
    {
        Wishlist::firstOrCreate([
            'user_id' => auth()->id(),
            'product_id' => $id,
        ]);

        return back()->with('success', 'Added to wishlist!');
    }

    public function remove($id)
    {
        Wishlist::where('user_id', auth()->id())
            ->where('product_id', $id)
            ->delete();

        return back()->with('success', 'Removed from wishlist');
    }

    public function moveToCart($id)
    {
        // 1. Add to cart
        Cart::create([
            'user_id' => auth()->id(),
            'product_id' => $id,
            'quantity' => 1
        ]);

        // 2. Remove from wishlist
        Wishlist::where('user_id', auth()->id())
            ->where('product_id', $id)
            ->delete();

        return back()->with('success', 'Moved to cart!');
    }
}
