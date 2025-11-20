<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard (Product Management Page)
     */
    public function index()
    {
        $products = Product::with('category')->get();
        $categories = Category::all();

        return view('admin.products', compact('products', 'categories'));
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
            'category_id' => 'nullable|exists:categories,category_id',
        ]);

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
            'image'       => $imagePath,
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
            'category_id' => 'nullable|exists:categories,category_id',
        ]);

        $product = Product::findOrFail($id);

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
