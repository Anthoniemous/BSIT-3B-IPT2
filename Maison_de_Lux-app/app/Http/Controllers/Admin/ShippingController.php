<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function index()
    {
        $orders = \App\Models\Order::with('user')->latest()->get();
        return view('admin.shippings.index', compact('orders'));
    }

    public function create()
    {
        return view('admin.shippings.create');
    }

    public function store(Request $request)
    {
        // Handle store logic
    }

    public function show($id)
    {
        $order = \App\Models\Order::with('user', 'orderItems.product')->findOrFail($id);
        return view('admin.shippings.show', compact('order'));
    }

    public function edit($id)
    {
        return view('admin.shippings.edit', compact('id'));
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
