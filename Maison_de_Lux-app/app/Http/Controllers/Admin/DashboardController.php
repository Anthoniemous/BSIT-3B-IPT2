<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total statistics
        $totalProducts = Product::count();
        $totalCustomers = Customer::count();
        $totalOrders = Order::count();
        $pendingShipments = Order::where('status', 'pending')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();
        $totalSalesMonth = Order::whereMonth('created_at', now()->month)
                                ->where('status', 'completed')
                                ->sum('total_amount');

        // Top Selling Products
        $topSellingProducts = Product::select(
                                    'products.id', 
                                    'products.name', 
                                    'products.price', 
                                    DB::raw('SUM(order_items.quantity) as total_sold')
                                )
                                ->join('order_items', 'products.id', '=', 'order_items.product_id')
                                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                                ->where('orders.status', 'completed')
                                ->groupBy('products.id', 'products.name', 'products.price')
                                ->orderByDesc('total_sold')
                                ->take(5)
                                ->get();

        // Low stock products (threshold 5)
        $lowStockProducts = Product::where('stock_quantity', '<=', 5)->get();

        // Pass data to the Blade view
        return view('admin.dashboard', compact(
            'totalProducts', 
            'totalCustomers', 
            'totalOrders', 
            'pendingShipments', 
            'cancelledOrders',
            'totalSalesMonth', 
            'topSellingProducts', 
            'lowStockProducts'
        ));
    }
}
