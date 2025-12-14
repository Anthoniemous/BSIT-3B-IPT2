@extends('layouts.app')

@section('content')
<section class="py-5 bg-light">
    <div class="container">

        <div class="text-center mb-4">
            <h2 class="text-success fw-bold">🧾 My Orders</h2>

            <a href="{{ route('products') }}" class="btn btn-outline-primary btn-sm">
                Back to Products
            </a>

            <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary btn-sm">
                View Cart
            </a>
        </div>

        @if($orders->isEmpty())
            <div class="text-center">
                <p class="text-muted">Wala pa kay order.</p>
            </div>
        @else
            @foreach($orders as $order)
                <div class="card mb-4 shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong>Order #{{ $order->id }}</strong>
                        
                        <span class="badge
                            {{ $order->status == 'pending' ? 'bg-warning text-dark' : '' }}
                            {{ $order->status == 'processing' ? 'bg-info text-white' : '' }}
                            {{ $order->status == 'completed' ? 'bg-success text-white' : '' }}
                            {{ $order->status == 'cancelled' ? 'bg-danger text-white' : '' }}
                            text-uppercase">
                            {{ $order->status }}
                        </span>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            @foreach($order->items as $item)
                                <div class="col-md-4 mb-3">
                                    <div class="border rounded p-2 h-100 text-center">

                                        <img 
                                            src="{{ $item->product->image ? asset('storage/' . $item->product->image) : asset('assets/images/default.png') }}"
                                            class="img-fluid rounded mb-2"
                                            style="height: 150px; object-fit: cover;"
                                        >

                                        <h6 class="mb-1">{{ $item->product->product_name }}</h6>

                                        <p class="text-success mb-0">
                                            ₱{{ number_format($item->price, 2) }}
                                        </p>

                                        <small class="text-muted">
                                            Qty: {{ $item->quantity }}
                                        </small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <strong>Total: </strong>
                        <span class="text-success">
                            ₱{{ number_format($order->total, 2) }}
                        </span>

                        @if($order->status != 'completed' && $order->status != 'cancelled')
                            <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    Cancel Order
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif

    </div>
</section>
@endsection
