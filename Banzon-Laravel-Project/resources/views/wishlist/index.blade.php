@extends('layouts.customer')

@section('title', 'My Wishlist')
@section('page_heading', 'My Wishlist')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
    <li class="breadcrumb-item text-dark" aria-current="page">Wishlist</li>
@endsection

@section('content')
    <div class="container py-5">
        <h2 class="mb-4 text-center text-primary">My Wishlist</h2>

        @php $wishlist = session('wishlist', []); @endphp

        @if(count($wishlist) > 0)
            <div class="table-responsive">
                <table class="table align-middle table-hover bg-white shadow-sm rounded-4 overflow-hidden">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 120px;">Image</th>
                            <th>Product</th>
                            <th style="width: 140px;">Price</th>
                            <th class="text-center" style="width: 280px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wishlist as $item)
                            <tr>
                                <td>
                                    <img
                                        src="{{ $item['image'] ? asset('img/products/' . $item['image']) : asset('img/store-product-1.jpg') }}"
                                        alt="{{ $item['name'] }}"
                                        class="img-fluid rounded-3"
                                        style="width: 100px; height: 80px; object-fit: cover;"
                                    >
                                </td>
                                <td class="fw-semibold">{{ $item['name'] }}</td>
                                <td class="text-primary fw-bold">${{ number_format($item['price'], 2) }}</td>
                                <td>
                                    <div class="d-flex flex-column flex-md-row justify-content-center gap-2">

                                        <!-- Move to Cart (UNCHANGED) -->
                                        <form action="{{ route('wishlist.moveToCart', $item['id']) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-success rounded-pill px-3 w-100">
                                                <i class="fa fa-cart-plus me-1"></i> Move to Cart
                                            </button>
                                        </form>

                                        <!-- Remove (UNCHANGED) -->
                                        <form action="{{ route('wishlist.remove', $item['id']) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger rounded-pill px-3 w-100">
                                                <i class="fa fa-trash me-1"></i> Remove
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-center mt-5">Your wishlist is empty.</p>
        @endif
    </div>
@endsection
