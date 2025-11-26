@extends('layouts.app')

@section('content')
<section class="py-5 bg-light" id="wishlist">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="font-weight-bold text-success">My Wishlist</h2>
            <p class="text-muted">Here are the car accessories you love the most.</p>
               <a href="{{ route('products') }}" class="btn btn-outline-primary btn-sm">
    Back to Products
</a>
    <!-- View Cart Page -->
<a href="{{ route('cart.index') }}" class="btn btn-outline-primary btn-sm">
    View Cart
</a>
        </div>
     
    
        @if($wishlist->count() > 0)
            <div class="row">
                @foreach($wishlist as $item)
                    @if($item->product) {{-- ✅ Only show if product exists --}}
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm">

                                {{-- ⭐ IMAGE --}}
                                <div class="overflow-hidden" style="height: 230px;">
                                    <img src="{{ $item->product->image ? asset('storage/'.$item->product->image) : asset('assets/images/default.png') }}"
                                         alt="{{ $item->product->name }}"
                                         class="card-img-top img-fluid"
                                         style="object-fit: cover; height: 100%; width: 100%;">
                                </div>

                                {{-- ⭐ CARD BODY --}}
                                <div class="card-body text-center">
                                    <h5 class="card-title text-dark font-weight-bold">
                                        {{ $item->product->name }}
                                    </h5>

                                    <p class="text-success font-weight-bold mb-1">
                                        ${{ number_format($item->product->price, 2) }}
                                    </p>

                                    {{-- BUTTONS --}}
                                    <div class="d-flex justify-content-center gap-2 mt-3">
                                        <a href="{{ route('wishlist.remove', $item->product->product_id) }}"
                                           class="btn btn-danger btn-sm w-50">
                                            Remove
                                        </a>

                                        <a href="{{ route('wishlist.move', $item->product->product_id) }}"
                                           class="btn btn-outline-success btn-sm w-50">
                                            Move to Cart
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="text-center mt-4">
                <p class="text-muted">Your wishlist is empty.</p>
            </div>
        @endif

    </div>
</section>
@endsection
