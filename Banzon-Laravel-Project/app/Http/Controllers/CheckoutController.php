<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        // You can pass cart items if needed
        $cart = session()->get('cart', []);
        return view('checkout', compact('cart'));
    }
}
