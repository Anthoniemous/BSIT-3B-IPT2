<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function adminIndex()
{
    $orders = Order::with(['items.product', 'user']) // para makita sad ang user name kung gusto nimo
                   ->latest()
                   ->get();

    return view('userorderlist', compact('orders'));
}
 public function index()
{
    $orders = Order::with('items.product')
                   ->where('user_id', Auth::id())
                   ->orderBy('created_at', 'desc')
                   ->paginate(5); // try 5 first to test pagination

    return view('orderlist', compact('orders'));
}

    // 🔹 Show specific cart item for ordering
    public function create($cart_id)
    {   
        // Retrieve specific cart item with product details
        $cart = Cart::with('product')->findOrFail($cart_id);

        return view('order', compact('cart'));
    }

    // 🔹 Store new order
    // 🔹 Store new order
public function store(Request $request)
{
    // Validate user input
    $request->validate([
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:500',
        'contact' => 'required|string|max:20',
        'payment_method' => 'required|string',
    ]);

    // Get the current logged-in user
    $user = Auth::user();

    // Create new order record
    $order = new Order();
    $order->user_id = $user->id;
    $order->name = $request->name;
    $order->address = $request->address;
    $order->contact_number = $request->contact;
    $order->status = 'pending';
    $order->total_price = 0; // You can update this later if you have cart total logic
    $order->save();

    // Optional: If you want to move items from cart to order_items table
    // (Uncomment if you already have order_items table and relationships)
    
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

    // Clear the user's cart after placing the order
    Cart::where('user_id', $user->id)->delete();


    return redirect()->route('orders.index')
        ->with('success', 'Order placed successfully!');
}

}
