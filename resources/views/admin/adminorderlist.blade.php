@extends('admin.admin')
@section('main')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <h2 class="text-3xl font-bold text-gray-800">🛒 Customer Orders</h2>
        <a href="{{ route('admin.index') }}" 
           class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
            ← Back to Dashboard
        </a>
    </div>

    {{-- Orders Table --}}
    @if($orders->isEmpty())
        <div class="bg-white rounded-xl shadow-md p-12 text-center">
            <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
            <p class="text-gray-500 text-lg">No orders yet</p>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-green-600 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase">Order ID</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase">Phone</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase">Address</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase">Payment Method</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase">Items</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($orders as $order)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-bold text-gray-900">#{{ $order->id }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-2">
                                        <i class="fas fa-user text-green-600 text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $order->customer_name ?? $order->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $order->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $order->phone ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 max-w-xs truncate">
                                {{ $order->address ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                    {{ ucfirst($order->payment_method ?? 'N/A') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-bold text-green-600">₱{{ number_format($order->total, 2) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                    @elseif($order->status == 'completed') bg-green-100 text-green-800
                                    @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <ul class="text-xs text-gray-600 space-y-1">
                                    @foreach($order->items as $item)
                                    <li class="flex items-center">
                                        <i class="fas fa-box text-gray-400 mr-1"></i>
                                        <span class="font-medium">{{ $item->quantity }}x</span> 
                                        <span class="ml-1">{{ $item->product->name ?? 'Product' }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($order->status != 'completed' && $order->status != 'cancelled')
                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" 
                                            onchange="this.form.submit()" 
                                            class="px-3 py-1 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-green-500 focus:outline-none">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>
                                @else
                                <span class="text-gray-400 text-xs italic">No action</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>

@endsection