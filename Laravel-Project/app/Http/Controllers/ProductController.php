<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    // 🔹 Admin: list all products (NOW RETURNS adminproducts.blade.php)
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

        // ⭐ BRAND FILTER
        if ($request->has('brand') && $request->brand != '') {
            $query->where('brand', 'LIKE', '%' . $request->brand . '%');
        }

        // ⭐ SORTING
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'price_low_high':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high_low':
                    $query->orderBy('price', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        }

        $products = $query->paginate(25);

        return view('Dashboard.adminproducts', [
            'products' => $products,
            'search' => $request->search,
            'category' => $request->category,
            'brand' => $request->brand,
            'sort' => $request->sort,
        ]);
    }

    // 🔹 USER PRODUCT DASHBOARD
    public function userDashboard(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $query->where('product_name', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->filled('category') && $request->category != 'all') {
            $query->where('category', $request->category);
        }

        if ($request->filled('brand')) {
            $query->where('brand', 'LIKE', '%' . $request->brand . '%');
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

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
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->paginate(20);

        return view('Dashboard.userdashboard', [
            'products'  => $products,
            'search'    => $request->search,
            'category'  => $request->category,
            'brand'     => $request->brand,
            'sort'      => $request->sort,
            'price_min' => $request->price_min,
            'price_max' => $request->price_max,
        ]);
    }


    // 🔹 Show create product form
    public function create()
    {
        return view('Addtocart.create');
    }

    // 🔹 Store product
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
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
            'brand' => $request->brand,
            'description' => $request->description,
            'price' => (float) $request->price,
            'image' => $imagePath,
            'category' => $request->category,
        ]);

        $this->syncProductsToLocal(); 

        return redirect()->route('admin.products.index')->with('success', 'Product added successfully!');
    }

    // 🔹 EDIT PRODUCT
    public function edit($id)
{
    $product = Product::where('product_id', $id)->firstOrFail();
    return view('Addtocart.edit', compact('product'));
}

    // 🔹 UPDATE PRODUCT
    public function update(Request $request, $id)
{
    $product = Product::where('product_id', $id)->firstOrFail();
    
    $request->validate([
        'product_name' => 'required|string|max:255',
        'brand' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'category' => 'required|string',
    ]);

    $data = [
        'product_name' => $request->product_name,
        'brand' => $request->brand,
        'description' => $request->description,
        'price' => (float) $request->price,
        'category' => $request->category,
    ];

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('products', 'public');
    }

    $product->update($data);

    $this->syncProductsToLocal();

    return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
}

    // 🔹 DELETE PRODUCT
    public function destroy(Product $product)
    {
        $product->delete();
        $this->syncProductsToLocal(); 
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }


    // ---------------------------------------------------------
    // JSON/XML SYNC HELPERS — unchanged
    // ---------------------------------------------------------

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
