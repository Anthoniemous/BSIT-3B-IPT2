@extends('layouts.app')

@section('content')
<section class="py-5 bg-light" id="cart">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="font-weight-bold text-success">Your Cart</h2>
                        <!-- Back to Products Page -->
<a href="{{ route('products') }}" class="btn btn-outline-primary btn-sm">
    Back to Products
</a>
    <a href="{{ route('wishlist.index') }}" class="btn btn-outline-secondary btn-sm">
        View Wishlist
    </a>

        </div>

        @if($cartItems->isEmpty())
            <div class="text-center">
                <p class="text-muted">Your cart is empty. Add some products!</p>
                
            </div>
        @else
            <div class="row">
                @foreach($cartItems as $item)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="overflow-hidden" style="height: 200px;">
                                <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : asset('assets/images/default.png') }}" 
                                     alt="{{ $item->product->name }}" 
                                     class="card-img-top img-fluid" 
                                     style="object-fit: cover; width: 100%; height: 100%;">
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title text-dark">{{ $item->product->name }}</h5>
                                <p class="text-success font-weight-bold mb-1">${{ number_format($item->product->price, 2) }}</p>
                                <p class="text-secondary small mb-1">Quantity: {{ $item->quantity }}</p>
                                
                                <div class="d-flex justify-content-center gap-2 mt-2">
                                    <!-- Update Quantity Form -->
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex gap-1">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control form-control-sm" style="width: 60px;">
                                        <button class="btn btn-primary btn-sm">Update</button>
                                    </form>

                                    <!-- Remove from Cart Form -->
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Remove</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
