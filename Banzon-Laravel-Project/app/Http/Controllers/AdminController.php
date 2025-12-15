<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // ===================================================
    // Show Admin Login Form
    // ===================================================
    public function showLogin()
    {
        return view('admin.login'); // make sure this view exists
    }

    // ===================================================
    // Handle Admin Login (manual)
    // ===================================================
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $admin = DB::table('admin')->where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            $request->session()->invalidate();
            $request->session()->regenerate();
            $request->session()->put('role', 'admin');
            $request->session()->put('admin_id', $admin->admin_id);

            return redirect()->route('admin.dashboard')->with('success', 'Welcome back, Admin!');

        }

        return back()->withErrors([
            'email' => 'Invalid credentials. Please try again.',
        ]);
    }

    // ===================================================
    // (Optional) Admin Registration (if needed)
    // ===================================================
    public function showRegister()
    {
        return view('admin.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:admin,username',
            'email'    => 'required|email|max:100|unique:admin,email',
            'password' => 'required|confirmed|min:8',
        ]);

        DB::table('admin')->insert([
            'username'          => $request->username,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'google_id'         => null,
            'created_at'        => now(),
            'email_verified_at' => now(), // optional: mark admin verified immediately
        ]);

        return redirect()->route('admin.login')
            ->with('success', 'Admin account created. You can now log in.');
    }

    // ===================================================
    // Admin Dashboard (statistics + orders)
    // ===================================================
    public function dashboard()
    {
        $totalOrders = DB::table('order')->count();

        $totalSales = DB::table('order')
            ->whereIn('order_status', ['Paid', 'Shipped'])
            ->sum('total_amount');

        $totalCancelledProducts = DB::table('order_item')
            ->join('order', 'order_item.order_id', '=', 'order.order_id')
            ->where('order.order_status', 'Cancelled')
            ->sum('order_item.quantity');

        // Sales chart (last 14 days)
        $salesByDay = DB::table('order')
            ->selectRaw("DATE(order_date) as day, SUM(total_amount) as total")
            ->whereIn('order_status', ['Paid', 'Shipped'])
            ->where('order_date', '>=', now()->subDays(14))
            ->groupByRaw("DATE(order_date)")
            ->orderBy('day')
            ->get();

        // Status summary chart
        $statusCounts = DB::table('order')
            ->select('order_status', DB::raw('COUNT(*) as cnt'))
            ->groupBy('order_status')
            ->get();

        // Marketable / non-marketable (still shown on dashboard)
        $topMarketable = DB::table('order_item')
            ->join('order', 'order_item.order_id', '=', 'order.order_id')
            ->join('product', 'order_item.product_id', '=', 'product.product_id')
            ->where('order.order_status', '!=', 'Cancelled')
            ->select(
                'product.product_id',
                'product.name',
                DB::raw('SUM(order_item.quantity) as qty_sold'),
                DB::raw('SUM(order_item.quantity * order_item.price) as revenue')
            )
            ->groupBy('product.product_id', 'product.name')
            ->orderByDesc('qty_sold')
            ->limit(5)
            ->get();

        $salesSub = DB::table('order_item')
            ->join('order', 'order_item.order_id', '=', 'order.order_id')
            ->where('order.order_status', '!=', 'Cancelled')
            ->select('order_item.product_id', DB::raw('SUM(order_item.quantity) as qty_sold'))
            ->groupBy('order_item.product_id');

        $nonMarketable = DB::table('product')
            ->leftJoinSub($salesSub, 'sales', function ($join) {
                $join->on('product.product_id', '=', 'sales.product_id');
            })
            ->select('product.product_id', 'product.name', DB::raw('COALESCE(sales.qty_sold, 0) as qty_sold'))
            ->orderBy('qty_sold')
            ->limit(5)
            ->get();
        
        $recentOrders = DB::table('order')
            ->join('customer', 'order.customer_id', '=', 'customer.customer_id')
            ->select('order.*', 'customer.name as customer_name')
            ->orderByDesc('order.order_date')
            ->limit(5)
            ->get();

        return view('admin_dashboard', compact(
            'totalOrders',
            'totalSales',
            'totalCancelledProducts',
            'salesByDay',
            'statusCounts',
            'recentOrders',
            'topMarketable',
            'nonMarketable'
        ));
    }

    public function orders()
    {
        $orders = DB::table('order')
            ->join('customer', 'order.customer_id', '=', 'customer.customer_id')
            ->select('order.*', 'customer.name as customer_name', 'customer.email as customer_email')
            ->orderByDesc('order.order_date')
            ->get();

        return view('admin_orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'order_status' => 'required|in:Pending,Paid,Shipped,Cancelled',
        ]);

        DB::table('order')
            ->where('order_id', $id)
            ->update(['order_status' => $request->order_status]);

        return back()->with('success', 'Order status updated!');
    }
}
