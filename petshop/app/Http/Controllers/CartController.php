<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Sale;
use App\Models\SalesDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart', compact('cart', 'total'));
    }

    public function add(Request $request, Pet $pet)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$pet->id])) {
            $cart[$pet->id]['quantity']++;
        } else {
            $cart[$pet->id] = [
                'id' => $pet->id,
                'name' => $pet->name,
                'price' => $pet->price,
                'quantity' => 1,
                'image' => $pet->image,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Pet added to cart successfully!');
    }

    public function update(Request $request, Pet $pet)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$pet->id])) {
            $cart[$pet->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Cart updated successfully!');
    }

    public function remove(Pet $pet)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$pet->id])) {
            unset($cart[$pet->id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Pet removed from cart!');
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty!');
        }

        try {
            DB::beginTransaction();

            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            $sale = Sale::create([
                'sale_date' => now(),
                'total_amount' => $total,
                'user_id' => auth()->id(),
                'status' => 'pending',
            ]);

            foreach ($cart as $item) {
                SalesDetail::create([
                    'sale_id' => $sale->id,
                    'pet_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);

                $pet = Pet::find($item['id']);
                $pet->quantity -= $item['quantity'];
                $pet->save();
            }

            session()->forget('cart');

            DB::commit();

            return redirect()->route('orders')->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong! Please try again.');
        }
    }
}