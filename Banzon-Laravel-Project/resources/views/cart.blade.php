<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6 text-primary">Your Cart</h1>

        @if(!empty($lastOrder))
            <div class="mb-4 bg-blue-50 border border-blue-200 text-sm text-blue-800 px-4 py-3 rounded">
                Last order #{{ $lastOrder->order_id }} status:
                <span class="font-semibold">{{ $lastOrder->order_status }}</span>

                @if(!empty($lastPayment))
                    — Payment: {{ $lastPayment->payment_method }} ({{ $lastPayment->payment_status }})
                @endif

                — Total: ₱{{ number_format($lastOrder->total_amount, 2) }}
            </div>
        @endif

        @php
            $grandTotal = 0;
            $totalItems = 0;
        @endphp

        @if(session('cart') && count(session('cart')) > 0)
            {{-- CART ITEMS --}}
            <div class="border border-gray-200 rounded bg-white">

                @foreach(session('cart') as $id => $item)
                    @php
                        $price = isset($item['price']) ? floatval($item['price']) : 0;
                        $quantity = $item['quantity'] ?? 1;
                        $total = $price * $quantity;
                        $grandTotal += $total;
                        $totalItems += $quantity;
                    @endphp

                    <div class="flex items-center px-4 py-4 border-b last:border-b-0 text-sm">

                        {{-- Checkbox --}}
                        <div class="w-6 flex justify-center">
                            <input type="checkbox" class="form-checkbox item-checkbox"  data-qty="{{ $quantity }}"
                             data-total="{{ $total }}" checked>
                        </div>

                        {{-- Product image --}}
                        <div class="w-16 h-16 mr-3 flex items-center justify-center border border-gray-200">
                            <img
                                 src="{{ !empty($item['image']) ? asset('img/products/' . $item['image']) : asset('img/no-image.png') }}"
                                 alt="{{ $item['name'] ?? 'Product image' }}"
                                class="object-contain max-h-16"
                            >
                        </div>

                        {{-- Product name & variation text --}}
                        <div class="flex-1">
                            <div class="text-gray-800 line-clamp-2">
                                {{ $item['name'] ?? 'Unknown Product' }}
                            </div>
                            <div class="text-xs text-gray-400 mt-1">
                                Variations:
                                <span class="text-gray-500">
                                    {{ $item['variation'] ?? 'Default' }}
                                </span>
                            </div>
                        </div>

                        {{-- Unit price (old + new) --}}
                        <div class="w-32 text-right mr-6">
                            @if(isset($item['old_price']))
                                <div class="text-xs text-gray-400 line-through">
                                    ₱{{ number_format($item['old_price'], 2) }}
                                </div>
                            @endif
                            <div class="text-sm text-gray-800">
                                ₱{{ number_format($price, 2) }}
                            </div>
                        </div>

                        {{-- Quantity stepper --}}
                        <div class="w-32 flex justify-center mr-6">
                            <form action="{{ route('cart.update') }}" method="POST" class="flex items-center">
                                @csrf
                                {{-- minus --}}
                                <button
                                    type="button"
                                    onclick="this.nextElementSibling.stepDown(); this.form.submit();"
                                    class="border border-gray-300 w-7 h-7 flex items-center justify-center text-gray-500"
                                >−</button>

                                {{-- number input --}}
                                <input
                                    type="number"
                                    name="quantities[{{ $id }}]"
                                    value="{{ $quantity }}"
                                    min="1"
                                    class="border-t border-b border-gray-300 w-12 h-7 text-center text-xs"
                                >

                                {{-- plus --}}
                                <button
                                    type="button"
                                    onclick="this.previousElementSibling.stepUp(); this.form.submit();"
                                    class="border border-gray-300 w-7 h-7 flex items-center justify-center text-gray-500"
                                >+</button>
                            </form>
                        </div>

                        {{-- Item total (right side orange price) & actions --}}
                        <div class="w-32 text-right">
                            <div class="text-sm text-orange-500">
                                ₱{{ number_format($total, 2) }}
                            </div>

                            <div class="mt-2 text-xs">
                                <form action="{{ route('cart.remove', $id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-500 hover:text-red-500">
                                        Delete
                                    </button>
                                </form>
                                <span class="text-gray-300 mx-1">|</span>
                                <button class="text-orange-500 hover:underline" type="button">
                                    Find Similar
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach

                    {{-- VOUCHER ROWS (just visual like screenshot) --}}
                <div class="mt-3 bg-white border border-gray-200 rounded text-xs text-gray-600">
                    <div class="px-4 py-3 border-b flex items-center">
                        <span class="mr-2 text-orange-500">🏷</span>
                        <span>Add shop voucher code</span>
                    </div>
                    <div class="px-4 py-3 flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="mr-2 text-orange-500">🏷</span>
                            <span>Platform Voucher</span>
                        </div>
                        <a href="#" class="text-orange-500 font-semibold">Select or enter code</a>
                    </div>
                </div>

            </div>

            {{-- BOTTOM BAR: select all + total + checkout --}}
            @php
                $itemLabel = $totalItems === 1 ? 'item' : 'items';
            @endphp

            <div class="fixed md:static bottom-0 left-0 right-0 bg-white border-t border-gray-200 mt-4">
                <div class="container mx-auto px-4 py-3 flex items-center justify-between text-sm">

                    <div class="flex items-center gap-3">
                        <label class="flex items-center gap-1">
                            <input
                                type="checkbox"
                                class="form-checkbox"
                                id="select-all"
                                checked
                            >
                            <span>Select All ({{ $totalItems }})</span>
                        </label>
                        <button class="text-gray-500 hover:text-red-500">Delete</button>
                        <button class="text-gray-500 hover:text-gray-700">
                            Remove inactive products
                        </button>
                        <button class="text-orange-500 hover:underline">
                            Move to My Likes
                        </button>
                    </div>

                   <div class="flex items-center gap-4">
                        <div class="text-right">
                            <div class="text-xs text-gray-500">
                                Total (<span id="selected-count">{{ $totalItems }}</span> items):
                            </div>
                            <div class="text-xl font-semibold text-orange-500" id="selected-total">
                                ₱{{ number_format($grandTotal, 2) }}
                            </div>
                        </div>

                        <a
                            href="{{ route('checkout') }}"
                            class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-2 rounded"
                        >
                            Check Out
                        </a>
                    </div>
                </div>
            </div>

        @else
            <p class="text-gray-600">Your cart is empty.</p>
        @endif
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
    const checkboxes   = document.querySelectorAll('.item-checkbox');
    const countElement = document.getElementById('selected-count');
    const totalElement = document.getElementById('selected-total');
    const selectAll    = document.getElementById('select-all');

    function recalcTotals() {
        let totalItems = 0;
        let totalPrice = 0;

        checkboxes.forEach(cb => {
            if (cb.checked) {
                const qty   = parseInt(cb.dataset.qty   || '0', 10);
                const total = parseFloat(cb.dataset.total || '0');

                totalItems += qty;
                totalPrice += total;
            }
        });

        countElement.textContent = totalItems;
        totalElement.textContent = '₱' + totalPrice.toFixed(2);

        // keep "Select All" in sync with item checkboxes
        if (selectAll) {
            let allChecked = true;
            checkboxes.forEach(cb => {
                if (!cb.checked) {
                    allChecked = false;
                }
            });
            selectAll.checked = allChecked && checkboxes.length > 0;
        }
    }

    // when Select All changes, toggle all items
    if (selectAll) {
        selectAll.addEventListener('change', function () {
            const checked = this.checked;
            checkboxes.forEach(cb => {
                cb.checked = checked;
            });
            recalcTotals();
        });
    }

    // recalc whenever an item checkbox is toggled
    checkboxes.forEach(cb => {
        cb.addEventListener('change', recalcTotals);
    });

    // initial calculation
    recalcTotals();
});
    </script>

</x-app-layout>
