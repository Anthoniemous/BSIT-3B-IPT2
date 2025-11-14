<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard (Product Management Page)
     */
    public function index()
    {
        // Load all products with category info (if exists)
        $products = Product::with('category')->get();

        // Load categories (for dropdown, if needed)
        $categories = Category::all();

        // Show the admin.products blade (CRUD page)
        return view('admin.products', compact('products', 'categories'));
    }

    /**
     * Store a new product
     */
  // Store a new product
public function store(Request $request)
{
    $request->validate([
        'name'        => 'required|string|max:255',
        'price'       => 'required|numeric',
        'description' => 'required|string|max:1000',
        'stock'       => 'nullable|integer',
        'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'category_id' => 'nullable|exists:categories,category_id',
    ]);

    // Save image to storage if uploaded
    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('products', 'public');
    }

    Product::create([
        'category_id' => $request->category_id,
        'name'        => $request->name,
        'description' => $request->description,
        'price'       => $request->price,
        'stock'       => $request->stock ?? 0,
        'image'       => $imagePath, // full storage path (e.g., products/car1.jpg)
    ]);

    return redirect()->route('admin.index')->with('success', '✅ Product added successfully!');
}

// Update an existing product
public function update(Request $request, $id)
{
    $request->validate([
        'name'        => 'required|string|max:255',
        'price'       => 'required|numeric',
        'description' => 'required|string|max:1000',
        'stock'       => 'nullable|integer',
        'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'category_id' => 'nullable|exists:categories,category_id',
    ]);

    $product = Product::findOrFail($id);

    // Handle image upload
    $imagePath = $product->image;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('products', 'public');
    }

    $product->update([
        'category_id' => $request->category_id,
        'name'        => $request->name,
        'description' => $request->description,
        'price'       => $request->price,
        'stock'       => $request->stock ?? 0,
        'image'       => $imagePath,
    ]);

    return redirect()->route('admin.index')->with('success', '✅ Product updated successfully!');
}
  public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.index')->with('success', '🗑️ Product deleted successfully!');
    }
}
