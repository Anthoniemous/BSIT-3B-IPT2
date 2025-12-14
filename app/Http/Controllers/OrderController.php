<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function adminIndex()
{
    // Get all orders with their items and products
    $orders = Order::with('items.product', 'user')
        ->latest()
        ->get();

    return view('admin.adminorderlist', compact('orders'));
}

    public function index()
{
    $orders = Order::where('user_id', auth()->id())
        ->with('items.product')
        ->latest()
        ->get();

    return view('orders.index', compact('orders'));
}

   public function store(Request $request)
{
    $cartItem = Cart::where('id', $request->cart_item_id)
        ->where('user_id', auth()->id())
        ->with('product')
        ->firstOrFail();

    $quantity = $request->quantity;
    $total = $cartItem->product->price * $quantity;

    $order = Order::create([
        'user_id' => auth()->id(),
        'customer_name' => $request->customer_name,
        'address' => $request->address,
        'phone' => $request->phone,
        'payment_method' => $request->payment_method,
        'total' => $total,
        'status' => 'pending'
    ]);

    OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $cartItem->product_id,
        'quantity' => $quantity,
        'price' => $cartItem->product->price
    ]);

    // remove item from cart after order
    $cartItem->delete();

    return redirect()->route('orders.index')
        ->with('success', 'Order placed successfully!');
}
public function updateStatus(Request $request, $id)
{
    $order = Order::findOrFail($id);
    $request->validate([
        'status' => 'required|in:pending,processing,completed,cancelled',
    ]);
    $order->status = $request->status;
    $order->save();

    return redirect()->back()->with('success', 'Order status updated!');
}
public function cancel($id)
{
    $order = Order::where('user_id', auth()->id())->findOrFail($id);

    if($order->status == 'completed' || $order->status == 'cancelled') {
        return redirect()->back()->with('error', 'You cannot cancel this order.');
    }

    $order->status = 'cancelled';
    $order->save();

    return redirect()->back()->with('success', 'Order has been cancelled.');
}
}
