<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    // Show cart items
    public function index()
    {
        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();
        return view('cart.index', compact('cartItems'));
    }

    // Add product to cart
    public function add($id)
    {
        // Check if product already in cart
        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $id)
            ->first();

        if ($cartItem) {
            // Increase quantity if exists
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            // Create new cart item
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $id,
                'quantity' => 1,
            ]);
        }

        return back()->with('success', 'Added to cart!');
    }

    // Remove product from cart
    public function remove($id)
    {
        Cart::where('user_id', auth()->id())
            ->where('product_id', $id)
            ->delete();

        return back()->with('success', 'Removed from cart!');
    }
}
