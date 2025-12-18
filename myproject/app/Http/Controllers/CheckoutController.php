<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;


class CheckoutController extends Controller
{
    /**
     * Show the Checkout Page
     */
    public function index()
    {
        $user = Auth::user();
        
        // Ensure you load the product relationship needed for price calculation
        $cartItems = Cart::where('user_id', $user->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Calculate Total amount before showing checkout view
        $total = 0;
        foreach($cartItems as $item) {
            // Check if product relationship exists to prevent errors
            if ($item->product) {
                $total += $item->product->price * $item->quantity;
            }
        }

        return view('customer.checkout', compact('cartItems', 'user', 'total'));
    }

    /**
     * Place Order Logic
     */
    public function placeOrder(Request $request)
    {
        // 1. Validation
$request->validate([
  'full_name' => 'required|string',
  'address' => 'required|string',
  'phone' => 'required|string',
  'payment_method' => 'required|in:COD,Online Banking,E-Wallet',

  'region_code' => 'required|string',
  'province_code' => 'required|string',
  'city_code' => 'required|string',
]);



        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Cannot place an order with an empty cart.');
        }

        // 2. Calculate Final Total
        $total = 0;
        foreach($cartItems as $item) {
            // Re-calculate total to ensure accuracy
            $total += $item->product->price * $item->quantity;
        }

        // 3. Database Transaction (Ensure all or nothing is saved)
        DB::transaction(function () use ($user, $request, $total, $cartItems) {
            
            // A. Create Order (orders table)
            $order = Order::create([
                'user_id' => $user->id,
                'full_name' => $request->full_name,
                'address' => $request->address,
                'phone' => $request->phone,
                'payment_method' => $request->payment_method,
                'total_amount' => $total,
                'status' => 'pending'
            ]);

            // B. Move Cart Items to Order Items (order_items table)
            foreach ($cartItems as $item) {
                // KINI ANG FIXED: Compute ang line item total
                $lineTotal = $item->product->price * $item->quantity; 

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'total' => $lineTotal, // 👈 GI-APIL NA ANG 'TOTAL' DIRI
                ]);
            }

            // C. Clear User's Cart
            Cart::where('user_id', $user->id)->delete();
            
        }); // End DB::transaction

        // 4. Success Redirect
      return redirect()->route('customer.dashboard')
    ->with('pending', '✅ Order placed! Status: PENDING. Please wait for confirmation.');

    }
 
public function myPurchases()
{
    $userId = Auth::id();

    $orders = Order::where('user_id', $userId)
        ->with(['items.product'])
        ->latest()
        ->paginate(10);

    return view('customer.my-purchases', compact('orders'));
}

public function purchaseShow(Order $order)
{
    // security: dapat iya ni nga order
    abort_if($order->user_id !== Auth::id(), 403);

    $order->load(['items.product']);

    return view('customer.purchase-show', compact('order'));
}

}