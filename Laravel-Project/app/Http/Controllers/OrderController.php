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
        return view('Dashboard.userorderlist', compact('orders'));
    }

    public function index()
    {
        $orders = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('Order.orderlist', compact('orders'));
    }

    public function create($cart_id)
    {
        $cart = Cart::with('product')->findOrFail($cart_id);
        return view('Order.order', compact('cart'));
    }

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

        $this->syncOrdersToLocal();

        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }

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
}
