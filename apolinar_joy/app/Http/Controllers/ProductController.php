<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // ADMIN PRODUCTS DASHBOARD (renamed from index)
    public function productsDashboard(Request $request)
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
        return view('productsdashboard', compact('products', 'sort'));
    }

    // ANALYTICS DASHBOARD
    public function dashboard()
    {
        // Total Orders
        $totalOrders = Order::count();
        
        // Order Details with Items
        $orderDetails = Order::with(['items.product', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Order Status Distribution
        $ordersByStatus = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Cancelled Products Count - FIXED to work with order_id primary key
        $cancelledProducts = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.order_id')
            ->where('orders.status', 'cancelled')
            ->sum('order_items.quantity');

        // Total Sales (only completed orders)
        $totalSales = Order::where('status', 'completed')
            ->sum('total_price');

        // Most Marketable Products - FIXED with explicit join on order_id
        $mostMarketable = DB::table('order_items')
            ->select('order_items.product_id', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->join('orders', 'order_items.order_id', '=', 'orders.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.product_id')
            ->where('orders.status', 'completed')
            ->groupBy('order_items.product_id', 'products.product_name', 'products.brand', 'products.category', 'products.price')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get()
            ->map(function($item) {
                // Add product object for compatibility with blade template
                $item->product = (object)[
                    'product_name' => $item->product_name ?? 'N/A',
                    'brand' => $item->brand ?? 'N/A',
                    'category' => $item->category ?? 'N/A',
                    'price' => $item->price ?? 0
                ];
                return $item;
            });

        // Non-Marketable Products - FIXED
        $allProducts = Product::all();
        $productSales = DB::table('order_items')
            ->select('order_items.product_id', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->join('orders', 'order_items.order_id', '=', 'orders.order_id')
            ->where('orders.status', 'completed')
            ->groupBy('order_items.product_id')
            ->pluck('total_sold', 'product_id');

        $nonMarketable = $allProducts->map(function($product) use ($productSales) {
            $product->total_sold = $productSales[$product->product_id] ?? 0;
            return $product;
        })->sortBy('total_sold')->take(10);

        // Monthly Sales Data (last 12 months)
        $monthlySales = Order::where('status', 'completed')
            ->where('created_at', '>=', now()->subMonths(12))
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(total_price) as total'),
                DB::raw('COUNT(*) as order_count')
            )
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Daily Orders (last 30 days)
        $dailyOrders = Order::where('created_at', '>=', now()->subDays(30))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Category Performance - FIXED with explicit order_id join
        $categoryPerformance = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.product_id')
            ->where('orders.status', 'completed')
            ->select('products.category', DB::raw('SUM(order_items.quantity * order_items.price) as revenue'))
            ->groupBy('products.category')
            ->orderBy('revenue', 'desc')
            ->get();

        return view('dashboard', compact(
            'totalOrders',
            'orderDetails',
            'ordersByStatus',
            'cancelledProducts',
            'totalSales',
            'mostMarketable',
            'nonMarketable',
            'monthlySales',
            'dailyOrders',
            'categoryPerformance'
        ));
    }

    // UPDATE ORDER STATUS
    public function updateOrderStatus(Request $request, $orderId)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        // Find by order_id (your primary key)
        $order = Order::where('order_id', $orderId)->firstOrFail();
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }

  public function userDashboard(Request $request)
{
    // 🔹 Filter values
    $sort             = $request->input('sort');
    $selectedBrand    = $request->input('brand');
    $selectedCategory = $request->input('category');
    $minPrice         = $request->input('min_price');
    $maxPrice         = $request->input('max_price');

    $query = Product::query();

    // 🔹 Brand filter
    if (!empty($selectedBrand)) {
        $query->where('brand', $selectedBrand);
    }

    // 🔹 Category filter
    if (!empty($selectedCategory)) {
        $query->where('category', $selectedCategory);
    }

    // 🔹 Price filter
    if (!empty($minPrice)) {
        $query->where('price', '>=', $minPrice);
    }

    if (!empty($maxPrice)) {
        $query->where('price', '<=', $maxPrice);
    }

    // 🔹 Sorting
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

    // 🔹 Dropdown data
    $categories = Product::select('category')->distinct()->pluck('category');
    $brands     = Product::select('brand')->distinct()->pluck('brand');

    return view('userdashboard', compact(
        'products',
        'categories',
        'brands',
        'sort',
        'selectedBrand',
        'selectedCategory',
        'minPrice',
        'maxPrice'
    ));
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

        return redirect()->route('admin.products.dashboard')
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

        return redirect()->route('admin.products.dashboard')
            ->with('success', 'Product updated successfully!');
    }

    // DELETE PRODUCT
    public function destroy(Product $product)
    {
        $product->delete();
        $this->syncProductsToLocal();

        return redirect()->route('admin.products.dashboard')
            ->with('success', 'Product deleted successfully!');
    }

    // 🔸 Sync JSON + XML
    private function syncProductsToLocal()
    {
        $products = Product::all();
        $jsonFolder = 'PRODUCTS';
        $xmlFolder = 'PRODUCTS';

        $this->ensureFolderExists(storage_path("app/apolinar_activity/$jsonFolder"));
        $this->ensureFolderExists(storage_path("app/apolinar_activity/XML/$xmlFolder"));

        // Save JSON
        Storage::disk('apolinar_activity')->put(
            "$jsonFolder/products.json",
            $products->toJson(JSON_PRETTY_PRINT)
        );

        // Save XML
        $xmlContent = $this->convertToXml($products, 'products', 'product');
        Storage::disk('apolinar_activity')->put("XML/$xmlFolder/products.xml", $xmlContent);
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
