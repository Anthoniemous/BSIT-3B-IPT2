<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                            <h2 class="text-2xl font-bold text-black">Shippings</h2>
                        </div>
                        <table class="min-w-full border border-fern-green/40 bg-white text-black rounded-lg">
                                <thead>
                                    <tr class="bg-dark-green border-b border-fern-green/50">
                                        <th class="px-6 py-3 text-left text-xs font-bold uppercase text-white">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold uppercase text-white">Details </th>
                                        <th class="px-6 py-3 text-left text-xs font-bold uppercase text-white">Actions</th>
                                    </tr>
                                </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $order->id }}</td>
                                <td class="py-2 px-4 border-b">
                                    Order by {{ $order->user->name ?? 'N/A' }} - Address: {{ $order->shipping_address ?? 'N/A' }} - Status: {{ $order->status }}
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <a href="{{ route('admin.shippings.show', $order->id) }}" class="text-blue-500">View</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="py-2 px-4 border-b text-center">No shippings found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
