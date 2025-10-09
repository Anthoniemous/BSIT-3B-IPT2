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
        ->orderBy('created_at', 'desc')
        ->get();

    return view('dashboard', compact('products'));
}

}
