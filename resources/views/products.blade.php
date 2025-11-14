@extends('layouts.app')

@section('content')
<!-- ***** Products Section Start ***** -->
<section class="py-5 bg-light" id="products">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="font-weight-bold text-success">Our Products</h2>
            <p class="text-muted">Browse our latest car accessories and maintenance products.</p>
        </div>

        <div class="row">
            @forelse($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <!-- Product Image -->
                        <div class="overflow-hidden" style="height: 230px;">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('assets/images/default.png') }}"
                                 alt="{{ $product->name }}"
                                 class="card-img-top img-fluid"
                                 style="object-fit: cover; height: 100%; width: 100%;">
                        </div>

                        <!-- Product Info -->
                        <div class="card-body text-center">
                            <h5 class="card-title text-dark font-weight-bold">{{ $product->name }}</h5>
                            <p class="text-muted small mb-1">{{ Str::limit($product->description, 60) }}</p>
                            <p class="text-success font-weight-bold mb-1">${{ number_format($product->price, 2) }}</p>
                            <p class="text-secondary small">Stock: {{ $product->stock }}</p>
                            <a href="{{ route('single-product', $product->product_id) }}" class="btn btn-outline-success btn-sm mt-2">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">No products available yet. Please check back later.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
<!-- ***** Products Section End ***** -->
@endsection
