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
        $request->validate(['size' => 'required']);

        if ($product->quantity <= 0) {
            return back()->with('error', 'Product is out of stock!');
        }

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->product_id)
            ->where('size', $request->size)
            ->first();

        if ($cartItem) {
            if ($cartItem->quantity >= $product->quantity) {
                return back()->with('error', 'Not enough stock!');
            }
            $cartItem->increment('quantity');
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->product_id,
                'quantity' => 1,
                'size' => $request->size,
            ]);
        }

        return redirect()->route('cart.index')->with('success','Added to cart!');
    }

    public function updateQuantity(Request $request, Cart $cart)
    {
        if ($request->quantity > $cart->product->quantity) {
            return response()->json(['success' => false]);
        }

        $cart->update(['quantity' => $request->quantity]);
        return response()->json(['success' => true]);
    }

    public function remove($id)
    {
        Cart::findOrFail($id)->delete();
        return back()->with('success','Item removed');
    }

    public function checkout(Request $request)
    {
        $cartIds = array_filter(explode(',', $request->cart_ids));

        if (!$cartIds) {
            return back()->with('error','No items selected!');
        }

        $cartItems = Cart::with('product')
            ->whereIn('cart_id', $cartIds)
            ->where('user_id', Auth::id())
            ->get();

        return view('Order.order', compact('cartItems'));
    }

    public function updateSize(Request $request, $cartId)
    {
        Cart::findOrFail($cartId)
            ->update(['size' => $request->size]);

        return back()->with('success','Size updated!');
    }
}
