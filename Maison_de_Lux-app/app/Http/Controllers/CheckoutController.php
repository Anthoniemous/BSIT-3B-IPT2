<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        $rules = [
            'name'           => 'required|string|max:255',
            'email'          => 'required|email',
            'phone'          => 'required|string|max:20',
            'address'        => 'required|string|max:500',
            'payment_method' => 'required|in:cash_on_delivery,gcash,paymaya,card',
        ];

        if (in_array($request->payment_method, ['gcash', 'paymaya'])) {
            $rules['ewallet_number'] = 'required|string|max:20';
        }

        if ($request->payment_method === 'card') {
            $rules['card_number'] = 'required|string|max:19';
            $rules['expiry_date'] = 'required|string|max:7';
            $rules['cvv']         = 'required|string|max:4';
        }

        $request->validate($rules);

        $cartItems = Cart::where('user_id', Auth::id())->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->withErrors('Your cart is empty.');
        }

        $totalAmount = $cartItems->sum(fn ($item) => $item->quantity * $item->product->price);

        $order = Order::create([
            'user_id'          => Auth::id(),
            'total_amount'     => $totalAmount,
            'status'           => 'pending',
            'shipping_address' => $request->address,
            'phone'            => $request->phone,
            'payment_method'   => $request->payment_method,
        ]);

        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->product->price,
            ]);

            $item->product->decrement('stock_quantity', $item->quantity);
        }

        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('myorders')->with('success', 'Order successfully placed!');
    }
}
