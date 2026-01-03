<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\XmlStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    protected $xmlService; //Kini ang gitawag og Dependency Injection. Gi-inject nako ang XmlStorageService sa constructor aron magamit nako ang iyang mga functions sa tibuok controller nga dili na kinahanglan mag-instantiate og balik-balik.

    public function __construct(XmlStorageService $xmlService)
    {
        $this->xmlService = $xmlService;
    }

    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'product_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $filename = null;

        if ($request->hasFile('product_image')) {
            $file = $request->file('product_image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->storeAs('products', $filename, 'public');
        }

        $product = Product::create([
            'product_name' => $request->product_name,
            'brand' => $request->brand,
            'category' => $request->category,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'description' => $request->description,
            'user_id' => Auth::id(),
            'product_image' => $filename
        ]);

        // ✅ SAVE TO XML
        $this->xmlService->save('product_' . $product->id . '.xml', $product->toArray());

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'product_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $filename = $product->product_image;

        if ($request->hasFile('product_image')) {
            $file = $request->file('product_image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->storeAs('products', $filename, 'public');
        }

        $product->update([
            'product_name' => $request->product_name,
            'brand' => $request->brand,   
            'category' => $request->category,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'description' => $request->description,
            'product_image' => $filename,
        ]);

        // ✅ UPDATE XML
        $this->xmlService->save('product_' . $product->id . '.xml', $product->toArray());

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // ✅ DELETE RELATED CART ITEMS
        $product->carts()->delete();

        // ✅ DELETE RELATED WISHLIST ITEMS
        $product->wishlists()->delete();

        // ✅ DELETE XML FILE
        $this->xmlService->delete('product_' . $product->id . '.xml');

        $product->delete();

        if (DB::table('products')->count() == 0) {
            DB::statement('ALTER TABLE products AUTO_INCREMENT = 1');
        }

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    public function list()
    {
        return view('admin.products.list');
    }

    public function userShop(Request $request)
    {
        $query = Product::query(); //Gigamit nako ang Query Builder aron mahimong dynamic ang pagpangita og data. Ang Product::query() nagtugot nako nga makadugang og filters (search, category, price) depende sa gi-input sa user sa dili pa nako i-execute ang .get()
                                  //Sa dili pa nako i-delete ang product, manual nako nga gipapas ang iyang relasyon sa carts ug wishlists aron malikayan ang 'orphan records' sa database. Pagkahuman, gi-delete sab nako ang iyang physical XML file.
        if ($request->has('search') && !empty($request->search)) {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }

        // BRAND FILTERING
        if ($request->has('brand') && !empty($request->brand)) {
            $query->byBrand($request->brand);
        }

        // PRICE RANGE FILTERING
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $query->priceRange($minPrice, $maxPrice);

         // SORTING
    if ($request->has('sort') && !empty($request->sort)) {
        switch ($request->sort) {
            case 'name_asc':
                $query->orderBy('product_name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('product_name', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
        }
    }

        $products = $query->get();

        $categories = Product::distinct()->pluck('category');
        $brands = Product::distinct()->pluck('brand')->filter()->values(); // Get brands and filter out nulls

        return view('user.product', compact('products', 'categories', 'brands'));
    }

    public function userShow(Product $product)
    {
        return view('user.product_show', compact('product'));
    }

    // ✅ NEW METHOD: Export ALL products to XML
    public function exportAllToXml()
    {
        $products = Product::all();
        
        $this->xmlService->save('all_products.xml', [
            'products' => $products->toArray()
        ]);

        return redirect()->back()->with('success', 'All products exported to XML successfully.');
    }

    // XML data
    public function viewXml(Product $product)
    {
        $xmlData = $this->xmlService->read('product_' . $product->id . '.xml');
        
        return response()->json($xmlData);
    }
}