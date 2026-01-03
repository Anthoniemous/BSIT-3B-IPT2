<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white-900">
                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                        <!-- Header & Button -->
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-2xl font-bold text-black">Products</h2>
                            <a href="{{ route('admin.products.create') }}"
                                class="bg-gradient-to-r from-mindaro via-asparagus to-fern-green
                                    hover:from-fern-green hover:to-cal-poly-green
                                    text-black font-semibold py-2 px-4 rounded-lg
                                    shadow-md border border-fern-green
                                    transition duration-300 transform hover:scale-105">
                                Add New Product
                            </a>
                        </div>
                        
                        <!-- Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-fern-green/40 bg-white text-black rounded-lg">
                                <thead>
                                    <tr class="bg-dark-green border-b border-fern-green/50">
                                        <th class="px-6 py-3 text-left text-xs font-bold uppercase text-white">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold uppercase text-white">Product Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold uppercase text-white">Brand</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold uppercase text-white">Category</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold uppercase text-white">Price</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold uppercase text-white">Stock</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold uppercase text-white">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products as $product)
                                        <tr class="border-b border-fern-green/20 hover:bg-fern-green/10 transition-all">
                                            <td class="px-6 py-4 text-sm">{{ $loop->iteration }}</td>
                                            <td class="px-6 py-4 text-sm font-medium">{{ $product->product_name }}</td>
                                            <td class="px-6 py-4 text-sm">{{ $product->brand }}</td>
                                            <td class="px-6 py-4 text-sm">{{ $product->category }}</td>
                                            <td class="px-6 py-4 text-sm text-fern-green font-semibold">₱{{ number_format($product->price, 2) }}</td>
                                            <td class="px-6 py-4 text-sm">
                                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                                    {{ $product->stock_quantity > 20 ? 'bg-green-100 text-green-700' :
                                                       ($product->stock_quantity > 0 ? 'bg-yellow-100 text-yellow-700' :
                                                       'bg-red-100 text-red-700') }}">
                                                    {{ $product->stock_quantity }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm relative" x-data="{ open: false }">
                                                <button @click="open = !open" @click.away="open = false" 
class="flex items-center text-gray-600 hover:text-black focus:outline-none bg-gray-50 px-3 py-1 rounded border border-fern-green shadow-sm hover:border-dark-green transition-colors">                                                    <span class="mr-1 font-medium">Actions</span>
                                                    <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    </svg>
                                                </button>

                                                <div x-show="open" 
                                                    x-transition:enter="transition ease-out duration-100"
                                                    x-transition:enter-start="transform opacity-0 scale-95"
                                                    x-transition:enter-end="transform opacity-100 scale-100"
                                                    x-transition:leave="transition ease-in duration-75"
                                                    x-transition:leave-start="transform opacity-100 scale-100"
                                                    x-transition:leave-end="transform opacity-0 scale-95"
                                                    class="absolute right-0 z-50 mt-2 w-32 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                                                    style="display: none;">
                                                    
                                                    <div class="py-1">
                                                        <a href="{{ route('admin.products.show', $product->product_id) }}" 
                                                        class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                                                            <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                            </svg>
                                                            View
                                                        </a>

                                                        <a href="{{ route('admin.products.edit', $product->product_id) }}" 
                                                        class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600 transition">
                                                            <svg class="w-4 h-4 mr-2 text-fern-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                            </svg>
                                                            Edit
                                                        </a>

                                                        <hr class="my-1 border-gray-100">

                                                        <form action="{{ route('admin.products.destroy', $product->product_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition text-left">
                                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                </svg>
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                                No products found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>