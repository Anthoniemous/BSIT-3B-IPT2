<x-app-layout>
<link rel="stylesheet" href="{{ asset('css/cart.css') }}">

<div class="container">
    <h1 class="page-title">  Cart 🛒</h1>

    {{-- ✅ Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($cartItems->isEmpty())
        <p class="no-orders">No items in your cart.</p>
    @else
        <div class="order-table">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                        <tr>
                            <td>{{ $item->product->product_name ?? 'Unknown Product' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>₱{{ number_format($item->product->price * $item->quantity, 2) }}</td>
                            <td>
                                <div class="actions">
                                    <form method="POST" action="{{ route('cart.remove', $item->cart_id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn danger">Remove</button>
                                    </form>

                                    <form method="GET" action="{{ route('orders.order', ['cart_id' => $item->cart_id]) }}">
                                        <button type="submit" class="btn primary">Checkout</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="mt-6 text-center">
        <a href="{{ route('user.dashboard') }}" 
           class="nav-btn">Back to Dashboard</a>

        <a href="{{ route('orders.index') }}" 
           class="nav-btn ml-3">Go to Orders</a>
    </div>
</div>
</x-app-layout>
