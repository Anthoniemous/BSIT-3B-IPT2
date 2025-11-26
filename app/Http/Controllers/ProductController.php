<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Display all products in admin panel
    public function index()
    {
        $products = Product::all();
        return view('admin.products', compact('products'));
    }

    public function userProducts(Request $request)
{
    $sort = $request->input('sort');
    $brand = $request->input('brand');
    $category = $request->input('category');

    $query = Product::query();

    if (!empty($brand)) {
        $query->where('brand', 'LIKE', "%$brand%");
    }

    if (!empty($category)) {
        $query->where('category', $category);
    }

    switch ($sort) {
        case 'newest':
            $query->orderBy('created_at', 'desc');
            break;
        case 'price_low_high':
            $query->orderBy('price', 'asc');
            break;
        case 'price_high_low':
            $query->orderBy('price', 'desc');
            break;
    }

    $products = $query->get();

    // ✅ THIS IS WHERE YOU GET UNIQUE CATEGORIES & BRANDS
    $categories = Product::select('category')->distinct()->pluck('category');
    $brands = Product::select('brand')->distinct()->pluck('brand');

    // ✅ PASS THEM TO THE VIEW
    return view('products', compact('products', 'sort', 'categories', 'brands'));
}

    // Store a new product
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|max:2048',
            'brand' => 'required|string|max:255',
            'category' => 'required|string|max:255',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'brand' => $request->brand,
            'category' => $request->category,
        ]);

        $this->syncProducts();

        return redirect()->route('admin.index')->with('success', 'Product added successfully.');
    }

    // Edit product
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    // Update product
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|max:2048',
            'brand' => 'required|string|max:255',
            'category' => 'required|string|max:255',
        ]);

        $product = Product::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $product->image,
            'brand' => $request->brand,
            'category' => $request->category,
        ]);

        $this->syncProducts();

        return redirect()->route('admin.index')->with('success', 'Product updated successfully.');
    }

    // Delete product
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        $this->syncProducts();

        return redirect()->route('admin.index')->with('success', 'Product deleted successfully.');
    }

    // 🔥 Sync Products to JSON + XML
    private function syncProducts()
    {
        $products = Product::all();

        Storage::disk('quibo_activity')->put(
            'products.json',
            $products->toJson(JSON_PRETTY_PRINT)
        );

        $xmlContent = $this->convertToXml($products, 'products', 'product');
        Storage::disk('xml_activity')->put('products.xml', $xmlContent);
    }

    private function convertToXml($data, $rootElement, $itemElement)
    {
        $xml = new \SimpleXMLElement("<{$rootElement}></{$rootElement}>");

        foreach ($data as $record) {
            $item = $xml->addChild($itemElement);

            foreach ($record->toArray() as $key => $value) {
                $item->addChild($key, htmlspecialchars($value));
            }
        }

        return $xml->asXML();
    }
}
