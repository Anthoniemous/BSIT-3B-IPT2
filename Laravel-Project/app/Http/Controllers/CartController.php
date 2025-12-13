<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product')
                        ->where('user_id', Auth::id())
                        ->get();

        return view('Addtocart.cart', compact('cartItems'));
    }

            public function add(Request $request, Product $product)
        {
            $request->validate([
                'size' => 'required'
            ]);

            $userId = Auth::id();
            if (!$userId) {
                return redirect()->route('login')->with('error', 'Please log in to add to cart.');
            }

            // Check if same product with same size already exists
            $cartItem = Cart::where('user_id', $userId)
                            ->where('product_id', $product->product_id)
                            ->where('size', $request->size)
                            ->first();

            if ($cartItem) {
                $cartItem->quantity += 1;
                $cartItem->save();
            } else {
                Cart::create([
                    'user_id' => $userId,
                    'product_id' => $product->product_id,
                    'quantity' => 1,
                    'size' => $request->size,
                ]);
            }

            return redirect()->route('cart.index')->with('success', 'Product added to cart!');
        }

        public function updateQuantity(Request $request, Cart $cart)
{
    $cart->quantity = $request->quantity;
    $cart->save();
    return response()->json(['success' => true]);
}

    public function remove($id)
    {
        $cartItem = Cart::find($id);

        if (!$cartItem) {
            return redirect()->back()->with('error', 'Cart item not found!');
        }

        $cartItem->delete();

        return redirect()->back()->with('success', 'Item removed from cart successfully!');
    }

    public function checkout(Request $request)
{
    // Get cart_ids and filter out empty values
    $cartIds = array_filter(explode(',', $request->cart_ids ?? ''));

    // Check if no items selected
    if (empty($cartIds)) {
        return redirect()->route('cart.index')->with('error', 'No items selected for checkout!');
    }

    // Get cart items
    $cartItems = \App\Models\Cart::with('product')
        ->whereIn('cart_id', $cartIds)
        ->where('user_id', auth()->id())
        ->get();

    // Check if cart items actually exist
    if ($cartItems->isEmpty()) {
        return redirect()->route('cart.index')->with('error', 'Selected items not found!');
    }

    // Return order view with cart items
    return view('Order.order', compact('cartItems'));
}



    public function updateSize(Request $request, $cartId)
{
    $request->validate([
        'size' => 'required'
    ]);

    $cartItem = Cart::findOrFail($cartId);
    $cartItem->size = $request->size;
    $cartItem->save();

    return back()->with('success', 'Size updated successfully!');
}
}
