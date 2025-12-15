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
    // Admin: view all orders
    public function adminIndex()
    {
        $orders = Order::with(['items.product', 'user'])->latest()->get();
        return view('userorderlist', compact('orders'));
    }

    // User: view their own orders
    public function index()
    {
        $orders = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('orderlist', compact('orders'));
    }

    // Show order creation page for a single cart item
    public function create($cart_id)
    {
        $cart = Cart::with('product')->findOrFail($cart_id);
        return view('order', compact('cart'));
    }

    // Store order from selected cart items
   public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:500',
        'contact' => 'required|string|max:20',
        'payment_method' => 'required|string',
        'selected_items' => 'required|array',
    ]);

    $order = Order::create([
        'user_id' => Auth::id(),
        'name' => $request->name,
        'address' => $request->address,
        'contact_number' => $request->contact,
        'status' => 'pending',
        'total_price' => 0,
    ]);

    $total = 0;

    $cartItems = Cart::with('product')
        ->whereIn('cart_id', $request->selected_items)
        ->get();

    foreach ($cartItems as $cart) {
        $product = $cart->product;

        if (!$product || $product->quantity < $cart->quantity) {
            continue;
        }

        $order->items()->create([
            'product_id' => $product->product_id,
            'quantity' => $cart->quantity,
            'price' => $product->price, // snapshot
        ]);

        $total += $cart->quantity * $product->price;

        $product->quantity -= $cart->quantity;
        $product->save();

        $cart->delete();
    }

    $order->update(['total_price' => $total]);

    return redirect()->route('orders.index')
        ->with('success', 'Order placed successfully!');
}


    // Checkout page with selected cart items
    public function checkoutPage(Request $request)
    {
        $selectedItems = $request->input('selected_items', []);

        if (empty($selectedItems)) {
            return redirect()->route('cart.index')->with('error', 'No items selected for checkout!');
        }

        $cartItems = Cart::with('product')->whereIn('cart_id', $selectedItems)->get();

        return view('order', compact('cartItems'));
    }

    // Cancel an order (restore stock)
    public function cancelOrder($orderId)
    {
        $order = Order::where('order_id', $orderId)
                     ->where('user_id', Auth::id())
                     ->firstOrFail();

        if (!in_array(strtolower($order->status), ['pending', 'processing'])) {
            return redirect()->route('orders.index')
                ->with('error', 'This order cannot be cancelled.');
        }

        $order->status = 'cancelled';
        $order->save();

        // Restore stock
        foreach ($order->items as $item) {
            $product = $item->product;
            if ($product) {
                $product->quantity += $item->quantity;
                $product->save();
            }
        }

        $this->syncOrdersToLocal();

        return redirect()->route('orders.index')
            ->with('success', 'Order #' . $orderId . ' has been cancelled.');
    }

    // ---------------- JSON / XML Sync ----------------
    private function syncOrdersToLocal()
    {
        $orders = Order::with(['items.product', 'user'])->get();

        $jsonFolder = 'ORDERS';
        $xmlFolder = 'ORDERS';
        $userOrdersFolder = 'USERS-ORDER';

        $this->ensureFolderExists(storage_path("app/ream_activity/$jsonFolder"));
        $this->ensureFolderExists(storage_path("app/ream_activity/XML/$xmlFolder"));
        $this->ensureFolderExists(storage_path("app/ream_activity/$userOrdersFolder"));
        $this->ensureFolderExists(storage_path("app/ream_activity/XML/$userOrdersFolder"));

        Storage::disk('ream_activity')->put("$jsonFolder/orders.json", $orders->toJson(JSON_PRETTY_PRINT));

        $xmlContent = $this->convertToXml($orders, 'orders', 'order');
        Storage::disk('ream_activity')->put("XML/$xmlFolder/orders.xml", $xmlContent);

        foreach ($orders->groupBy('user_id') as $userId => $userOrders) {
            Storage::disk('ream_activity')->put("$userOrdersFolder/user_$userId.json", $userOrders->toJson(JSON_PRETTY_PRINT));
            $xmlUserContent = $this->convertToXml($userOrders, 'orders', 'order');
            Storage::disk('ream_activity')->put("XML/$userOrdersFolder/user_$userId.xml", $xmlUserContent);
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
}
