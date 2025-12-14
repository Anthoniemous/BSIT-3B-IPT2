@extends('admin.admin')
@section('main')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <h2 class="text-3xl font-bold text-gray-800">📊 Admin Dashboard</h2>
        <p class="text-gray-500">Welcome back, <span class="font-semibold">{{ auth()->user()->name }}</span>!</p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        {{-- Total Orders --}}
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Total Orders</p>
                    <h3 class="text-3xl font-bold mt-2">{{ $totalOrders }}</h3>
                </div>
                <div class="bg-white bg-opacity-20 p-4 rounded-full">
                    <i class="fas fa-shopping-cart text-3xl"></i>
                </div>
            </div>
        </div>

        {{-- Total Sales --}}
        <div class="bg-gradient-to-br from-green-500 to-green-600 text-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Total Sales</p>
                    <h3 class="text-3xl font-bold mt-2">${{ number_format($totalSales, 2) }}</h3>
                </div>
                <div class="bg-white bg-opacity-20 p-4 rounded-full">
                    <i class="fas fa-dollar-sign text-3xl"></i>
                </div>
            </div>
        </div>

        {{-- Total Products --}}
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Total Products</p>
                    <h3 class="text-3xl font-bold mt-2">{{ $totalProducts }}</h3>
                </div>
                <div class="bg-white bg-opacity-20 p-4 rounded-full">
                    <i class="fas fa-box text-3xl"></i>
                </div>
            </div>
        </div>

        {{-- Cancelled Orders --}}
        <div class="bg-gradient-to-br from-red-500 to-red-600 text-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Cancelled Orders</p>
                    <h3 class="text-3xl font-bold mt-2">{{ $cancelledOrders }}</h3>
                </div>
                <div class="bg-white bg-opacity-20 p-4 rounded-full">
                    <i class="fas fa-times-circle text-3xl"></i>
                </div>
            </div>
        </div>

    </div>

    {{-- Charts Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        {{-- Bar Chart: Orders by Status --}}
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h3 class="text-xl font-bold text-gray-800 mb-4">📦 Orders by Status</h3>
            <div style="height: 300px;">
                <canvas id="orderStatusChart"></canvas>
            </div>
        </div>

        {{-- Doughnut Chart: Top Categories --}}
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h3 class="text-xl font-bold text-gray-800 mb-4">🏷️ Product Categories</h3>
            <div style="height: 300px;">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>

    </div>

    {{-- Product Performance Tables --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        {{-- Most Marketable Products --}}
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h3 class="text-xl font-bold text-green-600 mb-4">🔥 Most Marketable Products</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-green-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">Product</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">Total Sold</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($mostMarketable as $product)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-800">{{ $product->name }}</td>
                            <td class="px-4 py-3 text-sm font-semibold text-green-600">{{ $product->total_sold }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="px-4 py-3 text-center text-gray-500">No sales data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Non-Marketable Products --}}
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h3 class="text-xl font-bold text-red-600 mb-4">📉 Non-Marketable Products</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-red-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">Product</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">Total Sold</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($nonMarketable as $product)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-800">{{ $product->name }}</td>
                            <td class="px-4 py-3 text-sm font-semibold text-red-600">{{ $product->total_sold }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="px-4 py-3 text-center text-gray-500">No data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- Recent Orders Table --}}
    <div class="bg-white p-6 rounded-xl shadow-md">
        <h3 class="text-xl font-bold text-gray-800 mb-4">🛒 Recent Orders</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentOrders as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $order->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($order->total, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->status == 'completed') bg-green-100 text-green-800
                                @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                @else bg-blue-100 text-blue-800
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No orders yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Chart.js Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Bar Chart: Orders by Status
    const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
    new Chart(orderStatusCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($orderStatusLabels) !!},
            datasets: [{
                label: 'Orders',
                data: {!! json_encode($orderStatusData) !!},
                backgroundColor: [
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(249, 115, 22, 0.8)'
                ],
                borderColor: [
                    'rgb(59, 130, 246)',
                    'rgb(34, 197, 94)',
                    'rgb(239, 68, 68)',
                    'rgb(249, 115, 22)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { 
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Doughnut Chart: Categories
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($categoryLabels) !!},
            datasets: [{
                data: {!! json_encode($categoryData) !!},
                backgroundColor: [
                    'rgba(147, 51, 234, 0.8)',
                    'rgba(236, 72, 153, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(251, 191, 36, 0.8)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { 
                    position: 'bottom',
                    labels: {
                        padding: 10,
                        font: {
                            size: 12
                        }
                    }
                }
            }
        }
    });
</script>

@endsection