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

    // Add product to cart
    public function add(Product $product)
    {
        $userId = Auth::id();

        $cartItem = Cart::where('user_id', $userId)
            ->where('product_id', $product->product_id)
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

        return redirect()->route('cart.index')
            ->with('success', 'Product added to cart!');
    }

    // ✅ UPDATE QUANTITY (IMPORTANT)
    public function update(Request $request, Cart $cart)
    {
        // security: make sure owner
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart->quantity = $request->quantity;
        $cart->save();

        return response()->json(['success' => true]);
    }

    // Remove item
    public function remove($cart_id)
    {
        $cartItem = Cart::findOrFail($cart_id);
        $cartItem->delete();

        return back()->with('success', 'Item removed!');
    }

    // Checkout (clear cart)
    public function checkout()
    {
        Cart::where('user_id', Auth::id())->delete();
        return back()->with('success', 'Checkout complete!');
    }
}
