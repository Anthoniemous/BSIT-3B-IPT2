<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    // Admin: list all products
    public function index()
    {
        $products = Product::all();
        return view('dashboard', compact('products')); // admin dashboard
    }

    // User dashboard (view products)
    public function userDashboard()
    {
        $products = Product::all();
        return view('userdashboard', compact('products'));
    }

    // Show create product form
    public function create()
    {
        return view('create');
    }

    // Store new product
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric',
            'image'        => 'nullable|image|max:10240',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'product_name' => $request->product_name,
            'description'  => $request->description,
            'price'        => (float) $request->price, // cast to float
            'image'        => $imagePath,
        ]);

        $this->syncProductsToLocal(); // ✅ Sync to local JSON

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    // Edit product
    public function edit(Product $product)
    {
        return view('edit', compact('product'));
    }

    // Update product
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'product_name' => $request->product_name,
            'description'  => $request->description,
            'price'        => (float) $request->price, // cast to float
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        $this->syncProductsToLocal(); // ✅ Sync to local JSON

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    // Delete product
    public function destroy(Product $product)
    {
        $product->delete();

        $this->syncProductsToLocal(); // ✅ Sync to local JSON

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }

    // 🔸 Private helper for JSON sync
    private function syncProductsToLocal()
    {
        $products = Product::all();
        $folder = 'ADMIN-PRODUCTS';
        $this->ensureFolderExists(storage_path("app/local_activity/$folder"));
        Storage::disk('local_activity')->put("$folder/products.json", $products->toJson(JSON_PRETTY_PRINT));
    }

    // 🔹 Ensure folder exists
    private function ensureFolderExists($folderPath)
    {
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }
    }
}
