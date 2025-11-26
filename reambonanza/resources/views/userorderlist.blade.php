<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Customer Orders - Green Glow Shampoo Shop</title>

  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700;900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/orderlist.css') }}">
</head>
<body class="bg-light">

 
  <!-- Header / Nav -->
  <header class="header mb-4 d-flex justify-content-between align-items-center px-4 py-3 bg-white shadow-sm">
    <!-- Left: Title -->
    <h1 class="m-0">Admin Dashboard</h1>

    <!-- Centered Buttons -->
    <div class="d-flex justify-content-center flex-grow-1">
      <a href="{{ route('admin.products.create') }}" class="btn btn-primary me-2">Add Product</a>
      <a href="{{ route('admin.orders') }}" class="btn btn-secondary">View All Orders</a>
    </div>

    <!-- Right: Logout -->
    <div class="logout">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-outline-danger">Logout</button>
      </form>
    </div>
  </header>

  <div class="container">

    {{-- ✅ Flash Messages --}}
    @if(session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger">
        {{ session('error') }}
      </div>
    @endif

    {{-- ✅ Orders Table --}}
    @if($orders->isEmpty())
      <p class="no-orders">You have no orders yet.</p>
    @else
      <div class="table-responsive table-container mb-4">
        <table class="table table-striped align-middle">
          <thead>
            <tr>
              <th>Order ID</th>
              <th>Name</th>
              <th>Address</th>
              <th>Contact</th>
              <th>Date</th>
              <th>Product</th>
              <th>Quantity</th>
              <th>Total</th>  
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $order)
              @foreach($order->items as $item)
              <tr>
                <td>{{ $order->order_id }}</td>
                <td>{{ $order->name }}</td>
                <td>{{ $order->address }}</td>
                <td>{{ $order->contact_number }}</td>
                <td>{{ $order->created_at->format('M d, Y') }}</td>
                <td>{{ $item->product->product_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->product->price * $item->quantity, 2) }}</td>
                <td>
                  <span class="status {{ strtolower($order->status) }}">
                    {{ ucfirst($order->status) }}
                  </span>
                </td>
              </tr>
              @endforeach
            @endforeach
          </tbody>
        </table>
      </div>
    @endif

    <div class="text-center">
      <a href="{{ route('dashboard') }}" class="btn btn-secondary">← Back to Dashboard</a>
    </div>

  </div>

</body>
</html>
