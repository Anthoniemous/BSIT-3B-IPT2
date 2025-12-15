<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    // 🔹 ADMIN: LIST PRODUCTS
    public function index(Request $request)
    {
        $query = Product::query();

        // 🔍 SEARCH
        if ($request->filled('search')) {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }

        // 🏷 CATEGORY FILTER
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // 🏭 BRAND FILTER
        if ($request->filled('brand')) {
            $query->where('brand', 'like', '%' . $request->brand . '%');
        }

        // ↕ SORTING
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
        }

        $products = $query->paginate(25);

        return view('Dashboard.adminproducts', [
    'products' => $products,
    'search'   => $request->search ?? '',
    'category' => $request->category ?? 'all',
    'brand'    => $request->brand ?? '',
    'sort'     => $request->sort ?? '',
]);
    }

    // 🔹 USER DASHBOARD
    public function userDashboard(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        if ($request->filled('brand')) {
            $query->where('brand', 'like', '%' . $request->brand . '%');
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
        }

        $products = $query->paginate(20);

       return view('Dashboard.userdashboard', [
    'products'  => $products,
    'search'    => $request->search ?? '',
    'category'  => $request->category ?? 'all',
    'brand'     => $request->brand ?? '',
    'sort'      => $request->sort ?? '',
    'price_min' => $request->price_min ?? '',
    'price_max' => $request->price_max ?? '',
]);
    }

    // 🔹 CREATE FORM
    public function create()
    {
        return view('Addtocart.create');
    }

    // 🔹 STORE PRODUCT
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'brand'        => 'nullable|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric',
            'quantity'     => 'required|integer|min:0',
            'category'     => 'required|string',
            'image'        => 'nullable|image|max:10240',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'product_name' => $request->product_name,
            'brand'        => $request->brand,
            'description'  => $request->description,
            'price'        => (float) $request->price,
            'quantity'     => $request->quantity,
            'total_sold'   => 0, // ✅ always start at 0
            'image'        => $imagePath,
            'category'     => $request->category,
        ]);

        $this->syncProductsToLocal();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product added successfully!');
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
            'brand'        => 'nullable|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric',
            'quantity'     => 'required|integer|min:0',
            'category'     => 'required|string',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        $data = [
            'product_name' => $request->product_name,
            'brand'        => $request->brand,
            'description'  => $request->description,
            'price'        => (float) $request->price,
            'quantity'     => $request->quantity,
            'category'     => $request->category,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        $this->syncProductsToLocal();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    // 🔹 DELETE PRODUCT
    public function destroy(Product $product)
    {
        $product->delete();
        $this->syncProductsToLocal();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    // ---------------------------------------------------------
    // JSON / XML SYNC
    // ---------------------------------------------------------

    private function syncProductsToLocal()
    {
        $products = Product::all();

        $this->ensureFolderExists(storage_path('app/local_activity/ADMIN-PRODUCTS'));
        $this->ensureFolderExists(storage_path('app/local_activity/XML/ADMIN-PRODUCTS'));

        Storage::disk('local_activity')
            ->put('ADMIN-PRODUCTS/products.json', $products->toJson(JSON_PRETTY_PRINT));

        $xml = $this->convertToXml($products, 'products', 'product');

        Storage::disk('local_activity')
            ->put('XML/ADMIN-PRODUCTS/products.xml', $xml);
    }

    private function convertToXml($data, $rootElement, $itemElement)
    {
        $xml = new \SimpleXMLElement("<?xml version=\"1.0\"?><$rootElement></$rootElement>");

        foreach ($data as $record) {
            $item = $xml->addChild($itemElement);
            foreach ($record->toArray() as $key => $value) {
                if ($key === 'product_id') {
                    $key = 'id';
                }
                $item->addChild($key, htmlspecialchars((string) $value));
            }
        }

        return $xml->asXML();
    }

    private function ensureFolderExists($path)
    {
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
    }
}
