@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(180deg, #2C1B10 0%, #4B2D19 100%);
        font-family: 'Roboto', sans-serif;
        color: #fff;
    }

    .main-content { padding: 30px; }

    h1, h2 { color: #FFD699; }

    .product-card {
        background-color: #4B2D19;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        overflow: hidden;
        transition: transform 0.2s;
        display: flex;
        flex-direction: column;
    }
    .product-card:hover { transform: translateY(-5px); }
    .product-card img { width: 100%; height: 200px; object-fit: cover; }
    .product-card-body { padding: 15px; flex: 1; }
    .product-card-title { font-weight: 700; font-size: 1.2rem; margin-bottom: 5px; }
    .product-card-price { font-weight: 600; margin-bottom: 10px; }
    .product-card-footer { padding: 10px 15px; display: flex; justify-content: space-between; }

    .btn-order {
        background-color: #FFD699;
        color: #3B1F0D;
        font-weight: 600;
        transition: transform 0.2s;
        border-radius: 8px;
    }
    .btn-order:hover { transform: translateY(-2px); }
</style>

<div class="main-content">
    <div class="container">
        <h1 class="text-center mb-4">Welcome, {{ Auth::user()->name }}!</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show text-dark" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">
            @if(isset($products) && count($products) > 0)
                @foreach($products as $product)
                    <div class="col-md-6 col-lg-4">
                        <div class="product-card">
                            <img src="{{ $product->image ? asset('storage/products/'.$product->image) : 'https://via.placeholder.com/300x200.png?text=Coffee' }}" alt="{{ $product->name }}">
                            <div class="product-card-body">
                                <h5 class="product-card-title">{{ $product->name }}</h5>
                                <p class="product-card-price">₱ {{ number_format($product->price,2) }}</p>
                                <p>{{ $product->description }}</p>
                            </div>
                            <div class="product-card-footer">
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-order w-100">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-center">No products available.</p>
            @endif
        </div>
    </div>
</div>
@endsection
