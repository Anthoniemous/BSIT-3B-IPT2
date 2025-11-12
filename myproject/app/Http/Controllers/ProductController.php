<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    private $xmlPath = 'products.xml';

    private function updateXML()
    {
        $products = Product::all();

        $xml = new \SimpleXMLElement('<products></products>');

        foreach ($products as $product) {
            $p = $xml->addChild('product');
            $p->addChild('id', $product->id);
            $p->addChild('name', htmlspecialchars($product->name));
            $p->addChild('price', $product->price);
            $p->addChild('description', htmlspecialchars($product->description ?? ''));
            $p->addChild('image', $product->image ?? '');
        }

        Storage::put($this->xmlPath, $xml->asXML());
    }

    public function index()
    {
        $products = Product::all();
        return view('admin.dashboard', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:10240',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->storeAs('products', $filename, 'public');
            $product->image = $filename;
        }

        $product->save();

        // 👉 Update XML file after saving
        $this->updateXML();

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    public function edit(Product $product)
    {
        return view('admin.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:10240',
        ]);

        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists('products/'.$product->image)) {
                Storage::disk('public')->delete('products/'.$product->image);
            }
            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->storeAs('products', $filename, 'public');
            $product->image = $filename;
        }

        $product->save();

        // 👉 Update XML file after editing
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

        // 👉 Update XML file after deleting
        $this->updateXML();

        return redirect()->back()->with('success', 'Product deleted successfully!');
    }

    public function mainDashboard()
    {
        $products = Product::all();
        return view('admin.main-dashboard', compact('products'));
    }

    public function customerDashboard(Request $request)
    {
        $query = Product::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%'.$request->search.'%')
                ->orWhere('description', 'like', '%'.$request->search.'%');
        }

        $products = $query->get();

        return view('customer.dashboard', compact('products'));
    }
}
