@extends('layouts.customer')

@section('title', 'Bank Transfer - Instructions')
@section('page_heading', 'Bank Transfer')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('checkout') }}">Checkout</a></li>
    <li class="breadcrumb-item text-dark" aria-current="page">Bank Transfer</li>
@endsection

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center text-primary">Bank Transfer - Payment Instructions</h2>

    @php
        $grandTotal = $pending['total'] ?? 0;
        $totalItems = $pending['items'] ?? 0;
    @endphp

    <div class="row g-4">
        {{-- LEFT --}}
        <div class="col-12 col-lg-7">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Send Payment To</h5>

                    {{-- Replace these with your real bank details --}}
                    <div class="p-3 bg-light rounded-3">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Bank</span>
                            <span class="fw-semibold">BDO</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Account Name</span>
                            <span class="fw-semibold">Tea House Shop</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Account Number</span>
                            <span class="fw-semibold">1234-5678-9012</span>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h6 class="fw-bold mb-2">How to pay</h6>
                    <ol class="small text-muted mb-0">
                        <li>Transfer the exact amount shown in the summary.</li>
                        <li>Keep your receipt / reference number.</li>
                        <li>Fill out the form below and submit.</li>
                    </ol>
                </div>
            </div>
        </div>

        {{-- RIGHT --}}
        <div class="col-12 col-lg-5">
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Order Summary</h5>

                    <div class="small text-muted mb-2">
                        Items ({{ $totalItems }})
                    </div>

                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Total Payment</span>
                        <span class="fw-bold text-primary">₱{{ number_format($grandTotal, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Confirm Details</h5>

                    <form action="{{ route('bank.confirm') }}" method="POST" class="row g-3">
                        @csrf

                        <div class="col-12">
                            <label class="form-label small">Full Name</label>
                            <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}" required>
                            @error('full_name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label small">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                            @error('phone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label small">Reference No.</label>
                            <input type="text" name="reference_no" class="form-control" value="{{ old('reference_no') }}" required>
                            @error('reference_no') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label small">Shipping Address</label>
                            <textarea name="address" rows="3" class="form-control" required>{{ old('address') }}</textarea>
                            @error('address') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label small">Notes (optional)</label>
                            <input type="text" name="notes" class="form-control" value="{{ old('notes') }}">
                            @error('notes') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <button class="btn btn-primary w-100 rounded-pill py-2">
                                Submit Bank Transfer Confirmation
                            </button>
                        </div>

                        <div class="col-12">
                            <div class="small text-muted text-center">
                                Status will remain <b>Pending</b> until verified.
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
