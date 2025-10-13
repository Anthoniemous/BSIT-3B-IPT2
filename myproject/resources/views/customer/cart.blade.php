@extends('layouts.app')

@section('content')
<style>
    body {
        font-family: 'Lato', sans-serif;
        background-color: #fdf6f0;
        color: #3B1F0D;
    }

    h1, h2, h3 {
        font-family: 'Playfair Display', serif;
        color: #4B2D19;
    }

    .cart-container {
        max-width: 900px;
        margin: 40px auto;
        background: #fff8f0;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid #e0d8d0;
    }

    th {
        background-color: #f5e8df;
    }

    img.product-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
    }

    .btn-update, .btn-remove {
        background-color: #FFD699;
        color: #3B1F0D;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-update:hover, .btn-remove:hover {
        transform: translateY(-2px);
        background-color: #e6b86b;
    }

    .btn-back {
        background-color: #4B2D19;
        color: #FFD699;
        padding: 10px 20px;
        border-radius: 6px;
        text-decoration: none;
        display: inline-block;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .btn-back:hover {
        background-color: #3B1F0D;
        color: #fff;
        text-decoration: none;
    }

    .featured-products {
        margin-top: 50px;
    }

    .product-card {
        background-color: #fff5ec;
        border-radius: 12px;
        padding: 15px;
        text-align: center;
        box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        transition: 0.2s;
    }

    .product-card:hover {
        transform: translateY(-3px);
    }

    .product-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 10px;
    }

    .btn-quickshop {
        background-color: #FFD699;
        color: #3B1F0D;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-quickshop:hover {
        background-color: #e6b86b;
    }
</style>

<div class="cart-container">
    <!-- Back to Dashboard -->
    <a href="{{ route('customer.dashboard') }}" class="btn-back">← Back to Dashboard</a>

    <h1 class="mb-4">Your Cart</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(count($cartItems) > 0)
    <form action="">
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cartItems as $item)
                    @php 
                        $subtotal = $item->product->price * $item->quantity; 
                        $total += $subtotal; 
                    @endphp
                    <tr>
                        <td>
                            <img class="product-img" src="{{ $item->product->image ? asset('storage/products/'.$item->product->image) : 'https://via.placeholder.com/80' }}" alt="{{ $item->product->name }}">
                            <div>{{ $item->product->name }}</div>
                        </td>
                        <td>₱ {{ number_format($item->product->price, 2) }}</td>
                        <td>
                            <form action="{{ route('cart.update', $item->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" style="width:60px;">
                                <button type="submit" class="btn-update">Update</button>
                            </form>
                        </td>
                        <td>₱ {{ number_format($subtotal, 2) }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn-remove">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <h3 class="mt-3">Total: ₱ {{ number_format($total, 2) }}</h3>
    </form>
    @else
        <p>Your cart is empty.</p>
    @endif
</div>

<!-- Featured Products -->
<div class="container featured-products">
    <h2 class="mb-4">Featured Coffees</h2>
    <div class="row g-4">
        @foreach($products as $product)
            <div class="col-md-4">
                <div class="product-card">
                    <img src="{{ $product->image ? asset('storage/products/'.$product->image) : 'https://via.placeholder.com/300x200.png?text=Coffee' }}" alt="{{ $product->name }}">
                    <h3>{{ $product->name }}</h3>
                    <p>₱ {{ number_format($product->price, 2) }}</p>
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-quickshop">Quick Shop</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
