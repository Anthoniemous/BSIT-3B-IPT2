@extends('layouts.app')

@section('content')
<section class="py-5 bg-light" id="products">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="font-weight-bold text-success">Our Products</h2>
            <p class="text-muted">Browse our latest car accessories and maintenance products.</p>
        </div>

        {{-- ⭐ SORTING DROPDOWN --}}
        <div class="d-flex justify-content-end mb-4">
            <form method="GET" action="{{ route('products') }}">
                <select name="sort" class="form-select" onchange="this.form.submit()">
                    <option value="">Sort By</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A–Z</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z–A</option>
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
@endsection
