<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class OrderController extends Controller
{
    /**
     * Admin dashboard: paginated orders with optional search/filter/sort
     */
    public function adminIndex(Request $request)
    {
        $query = Order::with(['items.product', 'user'])->latest();

        if ($request->filled('search')) {
            $query->where('order_id', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->filled('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        switch ($request->sort) {
            case 'date_new_old':
                $query->orderBy('created_at', 'desc');
                break;
            case 'date_old_new':
                $query->orderBy('created_at', 'asc');
                break;
            case 'amount_low_high':
                $query->orderBy('total_price', 'asc');
                break;
            case 'amount_high_low':
                $query->orderBy('total_price', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $orders = $query->paginate(10);

        return view('Dashboard.userorderlist', [
            'orders' => $orders,
            'search' => $request->search,
            'status' => $request->status,
            'sort' => $request->sort,
        ]);
    }
        

    /**
     * User orders list (simple view)
     */
    public function index()
    {
        $orders = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('Order.orderlist', compact('orders'));
    }

    /**
     * User orders with filters for dashboard
     */
    public function userOrders(Request $request)
    {
        $query = Order::where('user_id', Auth::id());

        if ($request->filled('search')) {
            $query->where('order_id', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->filled('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        switch ($request->sort) {
            case 'date_new_old':
                $query->orderBy('created_at', 'desc');
                break;
            case 'date_old_new':
                $query->orderBy('created_at', 'asc');
                break;
            case 'amount_low_high':
                $query->orderBy('total_price', 'asc');
                break;
            case 'amount_high_low':
                $query->orderBy('total_price', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $orders = $query->paginate(10);

        return view('Dashboard.userorderlist', [
            'orders' => $orders,
            'search' => $request->search,
            'status' => $request->status,
            'sort' => $request->sort,
        ]);
    }

    /**
     * Show create order page from cart
     */
    public function create($cart_id)
    {
        $cart = Cart::with('product')->findOrFail($cart_id);
        return view('Order.order', compact('cart'));
    }

    /**
     * Store order from cart
     */
    public function store(Request $request)
{
    $request->validate([
        'cart_ids' => 'required|string',
        'name' => 'required|string|max:255',
        'address' => 'required|string',
        'contact' => 'required|string|max:20',
        'payment_method' => 'required|string|in:cod,gcash,maya,bank',
    ]);

    // Parse cart IDs
    $cartIds = array_filter(explode(',', $request->cart_ids));

    if (empty($cartIds)) {
        return redirect()->route('cart.index')
            ->with('error', 'No items found for checkout!');
    }

    // Get cart items
    $cartItems = Cart::with('product')
        ->whereIn('cart_id', $cartIds)
        ->where('user_id', auth()->id())
        ->get();

    if ($cartItems->isEmpty()) {
        return redirect()->route('cart.index')
            ->with('error', 'Selected items not found in your cart!');
    }

    // Calculate total
    $total = $cartItems->sum(function($item) {
        return $item->product->price * $item->quantity;
    });

    // Create the main order
    $order = Order::create([
        'user_id' => auth()->id(),
        'name' => $request->name,
        'address' => $request->address,
        'contact_number' => $request->contact,  // ✅ FIXED: Changed from 'contact' to 'contact_number'
        'total_price' => $total,  // ✅ FIXED: Changed from 'total_amount' to 'total_price' (based on your DB)
        'status' => 'pending',
    ]);

    // Create order items and remove from cart
    foreach ($cartItems as $cartItem) {

    $product = Product::where('product_id', $cartItem->product_id)->lockForUpdate()->first();

    // ❌ OUT OF STOCK CHECK
    if ($product->quantity < $cartItem->quantity) {
        return redirect()->route('cart.index')
            ->with('error', 'Not enough stock for ' . $product->product_name);
    }

    // ✅ CREATE ORDER ITEM
    OrderItem::create([
        'order_id'  => $order->order_id,
        'product_id'=> $cartItem->product_id,
        'quantity'  => $cartItem->quantity,
        'size'      => $cartItem->size,
        'price'     => $product->price,
    ]);

    // 🔥 UPDATE STOCK & SOLD
    $product->decrement('quantity', $cartItem->quantity);
    $product->increment('total_sold', $cartItem->quantity);

    // 🗑 REMOVE FROM CART
    $cartItem->delete();
}

    return redirect()->route('orders.index')
        ->with('success', 'Order placed successfully! Order ID: ' . $order->order_id);
}

    /**
     * Sync orders to local storage (JSON & XML)
     */
    private function syncOrdersToLocal()
    {
        $orders = Order::with(['items.product', 'user'])->get();
        $jsonFolder = 'ADMIN-ORDERS';
        $xmlFolder = 'ADMIN-ORDERS';
        $userOrdersFolder = 'USERS-ORDER';

        $this->ensureFolderExists(storage_path("app/local_activity/$jsonFolder"));
        $this->ensureFolderExists(storage_path("app/local_activity/XML/$xmlFolder"));
        $this->ensureFolderExists(storage_path("app/local_activity/$userOrdersFolder"));
        $this->ensureFolderExists(storage_path("app/local_activity/XML/$userOrdersFolder"));

        Storage::disk('local_activity')->put("$jsonFolder/orders.json", $orders->toJson(JSON_PRETTY_PRINT));
        $xmlContent = $this->convertToXml($orders, 'orders', 'order');
        Storage::disk('local_activity')->put("XML/$xmlFolder/orders.xml", $xmlContent);

        foreach ($orders->groupBy('user_id') as $userId => $userOrders) {
            Storage::disk('local_activity')->put("$userOrdersFolder/user_$userId.json", $userOrders->toJson(JSON_PRETTY_PRINT));
            $xmlUserContent = $this->convertToXml($userOrders, 'orders', 'order');
            Storage::disk('local_activity')->put("XML/$userOrdersFolder/user_$userId.xml", $xmlUserContent);
        }
    }

    private function convertToXml($data, $rootElement = 'items', $itemElement = 'item')
    {
        $xml = new \SimpleXMLElement("<?xml version=\"1.0\"?><$rootElement></$rootElement>");
        foreach ($data as $record) {
            $item = $xml->addChild($itemElement);
            $this->arrayToXml($record->toArray(), $item);
        }
        return $xml->asXML();
    }

    private function arrayToXml(array $data, \SimpleXMLElement &$xml)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $childKey = is_numeric($key) ? 'item' : $key;
                $subnode = $xml->addChild($childKey);
                $this->arrayToXml($value, $subnode);
            } else {
                $xml->addChild($key, htmlspecialchars($value));
            }
        }
    }

    private function ensureFolderExists($folderPath)
    {
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }
    }

    /**
     * Show order details
     */
    public function show(Order $order)
    {
        if (!auth()->user()->is_admin && $order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.product', 'user');
        return view('Order.show', compact('order'));
    }

    /**
     * Cancel order
     */
    public function cancel(Order $order)
    {
        if (!auth()->user()->is_admin && ($order->user_id !== auth()->id() || $order->status !== 'pending')) {
            abort(403);
        }

        $order->status = 'cancelled';
        $order->save();
        $this->syncOrdersToLocal();

        return redirect()->back()->with('success', 'Order cancelled successfully.');
    }

    /**
     * Mark order as complete (admin only)
     */
    public function complete(Order $order)
    {
        if (!auth()->user()->is_admin || $order->status !== 'pending') {
            abort(403);
        }

        $order->status = 'completed';
        $order->save();
        $this->syncOrdersToLocal();

        return redirect()->back()->with('success', 'Order marked as completed.');
    }

     // Update order status (admin)
    public function adminUpdateStatus(Request $request, Order $order)
{
    $validStatuses = ['pending', 'processing', 'completed', 'cancelled'];
    $status = $request->status;

    if (!in_array($status, $validStatuses)) {
        return back()->with('error', 'Invalid status.');
    }

    $order->status = $status;
    $order->save();

    return back()->with('success', 'Order status updated.');
}
  // OrderController.php
public function adminRemove(Order $order)
{
    $order->delete();
    return redirect()->back()->with('success', 'Order removed successfully.');
}
}
