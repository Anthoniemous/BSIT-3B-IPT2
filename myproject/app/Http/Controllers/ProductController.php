<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {   
        $products = Product::all();
        return view('admin.dashboard', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:10240',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();
          $file->storeAs('products', $filename, 'public');

 // Save to storage/app/public/products
            $product->image = $filename; // Save only filename
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    public function edit(Product $product)
    {
        return view('admin.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists('products/'.$product->image)) {
                Storage::disk('public')->delete('products/'.$product->image);
            }
            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();
          $file->storeAs('products', $filename, 'public');

            $product->image = $filename;
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image && Storage::disk('public')->exists('products/'.$product->image)) {
            Storage::disk('public')->delete('products/'.$product->image);
        }

        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully!');
    }
    // View-only admin dashboard
public function mainDashboard()
{
    $products = Product::all();
    return view('admin.main-dashboard', compact('products'));
}

//searchbar filter
public function customerDashboard(Request $request)
{
    $query = Product::query();

    if ($request->has('search') && $request->search != '') {
        $query->where('name', 'like', '%'.$request->search.'%')
              ->orWhere('description', 'like', '%'.$request->search.'%');
    }

    $products = $query->get();

    return view('customer.dashboard', compact('products'));
}
}
