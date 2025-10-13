<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('YOUR CART 🛒') }}
            </h2>

           
            <a href="{{ route('user.dashboard') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Back
                </a>
        </div>
               <a href="{{ route('orders.index') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Go to Orders
                </a>

                
    </x-slot>

    <div class="max-w-6xl mx-auto p-6">
        @if($cartItems->isEmpty())
            <p class="text-center text-gray-300 text-lg">No items in your cart.</p>
        @else
            <div class="overflow-hidden rounded-xl shadow-lg">
                <table class="w-full border-collapse bg-white text-gray-900">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-gray-300 px-4 py-3 text-left font-semibold">Product</th>
                            <th class="border border-gray-300 px-4 py-3 text-left font-semibold">Quantity</th>
                            <th class="border border-gray-300 px-4 py-3 text-left font-semibold">Price</th>
                            <th class="border border-gray-300 px-4 py-3 text-left font-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-300 px-4 py-3">{{ $item->product->product_name ?? 'Unknown Product' }}</td>
                                <td class="border border-gray-300 px-4 py-3">{{ $item->quantity }}</td>
                                <td class="border border-gray-300 px-4 py-3">
                                    ₱{{ number_format($item->product->price * $item->quantity, 2) }}
                                </td>
                                <td class="border border-gray-300 px-4 py-3">
                                    <div class="flex gap-2">
                                        <!-- Remove Button -->
                                        <form method="POST" action="{{ route('cart.remove', $item->cart_id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition">
                                                Remove
                                            </button>
                                        </form>

                                        <!-- Checkout Button -->
                                        <form method="GET" action="{{ route('orders.order', ['cart_id' => $item->cart_id]) }}">
                                            <button type="submit"
                                                class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition">
                                                Checkout
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
