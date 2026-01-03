<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function createFromCart($user, $request)
    {
        return DB::transaction(function () use ($user, $request) {

            $selectedItems = $request->input('selected_items', []);

            $cartItems = Cart::where('user_id', $user->id)
                ->whereIn('id', $selectedItems)
                ->with('product')
                ->get();

            if ($cartItems->isEmpty()) {
                throw new \Exception('No cart items found.');
            }

            $total = $cartItems->sum(fn ($item) =>
                $item->quantity * $item->product->price
            );

            // ✅ CREATE ORDER
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $total,
                'status' => 'pending',
                'shipping_address' => $request->address,
                'payment_method' => $request->payment_method,
            ]);

            // ✅ CREATE ORDER ITEMS + UPDATE STOCK
            foreach ($cartItems as $item) {

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                $item->product->decrement('stock_quantity', $item->quantity);
            }

            // ✅ REMOVE ONLY SELECTED CART ITEMS
            Cart::where('user_id', $user->id)
                ->whereIn('id', $selectedItems)
                ->delete();

            return $order;
        });
    }
}
