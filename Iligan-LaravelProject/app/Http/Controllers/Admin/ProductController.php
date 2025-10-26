<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // Display admin dashboard with products (only active ones)
    public function index()
    {
        // ✅ Fetch categories with only ACTIVE products
        $categories = Category::with(['products' => function($query) {
            $query->where('status', 'active');
        }])->get();

        return view('admin_dashboard', compact('categories'));
    }

    // Store a new product
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,category_id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Get currently logged-in user ID (acting as admin)
        $adminId = Auth::id();

        $product = Product::create([
            'category_id' => $request->category_id,
            'admin_id' => $adminId,
            'name' => $request->name,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'image' => $imagePath,
            'status' => 'active', // Ensure new products are active by default
        ]);

        return response()->json([
            'product_id' => $product->product_id,
            'category_id' => $product->category_id,
            'name' => $product->name,
            'description' => $product->description,
            'quantity' => $product->quantity,
            'unit_price' => $product->unit_price,
            'image' => $imagePath,
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::where('status', 'active')
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%$query%")
                  ->orWhere('description', 'LIKE', "%$query%");
            })
            ->with('category:category_id,name')
            ->get()
            ->map(function($p) {
                return [
                    'id' => $p->product_id,
                    'name' => $p->name,
                    'description' => $p->description,
                    'quantity' => $p->quantity,
                    'unit_price' => $p->unit_price,
                    'image' => $p->image,
                    'category_id' => $p->category->category_id,
                    'category_name' => $p->category->name
                ];
            });

        return response()->json($products);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer',
            'unit_price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
            'category_id' => 'required|exists:categories,category_id',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        $product->update($validated);

        return response()->json($product);
    }

    public function softDelete($id)
    {
        $product = Product::findOrFail($id);

        // Update status instead of removing from DB
        $product->status = 'inactive';
        $product->save();

        return redirect()->route('admin_dashboard')->with('success', 'Product marked as inactive.');
    }
}
