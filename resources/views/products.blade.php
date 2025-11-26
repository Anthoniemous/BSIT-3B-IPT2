@extends('layouts.app')

@section('content')
<section class="py-5 bg-light" id="products">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="font-weight-bold text-success">Our Products</h2>
            <p class="text-muted">Browse our latest car accessories and maintenance products.</p>
        </div>

        <div class="d-flex mb-4 gap-3">
            <!-- ⭐ FILTER BAR (Left) -->
            <form method="GET" action="{{ route('products') }}" class="d-flex gap-2 me-auto">
                <input 
                    type="text" 
                    name="brand" 
                    placeholder="Brand..." 
                    value="{{ request('brand') }}"
                    class="form-control"
                >

                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-success">Filter</button>
                    <!-- View Wishlist Page -->
    <a href="{{ route('wishlist.index') }}" class="btn btn-outline-secondary btn-sm">
        View Wishlist
    </a>
    <!-- View Cart Page -->
<a href="{{ route('cart.index') }}" class="btn btn-outline-primary btn-sm">
    View Cart
</a>

                
            </form>

            <!-- ⭐ SORT DROPDOWN (Right) -->
            <form method="GET" action="{{ route('products') }}">
                <select name="sort" class="form-select" onchange="this.form.submit()">
                    <option value="">Sort By</option>
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                    <option value="price_low_high" {{ request('sort') == 'price_low_high' ? 'selected' : '' }}>Price: Low → High</option>
                    <option value="price_high_low" {{ request('sort') == 'price_high_low' ? 'selected' : '' }}>Price: High → Low</option>
                </select>
            </form>
        </div>

        <div class="row">
            @forelse($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm">

                        <div class="overflow-hidden" style="height: 230px;">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('assets/images/default.png') }}"
                                 alt="{{ $product->name }}"
                                 class="card-img-top img-fluid"
                                 style="object-fit: cover; height: 100%; width: 100%;">
                        </div>

                        <div class="card-body text-center">
                            <h5 class="card-title text-dark font-weight-bold">{{ $product->name }}</h5>
                            <p class="text-muted small mb-1">{{ Str::limit($product->description, 60) }}</p>
                            <p class="text-success font-weight-bold mb-1">${{ number_format($product->price, 2) }}</p>
                            <p class="text-secondary small mb-1">Stock: {{ $product->stock }}</p>
                            <p class="text-secondary small mb-1">Category: {{ $product->category }}</p>
                            <p class="text-secondary small mb-1">Brand: {{ $product->brand }}</p>

                            <a href="{{ route('single-product', $product->product_id) }}" class="btn btn-outline-success btn-sm mt-2">
                                View Details
                            </a>

                            <!-- ⭐ Wishlist & Cart buttons -->
                            <div class="mt-2 d-flex justify-content-center gap-2">
                                <form method="POST" action="{{ route('wishlist.add', $product->product_id) }}">
                                    @csrf
                                    <button class="btn btn-outline-danger btn-sm">Add to Wishlist</button>
                                </form>
                                <form method="POST" action="{{ route('cart.add', $product->product_id) }}">
                                    @csrf
                                    <button class="btn btn-success btn-sm">Add to Cart</button>
                                </form>
                            </div>
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
@endsection
