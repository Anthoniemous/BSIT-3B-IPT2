<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    // LIST PRODUCTS
    public function index(Request $request)
    {
        $sort = $request->input('sort');
        $query = Product::query();

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
        return view('dashboard', compact('products', 'sort'));
    }

    // USER DASHBOARD
public function userDashboard(Request $request)
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

    // 🔹 Get unique categories for the filter dropdown
    $categories = Product::select('category')
                        ->distinct()
                        ->pluck('category');

    return view('userdashboard', compact('products', 'sort', 'categories'));
}

    // CREATE FORM
    public function create()
    {
        return view('create');
    }

    // STORE PRODUCT
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'brand'        => 'required|string|max:255',
            'category'     => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);
        $this->syncProductsToLocal();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product added successfully!');
    }

    // EDIT PRODUCT
    public function edit(Product $product)
    {
        return view('edit', compact('product'));
    }

    // UPDATE PRODUCT
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'brand'        => 'required|string|max:255',
            'category'     => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'product_name' => $request->product_name,
            'brand'        => $request->brand,
            'category'     => $request->category,
            'description'  => $request->description,
            'price'        => (float)$request->price,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        $this->syncProductsToLocal();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    // DELETE PRODUCT
    public function destroy(Product $product)
    {
        $product->delete();
        $this->syncProductsToLocal();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    // JSON & XML SYNC
    private function syncProductsToLocal()
    {
        $products = Product::all();
        $jsonFolder = 'PRODUCTS';
        $xmlFolder = 'PRODUCTS';

        $this->ensureFolderExists(storage_path("app/ream_activity/$jsonFolder"));
        $this->ensureFolderExists(storage_path("app/ream_activity/XML/$xmlFolder"));

        Storage::disk('ream_activity')->put("$jsonFolder/products.json", $products->toJson(JSON_PRETTY_PRINT));

        $xmlContent = $this->convertToXml($products, 'products', 'product');
        Storage::disk('ream_activity')->put("XML/$xmlFolder/products.xml", $xmlContent);
    }

    private function convertToXml($data, $rootElement = 'items', $itemElement = 'item')
    {
        $xml = new \SimpleXMLElement("<?xml version=\"1.0\"?><$rootElement></$rootElement>");

        foreach ($data as $record) {
            $item = $xml->addChild($itemElement);
            foreach ($record->toArray() as $key => $value) {
                if ($key === 'product_id') $key = 'id';
                $item->addChild($key, htmlspecialchars($value));
            }
        }

        return $xml->asXML();
    }

    private function ensureFolderExists($folderPath)
    {
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }
    }
}
