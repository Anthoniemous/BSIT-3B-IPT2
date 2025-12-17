@extends('admin.layout')

@section('title', 'Orders')

@section('content')
<div class="container-fluid pt-4 px-4">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="d-flex align-items-center gap-2">
    <form method="GET" action="{{ route('admin.orders') }}" class="d-flex align-items-center gap-2">
        <label class="small text-muted mb-0">Sort by</label>
        <select name="sort" class="form-select form-select-sm" style="width: 200px;" onchange="this.form.submit()">
            <option value="newest" @selected(($sort ?? 'newest') === 'newest')>Newest</option>
            <option value="oldest" @selected(($sort ?? '') === 'oldest')>Oldest</option>
            <option value="total_high" @selected(($sort ?? '') === 'total_high')>Total (High → Low)</option>
            <option value="total_low" @selected(($sort ?? '') === 'total_low')>Total (Low → High)</option>
            <option value="status_az" @selected(($sort ?? '') === 'status_az')>Status ASC</option>
            <option value="status_za" @selected(($sort ?? '') === 'status_za')>Status DSC</option>
        </select>
    </form>
</div>

    <div class="bg-light rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Orders</h6>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary">
                Back to Dashboard
            </a>
        </div>

        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-dark">
                        <th>#</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Order Date</th>
                        <th style="min-width: 240px;">Update Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($orders as $o)
                        <tr>
                            <td>#{{ $o->order_id }}</td>

                            <td>
                                <div class="fw-semibold">{{ $o->customer_name ?? 'N/A' }}</div>
                                <small class="text-muted">{{ $o->customer_email }}</small>
                            </td>

                            <td>₱{{ number_format($o->total_amount, 2) }}</td>

                            <td>
                                <span class="badge
                                    {{ $o->order_status == 'Paid' ? 'bg-success' : '' }}
                                    {{ $o->order_status == 'Shipped' ? 'bg-primary' : '' }}
                                    {{ $o->order_status == 'Pending' ? 'bg-warning text-dark' : '' }}
                                    {{ $o->order_status == 'Cancelled' ? 'bg-danger' : '' }}
                                ">
                                    {{ $o->order_status }}
                                </span>
                            </td>

                            <td>{{ \Carbon\Carbon::parse($o->order_date)->format('d M Y, h:i A') }}</td>

                            <td>
                                <form action="{{ route('admin.orders.status', $o->order_id) }}" method="POST" class="d-flex gap-2">
                                    @csrf
                                    @method('PUT')

                                    <select name="order_status" class="form-select form-select-sm">
                                        @foreach(['Pending','Paid','Shipped','Cancelled'] as $st)
                                            <option value="{{ $st }}" @selected($o->order_status === $st)>{{ $st }}</option>
                                        @endforeach
                                    </select>

                                    <button class="btn btn-sm btn-primary">Save</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection
