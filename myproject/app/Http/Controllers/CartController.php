<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Add product to cart
    public function add(Request $request, $id)
    {
        $user = Auth::user();
        $product = Product::findOrFail($id);

        // Check if item already exists in DB cart
        $cartItem = Cart::where('user_id', $user->id)
                         ->where('product_id', $product->id)
                         ->first();

        if ($cartItem) {
            $cartItem->quantity++;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        return redirect()->back()->with('success', $product->name.' added to cart!');
    }

    /**
     * Add 1 item to cart and redirect straight to Checkout.
     */
    public function buyNow($id)
    {
        $user = Auth::user();
        $product = Product::findOrFail($id);

        // Check if item already exists in DB cart
        $cartItem = Cart::where('user_id', $user->id)
                         ->where('product_id', $product->id)
                         ->first();

        if ($cartItem) {
            // Kung naa na, sigurohon lang nga ang quantity dili 0 (pwede ra i-ignore ang update)
            // But we ensure it exists before redirecting
            if ($cartItem->quantity == 0) {
                $cartItem->quantity = 1;
                $cartItem->save();
            }
        } else {
            // Kung wala pa, buhati og bag-o nga cart item
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => 1, // Default to 1 for Buy Now
            ]);
        }
        
        // Redirect diretso sa Checkout page!
        return redirect()->route('checkout.index')->with('success', $product->name . ' added to cart. Proceeding to checkout.');
    }


    // Show cart page
    public function index()
    {
        $user = Auth::user();
        $cartItems = Cart::with('product')->where('user_id', $user->id)->get();
        $products = Product::all(); // For featured products section

        return view('customer.cart', compact('cartItems', 'products'));
    }

    // Update quantity
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = Cart::findOrFail($id);
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return redirect()->back()->with('success', 'Cart updated!');
    }

    // Remove item
    public function remove($id)
    {
        $cartItem = Cart::findOrFail($id);
        $cartItem->delete();

        return redirect()->back()->with('success', 'Item removed!');
    }
}