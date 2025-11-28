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
    public function userDashboard(Request $request)
{
    $sort = $request->get('sort');
    $category = $request->get('category');
    $brand = $request->get('brand');
    $minPrice = $request->get('min_price');
    $maxPrice = $request->get('max_price');

    $products = Product::query();

    // FILTERS
    if($category) $products->where('category', $category);
    if($brand) $products->where('brand', $brand);
    if($minPrice) $products->where('price', '>=', $minPrice);
    if($maxPrice) $products->where('price', '<=', $maxPrice);

    // SORTING
    switch($sort){
        case 'newest': $products->orderBy('created_at', 'desc'); break;
        case 'featured': $products->orderBy('price', 'desc'); break;
        case 'price_low_high': $products->orderBy('price', 'asc'); break;
        case 'price_high_low': $products->orderBy('price', 'desc'); break;
        default: $products->orderBy('product_name', 'asc'); break;
    }

    $categories = Product::select('category')->distinct()->pluck('category');
    $brands = Product::select('brand')->distinct()->pluck('brand');

    return view('userdashboard', [
        'products' => $products->get(),
        'sort' => $sort,
        'categories' => $categories,
        'brands' => $brands,
        'selectedCategory' => $category,
        'selectedBrand' => $brand,
        'minPrice' => $minPrice,
        'maxPrice' => $maxPrice,
    ]);
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
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:10240',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'price' => (float) $request->price,
            'image' => $imagePath,
        ]);

        $this->syncProductsToLocal(); // ✅ Sync JSON + XML
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
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'brand' => 'required|string|max:255',       // ✅ added
            'category' => 'required|string|max:255',    // ✅ added
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'product_name' => $request->product_name,
            'description' => $request->description,
            'price' => (float) $request->price,
            'brand' => $request->brand,           // ✅ added
            'category' => $request->category,     // ✅ added
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        $this->syncProductsToLocal(); // ✅ Sync JSON + XML
        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }
    // Delete product
    public function destroy(Product $product)
    {
        $product->delete();
        $this->syncProductsToLocal(); // ✅ Sync JSON + XML
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }

    // 🔸 Private helper: sync JSON + XML
    private function syncProductsToLocal()
    {
        $products = Product::all();
        $jsonFolder = 'PRODUCTS';
        $xmlFolder = 'PRODUCTS';

        // Ensure folders exist
        $this->ensureFolderExists(storage_path("app/james_activity/$jsonFolder"));
        $this->ensureFolderExists(storage_path("app/james_activity/XML/$xmlFolder"));

        // Save JSON
        Storage::disk('james_activity')->put("$jsonFolder/products.json", $products->toJson(JSON_PRETTY_PRINT));

        // Save XML
        $xmlContent = $this->convertToXml($products, 'products', 'product');
        Storage::disk('james_activity')->put("XML/$xmlFolder/products.xml", $xmlContent);
    }

    // 🔹 Convert collection to XML
    private function convertToXml($data, $rootElement = 'items', $itemElement = 'item')
{
    $xml = new \SimpleXMLElement("<?xml version=\"1.0\"?><$rootElement></$rootElement>");

    foreach ($data as $record) {
        $item = $xml->addChild($itemElement);
        foreach ($record->toArray() as $key => $value) {
            // Optional: rename 'product_id' to 'id'
            if ($key === 'product_id') {
                $key = 'id';
            }
            $item->addChild($key, htmlspecialchars($value));
        }
    }

    return $xml->asXML();
}


    // 🔹 Ensure folder exists
    private function ensureFolderExists($folderPath)
    {
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }
    }
}
