<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;

class CartService
{
    public function getUserCart($userId)
    {
        return Cart::where('user_id', $userId)->with('product')->get();
    }

    public function addToCart($userId, $productId, $quantity)
    {
        $cartItem = Cart::firstOrNew([
            'user_id' => $userId,
            'product_id' => $productId
        ]);

        $cartItem->quantity = ($cartItem->quantity ?? 0) + $quantity;
        $cartItem->save();
    }

    public function updateCartItem($cartId, $quantity)
    {
        $cartItem = Cart::findOrFail($cartId);
        $cartItem->quantity = $quantity;
        $cartItem->save();
    }

    public function removeCartItem($cartId)
    {
        Cart::findOrFail($cartId)->delete();
    }

   public function checkout($userId, $data)
{
    $cartItems = $this->getUserCart($userId);

    if ($cartItems->isEmpty()) return;

    $order = Order::create([
        'user_id' => $userId,
        'total_amount' => $cartItems->sum(fn($item) => $item->product->price * $item->quantity),
        'status' => 'pending',
        'shipping_address' => $data['address'] ?? '',  // <-- add this
        'phone' => $data['phone'] ?? '',              // optional, if you have phone column
        'payment_method' => $data['payment_method'] ?? 'cash_on_delivery', // optional
    ]);

    foreach ($cartItems as $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item->product_id,
            'quantity' => $item->quantity,
            'price' => $item->product->price
        ]);
    }

    Cart::where('user_id', $userId)->delete();
}
}