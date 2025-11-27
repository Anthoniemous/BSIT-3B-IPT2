<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    private $xmlPath = 'products.xml';

    private function updateXML()
    {
        $products = Product::with('category')->get();

        $xml = new \SimpleXMLElement('<products></products>');

        foreach ($products as $product) {
            $p = $xml->addChild('product');
            $p->addChild('id', $product->id);
            $p->addChild('name', htmlspecialchars($product->name));
            $p->addChild('brand', htmlspecialchars($product->brand ?? ''));
           $p->addChild('category_name', htmlspecialchars($product->category->name ?? ''));
            $p->addChild('price', $product->price);
            $p->addChild('description', htmlspecialchars($product->description ?? ''));
            $p->addChild('image', $product->image ?? '');
        }

        Storage::put($this->xmlPath, $xml->asXML());
    }

    public function index()
    {
        $products = Product::with('category')->get();
        $categories = Category::all();

        return view('admin.dashboard', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required',
            'brand'       => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric',
            'image'       => 'nullable|image|max:10240',
        ]);

        $product = new Product();
        $product->name        = $request->name;
        $product->brand       = $request->brand;
        $product->category_id = $request->category_id;
        $product->price       = $request->price;
        $product->description = $request->description;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->storeAs('products', $filename, 'public');
            $product->image = $filename;
        }

        $product->save();
        $this->updateXML();

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required',
            'brand'       => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric',
            'image'       => 'nullable|image|max:10240',
        ]);

        $product->name        = $request->name;
        $product->brand       = $request->brand;
        $product->category_id = $request->category_id;
        $product->price       = $request->price;
        $product->description = $request->description;

        if ($request->hasFile('image')) {
            // delete old file if exists
            if ($product->image && Storage::disk('public')->exists('products/'.$product->image)) {
                Storage::disk('public')->delete('products/'.$product->image);
            }

            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->storeAs('products', $filename, 'public');
            $product->image = $filename;
        }

        $product->save();
        $this->updateXML();

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image && Storage::disk('public')->exists('products/'.$product->image)) {
            Storage::disk('public')->delete('products/'.$product->image);
        }

        $product->delete();
        $this->updateXML();

        return redirect()->back()->with('success', 'Product deleted successfully!');
    }

    public function mainDashboard(Request $request)
    {
        $query = Product::query();

        if ($request->sort == 'featured') {
            $query->where('featured', 1);
        }

        if ($request->sort == 'newest') {
            $query->orderBy('created_at', 'desc');
        }

        if ($request->sort == 'price_high') {
            $query->orderBy('price', 'desc');
        }

        if ($request->sort == 'price_low') {
            $query->orderBy('price', 'asc');
        }

        $products = $query->get();

        if ($request->sort == 'featured' && $products->isEmpty()) {
            $products = Product::all();
        }

        return view('admin.main-dashboard', compact('products'));
    }

    public function customerDashboard(Request $request)
    {
        $query = Product::query();

        switch ($request->sort) {
            case 'featured':
                $query->where('featured', 1);
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            default:
                $query->orderBy('name', 'asc');
        }

        $products = $query->get();

        if ($request->sort == 'featured' && $products->isEmpty()) {
            $products = Product::all()->sortBy('name');
        }

        return view('customer.dashboard', compact('products'));
    }
}
