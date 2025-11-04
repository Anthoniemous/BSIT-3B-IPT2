@extends('layouts.app')

@section('title', 'Shopping Cart - Paw Paradise')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Shopping Cart</h1>

    @if(empty($cart))
        <div class="alert alert-info text-center py-5">
            <i class="fas fa-shopping-cart fa-3x mb-3"></i>
            <h4>Your cart is empty</h4>
            <p>Browse our pets and add your favorites!</p>
            <a href="{{ route('shop') }}" class="btn btn-primary mt-3">Start Shopping</a>
        </div>
    @else
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        @foreach($cart as $item)
                        <div class="row align-items-center border-bottom py-3">
                            <div class="col-md-2">
                                @if($item['image'])
                                    <img src="{{ asset('storage/' . $item['image']) }}" class="img-fluid rounded" alt="{{ $item['name'] }}">
                                @else
                                    <img src="https://via.placeholder.com/100?text=Pet" class="img-fluid rounded" alt="{{ $item['name'] }}">
                                @endif
                            </div>
                            <div class="col-md-4">
                                <h5>{{ $item['name'] }}</h5>
                                <p class="text-primary fw-bold mb-0">₱{{ number_format($item['price'], 2) }}</p>
                            </div>
                            <div class="col-md-3">
                                <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="d-flex align-items-center">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control" style="width: 80px;">
                                    <button type="submit" class="btn btn-sm btn-primary ms-2">Update</button>
                                </form>
                            </div>
                            <div class="col-md-2">
                                <p class="fw-bold mb-0">₱{{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                            </div>
                            <div class="col-md-1">
                                <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Subtotal:</span>
                            <span class="fw-bold">₱{{ number_format($total, 2) }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <h5>Total:</h5>
                            <h5 class="text-primary">₱{{ number_format($total, 2) }}</h5>
                        </div>
                        <form action="{{ route('cart.checkout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100 btn-lg">Proceed to Checkout</button>
                        </form>
                        <a href="{{ route('shop') }}" class="btn btn-outline-secondary w-100 mt-2">Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection