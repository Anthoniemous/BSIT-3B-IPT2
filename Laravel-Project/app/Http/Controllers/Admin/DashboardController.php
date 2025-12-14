<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Disable ONLY_FULL_GROUP_BY para dili mo error ang aggregated queries
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");

        // ================= Stats =================
        $totalOrders = Order::count();

        $ordersGrowth = $this->calculateOrdersGrowth();
        
        // Get monthly order counts for modals
        $ordersThisMonth = Order::whereMonth('created_at', now()->month)
                                ->whereYear('created_at', now()->year)
                                ->count();
        
        $ordersLastMonth = Order::whereMonth('created_at', now()->subMonth()->month)
                                ->whereYear('created_at', now()->subMonth()->year)
                                ->count();

        $totalSales = Order::whereIn('status', ['completed', 'processing', 'pending'])
                           ->sum('total_price');

        $salesGrowth = $this->calculateSalesGrowth();
        
        // Get monthly sales for modals
        $salesThisMonth = Order::whereMonth('created_at', now()->month)
                               ->whereYear('created_at', now()->year)
                               ->whereIn('status', ['completed', 'processing', 'pending'])
                               ->sum('total_price');
        
        $salesLastMonth = Order::whereMonth('created_at', now()->subMonth()->month)
                               ->whereYear('created_at', now()->subMonth()->year)
                               ->whereIn('status', ['completed', 'processing', 'pending'])
                               ->sum('total_price');

        $cancelledOrders = Order::where('status', 'cancelled')->count();

        $activeProducts = Product::count();

        // ================= Recent Orders =================
        $recentOrders = Order::with('user', 'items')->latest()->take(5)->get();

        // ================= Recent Activities =================
        $recentActivities = $this->getRecentActivities();

        // ================= Product Performance =================
        $topProducts = $this->getTopSellingProducts();

        $lowProducts = $this->getLowPerformingProducts();

        // ================= CHART DATA =================
        
        // 1. Sales Trend Data (Last 6 months)
        $salesTrendData = $this->getSalesTrendData(6);

        // 2. Order Status Distribution
        $orderStatusData = $this->getOrderStatusData();

        // 3. Category Performance
        $categoryData = $this->getCategoryPerformanceData();

        // 4. Daily Orders (Last 7 days)
        $dailyOrdersData = $this->getDailyOrdersData();

        return view('Dashboard.dashboard', compact(
            'totalOrders',
            'ordersGrowth',
            'ordersThisMonth',
            'ordersLastMonth',
            'totalSales',
            'salesGrowth',
            'salesThisMonth',
            'salesLastMonth',
            'cancelledOrders',
            'activeProducts',
            'recentOrders',
            'recentActivities',
            'topProducts',
            'lowProducts',
            'salesTrendData',
            'orderStatusData',
            'categoryData',
            'dailyOrdersData'
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

    // ===============================================================
    // CHART DATA METHODS
    // ===============================================================

    /**
     * Get sales trend data for the last N months
     * Returns data for line chart showing monthly revenue
     */
    private function getSalesTrendData($months = 6)
    {
        $labels = [];
        $data = [];

        for ($i = $months - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels[] = $date->format('M Y');
            
            $sales = Order::whereIn('status', ['completed', 'processing', 'pending'])
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('total_price');
            
            $data[] = (float) $sales;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    /**
     * Get order status distribution data
     * Returns data for doughnut chart showing order status breakdown
     */
    private function getOrderStatusData()
    {
        $statuses = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        $labels = [];
        $data = [];

        // Define all possible statuses to ensure consistency
        $statusMap = [
            'completed' => 'Completed',
            'processing' => 'Processing',
            'pending' => 'Pending',
            'cancelled' => 'Cancelled'
        ];

        // Initialize with zeros
        $statusCounts = [
            'completed' => 0,
            'processing' => 0,
            'pending' => 0,
            'cancelled' => 0
        ];

        // Fill with actual counts
        foreach ($statuses as $status) {
            if (isset($statusCounts[$status->status])) {
                $statusCounts[$status->status] = $status->count;
            }
        }

        // Build final arrays
        foreach ($statusCounts as $key => $count) {
            if ($count > 0) { // Only include statuses with orders
                $labels[] = $statusMap[$key];
                $data[] = $count;
            }
        }

        // If no data, return sample data
        if (empty($data)) {
            $labels = ['No Orders'];
            $data = [1];
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    /**
     * Get category performance data
     * Returns data for bar chart showing revenue by category
     */
    private function getCategoryPerformanceData()
    {
        $categoryData = Product::select(
                'products.category', 
                DB::raw('COALESCE(SUM(order_items.quantity * order_items.price), 0) as total_revenue')
            )
            ->leftJoin('order_items', 'products.product_id', '=', 'order_items.product_id')
            ->leftJoin('orders', function ($join) {
                $join->on('order_items.order_id', '=', 'orders.order_id')
                     ->whereIn('orders.status', ['completed', 'processing', 'pending']);
            })
            ->groupBy('products.category')
            ->orderBy('total_revenue', 'desc')
            ->get();

        $labels = [];
        $data = [];

        foreach ($categoryData as $category) {
            // Only include categories with revenue
            if ($category->total_revenue > 0) {
                $labels[] = $category->category;
                $data[] = (float) $category->total_revenue;
            }
        }

        // If no data, return sample message
        if (empty($data)) {
            $labels = ['No Sales'];
            $data = [0];
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    /**
     * Get daily orders data for the last 7 days
     * Returns data for bar chart showing daily order count
     */
    private function getDailyOrdersData()
    {
        $labels = [];
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('D'); // Mon, Tue, Wed, etc.
            
            $orders = Order::whereDate('created_at', $date->toDateString())
                ->count();
            
            $data[] = $orders;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    /**
     * Optional: AJAX endpoint for dynamic sales trend period change
     * You can add this to your routes to allow the dropdown to fetch different periods
     */
    public function getSalesTrend(Request $request)
    {
        $months = $request->input('months', 6);
        $data = $this->getSalesTrendData($months);
        
        return response()->json($data);
    }
}