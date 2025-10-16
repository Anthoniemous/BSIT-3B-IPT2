<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // Show active products
    public function index()
    {
        $products = Product::where('status', 1)->get();
        return view('product', compact('products'));
    }

    // Show deactivated products
    public function storage()
    {
        $products = Product::where('status', 0)->get();
        return view('storage', compact('products'));
    }

    // Store new product
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = $request->hasFile('image') 
            ? $request->file('image')->store('products', 'public') 
            : null;

        Product::create([
            'name'   => $request->name,
            'price'  => $request->price,
            'image'  => $imagePath,
            'status' => 1
        ]);

        return redirect()->back()->with('success', 'Product added successfully!');
    }

    // Update product
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        $product->name = $request->name;
        $product->price = $request->price;

        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->save();

        return redirect()->back()->with('success', 'Product updated successfully!');
    }

    // Deactivate product
   public function deactivate($id)
{
    $product = Product::findOrFail($id);
    $product->status = 0; // set as deactivated
    $product->save();

    return response()->json(['success' => true]);
}

   public function activate($id)
{
    $product = Product::findOrFail($id);
    $product->status = 1; // reactivate product
    $product->save();

    return redirect()->route('products.storage')->with('success', 'Product activated successfully!');
}
}
