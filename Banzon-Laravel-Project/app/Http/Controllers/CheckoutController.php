<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{   // View Checkout Page
    public function checkout()
    {
        if (!session('customer_id')) {
            return redirect('/login')->with('error', 'Please log in.');
        }

        $cart = session('cart', []);

        return view('checkout', compact('cart'));
    }
    public function placeOrder(Request $request)
    {
        $paymentMethod = $request->input('payment_method', 'cod');
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty.');
        }

        // compute total
        $grandTotal = 0;
        $totalItems = 0;

        foreach ($cart as $item) {
            $qty = $item['quantity'] ?? 1;
            $price = isset($item['price']) ? floatval($item['price']) : 0;

            $grandTotal += $price * $qty;
            $totalItems += $qty;
        }

        // For now we only handle COD with the extra info page
        if ($paymentMethod === 'cod') {
            session()->put('pending_order', [
                'payment_method' => 'cod',
                'total'          => $grandTotal,
                'items'          => $totalItems,
            ]);

            return redirect()->route('cod.info');
        }

        // TODO: handle other payment methods here if you add them later
        return redirect()->route('checkout')->with('error', 'Only Cash on Delivery is supported for now.');
    }

        public function showCodInfo()
    {
        $cart = session('cart', []);
        $pending = session('pending_order');

        if (empty($cart) || empty($pending) || ($pending['payment_method'] ?? null) !== 'cod') {
            return redirect()->route('cart.view')->with('error', 'No COD order to confirm.');
        }

        return view('cod_checkout', compact('cart', 'pending'));
    }

public function confirmCodOrder(Request $request)
{
    $customerId = session('customer_id');
    if (!$customerId) {
        return redirect('/login')->with('error', 'Please log in.');
    }

    $cart    = session('cart', []);
    $pending = session('pending_order');

    if (empty($cart) || empty($pending) || ($pending['payment_method'] ?? null) !== 'cod') {
        return redirect()->route('cart.view')->with('error', 'No COD order to confirm.');
    }

    // 1️⃣ Validate user info from form
    $data = $request->validate([
        'full_name' => 'required|string|max:100',
        'phone'     => 'required|string|max:20',
        'address'   => 'required|string|max:255',
        'notes'     => 'nullable|string|max:255',
    ]);

    // 2️⃣ Recompute totals
    $grandTotal = 0;
    $totalItems = 0;

    foreach ($cart as $item) {
        $qty   = $item['quantity'] ?? 1;
        $price = isset($item['price']) ? floatval($item['price']) : 0;

        $grandTotal += $price * $qty;
        $totalItems += $qty;
    }

    DB::beginTransaction();

    try {
        // 3️⃣ Insert into `order`
        $orderId = DB::table('order')->insertGetId([
            'customer_id'  => $customerId,
            'total_amount' => $grandTotal,
            'order_status' => 'Pending',
            'created_by'   => null,
        ]);

        // 4️⃣ Insert `order_item` rows
        foreach ($cart as $item) {
            $qty       = $item['quantity'] ?? 1;
            $price     = isset($item['price']) ? floatval($item['price']) : 0;
            $productId = $item['product_id'] ?? null;

            if (!$productId) {
                continue;
            }

            DB::table('order_item')->insert([
                'order_id'   => $orderId,
                'product_id' => $productId,
                'quantity'   => $qty,
                'price'      => $price,
            ]);
        }

        // 5️⃣ Insert `payment` row
        $paymentId = DB::table('payment')->insertGetId([
            'order_id'       => $orderId,
            'payment_method' => 'COD',
            'payment_status' => 'Pending',
            'amount'         => $grandTotal,
        ]);

        // 6️⃣ Insert `transaction` row
        $remarks = 'COD order | ' .
            'Name: ' . $data['full_name'] .
            ' | Phone: ' . $data['phone'] .
            ' | Address: ' . $data['address'];

        if (!empty($data['notes'])) {
            $remarks .= ' | Notes: ' . $data['notes'];
        }

        DB::table('transaction')->insert([
            'payment_id'        => $paymentId,
            'transaction_type'  => 'Sale',
            'transaction_status'=> 'Pending',
            'remarks'           => $remarks,
        ]);

        DB::commit();

        session()->forget('cart');
        session()->forget('pending_order');

        return redirect()
            ->route('cart.view')
            ->with('success', 'Your COD order has been placed and saved!');
    } catch (\Throwable $e) {
        DB::rollBack();

        // TEMP: show exact DB error so you can see what's wrong
        dd($e->getMessage());

        // (after debugging, replace the dd() with a redirect)
        // return redirect()
        //     ->route('cart.view')
        //     ->with('error', 'Something went wrong placing your order.');
    }
}


}
