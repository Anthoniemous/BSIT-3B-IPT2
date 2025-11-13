<x-app-layout>
<link rel="stylesheet" href="{{ asset('css/checkout.css') }}">

<div class="checkout-container">
    <h1 class="checkout-title">💨 Vape Your Order</h1>

    <div class="checkout-card">
        <h3 class="section-title">Vape Order Details</h3>

        <form method="POST" action="{{ route('orders.store') }}">
            @csrf

            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" placeholder="Who’s vaping today?" required>
            </div>

            <div class="form-group">
                <label for="address">Pickup / Delivery Address</label>
                <textarea id="address" name="address" rows="3" placeholder="Where should we send your vape goodies?" required></textarea>
            </div>

            <div class="form-group">
                <label for="contact">Contact Number</label>
                <input type="text" id="contact" name="contact" placeholder="09XXXXXXXXX (so we can reach you!)" required>
            </div>

            <div class="form-group">
                <label for="payment_method">How would you like to pay?</label>
                <select id="payment_method" name="payment_method" required>
                    <option value="">Choose your payment option</option>
                    <option value="cod">Cash upon delivery 💨</option>
                    <option value="gcash">GCash (Quick & Easy 💳)</option>
                </select>
            </div>

            <div class="form-actions">
                <a href="{{ route('cart.index') }}" class="btn cancel">← Back to Vape Cart</a>
                <button type="submit" class="btn submit">Confirm My Vape 💨</button>
            </div>
        </form>
    </div>
</div>
</x-app-layout>
