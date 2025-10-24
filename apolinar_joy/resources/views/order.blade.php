<x-app-layout>
<link rel="stylesheet" href="{{ asset('css/checkout.css') }}">

<div class="checkout-container">
    <h1 class="checkout-title">🧾 PAYMENTS </h1>

    <div class="checkout-card">
        <h3 class="section-title">Order Information</h3>

        <form method="POST" action="{{ route('orders.store') }}">
            @csrf

            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your full name" required>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <textarea id="address" name="address" rows="3" placeholder="Enter your delivery address" required></textarea>
            </div>

            <div class="form-group">
                <label for="contact">Contact Number</label>
                <input type="text" id="contact" name="contact" placeholder="09XXXXXXXXX" required>
            </div>

            <div class="form-group">
                <label for="payment_method">Payment Method</label>
                <select id="payment_method" name="payment_method" required>
                    <option value="">Select Payment Option</option>
                    <option value="cod">Cash on Delivery</option>
                    <option value="gcash">GCash</option>
                </select>
            </div>

            <div class="form-actions">
                <a href="{{ route('cart.index') }}" class="btn cancel">← Back to Cart</a>
                <button type="submit" class="btn submit">Place Order</button>
            </div>
        </form>
    </div>
</div>
</x-app-layout>
