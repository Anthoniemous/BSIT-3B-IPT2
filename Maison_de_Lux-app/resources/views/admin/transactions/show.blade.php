<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold">Order Details - ID: {{ $order->id }}</h3>
                        
                        <!-- Status Badge -->
                        <span class="px-4 py-2 rounded-full text-sm font-semibold
                            {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $order->status == 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $order->status == 'shipped' ? 'bg-purple-100 text-purple-800' : '' }}
                            {{ $order->status == 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $order->status == 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Update Status Section -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <form action="{{ route('admin.transactions.updateStatus', $order->id) }}" method="POST" class="flex items-center gap-4">
                            @csrf
                            @method('PATCH')
                            
                            <label for="status" class="font-semibold text-gray-700">Update Status:</label>
                            <select name="status" id="status" 
                                    class="border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-fern-green">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            
                            <button type="submit" 
                                    class="bg-gradient-to-r from-mindaro via-asparagus to-fern-green
                                           hover:from-fern-green hover:to-cal-poly-green
                                           text-black font-semibold py-2 px-6 rounded-lg
                                           shadow-md border border-fern-green
                                           transition duration-300 transform hover:scale-105">
                                Update Status
                            </button>
                        </form>
                        
                        @error('status')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Order Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-lg mb-3 text-gray-800">Customer Information</h4>
                            <p class="mb-2"><strong>Name:</strong> {{ $order->user->name ?? 'Unknown' }}</p>
                            <p class="mb-2"><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
                            <p class="mb-2"><strong>Phone:</strong> {{ $order->phone }}</p>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-lg mb-3 text-gray-800">Order Information</h4>
                            <p class="mb-2"><strong>Total Amount:</strong> <span class="text-green-600 font-bold">₱{{ number_format($order->total_amount, 2) }}</span></p>
                            <p class="mb-2"><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
                            <p class="mb-2"><strong>Created At:</strong> {{ $order->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <h4 class="font-semibold text-lg mb-3 text-gray-800">Shipping Address</h4>
                        <p class="text-gray-700">{{ $order->shipping_address }}</p>
                    </div>

                    <!-- Order Items -->
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold mb-4">Order Items</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                                <thead>
                                    <tr class="bg-gradient-to-r from-mindaro to-asparagus">
                                        <th class="py-3 px-4 border-b text-left font-bold">Product</th>
                                        <th class="py-3 px-4 border-b text-center font-bold">Quantity</th>
                                        <th class="py-3 px-4 border-b text-right font-bold">Price</th>
                                        <th class="py-3 px-4 border-b text-right font-bold">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderItems as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 px-4 border-b">
                                            {{ $item->product->product_name ?? 'Product not found' }}
                                        </td>
                                        <td class="py-3 px-4 border-b text-center">{{ $item->quantity }}</td>
                                        <td class="py-3 px-4 border-b text-right">₱{{ number_format($item->price, 2) }}</td>
                                        <td class="py-3 px-4 border-b text-right font-semibold">₱{{ number_format($item->quantity * $item->price, 2) }}</td>
                                    </tr>
                                    @endforeach
                                    
                                    <!-- Total Row -->
                                    <tr class="bg-gray-100 font-bold">
                                        <td colspan="3" class="py-3 px-4 text-right">Grand Total:</td>
                                        <td class="py-3 px-4 text-right text-green-600 text-lg">₱{{ number_format($order->total_amount, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 flex items-center space-x-4">
                        <a href="{{ route('admin.transactions.index') }}"
                           class="bg-gradient-to-r from-mindaro via-asparagus to-fern-green
                                  hover:from-fern-green hover:to-cal-poly-green
                                  text-black font-semibold py-2 px-6 rounded-lg
                                  shadow-md border border-fern-green
                                  transition duration-300 transform hover:scale-105">
                            ← Back to Transactions
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>