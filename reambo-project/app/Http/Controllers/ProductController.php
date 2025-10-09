<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
         $products = Product::all();
    return view('product', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name'  => $request->name,
            'price' => $request->price,
            'image' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Product added successfully!');
    }
}
