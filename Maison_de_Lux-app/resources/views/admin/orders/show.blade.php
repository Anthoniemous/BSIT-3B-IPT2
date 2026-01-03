<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Order #{{ $order->id }}</h3>
                        <p class="text-sm text-gray-500">Placed on {{ $order->created_at->format('M d, Y H:i') }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h4 class="text-md font-medium text-gray-900">Customer Information</h4>
                            <p><strong>Name:</strong> {{ $order->user->name }}</p>
                            <p><strong>Email:</strong> {{ $order->user->email }}</p>
                        </div>
                        <div>
                            <h4 class="text-md font-medium text-gray-900">Order Summary</h4>
                            <p><strong>Total:</strong> ₱{{ number_format($order->total_amount, 2) }}</p>
                            <p><strong>Status:</strong>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status == 'completed') bg-green-100 text-green-800
                                    @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </p>
                            <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-md font-medium text-gray-900">Shipping Address</h4>
                        <p>{{ $order->shipping_address }}</p>
                        @if($order->phone)
                            <p><strong>Phone:</strong> {{ $order->phone }}</p>
                        @endif
                    </div>

                    <div>
                        <h4 class="text-md font-medium text-gray-900 mb-4">Order Items</h4>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($order->orderItems as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->product->product_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->quantity }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">₱{{ number_format($item->price, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">₱{{ number_format($item->quantity * $item->price, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('orders.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Back to Orders</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
