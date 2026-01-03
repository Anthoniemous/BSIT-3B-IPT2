<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-12 bg-dark-green-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 border-l-4 border-indigo-500">
                <div class="p-6 text-gray-900 flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ __("Welcome back, Admin!") }}</h1>
                       
                    </div>
                    <div class="hidden md:block">
                        <span class="text-sm font-medium bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full">
                            {{ now()->format('F d, Y') }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium uppercase">Total Products</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($totalProducts) }}</p>
                        </div>
                        <div class="p-3 bg-green-100 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium uppercase">Total Sales (Month)</p>
                            <p class="text-2xl font-bold text-gray-900">₱{{ number_format($totalSalesMonth, 2) }}</p>
                        </div>
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium uppercase">Total Orders</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($totalOrders) }}</p>
                        </div>
                        <div class="p-3 bg-purple-100 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                        </div>
                    </div>
                </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium uppercase">Total Customers</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($totalCustomers) }}</p>
                        </div>
                        <div class="p-3 bg-indigo-100 rounded-lg">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium uppercase">Cancelled Orders</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($cancelledOrders) }}</p>
                        </div>
                        <div class="p-3 bg-red-100 rounded-lg">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium uppercase">Pending Shipments</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($pendingShipments) }}</p>
                        </div>
                        <div class="p-3 bg-yellow-100 rounded-lg">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">📈 Sales Performance</h2>
                    <canvas id="salesChart" height="150"></canvas>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">⚠️ Low Stock Alerts</h2>
                    <div class="space-y-4">
                        @forelse($lowStockProducts as $product)
                        <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-700">{{ $product->product_name }}</span>
                            <span class="px-2 py-1 text-xs font-bold bg-red-200 text-red-800 rounded">Stock: {{ $product->stock_quantity }}</span>
                        </div>
                        @empty
                        <p class="text-gray-500 text-sm italic">All products are well stocked.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900">🔥 Top Selling Products</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase">Rank</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase">Product</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase text-center">Total Sold</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($topSellingProducts as $index => $product)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-bold text-gray-400">#{{ $index + 1 }}</td>
                                <td class="px-6 py-4 text-gray-900 font-medium">{{ $product->product_name }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-block px-3 py-1 bg-green-100 text-green-700 rounded-full font-bold">
                                        {{ $product->total_sold }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                datasets: [{
                    label: 'Sales (₱)',
                    data: [12000, 19000, 15000, 25000],
                    borderColor: 'rgba(70, 229, 97, 1)',
                    tension: 0.4,
                    fill: true,
                    backgroundColor: 'rgba(0, 0, 0, 0.1)'
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } }
            }
        });
    </script>
</x-app-layout>