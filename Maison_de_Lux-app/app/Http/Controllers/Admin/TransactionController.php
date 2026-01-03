<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class TransactionController extends Controller
{
    public function index()
    {
        $orders = \App\Models\Order::with('user')->latest()->get();
        return view('admin.transactions.index', compact('orders'));
    }

    public function create()
    {
        return view('admin.transactions.create');
    }

    public function store(Request $request)
    {
        // Handle store logic
    }

    public function show($id)
    {
        $order = \App\Models\Order::with('user', 'orderItems.product')->findOrFail($id);
        return view('admin.transactions.show', compact('order'));
    }
 public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }

    public function edit($id)
    {
        return view('admin.transactions.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Handle update logic
    }

    public function destroy($id)
    {
        // Handle destroy logic
    }
}
