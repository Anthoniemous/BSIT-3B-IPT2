<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Product;
use App\Models\CartItem;

class CustomerProductController extends Controller
{
    // Display active products
    public function index(Request $request)
    {
        if (session('role') !== 'customer') {
            return redirect('/login')->with('error', 'Please log in as a customer.');
        }

        // ORIGINAL QUERY
        $products = Product::where('status', 'active');

        // ⭐ ADDED SORTING ⭐
        if ($request->has('sort')) {
            if ($request->sort === 'newest') {
                $products = $products->orderBy('created_at', 'desc');
            } elseif ($request->sort === 'featured') {
                $products = $products->where('featured', 1);
            }
        }

        // FINAL GET
        $products = $products->get();

        return view('customer_dashboard', compact('products'));
    }

    // View Cart Page
    public function viewCart()
    {
        $cart = session('cart', []);
        return view('cart', compact('cart'));
    }

    // Add product to cart
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $customerId = session('customer_id');

        if (!$customerId) {
            return redirect('/login')->with('error', 'Please log in.');
        }

        $cart = session()->get('cart', []);

        // Add or increase quantity in session
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'product_id' => $product->product_id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);

        // Sync DB and JSON
        $this->syncCart($customerId, $cart);

        return back()->with('success', "{$product->name} added to cart!");
    }

    // Remove product from cart
    public function removeFromCart($id)
    {
        $customerId = session('customer_id');
        if (!$customerId) return redirect('/login');

        $cart = session('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        // Sync DB and JSON
        $this->syncCart($customerId, $cart);

        return back()->with('success', 'Product removed from cart.');
    }

    // Update quantities
    public function updateCart(Request $request)
    {
        $customerId = session('customer_id');
        if (!$customerId) return redirect('/login');

        $cart = session('cart', []);

        foreach ($request->quantities as $id => $quantity) {
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = max(1, intval($quantity)); // prevent negative/zero
            }
        }

        session()->put('cart', $cart);

        // Sync DB and JSON
        $this->syncCart($customerId, $cart);

        return back()->with('success', 'Cart updated successfully!');
    }

    /**
     * Sync cart session data to database and JSON file
     */
    private function syncCart($customerId, $cart)
    {
        // 1️⃣ Save to JSON first
        $jsonPath = storage_path('app/cart.json');
        $cartData = [];
        foreach ($cart as $item) {
            $cartData[] = [
                'product_id' => $item['product_id'],
                'name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'customer_id' => $customerId,
            ];
        }
        file_put_contents($jsonPath, json_encode($cartData, JSON_PRETTY_PRINT));

        // 2️⃣ Sync DB based on JSON
        foreach ($cartData as $item) {
            CartItem::updateOrCreate(
                [
                    'product_id' => $item['product_id'],
                    'customer_id' => $item['customer_id']
                ],
                [
                    'quantity' => $item['quantity']
                ]
            );
        }

        // 3️⃣ Optional: remove DB entries not in JSON
        $productIds = array_column($cartData, 'product_id');
        CartItem::where('customer_id', $customerId)
                ->whereNotIn('product_id', $productIds)
                ->delete();
    }
}
