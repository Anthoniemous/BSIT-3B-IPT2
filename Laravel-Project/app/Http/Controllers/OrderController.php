<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class OrderController extends Controller
{
    public function adminIndex()
    {
        $orders = Order::with(['items.product', 'user'])->latest()->get();
        return view('userorderlist', compact('orders'));
    }

    public function index()
    {
        $orders = Order::with('items.product')
                       ->where('user_id', Auth::id())
                       ->orderBy('created_at', 'desc')
                       ->paginate(5);
        return view('orderlist', compact('orders'));
    }

    // Show specific cart item for ordering
    public function create($cart_id)
    {   
        $cart = Cart::with('product')->findOrFail($cart_id);
        return view('order', compact('cart'));
    }

    // Store new order
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'contact' => 'required|string|max:20',
            'payment_method' => 'required|string',
        ]);

        $user = Auth::user();

        $order = new Order();
        $order->user_id = $user->id;
        $order->name = $request->name;
        $order->address = $request->address;
        $order->contact_number = $request->contact;
        $order->status = 'pending';
        $order->total_price = 0;
        $order->save();

        $cartItems = Cart::where('user_id', $user->id)->get();
        foreach ($cartItems as $cart) {
            $order->items()->create([
                'product_id' => $cart->product_id,
                'quantity' => $cart->quantity,
                'price' => $cart->product->price,
            ]);
            $order->total_price += $cart->product->price * $cart->quantity;
        }
        $order->save();

        Cart::where('user_id', $user->id)->delete();

        $this->syncOrdersToLocal(); // ✅ Sync to local JSON

        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }

    // 🔸 Private helper for JSON sync
    private function syncOrdersToLocal()
    {
        $orders = \App\Models\Order::with(['items.product', 'user'])->get();
        $ordersFolder = 'ADMIN-ORDERS';
        $userOrdersFolder = 'USERS-ORDER';

        $this->ensureFolderExists(storage_path("app/local_activity/$ordersFolder"));
        $this->ensureFolderExists(storage_path("app/local_activity/$userOrdersFolder"));

        Storage::disk('local_activity')->put("$ordersFolder/orders.json", $orders->toJson(JSON_PRETTY_PRINT));

        // Save each user's orders separately
        foreach ($orders->groupBy('user_id') as $userId => $userOrders) {
            Storage::disk('local_activity')->put("$userOrdersFolder/user_$userId.json", $userOrders->toJson(JSON_PRETTY_PRINT));
        }
    }

    // 🔹 Ensure folder exists
    private function ensureFolderExists($folderPath)
    {
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }
    }
}
