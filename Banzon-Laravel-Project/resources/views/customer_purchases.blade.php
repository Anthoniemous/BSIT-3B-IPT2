@extends('layouts.customer')

@section('title', 'My Purchases')
@section('page_heading', 'My Purchases')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
    <li class="breadcrumb-item text-dark" aria-current="page">My Purchases</li>
@endsection

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center text-primary">My Purchases</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    @if($orders->count() <= 0)
        <div class="text-center text-muted py-5">
            You have no orders yet.
        </div>
    @else
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Order #</th>
                                <th>Date</th>
                                <th class="text-center">Items</th>
                                <th class="text-end">Total</th>
                                <th class="text-center">Payment</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $o)
                                @php
                                    $orderStatus = $o->order_status ?? 'Pending';
                                    $payMethod   = $o->payment_method ?? '—';
                                    $payStatus   = $o->payment_status ?? '—';

                                    $orderBadge = match($orderStatus) {
                                        'Paid' => 'bg-success',
                                        'Shipped' => 'bg-primary',
                                        'Cancelled' => 'bg-danger',
                                        default => 'bg-warning text-dark',
                                    };

                                    $payBadge = match($payStatus) {
                                        'Completed' => 'bg-success',
                                        'Failed' => 'bg-danger',
                                        'Pending' => 'bg-warning text-dark',
                                        default => 'bg-secondary',
                                    };
                                @endphp

                                <tr>
                                    <td class="fw-semibold">#{{ $o->order_id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($o->order_date)->format('M d, Y h:i A') }}</td>
                                    <td class="text-center">{{ (int)($o->items_count ?? 0) }}</td>
                                    <td class="text-end">₱{{ number_format($o->total_amount, 2) }}</td>

                                    <td>
                                        <div class="fw-semibold text-center">{{ $payMethod }}</div>
                                    </td>

                                    <td>
                                        <span class="badge {{ $orderBadge }}">{{ $orderStatus }}</span>
                                    </td>

                                    <td class="text-end">
                                        <a href="{{ route('purchases.show', $o->order_id) }}"
                                           class="btn btn-sm btn-outline-primary rounded-pill">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    @endif
</div>
@endsection
