<x-app-layout>
    <div class="container mx-auto px-4 py-8 text-sm">
        <h1 class="text-2xl font-bold mb-6 text-primary">Checkout</h1>

        @php
            $grandTotal  = 0;
            $totalItems  = 0;
        @endphp

        @if(!empty($cart) && count($cart) > 0)

            {{-- compute cart totals --}}
            @foreach($cart as $id => $item)
                @php
                    $price     = isset($item['price']) ? floatval($item['price']) : 0;
                    $quantity  = $item['quantity'] ?? 1;
                    $lineTotal = $price * $quantity;
                    $grandTotal += $lineTotal;
                    $totalItems += $quantity;
                @endphp
            @endforeach

            @php
                // You can replace these with real logic later
                $merchSubtotal       = $grandTotal;
                $productProtection   = 0;   // e.g. ₱10
                $shippingSubtotal    = 0;   // e.g. ₱223
                $totalPayment        = $merchSubtotal + $productProtection + $shippingSubtotal;
            @endphp

            {{-- ORDER ITEMS (simple list, keep or style as you like) --}}
            <div class="bg-white rounded border border-gray-200 mb-6">
                <div class="border-b px-4 py-3 flex text-xs text-gray-500">
                    <div class="flex-1">Product</div>
                    <div class="w-28 text-right">Unit Price</div>
                    <div class="w-20 text-center">Quantity</div>
                    <div class="w-28 text-right">Total</div>
                </div>

                @foreach($cart as $id => $item)
                    @php
                        $price     = isset($item['price']) ? floatval($item['price']) : 0;
                        $quantity  = $item['quantity'] ?? 1;
                        $lineTotal = $price * $quantity;
                    @endphp

                    <div class="px-4 py-4 border-t flex items-center text-xs md:text-sm">

                        {{-- image --}}
                        <div class="w-16 h-16 mr-3 flex items-center justify-center border border-gray-200">
                            <img
                                src="{{ !empty($item['image']) ? asset('img/products/' . $item['image']) : asset('img/no-image.png') }}"
                                alt="{{ $item['name'] ?? 'Product image' }}"
                                class="object-contain max-h-16"
                            >
                        </div>

                        {{-- name + variation --}}
                        <div class="flex-1">
                            <div class="text-gray-800">
                                {{ $item['name'] ?? 'Unknown Product' }}
                            </div>
                            <div class="text-xs text-gray-400 mt-1">
                                Variations:
                                <span class="text-gray-500">
                                    {{ $item['variation'] ?? 'Default' }}
                                </span>
                            </div>
                        </div>

                        {{-- unit price --}}
                        <div class="w-28 text-right text-gray-800">
                            ₱{{ number_format($price, 2) }}
                        </div>

                        {{-- qty --}}
                        <div class="w-20 text-center">
                            x{{ $quantity }}
                        </div>

                        {{-- line total --}}
                        <div class="w-28 text-right text-orange-500 font-semibold">
                            ₱{{ number_format($lineTotal, 2) }}
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- PAYMENT METHOD + SUMMARY (Shopee-style block) --}}
            <form action="{{ route('place.order') ?? '#' }}" method="POST" class="bg-white rounded border border-gray-200">
                <input type="hidden" name="payment_method" id="payment_method" value="cod">
                @csrf
                {{-- header --}}
                <div class="border-b px-4 py-3 text-sm font-semibold text-gray-800">
                    Payment Method
                </div>

                {{-- top tabs --}}
                <div class="px-4 pt-3 pb-2 flex flex-wrap gap-2 text-xs">
                    {{-- ShopeePay --}}
                    <button
                        type="button"
                        class="payment-tab px-3 py-1 border border-gray-200 rounded bg-gray-50 text-gray-500"
                        data-method="shopeepay"
                    >
                        ShopeePay Balance
                    </button>

                    {{-- SPayLater --}}
                    <button
                        type="button"
                        class="payment-tab px-3 py-1 border border-gray-200 rounded bg-gray-50 text-gray-500"
                        data-method="spaylater"
                    >
                        SPayLater
                    </button>

                    {{-- Cash on Delivery (default active) --}}
                    <button
                        type="button"
                        class="payment-tab px-3 py-1 border border-orange-500 rounded bg-orange-50 text-orange-600 font-semibold"
                        data-method="cod"
                    >
                        Cash on Delivery
                    </button>

                    {{-- Payment Center / E-Wallet --}}
                    <button
                        type="button"
                        class="payment-tab px-3 py-1 border border-gray-200 rounded bg-gray-50 text-gray-500"
                        data-method="ewallet"
                    >
                        Payment Center / E-Wallet
                    </button>

                    {{-- Linked Bank Account --}}
                    <button
                        type="button"
                        class="payment-tab px-3 py-1 border border-gray-200 rounded bg-gray-50 text-gray-500"
                        data-method="bank"
                    >
                        Linked Bank Account
                    </button>
                </div>


                {{-- middle: left method detail + right summary like your screenshot --}}
                <div class="px-4 py-4 border-t flex flex-col md:flex-row md:items-start md:justify-between text-xs md:text-sm">

                    {{-- left: method title + detail --}}
                    <div class="flex-1 mb-4 md:mb-0 md:mr-6">
                        <div id="payment_method_label" class="font-semibold text-gray-800">
                            Cash on Delivery
                        </div>
                        <div id="payment_method_desc" class="mt-1 text-gray-600">
                            Pay with cash when your order is delivered.
                        </div>
                    </div>

                    {{-- right: breakdown --}}
                    <div class="w-full md:w-64 text-gray-700 space-y-1">
                        <div class="flex justify-between">
                            <span>Merchandise Subtotal</span>
                            <span>₱{{ number_format($merchSubtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Product Protection Subtotal</span>
                            <span>
                                @if($productProtection > 0)
                                    ₱{{ number_format($productProtection, 2) }}
                                @else
                                    ₱0.00
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span>Shipping Subtotal</span>
                            <span>
                                @if($shippingSubtotal > 0)
                                    ₱{{ number_format($shippingSubtotal, 2) }}
                                @else
                                    ₱0.00
                                @endif
                            </span>
                        </div>

                        <div class="flex justify-between items-center pt-2 mt-2 border-t">
                            <span class="text-gray-600">Total Payment:</span>
                            <span class="text-lg font-semibold text-orange-500">
                                ₱{{ number_format($totalPayment, 2) }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- bottom bar with Place Order button, full width like Shopee --}}
                <div class="px-4 py-3 border-t flex flex-col md:flex-row md:items-center md:justify-end gap-3">
                    <div class="text-sm text-gray-700 md:mr-4">
                        Total Payment:
                        <span class="text-xl font-semibold text-orange-500 ml-1">
                            ₱{{ number_format($totalPayment, 2) }}
                        </span>
                    </div>

                    <button
                        type="submit"
                        class="w-full md:w-auto px-8 py-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded text-sm"
                    >
                        Place Order
                    </button>
                </div>
            </form>

        @else
            <p class="text-gray-600">Your cart is empty.</p>
        @endif
    </div>

    <script>
document.addEventListener('DOMContentLoaded', function () {
    const tabs       = document.querySelectorAll('.payment-tab');
    const methodInput = document.getElementById('payment_method');
    const labelEl    = document.getElementById('payment_method_label');
    const descEl     = document.getElementById('payment_method_desc');

    const activeClasses   = ['border-orange-500', 'bg-orange-50', 'text-orange-600', 'font-semibold'];
    const inactiveClasses = ['border-gray-200', 'bg-gray-50', 'text-gray-500'];

    function setDescription(method) {
        switch (method) {
            case 'shopeepay':
                labelEl.textContent = 'ShopeePay Balance';
                descEl.textContent  = 'Pay quickly using your ShopeePay wallet balance.';
                break;
            case 'spaylater':
                labelEl.textContent = 'SPayLater';
                descEl.textContent  = 'Buy now and pay later with SPayLater.';
                break;
            case 'ewallet':
                labelEl.textContent = 'Payment Center / E-Wallet';
                descEl.textContent  = 'Pay using supported payment centers or e-wallets.';
                break;
            case 'bank':
                labelEl.textContent = 'Linked Bank Account';
                descEl.textContent  = 'Pay directly from your linked bank account.';
                break;
            case 'cod':
            default:
                labelEl.textContent = 'Cash on Delivery';
                descEl.textContent  = 'Pay with cash when your order is delivered.';
                break;
        }
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', function () {
            const method = this.dataset.method || 'cod';

            // update hidden input
            methodInput.value = method;

            // update classes on all tabs
            tabs.forEach(t => {
                t.classList.remove(...activeClasses);
                t.classList.add(...inactiveClasses);
            });

            // set active style on clicked tab
            this.classList.remove(...inactiveClasses);
            this.classList.add(...activeClasses);

            // update text on the left
            setDescription(method);
        });
    });

    // ensure description matches default value on load
    setDescription(methodInput.value || 'cod');
});
</script>

</x-app-layout>
