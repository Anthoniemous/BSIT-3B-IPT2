<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    // 🔹 Admin: list all products with search, category filter, sort
    public function index(Request $request)
    {
        $query = Product::query();

        // ⭐ SEARCH
        if ($request->has('search') && $request->search != '') {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }

        // ⭐ CATEGORY FILTER
        if ($request->has('category') && $request->category != 'all') {
            $query->where('category', $request->category);
        }

        // ⭐ SORTING
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'az':
                    $query->orderBy('product_name', 'asc');
                    break;
                case 'za':
                    $query->orderBy('product_name', 'desc');
                    break;
                case 'price_low_high':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high_low':
                    $query->orderBy('price', 'desc');
                    break;
            }
        }

        $products = $query->paginate(10);

        return view('Dashboard.dashboard', [
            'products' => $products,
            'search' => $request->search,
            'category' => $request->category,
            'sort' => $request->sort,
        ]);
    }

   public function userDashboard(Request $request)
{
    $query = Product::query();

    // 🔍 Search
    if ($request->filled('search')) {
        $query->where('product_name', 'LIKE', '%' . $request->search . '%');
    }

    // 🏷 Category
    if ($request->filled('category') && $request->category != 'all') {
        $query->where('category', $request->category);
    }

    // 💰 MIN PRICE
    if ($request->filled('min_price')) {
        $query->where('price', '>=', $request->min_price);
    }

    // 💰 MAX PRICE
    if ($request->filled('max_price')) {
        $query->where('price', '<=', $request->max_price);
    }

    // ↕ SORTING
    switch ($request->sort) {
        case 'newest':
            $query->orderBy('created_at', 'desc');
            break;

        case 'price_high_low':
            $query->orderBy('price', 'desc');
            break;

        case 'price_low_high':
            $query->orderBy('price', 'asc');
            break;

        case 'featured':
        default:
            $query->orderBy('product_id', 'asc'); // default Featured order
            break;
    }

    $products = $query->paginate(6);

    return view('Dashboard.userdashboard', [
        'products'  => $products,
        'search'    => $request->search,
        'category'  => $request->category,
        'sort'      => $request->sort,
    ]);
}


    // 🔹 Show create product form
    public function create()
    {
        return view('Addtocart.create');
    }

    // 🔹 Store new product
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:10240',
            'category' => 'required|string',
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
            'category' => $request->category,
        ]);

        $this->syncProductsToLocal(); 
        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    // 🔹 Edit product
    public function edit(Product $product)
    {
        return view('Addtocart.edit', compact('product'));
    }

    // 🔹 Update product
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'category' => 'required|string',
        ]);

        $data = [
            'product_name' => $request->product_name,
            'description' => $request->description,
            'price' => (float) $request->price,
            'category' => $request->category,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        $this->syncProductsToLocal(); 
        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    // 🔹 Delete product
    public function destroy(Product $product)
    {
        $product->delete();
        $this->syncProductsToLocal(); 
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }

    // 🔹 Private helper: sync JSON + XML
    private function syncProductsToLocal()
    {
        $products = Product::all();
        $jsonFolder = 'ADMIN-PRODUCTS';
        $xmlFolder = 'ADMIN-PRODUCTS';

        $this->ensureFolderExists(storage_path("app/local_activity/$jsonFolder"));
        $this->ensureFolderExists(storage_path("app/local_activity/XML/$xmlFolder"));

        Storage::disk('local_activity')->put("$jsonFolder/products.json", $products->toJson(JSON_PRETTY_PRINT));

        $xmlContent = $this->convertToXml($products, 'products', 'product');
        Storage::disk('local_activity')->put("XML/$xmlFolder/products.xml", $xmlContent);
    }

    private function convertToXml($data, $rootElement = 'items', $itemElement = 'item')
    {
        $xml = new \SimpleXMLElement("<?xml version=\"1.0\"?><$rootElement></$rootElement>");

        foreach ($data as $record) {
            $item = $xml->addChild($itemElement);
            foreach ($record->toArray() as $key => $value) {
                if ($key === 'product_id') {
                    $key = 'id';
                }
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
