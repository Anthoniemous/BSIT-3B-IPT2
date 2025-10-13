<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        DB::table('product')->insert([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'created_at' => now(),
            'updated_by' => Auth::id(), // if admin login integrated
        ]);

        return redirect()->back()->with('success', 'Product added successfully!');
    }

        public function index()
    {
        $products = DB::table('product')
                 ->select('product_id as id', 'name', 'description', 'price', 'stock_quantity', 'status', 'created_at')
        ->orderBy('created_at', 'desc')
        ->get();

        return view('dashboard', compact('products'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        DB::table('product')
            ->where('product_id', $id)
            ->update([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'stock_quantity' => $request->stock_quantity,
            ]);

        return redirect()->back()->with('success', 'Product updated successfully!');
    }

        public function toggleStatus($id)
    {
        $product = DB::table('product')->where('product_id', $id)->first();

        if (!$product) {
            return back()->with('error', 'Product not found!');
        }

        $newStatus = ($product->status === 'active') ? 'inactive' : 'active';

        DB::table('product')
            ->where('product_id', $id)
            ->update(['status' => $newStatus]);

        return back()->with('success', "Product status changed to {$newStatus}!");
    }
}
