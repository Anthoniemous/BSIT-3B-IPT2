<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Your Cart</h1>

        @php $grandTotal = 0; @endphp

        @if(session('cart') && count(session('cart')) > 0)
            <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-2 px-4 text-left">Product</th>
                        <th class="py-2 px-4 text-left">Price</th>
                        <th class="py-2 px-4 text-left">Quantity</th>
                        <th class="py-2 px-4 text-left">Total</th>
                        <th class="py-2 px-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(session('cart') as $id => $item)
                        @php
                            $price = isset($item['price']) ? floatval($item['price']) : 0;
                            $quantity = $item['quantity'] ?? 1;
                            $total = $price * $quantity;
                            $grandTotal += $total;
                        @endphp
                        <tr class="border-b">
                            <td class="py-2 px-4">{{ $item['name'] ?? 'Unknown Product' }}</td>
                            <td class="py-2 px-4">${{ number_format($price, 2) }}</td>
                            <td class="py-2 px-4">
                                <!-- Update quantity input -->
                                <form action="{{ route('cart.update') }}" method="POST">
                                    @csrf
                                    <input type="number" name="quantities[{{ $id }}]" value="{{ $quantity }}" min="1" class="border rounded px-2 py-1 w-20">
                                    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded ml-2">
                                        Update
                                    </button>
                                </form>
                            </td>
                            <td class="py-2 px-4">${{ number_format($total, 2) }}</td>
                            <td class="py-2 px-4">
                                <!-- Remove product form -->
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                        Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right font-bold py-2 px-4">Grand Total:</td>
                        <td class="font-bold py-2 px-4">${{ number_format($grandTotal, 2) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>

            <div class="mt-4 flex justify-end">
                <a href="{{ route('checkout') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    Proceed to Checkout
                </a>
            </div>
        @else
            <p class="text-gray-600">Your cart is empty.</p>
        @endif
    </div>
</x-app-layout>
