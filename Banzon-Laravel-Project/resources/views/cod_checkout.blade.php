<x-app-layout>
    <div class="container mx-auto px-4 py-8 text-sm">
        <h1 class="text-2xl font-bold mb-6 text-primary">Cash on Delivery - Shipping Details</h1>

        @php
            $grandTotal = $pending['total'] ?? 0;
            $totalItems = $pending['items'] ?? 0;
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- LEFT: INFO FORM --}}
            <div class="lg:col-span-2 bg-white border border-gray-200 rounded p-4">
                <h2 class="text-sm font-semibold text-gray-800 mb-4">
                    Shipping Information
                </h2>

                <form action="{{ route('cod.confirm') }}" method="POST" class="space-y-3">
                    @csrf

                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Full Name</label>
                        <input type="text" name="full_name"
                               class="w-full border rounded px-3 py-2 text-sm"
                               value="{{ old('full_name') }}"
                               required>
                        @error('full_name')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Phone Number</label>
                        <input type="text" name="phone"
                               class="w-full border rounded px-3 py-2 text-sm"
                               value="{{ old('phone') }}"
                               required>
                        @error('phone')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Address</label>
                        <textarea name="address"
                                  class="w-full border rounded px-3 py-2 text-sm"
                                  rows="3"
                                  required>{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Notes (optional)</label>
                        <textarea name="notes"
                                  class="w-full border rounded px-3 py-2 text-sm"
                                  rows="2">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end mt-4">
                        <button type="submit"
                                class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-2 rounded text-sm">
                            Confirm Order
                        </button>
                    </div>
                </form>
            </div>

            {{-- RIGHT: ORDER SUMMARY --}}
            <div class="bg-white border border-gray-200 rounded p-4">
                <h2 class="text-sm font-semibold text-gray-800 mb-4">
                    Order Summary
                </h2>

                <div class="space-y-2 mb-4">
                    @foreach($cart as $item)
                        @php
                            $price     = isset($item['price']) ? floatval($item['price']) : 0;
                            $quantity  = $item['quantity'] ?? 1;
                            $lineTotal = $price * $quantity;
                        @endphp
                        <div class="flex justify-between text-xs text-gray-700">
                            <div class="pr-2">
                                {{ $item['name'] ?? 'Product' }}
                                <span class="text-gray-400">x{{ $quantity }}</span>
                            </div>
                            <div>
                                ₱{{ number_format($lineTotal, 2) }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="border-t pt-3 mt-3 space-y-1 text-sm text-gray-700">
                    <div class="flex justify-between">
                        <span>Items ({{ $totalItems }})</span>
                        <span>₱{{ number_format($grandTotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Shipping Fee</span>
                        <span>Free</span>
                    </div>
                    <div class="flex justify-between items-center pt-2 mt-2 border-t">
                        <span class="text-gray-600">Total Payment:</span>
                        <span class="text-lg font-semibold text-orange-500">
                            ₱{{ number_format($grandTotal, 2) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
