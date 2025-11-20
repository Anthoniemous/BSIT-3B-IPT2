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

    // ⭐ USER PRODUCT LIST WITH SORTING
    public function userProducts(Request $request)
    {
        $sort = $request->get('sort');

        $products = Product::query();

        if ($sort === 'name_asc') {
            $products->orderBy('name', 'asc');
        } elseif ($sort === 'name_desc') {
            $products->orderBy('name', 'desc');
        } elseif ($sort === 'price_low_high') {
            $products->orderBy('price', 'asc');
        } elseif ($sort === 'price_high_low') {
            $products->orderBy('price', 'desc');
        }

        $products = $products->get();

        return view('products', compact('products', 'sort'));
    }

    // Store a new product
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
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
            'category_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|max:2048',
        ]);

        $product = Product::findOrFail($id);

        // If image is updated
        if ($request->hasFile('image')) {

            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $product->image,
        ]);

        $this->syncProducts();

        return redirect()->route('admin.index')->with('success', 'Product updated successfully.');
    }

    // Delete product
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete old image
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

        // Save JSON
        Storage::disk('quibo_activity')->put(
            'products.json',
            $products->toJson(JSON_PRETTY_PRINT)
        );

        // Save XML
        $xmlContent = $this->convertToXml($products, 'products', 'product');
        Storage::disk('xml_activity')->put('products.xml', $xmlContent);
    }

    // Convert data to XML format
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
