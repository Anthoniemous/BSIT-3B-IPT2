@extends('layouts.customer')

@section('title', 'Checkout')
@section('page_heading', 'Checkout')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
    <li class="breadcrumb-item text-dark" aria-current="page">Checkout</li>
@endsection

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center text-primary">Checkout</h2>

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
            $merchSubtotal       = $grandTotal;
            $productProtection   = 0;
            $shippingSubtotal    = 0;
            $totalPayment        = $merchSubtotal + $productProtection + $shippingSubtotal;
        @endphp

        {{-- ORDER ITEMS --}}
        <div class="bg-white border rounded-4 shadow-sm mb-4 overflow-hidden">
            <div class="border-bottom px-4 py-3 d-flex small text-muted">
                <div class="flex-grow-1">Product</div>
                <div style="width: 120px;" class="text-end">Unit Price</div>
                <div style="width: 90px;" class="text-center">Qty</div>
                <div style="width: 120px;" class="text-end">Total</div>
            </div>

            @foreach($cart as $id => $item)
                @php
                    $price     = isset($item['price']) ? floatval($item['price']) : 0;
                    $quantity  = $item['quantity'] ?? 1;
                    $lineTotal = $price * $quantity;
                @endphp

                <div class="px-4 py-3 border-top d-flex align-items-center">

                    {{-- image --}}
                    <div class="me-3 border rounded-3 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                        <img
                            src="{{ !empty($item['image']) ? asset('img/products/' . $item['image']) : asset('img/no-image.png') }}"
                            alt="{{ $item['name'] ?? 'Product image' }}"
                            class="img-fluid"
                            style="max-height: 60px; object-fit: contain;"
                        >
                    </div>

                    {{-- name + variation --}}
                    <div class="flex-grow-1">
                        <div class="text-dark fw-semibold">
                            {{ $item['name'] ?? 'Unknown Product' }}
                        </div>
                        <div class="small text-muted mt-1">
                            Variations:
                            <span class="text-secondary">{{ $item['variation'] ?? 'Default' }}</span>
                        </div>
                    </div>

                    {{-- unit price --}}
                    <div style="width: 120px;" class="text-end text-dark">
                        ₱{{ number_format($price, 2) }}
                    </div>

                    {{-- qty --}}
                    <div style="width: 90px;" class="text-center">
                        x{{ $quantity }}
                    </div>

                    {{-- line total --}}
                    <div style="width: 120px;" class="text-end fw-semibold" style="color:#f97316;">
                        <span style="color:#f97316;">₱{{ number_format($lineTotal, 2) }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- PAYMENT METHOD + SUMMARY --}}
        <form action="{{ route('place.order') ?? '#' }}" method="POST" class="bg-white border rounded-4 shadow-sm overflow-hidden">
            <input type="hidden" name="payment_method" id="payment_method" value="cod">
            @csrf

            {{-- header --}}
            <div class="border-bottom px-4 py-3 fw-semibold text-dark">
                Payment Method

            {{-- tabs (KEEP .payment-tab + data-method for your JS) --}}
            <div class="px-4 pt-3 pb-2 d-flex flex-wrap gap-2"></div>
                <button type="button"
                        class="payment-tab px-3 py-2 border rounded small fw-semibold"
                        style="border-color:#f97316; background:#fff7ed; color:#f97316;"
                        data-method="cod">
                    Cash on Delivery
                </button>

                <button type="button"
                        class="payment-tab px-3 py-2 border border-secondary-subtle rounded bg-light text-secondary small"
                        data-method="bank">
                    Linked Bank Account
                </button>
            </div>

            {{-- middle: left method detail + right summary --}}
            <div class="px-4 py-4 border-top row g-4 align-items-start">
                {{-- left --}}
                <div class="col-12 col-md-7">
                    <div id="payment_method_label" class="fw-semibold text-dark">
                        Cash on Delivery
                    </div>
                    <div id="payment_method_desc" class="mt-1 text-muted">
                        Pay with cash when your order is delivered.
                    </div>
                </div>
                

                {{-- right breakdown --}}
                <div class="col-12 col-md-5 col-lg-4 ms-md-auto">
                    <div class="text-secondary small">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Merchandise Subtotal</span>
                            <span>₱{{ number_format($merchSubtotal, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Product Protection Subtotal</span>
                            <span>₱{{ number_format($productProtection, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping Subtotal</span>
                            <span>₱{{ number_format($shippingSubtotal, 2) }}</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                            <span class="text-muted">Total Payment:</span>
                            <span class="fs-5 fw-semibold" style="color:#f97316;">
                                ₱{{ number_format($totalPayment, 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- bottom bar --}}
            <div class="px-4 py-3 border-top d-flex flex-column flex-md-row align-items-md-center justify-content-md-end gap-3">
                <div class="text-dark">
                    Total Payment:
                    <span class="fs-4 fw-semibold ms-1" style="color:#f97316;">
                        ₱{{ number_format($totalPayment, 2) }}
                    </span>
                </div>

                <button type="submit"
                        class="btn text-white fw-semibold px-4 py-2 rounded-3 btn-success">
                    Place Order
                </button>
            </div>
        </div>
        </form>

    @else
        <p class="text-center text-muted">Your cart is empty.</p>
    @endif
</div>
@endsection

@push('scripts')
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
@endpush
