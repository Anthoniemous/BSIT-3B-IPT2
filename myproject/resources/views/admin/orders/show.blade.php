<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order #{{ $order->id }} | Coffee Admin</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('admin/darkpan/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/darkpan/css/light.css') }}">
</head>
<body>

<div class="container-fluid p-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Order #{{ $order->id }}</h4>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">Back to Orders</a>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="row g-4">
    <div class="col-lg-6">
      <div class="bg-secondary rounded p-4">
        <h6>Customer</h6>
        <div>{{ $order->user->name ?? $order->full_name ?? '—' }}</div>
        <div>{{ $order->phone ?? '—' }}</div>
        <div>{{ $order->address ?? '—' }}</div>

        <hr>
        <h6>Order Info</h6>
        <div>Payment: {{ $order->payment_method }}</div>
        <div>Status: {{ strtoupper($order->status) }}</div>
        <div>Total: ₱ {{ number_format($order->total_amount, 2) }}</div>

        <hr>
        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="d-flex gap-2">
          @csrf
          @method('PUT')
          <select name="status" class="form-select">
            <option value="pending" {{ $order->status=='pending'?'selected':'' }}>Pending</option>
            <option value="processing" {{ $order->status=='processing'?'selected':'' }}>Processing</option>
            <option value="paid" {{ $order->status=='paid'?'selected':'' }}>Paid</option>
            <option value="delivered" {{ $order->status=='delivered'?'selected':'' }}>Delivered</option>
            <option value="cancelled" {{ $order->status=='cancelled'?'selected':'' }}>Cancelled</option>
          </select>
          <button class="btn btn-primary" type="submit">Update</button>
        </form>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="bg-secondary rounded p-4">
        <h6>Items</h6>

        <div class="table-responsive">
          <table class="table table-bordered table-hover mb-0">
            <thead>
              <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              @foreach($order->items as $it)
                <tr>
                  <td>{{ $it->product?->name ?? 'Product deleted' }}</td>
                  <td>{{ $it->quantity }}</td>
                  <td>₱ {{ number_format($it->price, 2) }}</td>
                  <td>₱ {{ number_format($it->total, 2) }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
