<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CustomerProductController extends Controller
{
    /**
     * Display a list of active products for customers.
     */
    public function index()
    {
        // Check session role for security
        if (session('role') !== 'customer') {
            return redirect('/login')->with('error', 'Please log in as a customer.');
        }

        // Fetch active products from your 'product' table
        $products = Product::where('status', 'active')->get();

        // Send data to customer dashboard
        return view('customer_dashboard', compact('products'));
    }

    /**
     * Add product to cart (session-based cart).
     */
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);

        // Add or increment quantity
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "id" => $product->product_id,
                "name" => $product->name,
                "price" => $product->price,
                "quantity" => 1
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', "{$product->name} added to cart!");
    }

    /**
     * Remove product from cart.
     */
    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Product removed from cart.');
    }
}
