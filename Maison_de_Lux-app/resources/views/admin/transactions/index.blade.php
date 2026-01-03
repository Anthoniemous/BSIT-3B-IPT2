<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-2xl font-bold text-black">Transactions</h2>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-fern-green/40 bg-white text-black rounded-lg">
                            <thead>
                                <tr class="bg-dark-green border-b border-fern-green/50">
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-white">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-white">Details</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-white">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-white">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($orders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-2 px-4 border-b">{{ $order->id }}</td>
                                    <td class="py-2 px-4 border-b">
                                        <div class="text-sm">
                                            <div class="font-medium">Order by {{ $order->user->name ?? 'N/A' }}</div>
                                            <div class="text-gray-600">Total: ${{ number_format($order->total_amount, 2) }}</div>
                                            <div class="text-gray-500 text-xs">{{ $order->created_at->format('M d, Y h:i A') }}</div>
                                        </div>
                                    </td>
                                    <td class="py-2 px-6 border-b">
                                        <form action="{{ route('admin.transactions.updateStatus', $order->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" 
                                                    onchange="this.form.submit()" 
                                                    class="text-sm border rounded px-5 py-2
                                                           {{ $order->status == 'pending' ? 'bg-yellow-100 border-yellow-300 text-yellow-800' : '' }}
                                                           {{ $order->status == 'processing' ? 'bg-blue-100 border-blue-300 text-blue-800' : '' }}
                                                           {{ $order->status == 'shipped' ? 'bg-purple-100 border-purple-300 text-purple-800' : '' }}
                                                           {{ $order->status == 'delivered' ? 'bg-green-100 border-green-300 text-green-800' : '' }}
                                                           {{ $order->status == 'cancelled' ? 'bg-red-100 border-red-300 text-red-800' : '' }}">
                                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="py-2 px-4 border-b">
                                        <a href="{{ route('admin.transactions.show', $order->id) }}" 
                                           class="text-blue-500 hover:text-blue-700 font-medium">View</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-8 px-4 text-center text-gray-500">No transactions found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>