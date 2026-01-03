<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user', 'orderItems')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'orderItems.product');
        return view('admin.orders.show', compact('order'));
    }
    public function cancel(Order $order)
    {
        // Check if the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Only allow cancellation of pending orders
        if ($order->status !== 'pending') {
            return back()->withErrors(['order' => 'Only pending orders can be cancelled.']);
        }

        // Restore product stock
        foreach ($order->orderItems as $item) {
            $item->product->increment('stock_quantity', $item->quantity);
        }

        // Update order status to cancelled
        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Order cancelled successfully. Product stock has been restored.');
    }

    public function edit(Order $order)
    {
        // Check if the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Only allow editing of pending orders
        if ($order->status !== 'pending') {
            return back()->withErrors(['order' => 'Only pending orders can be edited.']);
        }

        // Load order items with product details
        $order->load('orderItems.product');

        return view('user.order_edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        // Check if the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Only allow updating of pending orders
        if ($order->status !== 'pending') {
            return back()->withErrors(['order' => 'Only pending orders can be updated.']);
        }

        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
        ]);

        // Update shipping address and phone
        $order->update([
            'shipping_address' => $request->shipping_address,
            'phone' => $request->phone,
        ]);

        return redirect()->route('myorders')->with('success', 'Order updated successfully.');
    }

    public function delete(Order $order)
    {
        // Check if the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Only allow deletion of cancelled orders
        if ($order->status !== 'cancelled') {
            return back()->withErrors(['order' => 'Only cancelled orders can be deleted.']);
        }

        // Delete the order (this will also delete related order items due to cascade)
        $order->delete();

        return back()->with('success', 'Order deleted successfully.');
    }
    // Add to OrderController.php
public function updateStatus(Request $request, Order $order)
{
    $request->validate([
        'status' => 'required|in:pending,processing,shipped,completed,cancelled'
    ]);
    
    $order->update(['status' => $request->status]);
    
    return back()->with('success', 'Order status updated successfully.');
}
}
