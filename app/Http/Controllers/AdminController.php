<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard with stats & charts
     */
    public function index()
    {
        // ✅ Get stats from Orders table
        $totalOrders = Order::count();
        $totalSales = Order::whereNotIn('status', ['cancelled'])->sum('total');
        $totalProducts = Product::count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();

        // ✅ Recent orders (latest 10) with user relationship
        $recentOrders = Order::with('user')->latest()->take(10)->get();

        // ✅ Orders by status (for bar chart)
        $ordersByStatus = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();
        
        $orderStatusLabels = $ordersByStatus->pluck('status')->map(fn($s) => ucfirst($s));
        $orderStatusData = $ordersByStatus->pluck('count');

        // ✅ Products by category (for doughnut chart)
        $productsByCategory = Product::select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->get();
        
        $categoryLabels = $productsByCategory->pluck('category');
        $categoryData = $productsByCategory->pluck('count');

        // ✅ Most Marketable Products (highest sales)
        $mostMarketable = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereNotIn('orders.status', ['cancelled'])
            ->select('products.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('products.product_id', 'products.name')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        // ✅ Non-Marketable Products (no sales or low sales)
        $nonMarketable = DB::table('products')
            ->leftJoin('order_items', 'products.product_id', '=', 'order_items.product_id')
            ->select('products.name', DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_sold'))
            ->groupBy('products.product_id', 'products.name')
            ->orderBy('total_sold', 'asc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalSales',
            'totalProducts',
            'cancelledOrders',
            'recentOrders',
            'orderStatusLabels',
            'orderStatusData',
            'categoryLabels',
            'categoryData',
            'mostMarketable',
            'nonMarketable'
        ));
    }

    /**
     * Show products page
     */
    public function products()
    {
        $products = Product::all();
        return view('admin.products', compact('products'));
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
            'brand'       => 'required|string|max:255',
            'category'    => 'required|string|max:255',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock ?? 0,
            'image'       => $imagePath,
            'brand'       => $request->brand,
            'category'    => $request->category,
        ]);

        $this->syncProducts();

        return redirect()->route('admin.products')->with('success', '✅ Product added successfully!');
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
            'brand'       => 'required|string|max:255',
            'category'    => 'required|string|max:255',
        ]);

        $product = Product::findOrFail($id);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock ?? 0,
            'image'       => $imagePath,
            'brand'       => $request->brand,
            'category'    => $request->category,
        ]);

        $this->syncProducts();

        return redirect()->route('admin.products')->with('success', '✅ Product updated successfully!');
    }

    /**
     * Delete product
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        $this->syncProducts();

        return redirect()->route('admin.products')->with('success', '🗑️ Product deleted successfully!');
    }

    private function syncProducts()
    {
        $products = Product::all();

        Storage::disk('quibo_activity')->put(
            'products.json',
            $products->toJson(JSON_PRETTY_PRINT)
        );

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