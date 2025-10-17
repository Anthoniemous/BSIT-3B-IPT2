@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Your Cart 🛒</h2>

    @if($cartItems->isEmpty())
        <p>No items in cart.</p>
    @else
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            @foreach($cartItems as $item)
            <tr>
                <td>{{ $item->product->product_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->product->price * $item->quantity, 2) }}</td>
                <td>
                    <form method="POST" action="{{ route('cart.remove', $item->cart_id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Remove</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>

        <form method="POST" action="{{ route('cart.checkout') }}" style="margin-top: 20px;">
            @csrf
            <button type="submit">Checkout</button>
        </form>
    @endif
</div>
@endsection
