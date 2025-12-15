@extends('layouts.customer')

@section('title', 'COD Shipping Details')
@section('page_heading', 'Cash on Delivery')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('checkout') }}">Checkout</a></li>
    <li class="breadcrumb-item text-dark" aria-current="page">COD Details</li>
@endsection

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center text-primary">Cash on Delivery - Shipping Details</h2>

    @php
        $grandTotal = $pending['total'] ?? 0;
        $totalItems = $pending['items'] ?? 0;
    @endphp

    <div class="row g-4">
        {{-- LEFT: INFO FORM --}}
        <div class="col-12 col-lg-8">
            <div class="bg-white border rounded-4 shadow-sm p-4">
                <h5 class="fw-semibold text-dark mb-4">Shipping Information</h5>

                <form action="{{ route('cod.confirm') }}" method="POST">
                    @csrf

                    <div class="row g-3">
                        {{-- Full Name --}}
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-muted">Full Name</label>
                            <input type="text"
                                   name="full_name"
                                   class="form-control @error('full_name') is-invalid @enderror"
                                   value="{{ old('full_name') }}"
                                   required>
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Phone Number --}}
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-muted">Phone Number</label>
                            <input type="text"
                                   name="phone"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone') }}"
                                   required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Address --}}
                        <div class="col-12">
                            <label class="form-label small text-muted">Address</label>
                            <textarea name="address"
                                      rows="3"
                                      class="form-control @error('address') is-invalid @enderror"
                                      required>{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Notes --}}
                        <div class="col-12">
                            <label class="form-label small text-muted">Notes (optional)</label>
                            <textarea name="notes"
                                      rows="2"
                                      class="form-control @error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit"
                                    class="btn text-white fw-semibold px-4 py-2 rounded-3 btn-success">
                                Confirm Order
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- RIGHT: ORDER SUMMARY --}}
        <div class="col-12 col-lg-4">
            <div class="bg-white border rounded-4 shadow-sm p-4">
                <h5 class="fw-semibold text-dark mb-4">Order Summary</h5>

                <div class="mb-3">
                    @foreach($cart as $item)
                        @php
                            $price     = isset($item['price']) ? floatval($item['price']) : 0;
                            $quantity  = $item['quantity'] ?? 1;
                            $lineTotal = $price * $quantity;
                        @endphp

                        <div class="d-flex justify-content-between small text-secondary py-1">
                            <div class="pe-2">
                                {{ $item['name'] ?? 'Product' }}
                                <span class="text-muted">x{{ $quantity }}</span>
                            </div>
                            <div>₱{{ number_format($lineTotal, 2) }}</div>
                        </div>
                    @endforeach
                </div>

                <div class="border-top pt-3">
                    <div class="d-flex justify-content-between small text-secondary mb-1">
                        <span>Items ({{ $totalItems }})</span>
                        <span>₱{{ number_format($grandTotal, 2) }}</span>
                    </div>

                    <div class="d-flex justify-content-between small text-secondary mb-2">
                        <span>Shipping Fee</span>
                        <span>Free</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                        <span class="text-muted">Total Payment:</span>
                        <span class="fs-5 fw-semibold" style="color:#f97316;">
                            ₱{{ number_format($grandTotal, 2) }}
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
