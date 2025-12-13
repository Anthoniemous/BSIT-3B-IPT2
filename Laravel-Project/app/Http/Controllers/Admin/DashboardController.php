<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Disable ONLY_FULL_GROUP_BY para dili mo error ang aggregated queries
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");

        // ================= Stats =================
        $totalOrders = Order::count();

        $ordersGrowth = $this->calculateOrdersGrowth();

        $totalSales = Order::whereIn('status', ['completed', 'processing', 'pending'])
                           ->sum('total_price');

        $salesGrowth = $this->calculateSalesGrowth();

        $cancelledOrders = Order::where('status', 'cancelled')->count();

        $activeProducts = Product::count();

        // ================= Recent Orders =================
        $recentOrders = Order::with('user', 'items')->latest()->take(5)->get();

        // ================= Recent Activities =================
        $recentActivities = $this->getRecentActivities();

        // ================= Product Performance =================
        $topProducts = $this->getTopSellingProducts();

        $lowProducts = $this->getLowPerformingProducts();

        return view('Dashboard.dashboard', compact(
            'totalOrders',
            'ordersGrowth',
            'totalSales',
            'salesGrowth',
            'cancelledOrders',
            'activeProducts',
            'recentOrders',
            'recentActivities',
            'topProducts',
            'lowProducts'
        ));
    }

    // ===============================================================
    // TOP SELLING PRODUCTS (no strict SQL errors)
    // ===============================================================
    private function getTopSellingProducts()
{
    return Product::select(
            'products.product_id',
            'products.product_name',
            'products.description',   // correct column
            'products.price',         // correct column
            'products.category',      // correct column
            'products.brand',
            'products.status',
            DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_sold'),
            DB::raw('COALESCE(SUM(order_items.quantity * order_items.price), 0) as total_revenue')
        )
        ->leftJoin('order_items', 'products.product_id', '=', 'order_items.product_id')
        ->leftJoin('orders', function ($join) {
            $join->on('order_items.order_id', '=', 'orders.order_id')
                 ->whereIn('orders.status', ['completed', 'processing', 'pending']);
        })
        ->groupBy('products.product_id')
        ->orderBy('total_sold', 'desc')
        ->orderBy('total_revenue', 'desc')
        ->take(5)
        ->get();
}


    // ===============================================================
    // LOW PERFORMING PRODUCTS
    // ===============================================================
    private function getLowPerformingProducts()
{
    return Product::select(
            'products.product_id',
            'products.product_name',
            'products.description',
            'products.price',
            'products.category',
            'products.brand',
            'products.status',
            DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_sold'),
            DB::raw('COALESCE(SUM(order_items.quantity * order_items.price), 0) as total_revenue')
        )
        ->leftJoin('order_items', 'products.product_id', '=', 'order_items.product_id')
        ->leftJoin('orders', function ($join) {
            $join->on('order_items.order_id', '=', 'orders.order_id')
                 ->whereIn('orders.status', ['completed', 'processing', 'pending']);
        })
        ->groupBy('products.product_id')
        ->orderBy('total_sold', 'asc')
        ->orderBy('total_revenue', 'asc')
        ->take(5)
        ->get();
}

    // ===============================================================
    // RECENT ACTIVITIES
    // ===============================================================
    private function getRecentActivities()
    {
        $activities = [];

        // Recent orders
        $recentOrders = Order::with('user')->latest()->take(3)->get();
        foreach ($recentOrders as $order) {
            $activities[] = [
                'icon' => '🛒',
                'color' => 'blue',
                'title' => 'New Order',
                'description' => 'Order #' . $order->order_id . ' by ' . $order->user->name,
                'time' => $order->created_at->diffForHumans()
            ];
        }

        // Recent products added
        $recentProducts = Product::latest()->take(2)->get();
        foreach ($recentProducts as $product) {
            $activities[] = [
                'icon' => '📦',
                'color' => 'green',
                'title' => 'Product Added',
                'description' => 'New product "' . $product->product_name . '" added',
                'time' => $product->created_at->diffForHumans()
            ];
        }

        // Sort newest first
        usort($activities, function ($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });

        return array_slice($activities, 0, 5);
    }

    // ===============================================================
    // ORDER GROWTH
    // ===============================================================
    private function calculateOrdersGrowth()
    {
        $thisMonth = Order::whereMonth('created_at', now()->month)
                          ->whereYear('created_at', now()->year)
                          ->count();

        $lastMonth = Order::whereMonth('created_at', now()->subMonth()->month)
                          ->whereYear('created_at', now()->subMonth()->year)
                          ->count();

        if ($lastMonth == 0) return $thisMonth > 0 ? 100 : 0;

        return round((($thisMonth - $lastMonth) / $lastMonth) * 100, 2);
    }

    // ===============================================================
    // SALES GROWTH
    // ===============================================================
    private function calculateSalesGrowth()
    {
        $thisMonth = Order::whereMonth('created_at', now()->month)
                          ->whereYear('created_at', now()->year)
                          ->whereIn('status', ['completed', 'processing', 'pending'])
                          ->sum('total_price');

        $lastMonth = Order::whereMonth('created_at', now()->subMonth()->month)
                          ->whereYear('created_at', now()->subMonth()->year)
                          ->whereIn('status', ['completed', 'processing', 'pending'])
                          ->sum('total_price');

        if ($lastMonth == 0) return $thisMonth > 0 ? 100 : 0;

        return round((($thisMonth - $lastMonth) / $lastMonth) * 100, 2);
    }
}

