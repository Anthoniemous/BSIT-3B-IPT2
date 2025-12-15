<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    // View Checkout Page
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
        $paymentMethod = $request->input('payment_method', 'cod'); // "cod" or "bank"
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty.');
        }

        // compute total
        $grandTotal = 0;
        $totalItems = 0;

        foreach ($cart as $item) {
            $qty   = $item['quantity'] ?? 1;
            $price = isset($item['price']) ? floatval($item['price']) : 0;

            $grandTotal += $price * $qty;
            $totalItems += $qty;
        }

        // Save pending order for next step page
        if ($paymentMethod === 'cod') {
            session()->put('pending_order', [
                'payment_method' => 'cod',
                'total'          => $grandTotal,
                'items'          => $totalItems,
            ]);

            return redirect()->route('cod.info');
        }

        if ($paymentMethod === 'bank') {
            session()->put('pending_order', [
                'payment_method' => 'bank',
                'total'          => $grandTotal,
                'items'          => $totalItems,
            ]);

            return redirect()->route('bank.info');
        }

        return redirect()->route('checkout')->with('error', 'Invalid payment method selected.');
    }

    // COD page
    public function showCodInfo()
    {
        $cart = session('cart', []);
        $pending = session('pending_order');

        if (empty($cart) || empty($pending) || ($pending['payment_method'] ?? null) !== 'cod') {
            return redirect()->route('cart.view')->with('error', 'No COD order to confirm.');
        }

        return view('cod_checkout', compact('cart', 'pending'));
    }

    // BANK instruction page
    public function showBankInfo()
    {
        $cart = session('cart', []);
        $pending = session('pending_order');

        if (empty($cart) || empty($pending) || ($pending['payment_method'] ?? null) !== 'bank') {
            return redirect()->route('cart.view')->with('error', 'No Bank Transfer order to confirm.');
        }

        return view('bank_checkout', compact('cart', 'pending'));
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

        // Validate
        $data = $request->validate([
            'full_name' => 'required|string|max:100',
            'phone'     => 'required|string|max:20',
            'address'   => 'required|string|max:255',
            'notes'     => 'nullable|string|max:255',
        ]);

        // Totals
        $grandTotal = 0;
        foreach ($cart as $item) {
            $qty   = $item['quantity'] ?? 1;
            $price = isset($item['price']) ? floatval($item['price']) : 0;
            $grandTotal += $price * $qty;
        }

        DB::beginTransaction();

        try {
            $orderId = DB::table('order')->insertGetId([
                'customer_id'  => $customerId,
                'total_amount' => $grandTotal,
                'order_status' => 'Pending',
                'created_by'   => null,
            ]);

            foreach ($cart as $item) {
                $qty       = $item['quantity'] ?? 1;
                $price     = isset($item['price']) ? floatval($item['price']) : 0;
                $productId = $item['product_id'] ?? null;

                if (!$productId) continue;

                DB::table('order_item')->insert([
                    'order_id'   => $orderId,
                    'product_id' => $productId,
                    'quantity'   => $qty,
                    'price'      => $price,
                ]);
            }

            // IMPORTANT: match DB ENUM exactly: 'COD'
            $paymentId = DB::table('payment')->insertGetId([
                'order_id'       => $orderId,
                'payment_method' => 'COD',
                'payment_status' => 'Pending',
                'amount'         => $grandTotal,
            ]);

            $remarks = 'COD order | ' .
                'Name: ' . $data['full_name'] .
                ' | Phone: ' . $data['phone'] .
                ' | Address: ' . $data['address'];

            if (!empty($data['notes'])) {
                $remarks .= ' | Notes: ' . $data['notes'];
            }

            DB::table('transaction')->insert([
                'payment_id'         => $paymentId,
                'transaction_type'   => 'Sale',
                'transaction_status' => 'Pending',
                'remarks'            => $remarks,
            ]);

            DB::commit();

            session()->forget('cart');
            session()->forget('pending_order');

            return redirect()
                ->route('cart.view')
                ->with('success', 'Your COD order has been placed and saved!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('checkout')->with('error', $e->getMessage());
        }
    }

    // BANK confirm (creates order + payment + transaction)
    public function confirmBankOrder(Request $request)
    {
        $customerId = session('customer_id');
        if (!$customerId) {
            return redirect('/login')->with('error', 'Please log in.');
        }

        $cart    = session('cart', []);
        $pending = session('pending_order');

        if (empty($cart) || empty($pending) || ($pending['payment_method'] ?? null) !== 'bank') {
            return redirect()->route('cart.view')->with('error', 'No Bank Transfer order to confirm.');
        }

        // Minimal fields for bank transfer reference + shipping info
        $data = $request->validate([
            'full_name'      => 'required|string|max:100',
            'phone'          => 'required|string|max:20',
            'address'        => 'required|string|max:255',
            'reference_no'   => 'required|string|max:50',
            'notes'          => 'nullable|string|max:255',
        ]);

        // Totals
        $grandTotal = 0;
        foreach ($cart as $item) {
            $qty   = $item['quantity'] ?? 1;
            $price = isset($item['price']) ? floatval($item['price']) : 0;
            $grandTotal += $price * $qty;
        }

        DB::beginTransaction();

        try {
            $orderId = DB::table('order')->insertGetId([
                'customer_id'  => $customerId,
                'total_amount' => $grandTotal,
                'order_status' => 'Pending',
                'created_by'   => null,
            ]);

            foreach ($cart as $item) {
                $qty       = $item['quantity'] ?? 1;
                $price     = isset($item['price']) ? floatval($item['price']) : 0;
                $productId = $item['product_id'] ?? null;

                if (!$productId) continue;

                DB::table('order_item')->insert([
                    'order_id'   => $orderId,
                    'product_id' => $productId,
                    'quantity'   => $qty,
                    'price'      => $price,
                ]);
            }

            // IMPORTANT: match DB ENUM exactly: 'Bank Transfer'
            $paymentId = DB::table('payment')->insertGetId([
                'order_id'       => $orderId,
                'payment_method' => 'Bank Transfer', // MUST match enum :contentReference[oaicite:1]{index=1}
                'payment_status' => 'Pending',
                'amount'         => $grandTotal,
            ]);

            $remarks = 'Bank Transfer | Ref: ' . $data['reference_no'] .
                ' | Name: ' . $data['full_name'] .
                ' | Phone: ' . $data['phone'] .
                ' | Address: ' . $data['address'];

            if (!empty($data['notes'])) {
                $remarks .= ' | Notes: ' . $data['notes'];
            }

            DB::table('transaction')->insert([
                'payment_id'         => $paymentId,
                'transaction_type'   => 'Sale',
                'transaction_status' => 'Pending',
                'remarks'            => $remarks,
            ]);

            DB::commit();

            session()->forget('cart');
            session()->forget('pending_order');

            return redirect()
                ->route('cart.view')
                ->with('success', 'Your Bank Transfer order has been placed! Please wait for confirmation.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('checkout')->with('error', $e->getMessage());
        }
    }

    public function myPurchases()
{
    if (!session('customer_id')) {
        return redirect('/login')->with('error', 'Please log in.');
    }

    $customerId = session('customer_id');

    // Orders + payment + total items
    $orders = DB::table('order as o')
        ->leftJoin('payment as p', 'p.order_id', '=', 'o.order_id')
        ->leftJoin(DB::raw('(SELECT order_id, SUM(quantity) AS items_count FROM order_item GROUP BY order_id) oi'), 'oi.order_id', '=', 'o.order_id')
        ->where('o.customer_id', $customerId)
        ->orderByDesc('o.order_date')
        ->select([
            'o.order_id',
            'o.order_date',
            'o.total_amount',
            'o.order_status',
            'p.payment_method',
            'p.payment_status',
            DB::raw('COALESCE(oi.items_count, 0) AS items_count'),
        ])
        ->get();

    return view('customer_purchases', compact('orders'));
}

public function showPurchase($orderId)
{
    if (!session('customer_id')) {
        return redirect('/login')->with('error', 'Please log in.');
    }

    $customerId = session('customer_id');

    $order = DB::table('order as o')
        ->leftJoin('payment as p', 'p.order_id', '=', 'o.order_id')
        ->where('o.customer_id', $customerId)
        ->where('o.order_id', $orderId)
        ->select([
            'o.order_id',
            'o.order_date',
            'o.total_amount',
            'o.order_status',
            'p.payment_method',
            'p.payment_status',
            'p.payment_date',
        ])
        ->first();

    if (!$order) {
        abort(404);
    }

    $items = DB::table('order_item as oi')
        ->join('product as pr', 'pr.product_id', '=', 'oi.product_id')
        ->where('oi.order_id', $orderId)
        ->select([
            'oi.quantity',
            'oi.price',
            'pr.name as product_name',
            'pr.image as product_image',
            'pr.product_id',
        ])
        ->get();

    return view('customer_purchase_show', compact('order', 'items'));
}

}
