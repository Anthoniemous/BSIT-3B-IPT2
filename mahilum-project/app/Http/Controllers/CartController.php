<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Show cart
    public function index()
    {
        $cartItems = Cart::with('product')
                        ->where('user_id', Auth::id())
                        ->get();

        return view('cart', compact('cartItems'));
    }

    // Add product to cart (Route Model Binding)
    public function add(Product $product)
{
    $userId = Auth::id();
    if (!$userId) {
        return redirect()->route('login')->with('error', 'Please log in to add to cart.');
    }

    $cartItem = Cart::where('user_id', $userId)
                    ->where('product_id', $product->id)
                    ->first();

    if ($cartItem) {
        $cartItem->quantity += 1;
        $cartItem->save();
    } else {
        Cart::create([
    'user_id' => $userId,
    'product_id' => $product->product_id,
    'quantity' => 1,
]);
    }

    return redirect()->route('cart.index')->with('success', 'Product added to cart!');
}

    // Remove item from cart
   public function remove($id)
    {
        $cartItem = Cart::find($id);

        if (!$cartItem) {
            return redirect()->back()->with('error', 'Cart item not found!');
        }

        $cartItem->delete();

        return redirect()->back()->with('success', 'Item removed from cart successfully!');
    }

    // Checkout (clear cart)
    public function checkout()
    {
        Cart::where('user_id', Auth::id())->delete();
        return back()->with('success', 'Checkout complete!');
    }
}
