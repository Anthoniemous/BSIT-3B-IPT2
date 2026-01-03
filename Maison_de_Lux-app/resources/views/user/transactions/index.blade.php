@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>My Payment Transactions</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            @if($transactions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Transaction ID</th>
                                <th>Reference</th>
                                <th>Order #</th>
                                <th>Amount</th>
                                <th>Payment Method</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                            <tr>
                                <td><strong>#{{ $transaction->id }}</strong></td>
                                <td>
                                    <code class="text-primary">{{ $transaction->transaction_reference ?? 'N/A' }}</code>
                                </td>
                                <td>
                                    <a href="{{ route('myorders') }}" class="text-decoration-none">
                                        Order #{{ $transaction->order_id }}
                                    </a>
                                </td>
                                <td class="fw-bold text-success">
                                    ₱{{ number_format($transaction->total_amount, 2) }}
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        {{ ucfirst($transaction->payment_method ?? 'N/A') }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'completed' => 'success',
                                            'pending' => 'warning',
                                            'failed' => 'danger',
                                            'refunded' => 'info',
                                            'cancelled' => 'secondary'
                                        ];
                                        $color = $statusColors[$transaction->transaction_status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $color }}">
                                        {{ ucfirst($transaction->transaction_status) }}
                                    </span>
                                </td>
                                <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('transactions.show', $transaction->id) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $transactions->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-receipt fs-1 text-muted"></i>
                    <p class="text-muted mt-3">No transactions yet</p>
                    <a href="{{ route('shop') }}" class="btn btn-primary">
                        Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection