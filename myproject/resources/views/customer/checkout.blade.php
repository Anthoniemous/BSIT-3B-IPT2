<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout | Coffee ' Sodoso</title>
  <link rel="stylesheet" href="{{ asset('customer/cart.css') }}">
  <style>
    /* Specific styles for checkout */
    .checkout-container { max-width: 900px; margin: 40px auto; display: flex; gap: 30px; }
    .checkout-left { flex: 2; }
    .checkout-right { flex: 1; background: #f9f9f9; padding: 20px; border-radius: 8px; height: fit-content; }
    
    .section-box { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
    .section-title { font-size: 18px; font-weight: bold; margin-bottom: 15px; border-bottom: 1px solid #030101ff; padding-bottom: 10px; }
    
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; margin-bottom: 5px; font-weight: 500; }
    .form-group input, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
    
    /* Payment Methods based on your image */
    .payment-options { display: flex; gap: 10px; flex-wrap: wrap; }
    .payment-radio { display: none; }
    .payment-label { 
        border: 1px solid #ddd; padding: 10px 20px; border-radius: 4px; cursor: pointer; transition: 0.2s; 
        font-weight: 500; text-align: center; flex: 1;
    }
    .payment-radio:checked + .payment-label { border-color: #ff5722; color: #ff5722; background: #fff5f2; }
    
    .order-item { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px; }
    .total-row { display: flex; justify-content: space-between; margin-top: 15px; font-weight: bold; font-size: 18px; color: #ff5722; }
    
    .btn-place-order { width: 100%; padding: 15px; background: #ff5722; color: white; border: none; font-size: 16px; font-weight: bold; cursor: pointer; border-radius: 4px; margin-top: 20px; }
    .btn-place-order:hover { background: #e64a19; }
  </style>
</head>
<body>

  <nav class="navbar" style="padding: 15px 50px; background:white; box-shadow: 0 2px 5px rgba(0,0,0,0.1); display:flex; justify-content:space-between; align-items:center;">
    <div class="logo" style="font-weight:bold; font-size:20px;">Coffee ' Sodoso ☕ | Checkout</div>
    <a href="{{ route('cart.index') }}" style="text-decoration:none; color:#333;">Back to Cart</a>
  </nav>

  <form action="{{ route('checkout.placeOrder') }}" method="POST" class="checkout-container">
    @csrf
    
    <div class="checkout-left">
      
      <div class="section-box">
     <div class="section-title" style="color: black;">📍 Delivery Address</div>
        <div class="form-group" style="color: black;">
            <label>Full Name</label>
            <input type="text" name="full_name" value="{{ Auth::user()->name }}" required>
        </div>
        <div class="form-group" style="color: black;">
            <label>Phone Number</label>
            <input type="text" name="phone" placeholder="09xxxxxxxxx" required>
        </div>
        <div class="form-group" style="color: black;">
            <label>Address</label>
            <textarea name="address" rows="2" required>{{ Auth::user()->address }}</textarea>
        </div>
      </div>

      <div class="section-box">
        <div class="section-title" style="color: black;">💳 Payment Method</div>
        <div class="payment-options">
            <input type="radio" name="payment_method" id="cod" value="COD" class="payment-radio" checked>
            <label for="cod" class="payment-label">Cash on Delivery</label>
            
            <input type="radio" name="payment_method" id="ewallet" value="E-Wallet" class="payment-radio">
            <label for="ewallet" class="payment-label" >Payment Center / E-Wallet</label>
            
            <input type="radio" name="payment_method" id="bank" value="Online Banking" class="payment-radio">
            <label for="bank" class="payment-label">Online Banking</label>
        </div>
        
        <div style="margin-top: 15px; color: #666; font-size: 14px; background: #fdfdfdff; padding: 10px;">
            Cash on Delivery is available for this order.
        </div>
      </div>

      <div class="section-box">
        <div class="section-title" style="color: black;">📦 Order Review</div>
        @foreach($cartItems as $item)
        <div style="display: flex; gap: 15px; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
            <img src="{{ $item->product->image ? asset('storage/products/'.$item->product->image) : 'https://via.placeholder.com/60' }}" 
                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
            <div>
                <h4 style="margin: 0 0 5px 0;">{{ $item->product->name }}</h4>
                <p style="margin: 0; color: #888;">Qty: {{ $item->quantity }}</p>
                <p style="margin: 0; color: #ff5722;">₱ {{ number_format($item->product->price, 2) }}</p>
            </div>
        </div>
        @endforeach
      </div>

    </div>

    <div class="checkout-right">
        <div class="section-title" style="color: black;">Order Summary</div>
        
        @php $total = 0; @endphp
        @foreach($cartItems as $item)
            @php $total += $item->product->price * $item->quantity; @endphp
            <div class="order-item">
                <span>{{ $item->product->name }} x {{ $item->quantity }}</span>
                <span>₱ {{ number_format($item->product->price * $item->quantity, 2) }}</span>
            </div>
        @endforeach
        
        <div class="order-item">
            <span>Shipping Fee</span>
            <span>₱ 0.00</span>
        </div>

        <div class="order-item">
            <span>Voucher</span>
            <span>-</span>
        </div>

        <hr>

        <div class="total-row">
            <span>Total Payment</span>
            <span>₱ {{ number_format($total, 2) }}</span>
        </div>

        <button type="submit" class="btn-place-order">Place Order</button>
    </div>

  </form>

</body>
</html>