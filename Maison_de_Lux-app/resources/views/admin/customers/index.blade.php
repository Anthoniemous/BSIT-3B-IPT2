<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-2xl font-bold text-black">Customers</h2>
                        </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-fern-green/40 bg-white text-black rounded-lg">
                            <thead>
                                <tr class="bg-dark-green border-b border-fern-green/50">
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-white">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-white">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-white">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-white">Phone</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-white">Address</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-white">Joined</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-fern-green/20">
                                @forelse($customers as $customer)
                                    <tr class="hover:bg-fern-green/10 transition-all">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $customer->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                            {{ $customer->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $customer->email }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $customer->phone ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $customer->address ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-fern-green font-semibold">
                                            {{ $customer->created_at->format('M d, Y') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                            No customers found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $customers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>