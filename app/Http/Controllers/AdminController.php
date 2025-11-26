<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard (Product Management Page)
     */
    public function index()
    {
        // ✅ Get all products (no relationship)
        $products = Product::all();

        return view('admin.products', compact('products'));
    }

    /**
     * Store a new product
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric',
            'description' => 'required|string|max:1000',
            'stock'       => 'nullable|integer',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'brand'       => 'required|string|max:255',
            'category'    => 'required|string|max:255',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock ?? 0,
            'image'       => $imagePath,
            'brand'       => $request->brand,
            'category'    => $request->category,
        ]);

        // 🔥 SYNC TO JSON + XML
        $this->syncProducts();

        return redirect()->route('admin.index')->with('success', '✅ Product added successfully!');
    }

    /**
     * Update product
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric',
            'description' => 'required|string|max:1000',
            'stock'       => 'nullable|integer',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'brand'       => 'required|string|max:255',
            'category'    => 'required|string|max:255',
        ]);

        $product = Product::findOrFail($id);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock ?? 0,
            'image'       => $imagePath,
            'brand'       => $request->brand,
            'category'    => $request->category,
        ]);

        // 🔥 SYNC TO JSON + XML
        $this->syncProducts();

        return redirect()->route('admin.index')->with('success', '✅ Product updated successfully!');
    }

    /**
     * Delete product
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete image
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        // 🔥 SYNC TO JSON + XML
        $this->syncProducts();

        return redirect()->route('admin.index')->with('success', '🗑️ Product deleted successfully!');
    }

    // --------------------------------------------------------------
    // 🔥 JSON + XML SYNC HANDLER
    // --------------------------------------------------------------
    private function syncProducts()
    {
        $products = Product::all();

        // SAVE JSON  
        Storage::disk('quibo_activity')->put(
            'products.json',
            $products->toJson(JSON_PRETTY_PRINT)
        );

        // SAVE XML
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
