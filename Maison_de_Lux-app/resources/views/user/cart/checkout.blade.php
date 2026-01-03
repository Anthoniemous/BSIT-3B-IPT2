<x-app-layout>
    <link rel="stylesheet" href="{{ asset('assets/css/checkout.css') }}">

    <div class="checkout-container">
        <div class="mb-6">
            <a href="{{ route('cart') }}" class="back-link">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Cart
            </a>
        </div>

        @if(session('success'))
            <div class="p-3 mb-4 bg-green-500 text-white rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="p-3 mb-4 bg-red-500 text-white rounded">
                {{ $errors->first() }}
            </div>
        @endif

        <h1 class="checkout-title">Checkout</h1>

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf

            <!-- Shipping Information -->
            <div class="checkout-form">
                <div class="form-section">
                    <h3>Shipping Information</h3>

                    <div class="form-group">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" id="name" name="name" class="form-input" value="{{ old('name', Auth::user()->name) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-input" value="{{ old('email', Auth::user()->email) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" id="phone" name="phone" class="form-input" value="{{ old('phone') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="address" class="form-label">Address</label>
                        <textarea id="address" name="address" class="form-input" rows="3" required>{{ old('address') }}</textarea>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="form-section">
                    <h3>Payment Method</h3>
                    <div class="form-group">
                        <div class="payment-options" style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <label style="display: flex; align-items: center; color: var(--white);">
                                <input type="radio" name="payment_method" value="cash_on_delivery" style="margin-right: 0.5rem;">
                                Cash on Delivery
                            </label>
                            <label style="display: flex; align-items: center; color: var(--white);">
                                <input type="radio" name="payment_method" value="gcash" style="margin-right: 0.5rem;">
                                GCash
                            </label>
                            <label style="display: flex; align-items: center; color: var(--white);">
                                <input type="radio" name="payment_method" value="paymaya" style="margin-right: 0.5rem;">
                                PayMaya
                            </label>
                             <!-- GCash / PayMaya -->
                                <div id="ewallet-fields" class="form-section" style="display:none;">
                                    <h3>E-Wallet Information</h3>

                                    <div class="form-group">
                                        <label class="form-label">Mobile Number</label>
                                        <input type="text"
                                            name="ewallet_number"
                                            class="form-input"
                                            placeholder="09XXXXXXXXX">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Reference No. (optional)</label>
                                        <input type="text"
                                            name="reference_no"
                                            class="form-input">
                                    </div>
                                </div>

                                <!-- Card Payment -->
                                <div id="card-fields" class="form-section" style="display:none;">
                                    <h3>Card Information</h3>

                                    <div class="form-group">
                                        <label class="form-label">Card Number</label>
                                        <input type="text"
                                            id="card_number"
                                            name="card_number"
                                            class="form-input"
                                            placeholder="XXXX XXXX XXXX XXXX">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Expiry Date</label>
                                        <input type="text"
                                            id="expiry_date"
                                            name="expiry_date"
                                            class="form-input"
                                            placeholder="MM/YY">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">CVV</label>
                                        <input type="text"
                                            id="cvv"
                                            name="cvv"
                                            class="form-input"
                                            placeholder="XXX">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="checkout-summary">
                    <h3 style="color: var(--gold); margin-bottom: 1rem;">Order Summary</h3>

                    @foreach($cartItems as $item)
                        <div class="summary-item">
                            <span>{{ $item->product->product_name }} (x{{ $item->quantity }})</span>
                            <span>₱{{ number_format($item->quantity * $item->product->price, 2) }}</span>
                        </div>
                    @endforeach

                    <div class="summary-item summary-total">
                        <span>Total</span>
                        <span>₱{{ number_format($total, 2) }}</span>
                    </div>

                    <!-- Hidden inputs for selected items -->
                    @foreach($selectedItems as $selectedItemId)
                        <input type="hidden" name="selected_items[]" value="{{ $selectedItemId }}">
                    @endforeach
                </div>

                <div style="text-align: center; margin-top: 1.5rem;">
                    <button type="submit" class="btn-place-order">Place Order</button>
                </div>
            </div>
        </form>
    </div>

            <script>
            document.addEventListener('DOMContentLoaded', function () {
            const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
            const ewalletFields = document.getElementById('ewallet-fields');
            const cardFields = document.getElementById('card-fields');

            function togglePaymentFields() {
                const selected = document.querySelector('input[name="payment_method"]:checked')?.value;

                // Hide all
                ewalletFields.style.display = 'none';
                cardFields.style.display = 'none';

                // Remove required attributes
                document.querySelector('[name="ewallet_number"]')?.removeAttribute('required');
                document.getElementById('card_number')?.removeAttribute('required');
                document.getElementById('expiry_date')?.removeAttribute('required');
                document.getElementById('cvv')?.removeAttribute('required');

                // Show based on selected payment method
                if (selected === 'gcash' || selected === 'paymaya') {
                    ewalletFields.style.display = 'block';
                    document.querySelector('[name="ewallet_number"]').setAttribute('required', 'required');
                }

                if (selected === 'card') {
                    cardFields.style.display = 'block';
                    document.getElementById('card_number').setAttribute('required', 'required');
                    document.getElementById('expiry_date').setAttribute('required', 'required');
                    document.getElementById('cvv').setAttribute('required', 'required');
                }
            }

            paymentMethods.forEach(method => {
                method.addEventListener('change', togglePaymentFields);
            });
        });
        </script>
</x-app-layout>
