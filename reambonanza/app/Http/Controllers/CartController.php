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

    // Add product to cart (with quantity)
    public function add(Request $request, Product $product)
    {
        $userId = Auth::id();

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Please log in to add to cart.');
        }

        $quantityToAdd = (int) $request->input('quantity', 1);

        if ($quantityToAdd < 1) $quantityToAdd = 1;
        if ($quantityToAdd > $product->quantity) {
            return redirect()->back()->with('error', 'Quantity exceeds available stock.');
        }

        $cartItem = Cart::where('user_id', $userId)
                        ->where('product_id', $product->product_id)
                        ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantityToAdd;
            if ($newQuantity > $product->quantity) {
                return redirect()->back()->with('error', 'Total quantity in cart exceeds available stock.');
            }
            $cartItem->quantity = $newQuantity;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $userId,
                'product_id' => $product->product_id,
                'quantity' => $quantityToAdd,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    // Remove item from cart
    public function remove($cart_id)
    {
        $cartItem = Cart::find($cart_id);

        if (!$cartItem) {
            return redirect()->back()->with('error', 'Cart item not found!');
        }

        $cartItem->delete();

        return redirect()->back()->with('success', 'Item removed from cart successfully!');
    }

    // Checkout (adjust stock & clear cart)
    public function checkout()
    {
        $userId = Auth::id();
        $cartItems = Cart::with('product')->where('user_id', $userId)->get();

        foreach ($cartItems as $item) {
            $product = $item->product;
            if ($product && $product->quantity >= $item->quantity) {
                $product->quantity -= $item->quantity;
                $product->save();
            }
        }

        Cart::where('user_id', $userId)->delete();

        return back()->with('success', 'Checkout complete!');
    }

    public function updateQuantity(Request $request, Cart $cart)
{
    $request->validate([
        'quantity' => 'required|integer|min:1'
    ]);

    // security: owner check
    if ($cart->user_id !== Auth::id()) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    // stock check
    if ($cart->product && $request->quantity > $cart->product->quantity) {
        return response()->json([
            'error' => 'Quantity exceeds available stock'
        ], 422);
    }

    $cart->quantity = $request->quantity;
    $cart->save();

    return response()->json([
        'success' => true,
        'quantity' => $cart->quantity
    ]);
}
}
