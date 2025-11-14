@extends('layouts.app')

@section('content')

<section class="section" id="single-product" style="padding-top: 120px; padding-bottom: 100px;">
    <div class="container">
        @if($product)
            <div class="row align-items-center">
                <!-- Product Image -->
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/default.png') }}"
                         alt="{{ $product->name }}"
                         class="img-fluid rounded shadow w-100"
                         style="max-height: 450px; object-fit: cover;">
                </div>

                <!-- Product Info -->
                <div class="col-lg-6">
                    <div class="right-content">
                        <h2 class="fw-bold text-gray-800">{{ $product->name }}</h2>
                        <span class="text-primary fs-4 d-block mb-2">${{ number_format($product->price, 2) }}</span>
                        <p class="text-muted mb-3">{{ $product->description }}</p>
                        <p class="text-secondary mb-3">Available Stock: <strong>{{ $product->stock }}</strong></p>

                        <div class="main-border-button mt-3">
                            <a href="#" class="btn btn-primary text-white px-4 py-2 rounded-pill shadow-sm">
                                Order Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <h3 class="text-gray-600">Product not found.</h3>
                <a href="{{ route('products') }}" class="btn btn-outline-primary mt-3">Back to Products</a>
            </div>
        @endif
    </div>
</section>

@endsection
