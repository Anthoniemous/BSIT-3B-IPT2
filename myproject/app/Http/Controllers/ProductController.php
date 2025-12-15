<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Helpers\Logger;



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

        Logger::log('Products', 'CREATE', "Added product #{$product->id} ({$product->name})");

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
        Logger::log('Products', 'UPDATE', "Updated product #{$product->id} ({$product->name})");

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
            Logger::log('Products', 'DELETE', "Deleted product #{$product->id} ({$product->name})");

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

        // --- DASHBOARD STATS (added) ---

        // ✅ Line chart: Total Sales per day (exclude cancelled)
$salesRows = Order::where('status', '!=', 'cancelled')
    ->selectRaw('DATE(created_at) as day, SUM(total_amount) as total')
    ->groupBy('day')
    ->orderBy('day')
    ->get();

$salesLabels = $salesRows->pluck('day')->map(function ($d) {
    return Carbon::parse($d)->format('M d');
})->toArray();

$salesTotals = $salesRows->pluck('total')->map(fn($v) => (float) $v)->toArray();

// ✅ Doughnut chart: Order status counts
$statusRows = Order::selectRaw('status, COUNT(*) as cnt')
    ->groupBy('status')
    ->get();

$statusLabels = $statusRows->pluck('status')->map(fn($s) => strtoupper($s))->toArray();
$statusCounts = $statusRows->pluck('cnt')->toArray();

$totalOrders = Order::count();

$todaySales = Order::whereDate('created_at', today())
    ->where('status', '!=', 'cancelled')
    ->sum('total_amount');

$totalSales = Order::where('status', '!=', 'cancelled')
    ->sum('total_amount');

// total number of cancelled products (sum qty of items in cancelled orders)
$cancelledProducts = DB::table('order_items')
    ->join('orders', 'orders.id', '=', 'order_items.order_id')
    ->where('orders.status', 'cancelled')
    ->sum('order_items.quantity');

// recent orders
$recentOrders = Order::with('user')->latest()->take(10)->get();

// marketable / non-marketable
$topProducts = DB::table('order_items')
    ->join('orders', 'orders.id', '=', 'order_items.order_id')
    ->join('products', 'products.id', '=', 'order_items.product_id')
    ->where('orders.status', '!=', 'cancelled')
    ->groupBy('products.id', 'products.name')
    ->select('products.name', DB::raw('SUM(order_items.quantity) as qty_sold'))
    ->orderByDesc('qty_sold')
    ->limit(5)
    ->get();

$lowProducts = DB::table('products')
    ->leftJoin('order_items', 'order_items.product_id', '=', 'products.id')
    ->leftJoin('orders', function($join){
        $join->on('orders.id', '=', 'order_items.order_id')
             ->where('orders.status', '!=', 'cancelled');
    })
    ->groupBy('products.id', 'products.name')
    ->select('products.name', DB::raw('COALESCE(SUM(order_items.quantity),0) as qty_sold'))
    ->orderBy('qty_sold')
    ->limit(5)
    ->get();


       return view('admin.main-dashboard', compact(
    'products',
    'totalOrders',
    'todaySales',
    'totalSales',
    'cancelledProducts',
    'recentOrders',
    'topProducts',
    'lowProducts',
    'salesLabels',
    'salesTotals',
    'statusLabels',
    'statusCounts'
));


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
