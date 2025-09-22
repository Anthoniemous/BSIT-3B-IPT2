<!-- resources/views/dashboard.blade.php -->
<x-app-layout>
    <div class="flex min-h-screen bg-gray-100">

        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white p-6">
            <h2 class="text-2xl font-bold mb-6">Dashboard</h2>
            <ul class="space-y-3">
                <li><a href="#" class="block px-3 py-2 rounded hover:bg-gray-700">Overview</a></li>
                <li><a href="#" class="block px-3 py-2 rounded hover:bg-gray-700">Orders</a></li>
                <li><a href="#" class="block px-3 py-2 rounded hover:bg-gray-700">Products</a></li>
                <li><a href="#" class="block px-3 py-2 rounded hover:bg-gray-700">Reports</a></li>
                <li><a href="#" class="block px-3 py-2 rounded hover:bg-gray-700">Settings</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8 space-y-6">

            <!-- Profile Section (Kept from old dashboard) -->
            <section class="bg-white shadow rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">My Profile</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p><span class="font-bold">Name:</span> {{ Auth::user()->name }}</p>
                        <p><span class="font-bold">Email:</span> {{ Auth::user()->email }}</p>
                    </div>
                    <div>
                        <p><span class="font-bold">Member Since:</span> {{ Auth::user()->created_at->format('F d, Y') }}</p>
                    </div>
                </div>
            </section>

            <!-- Quick Stats (From ZIP Dashboard) -->
            <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white shadow rounded-lg p-6 border border-gray-200">
                    <h4 class="text-gray-600">Total Orders</h4>
                    <p class="mt-2 text-3xl font-bold text-blue-600">{{ $totalOrders ?? 0 }}</p>
                </div>
                <div class="bg-white shadow rounded-lg p-6 border border-gray-200">
                    <h4 class="text-gray-600">Pending Orders</h4>
                    <p class="mt-2 text-3xl font-bold text-yellow-500">{{ $pendingOrders ?? 0 }}</p>
                </div>
                <div class="bg-white shadow rounded-lg p-6 border border-gray-200">
                    <h4 class="text-gray-600">Products</h4>
                    <p class="mt-2 text-3xl font-bold text-green-600">{{ $products ?? 0 }}</p>
                </div>
                <div class="bg-white shadow rounded-lg p-6 border border-gray-200">
                    <h4 class="text-gray-600">Customers</h4>
                    <p class="mt-2 text-3xl font-bold text-purple-600">{{ $customers ?? 0 }}</p>
                </div>
            </section>

            <!-- Recent Orders (From ZIP Dashboard) -->
            <section class="bg-white shadow rounded-lg p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Orders</h3>
                <table class="min-w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b bg-gray-100">
                            <th class="px-4 py-2 text-gray-600">Order ID</th>
                            <th class="px-4 py-2 text-gray-600">Total</th>
                            <th class="px-4 py-2 text-gray-600">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders ?? [] as $order)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $order->id }}</td>
                                <td class="px-4 py-2">₱{{ number_format($order->total, 2) }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 rounded text-white text-sm
                                        {{ $order->status === 'Completed' ? 'bg-green-600' : 'bg-yellow-500' }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-2 text-center text-gray-500">
                                    No recent orders.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</x-app-layout>
