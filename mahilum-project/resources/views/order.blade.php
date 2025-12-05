<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>checkout</title>
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
</head>
<body>
    

<div class="checkout-container">
    <h1 class="checkout-title">☕ Brew Your Order</h1>

    <div class="checkout-card">
        <h3 class="section-title">Coffee Order Details</h3>

        <form method="POST" action="{{ route('orders.store') }}">
            @csrf

            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" placeholder="Who’s the coffee for?" required>
            </div>

            <div class="form-group">
                <label for="address">Pickup / Delivery Spot</label>
                <textarea id="address" name="address" rows="3" placeholder="Where should we bring your brew?" required></textarea>
            </div>

            <div class="form-group">
                <label for="contact">Contact Number</label>
                <input type="text" id="contact" name="contact" placeholder="09XXXXXXXXX (so we can reach you!)" required>
            </div>

            <div class="form-group">
                <label for="payment_method">How would you like to pay?</label>
                <select id="payment_method" name="payment_method" required>
                    <option value="">Choose your payment option</option>
                    <option value="cod">Cash upon delivery ☕</option>
                    <option value="gcash">GCash (Quick & Easy 💳)</option>
                </select>
            </div>

               <!-- Hidden inputs for selected cart items -->
            @if(isset($cartItems) && $cartItems->count() > 0)
                @foreach($cartItems as $item)
                    <input type="hidden" name="selected_items[]" value="{{ $item->cart_id }}">
                @endforeach
            @endif


            <div class="form-actions">
                <a href="{{ route('cart.index') }}" class="btn cancel">← Back to Coffee Cart</a>
                <button type="submit" class="btn submit">Confirm My Brew</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>