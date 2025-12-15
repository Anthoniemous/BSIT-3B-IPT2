@extends('layouts.customer')

@section('title', 'Your Cart')
@section('page_heading', 'Your Cart')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
    <li class="breadcrumb-item text-dark" aria-current="page">Cart</li>
@endsection

@section('content')
<div class="container py-5">

    <h2 class="mb-4 text-center text-primary">Your Cart</h2>

    @if(!empty($lastOrder))
        <div class="mb-4 alert alert-info">
            Last order #{{ $lastOrder->order_id }} status:
            <span class="fw-semibold">{{ $lastOrder->order_status }}</span>

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

        <div class="table-responsive bg-white shadow-sm rounded-4 overflow-hidden">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:60px;" class="text-center">Select</th>
                        <th style="width:110px;">Image</th>
                        <th>Product</th>
                        <th style="width:140px;" class="text-end">Unit Price</th>
                        <th style="width:220px;" class="text-center">Quantity</th>
                        <th style="width:140px;" class="text-end">Total</th>
                        <th style="width:160px;" class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                @foreach(session('cart') as $id => $item)
                    @php
                        $price = isset($item['price']) ? floatval($item['price']) : 0;
                        $quantity = $item['quantity'] ?? 1;
                        $total = $price * $quantity;
                        $grandTotal += $total;
                        $totalItems += $quantity;
                    @endphp

                    <tr>
                        <!-- Checkbox (UNCHANGED CLASS + DATA ATTRS) -->
                        <td class="text-center">
                            <input type="checkbox"
                                   class="form-check-input item-checkbox"
                                   data-qty="{{ $quantity }}"
                                   data-total="{{ $total }}"
                                   checked>
                        </td>

                        <!-- Image -->
                        <td>
                            <img
                                src="{{ !empty($item['image']) ? asset('img/products/' . $item['image']) : asset('img/no-image.png') }}"
                                alt="{{ $item['name'] ?? 'Product image' }}"
                                class="img-fluid rounded-3"
                                style="width: 90px; height: 70px; object-fit: cover;"
                            >
                        </td>

                        <!-- Name + Variation -->
                        <td>
                            <div class="fw-semibold text-dark">
                                {{ $item['name'] ?? 'Unknown Product' }}
                            </div>
                            <div class="small text-muted mt-1">
                                Variations: <span class="text-secondary">{{ $item['variation'] ?? 'Default' }}</span>
                            </div>
                        </td>

                        <!-- Unit price -->
                        <td class="text-end">
                            @if(isset($item['old_price']))
                                <div class="small text-muted text-decoration-line-through">
                                    ₱{{ number_format($item['old_price'], 2) }}
                                </div>
                            @endif
                            <div class="text-dark">
                                ₱{{ number_format($price, 2) }}
                            </div>
                        </td>

                        <!-- Quantity stepper (FORM + onclick unchanged structure) -->
                        <td class="text-center">
                            <form action="{{ route('cart.update') }}" method="POST" class="d-inline-flex align-items-center">
                                @csrf

                                <button
                                    type="button"
                                    onclick="this.nextElementSibling.stepDown(); this.form.submit();"
                                    class="btn btn-outline-secondary btn-sm"
                                >−</button>

                                <input
                                    type="number"
                                    name="quantities[{{ $id }}]"
                                    value="{{ $quantity }}"
                                    min="1"
                                    class="form-control form-control-sm text-center mx-2"
                                    style="width: 70px;"
                                >

                                <button
                                    type="button"
                                    onclick="this.previousElementSibling.stepUp(); this.form.submit();"
                                    class="btn btn-outline-secondary btn-sm"
                                >+</button>
                            </form>
                        </td>

                        <!-- Item total -->
                        <td class="text-end fw-semibold" style="color:#f97316;">
                            ₱{{ number_format($total, 2) }}
                        </td>

                        <!-- Actions (delete form unchanged) -->
                        <td class="text-center">
                            <form action="{{ route('cart.remove', $id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{-- Voucher rows (visual only, kept) --}}
        <div class="mt-3 bg-white border rounded-4 overflow-hidden shadow-sm">
            <div class="px-4 py-3 border-bottom d-flex align-items-center">
                <span class="me-2" style="color:#f97316;">🏷</span>
                <span class="text-muted">Add shop voucher code</span>
            </div>
            <div class="px-4 py-3 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <span class="me-2" style="color:#f97316;">🏷</span>
                    <span class="text-muted">Platform Voucher</span>
                </div>
                <a href="#" class="fw-semibold" style="color:#f97316;">Select or enter code</a>
            </div>
        </div>

        {{-- Bottom bar: Select All + Total + Checkout (IDs unchanged for JS) --}}
        <div class="mt-4 bg-white border rounded-4 shadow-sm">
            <div class="p-3 d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">

                <div class="d-flex flex-wrap align-items-center gap-3">
                    <label class="d-flex align-items-center gap-2 mb-0">
                        <input type="checkbox" class="form-check-input" id="select-all" checked>
                        <span>Select All ({{ $totalItems }})</span>
                    </label>
                </div>

                <div class="d-flex align-items-center justify-content-between justify-content-lg-end gap-4">
                    <div class="text-end">
                        <div class="small text-muted">
                            Total (<span id="selected-count">{{ $totalItems }}</span> items):
                        </div>
                        <div class="fs-4 fw-semibold" style="color:#f97316;" id="selected-total">
                            ₱{{ number_format($grandTotal, 2) }}
                        </div>
                    </div>

                    <a href="{{ route('checkout') }}" class="btn btn-lg text-white fw-semibold px-4 rounded-3
                    btn-success"
                      >
                        Check Out
                    </a>
                </div>

            </div>
        </div>

    @else
        <p class="text-center text-muted">Your cart is empty.</p>
    @endif
</div>
@endsection

@push('scripts')
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
@endpush
