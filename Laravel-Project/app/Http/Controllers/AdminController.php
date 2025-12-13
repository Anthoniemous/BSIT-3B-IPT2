<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class AdminController extends Controller
{
    public function dashboard()
    {
        $cancelledOrders = Order::where('status', 'cancelled')->count();
        $totalSales = Order::where('status', 'completed')->sum('total_price');

        $bestProduct = OrderItem::selectRaw('product_id, COUNT(*) as total')
            ->groupBy('product_id')
            ->orderBy('total', 'DESC')
            ->with('product')
            ->first();

        $worstProduct = OrderItem::selectRaw('product_id, COUNT(*) as total')
            ->groupBy('product_id')
            ->orderBy('total', 'ASC')
            ->with('product')
            ->first();

        return view('Dashboard.dashboard', compact(
            'cancelledOrders',
            'totalSales',
            'bestProduct',
            'worstProduct'
        ));
    }
}
