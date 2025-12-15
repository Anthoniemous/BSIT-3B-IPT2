<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
  public function store(Request $request)
{
    $request->validate([
        'name' => 'required|max:100',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'stock_quantity' => 'required|integer|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // validate image
    ]);

    // Handle image upload
    $imageName = null;
    if ($request->hasFile('image')) {
        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('img/products'), $imageName);
    }

    DB::table('product')->insert([
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
        'stock_quantity' => $request->stock_quantity,
        'image' => $imageName, // save filename in DB
        'created_at' => now(),
        'updated_by' => Auth::guard('admin')->id(),

    ]);

    return redirect()->back()->with('success', 'Product added successfully!');
}


        public function index()
    {
        $products = DB::table('product')
                 ->select('product_id as id', 'name', 'description', 'price', 'stock_quantity', 'status','image', 'created_at')
        ->orderBy('created_at', 'desc')
        ->get();

        return view('products', compact('products'));

    }
    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'stock_quantity' => 'required|integer|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $data = [
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
        'stock_quantity' => $request->stock_quantity,
    ];

    if ($request->hasFile('image')) {
        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('img/products'), $imageName);
        $data['image'] = $imageName;
    }

    DB::table('product')
        ->where('product_id', $id)
        ->update($data);

    return redirect()->back()->with('success', 'Product updated successfully!');
}


        public function toggleStatus($id)
    {
        $product = DB::table('product')->where('product_id', $id)->first();

        if (!$product) {
            return back()->with('error', 'Product not found!');
        }

        $newStatus = ($product->status === 'active') ? 'inactive' : 'active';

        DB::table('product')
            ->where('product_id', $id)
            ->update(['status' => $newStatus]);

        return back()->with('success', "Product status changed to {$newStatus}!");
    }
}
