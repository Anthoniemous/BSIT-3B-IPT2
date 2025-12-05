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

    public function create($cart_id)
    {
        $cart = Cart::with('product')->findOrFail($cart_id);
        return view('order', compact('cart'));
    }

    public function store(Request $request)
{
    // Validate input
    $request->validate([
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:500',
        'contact' => 'required|string|max:20',
        'payment_method' => 'required|string',
        'selected_items' => 'required|array',
    ]);

    $user = Auth::user();

    // Create order
    $order = new Order();
    $order->user_id = $user->id;
    $order->name = $request->name;
    $order->address = $request->address;
    $order->contact_number = $request->contact;
    $order->status = 'pending';
    $order->total_price = 0;
    $order->save();

    $total = 0;

    // Group selected cart items by product_id
    $cartItems = Cart::with('product')
        ->whereIn('cart_id', $request->selected_items)
        ->get()
        ->groupBy('product_id');

    foreach ($cartItems as $productId => $items) {
        $product = $items[0]->product;

        if (!$product) {
            continue; // skip if product does not exist
        }

        $quantity = $items->sum('quantity');
        $price = $product->price;

        // Save merged order item
        $order->items()->create([
            'product_id' => $product->product_id, // ✅ use correct key
            'quantity'   => $quantity,
            'price'      => $price,
        ]);

        $total += $quantity * $price;

        // Delete all cart items for this product
        foreach ($items as $cart) {
            $cart->delete();
        }
    }

    $order->total_price = $total;
    $order->save();

    $this->syncOrdersToLocal();
 
    return redirect()->route('orders.index')
        ->with('success', 'Selected items checked out successfully!');
}

public function checkoutPage(Request $request)
{
    $selectedItems = $request->input('selected_items', []);

    if (empty($selectedItems)) {
        return redirect()->route('cart.index')->with('error', 'No items selected for checkout!');
    }

    $cartItems = Cart::with('product')->whereIn('cart_id', $selectedItems)->get();

    return view('order', compact('cartItems'));
}


    // 🔸 Private helper: sync JSON + XML
    private function syncOrdersToLocal()
    {
        $orders = Order::with(['items.product', 'user'])->get();
        $jsonFolder = 'ORDERS';
        $xmlFolder = 'ORDERS';
        $userOrdersFolder = 'USERS-ORDER';

        $this->ensureFolderExists(storage_path("app/apolinar_activity/$jsonFolder"));
        $this->ensureFolderExists(storage_path("app/apolinar_activity/XML/$xmlFolder"));
        $this->ensureFolderExists(storage_path("app/apolinar_activity/$userOrdersFolder"));
        $this->ensureFolderExists(storage_path("app/apolinar_activity/XML/$userOrdersFolder"));

        // Save JSON
        Storage::disk('apolinar_activity')->put("$jsonFolder/orders.json", $orders->toJson(JSON_PRETTY_PRINT));

        // Save XML
        $xmlContent = $this->convertToXml($orders, 'orders', 'order');
        Storage::disk('apolinar_activity')->put("XML/$xmlFolder/orders.xml", $xmlContent);

        // Save each user's orders separately
        foreach ($orders->groupBy('user_id') as $userId => $userOrders) {
            Storage::disk('apolinar_activity')->put("$userOrdersFolder/user_$userId.json", $userOrders->toJson(JSON_PRETTY_PRINT));

            $xmlUserContent = $this->convertToXml($userOrders, 'orders', 'order');
            Storage::disk('apolinar_activity')->put("XML/$userOrdersFolder/user_$userId.xml", $xmlUserContent);
        }
    }

    // 🔹 Convert collection to XML
    private function convertToXml($data, $rootElement = 'items', $itemElement = 'item')
{
    $xml = new \SimpleXMLElement("<?xml version=\"1.0\"?><$rootElement></$rootElement>");

    foreach ($data as $record) {
        $item = $xml->addChild($itemElement);
        $this->arrayToXml($record->toArray(), $item);
    }

    return $xml->asXML();
}

// Recursive function to handle nested arrays
private function arrayToXml(array $data, \SimpleXMLElement &$xml)
{
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            // Use numeric keys as 'item' by default
            $childKey = is_numeric($key) ? 'item' : $key;
            $subnode = $xml->addChild($childKey);
            $this->arrayToXml($value, $subnode);
        } else {
            $xml->addChild($key, htmlspecialchars($value));
        }
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
