<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
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
        $customerId = session('customer_id');

        $lastOrder = null;
        $lastPayment = null;

        if ($customerId) {
            // latest order for this customer
            $lastOrder = DB::table('order')
                ->where('customer_id', $customerId)
                ->orderBy('order_date', 'desc')
                ->first();

            if ($lastOrder) {
                $lastPayment = DB::table('payment')
                    ->where('order_id', $lastOrder->order_id)
                    ->orderBy('payment_date', 'desc')
                    ->first();
            }
        }

        return view('cart', compact('cart', 'lastOrder', 'lastPayment'));
    }
    // Add product to cart
public function addToCart($id)
{
    $product = Product::findOrFail($id);
    $customerId = session('customer_id');

    if (!$customerId) {
        return redirect('/login')->with('error', 'Please log in.');
    }

    if ((int)$product->stock_quantity <= 0) {
        return back()->with('error', 'This product is out of stock.');
    }

    $cart = session()->get('cart', []);
    $currentQty = isset($cart[$id]) ? (int)$cart[$id]['quantity'] : 0;

    // ✅ don’t allow cart qty to exceed available stock
    if ($currentQty >= (int)$product->stock_quantity) {
        return back()->with('error', "Only {$product->stock_quantity} left in stock.");
    }

    if (isset($cart[$id])) {
        $cart[$id]['quantity']++;
    } else {
        $cart[$id] = [
            'product_id' => $product->product_id,
            'name'       => $product->name,
            'price'      => $product->price,
            'quantity'   => 1,
            'image'      => $product->image,
        ];
    }

    session()->put('cart', $cart);
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
                $cart[$id]['quantity'] = max(1, intval($quantity));
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
        $jsonPath = storage_path('app/cart.json');
        $cartData = [];

        foreach ($cart as $key => $item) {
            // Skip completely invalid items, just in case
            if (!is_array($item)) {
                continue;
            }

            $productId = $item['product_id'] ?? $key; // fallback to key if needed

            $cartData[] = [
                'product_id'  => $productId,
                'name'        => $item['name']     ?? '',
                'price'       => $item['price']    ?? 0,
                'quantity'    => $item['quantity'] ?? 1,
                'customer_id' => $customerId,
                'image'       => $item['image']    ?? null,
            ];
        }

        // 1️⃣ Save to JSON
        file_put_contents($jsonPath, json_encode($cartData, JSON_PRETTY_PRINT));

        // 2️⃣ Sync DB
        foreach ($cartData as $item) {
            CartItem::updateOrCreate(
                [
                    'product_id'  => $item['product_id'],
                    'customer_id' => $item['customer_id'],
                ],
                [
                    'quantity' => $item['quantity'],
                ]
            );
        }

        // 3️⃣ Remove DB entries not in JSON
        $productIds = array_column($cartData, 'product_id');
        CartItem::where('customer_id', $customerId)
                ->whereNotIn('product_id', $productIds)
                ->delete();
    }

}
