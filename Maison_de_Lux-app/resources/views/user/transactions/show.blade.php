@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Transaction Details</h4>
                </div>
                <div class="card-body">
                    <!-- Transaction Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Transaction ID:</strong> #{{ $transaction->id }}</p>
                            <p class="mb-2"><strong>Reference:</strong> <code>{{ $transaction->transaction_reference ?? 'N/A' }}</code></p>
                            <p class="mb-2"><strong>Order ID:</strong> #{{ $transaction->order_id }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Date:</strong> {{ $transaction->created_at->format('F d, Y h:i A') }}</p>
                            <p class="mb-2">
                                <strong>Status:</strong> 
                                @php
                                    $statusColors = [
                                        'completed' => 'success',
                                        'pending' => 'warning',
                                        'failed' => 'danger',
                                        'refunded' => 'info'
                                    ];
                                    $color = $statusColors[$transaction->transaction_status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $color }}">
                                    {{ ucfirst($transaction->transaction_status) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <hr>

                    <!-- Payment Info -->
                    <h5>Payment Information</h5>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Payment Method:</strong> {{ ucfirst($transaction->payment_method ?? 'N/A') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Total Amount:</strong> 
                                <span class="text-success fw-bold fs-5">₱{{ number_format($transaction->total_amount, 2) }}</span>
                            </p>
                        </div>
                    </div>

                    <hr>

                    <!-- Order Items -->
                    <h5>Order Items</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaction->order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->product->product_name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>₱{{ number_format($item->price, 2) }}</td>
                                    <td>₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Back to Transactions
                        </a>
                        <a href="{{ route('myorders') }}" class="btn btn-primary">
                            View Order Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection