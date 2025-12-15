@extends('layouts.customer')

@section('title', 'Order Details')
@section('page_heading', 'Order Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('purchases.index') }}">My Purchases</a></li>
    <li class="breadcrumb-item text-dark" aria-current="page">Order #{{ $order->order_id }}</li>
@endsection

@section('content')
<div class="container py-5">
    <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between mb-3">
        <h2 class="text-primary m-0">Order #{{ $order->order_id }}</h2>
        <a href="{{ route('purchases.index') }}" class="btn btn-outline-secondary rounded-pill">
            Back
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <div class="mb-2"><span class="text-muted">Order Date:</span><br>
                        <strong>{{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y h:i A') }}</strong>
                    </div>
                    <div class="mb-2"><span class="text-muted">Order Status:</span><br>
                        <strong>{{ $order->order_status }}</strong>
                    </div>
                    <div class="mb-2"><span class="text-muted">Payment Method:</span><br>
                        <strong>{{ $order->payment_method ?? '—' }}</strong>
                    </div>
                    <div class="mb-2"><span class="text-muted">Payment Status:</span><br>
                        <strong>{{ $order->payment_status ?? '—' }}</strong>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Total:</span>
                        <strong class="text-primary">₱{{ number_format($order->total_amount, 2) }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <h5 class="mb-3">Items</h5>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-end">Line Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $it)
                                    @php
                                        $line = (float)$it->price * (int)$it->quantity;
                                        $img = !empty($it->product_image)
                                            ? asset('img/products/'.$it->product_image)
                                            : asset('img/no-image.png');
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{ $img }}" alt="img"
                                                     style="width:50px;height:50px;object-fit:cover;border-radius:10px;">
                                                <div class="fw-semibold">{{ $it->product_name }}</div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $it->quantity }}</td>
                                        <td class="text-end">₱{{ number_format($it->price, 2) }}</td>
                                        <td class="text-end">₱{{ number_format($line, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
