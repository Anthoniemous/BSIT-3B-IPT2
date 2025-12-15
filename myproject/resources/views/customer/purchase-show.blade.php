<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Order #{{ $order->id }} | Coffee ' Sodoso</title>
  <style>
    body{font-family:Arial,sans-serif;background:#f6f6f6;margin:0}
    .nav{background:#fff;padding:15px 50px;box-shadow:0 2px 5px rgba(0,0,0,.08);display:flex;justify-content:space-between;align-items:center}
    .wrap{max-width:900px;margin:30px auto;padding:0 15px}
    .card{background:#fff;border-radius:8px;padding:18px;box-shadow:0 2px 5px rgba(0,0,0,.05);margin-bottom:15px}
    .row{display:flex;justify-content:space-between;gap:15px;flex-wrap:wrap}
    .muted{color:#777;font-size:13px}
    .item{display:flex;justify-content:space-between;border-bottom:1px solid #eee;padding:10px 0}
    .btn{padding:8px 12px;border-radius:6px;text-decoration:none;border:1px solid #ddd;color:#333;background:#fff}
  </style>
</head>
<body>

  <div class="nav">
    <div style="font-weight:bold;font-size:18px;">Coffee ' Sodoso ☕ | Order #{{ $order->id }}</div>
    <a class="btn" href="{{ route('customer.purchases') }}">Back</a>
  </div>

  <div class="wrap">
    <div class="card">
      <div class="row">
        <div>
          <div style="font-weight:bold;">Delivery</div>
          <div class="muted">{{ $order->full_name }}</div>
          <div class="muted">{{ $order->phone }}</div>
          <div class="muted">{{ $order->address }}</div>
        </div>
        <div>
          <div style="font-weight:bold;">Order Info</div>
          <div class="muted">Payment: {{ $order->payment_method }}</div>
          <div class="muted">Status: {{ strtoupper($order->status ?? 'pending') }}</div>
          <div class="muted">Date: {{ optional($order->created_at)->format('M d, Y h:i A') }}</div>
        </div>
      </div>
    </div>

    <div class="card">
      <div style="font-weight:bold;margin-bottom:10px;">Items</div>

      @foreach($order->items as $it)
        <div class="item">
          <div>
            <div style="font-weight:bold;">{{ $it->product?->name ?? 'Product deleted' }}</div>
            <div class="muted">Qty: {{ $it->quantity }}</div>
          </div>
          <div style="text-align:right;">
            <div>₱ {{ number_format($it->price, 2) }}</div>
            <div class="muted">Line: ₱ {{ number_format($it->total, 2) }}</div>
          </div>
        </div>
      @endforeach

      <div style="display:flex;justify-content:space-between;margin-top:12px;font-weight:bold;">
        <span>Total</span>
        <span>₱ {{ number_format($order->total_amount, 2) }}</span>
      </div>
    </div>
  </div>

</body>
</html>
