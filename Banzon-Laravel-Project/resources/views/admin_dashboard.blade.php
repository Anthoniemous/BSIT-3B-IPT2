@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')

<!-- Sale & Revenue Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">

        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-shopping-bag fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Total Orders</p>
                    <h6 class="mb-0">{{ $totalOrders }}</h6>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-coins fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Total Sales</p>
                    <h6 class="mb-0">₱{{ number_format($totalSales, 2) }}</h6>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-ban fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Cancelled Products</p>
                    <h6 class="mb-0">{{ $totalCancelledProducts }}</h6>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <a href="{{ route('admin.orders') }}" class="text-decoration-none">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-eye fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Manage</p>
                        <h6 class="mb-0">View Orders</h6>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>
<!-- Sale & Revenue End -->


<!-- Sales Chart Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">

        <div class="col-sm-12 col-xl-6">
            <div class="bg-light text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Sales (Last 14 Days)</h6>
                    <a href="{{ route('admin.orders') }}">Show All</a>
                </div>
                <div style="height: 320px;">
                    <canvas id="worldwide-sales"></canvas>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-xl-6">
            <div class="bg-light text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Order Status Summary</h6>
                    <a href="{{ route('admin.orders') }}">Show All</a>
                </div>
                <div style="height: 320px;">
                    <canvas id="salse-revenue"></canvas>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Sales Chart End -->


<!-- Recent Sales Start -->
<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Recent Sales</h6>
            <a href="{{ route('admin.orders') }}">Show All</a>
        </div>

        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-dark">
                        <th>Date</th>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($recentOrders as $o)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($o->order_date)->format('d M Y') }}</td>
                            <td>#{{ $o->order_id }}</td>
                            <td>{{ $o->customer_name ?? 'N/A' }}</td>
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
                            <td>
                                <a class="btn btn-sm btn-primary" href="{{ route('admin.orders') }}">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No recent sales found.</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>
<!-- Recent Sales End -->

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const salesLabels = @json($salesByDay->pluck('day'));
    const salesTotals = @json($salesByDay->pluck('total'));

    new Chart(document.getElementById("worldwide-sales"), {
        type: "line",
        data: {
            labels: salesLabels,
            datasets: [{
                label: "Sales",
                data: salesTotals,
                tension: 0.35,
                borderWidth: 2,
                fill: true
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    const statusLabels = @json($statusCounts->pluck('order_status'));
    const statusData = @json($statusCounts->pluck('cnt'));

    new Chart(document.getElementById("salse-revenue"), {
        type: "doughnut",
        data: {
            labels: statusLabels,
            datasets: [{ data: statusData }]
        },
        options: { responsive: true, maintainAspectRatio: false, cutout: "70%" }
    });
</script>
@endpush
