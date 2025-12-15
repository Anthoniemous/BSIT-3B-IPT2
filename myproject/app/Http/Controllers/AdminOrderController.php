<?php

namespace App\Http\Controllers;
use App\Helpers\Logger;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,paid,delivered,cancelled',
        ]);

        $order->status = $request->status;
        $order->save();
        Logger::log('Orders', 'UPDATE_STATUS', "Updated order #{$order->id} to {$order->status}");


        return back()->with('success', 'Order status updated!');
    }
}
