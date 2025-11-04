@extends('layouts.app')

@section('title', 'My Orders - Paw Paradise')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">My Orders</h1>

    @forelse($orders as $order)
    <div class="card mb-4 shadow">
        <div class="card-header bg-light">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <strong>Order #{{ $order->id }}</strong>
                </div>
                <div class="col-md-3">
                    {{ $order->sale_date->format('M d, Y') }}
                </div>
                <div class="col-md-3">
                    <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : 'danger') }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div class="col-md-3 text-end">
                    <strong>₱{{ number_format($order->total_amount, 2) }}</strong>
                </div>
            </div>
        </div>
        <div class="card-body">
            @foreach($order->salesDetails as $detail)
            <div class="row align-items-center mb-3">
                <div class="col-md-2">
                    @if($detail->pet->image)
                        <img src="{{ asset('storage/' . $detail->pet->image) }}" class="img-fluid rounded" alt="{{ $detail->pet->name }}">
                    @else
                        <img src="https://via.placeholder.com/100" class="img-fluid rounded" alt="{{ $detail->pet->name }}">
                    @endif
                </div>
                <div class="col-md-6">
                    <h6>{{ $detail->pet->name }}</h6>
                    <p class="text-muted mb-0">Quantity: {{ $detail->quantity }}</p>
                </div>
                <div class="col-md-4 text-end">
                    <p class="mb-0">₱{{ number_format($detail->subtotal, 2) }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @empty
    <div class="alert alert-info text-center py-5">
        <i class="fas fa-box-open fa-3x mb-3"></i>
        <h4>No orders yet</h4>
        <p>Start shopping to see your orders here!</p>
        <a href="{{ route('shop') }}" class="btn btn-primary mt-3">Browse Pets</a>
    </div>
    @endforelse

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection