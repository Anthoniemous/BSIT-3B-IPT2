<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orders | Coffee Admin</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('admin/darkpan/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/darkpan/css/light.css') }}">
</head>
<body>

<div class="container-fluid position-relative d-flex p-0">

  <!-- Sidebar -->
  <div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-secondary navbar-dark">
      <a href="{{ route('admin.dashboard') }}" class="navbar-brand mx-4 mb-3">
        <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>Coffee Admin</h3>
      </a>

      <div class="navbar-nav w-100">
        <a href="{{ route('admin.dashboard') }}" class="nav-item nav-link">
          <i class="fa fa-tachometer-alt me-2"></i>Dashboard
        </a>
        <a href="{{ route('products.index') }}" class="nav-item nav-link">
          <i class="fa fa-shopping-bag me-2"></i>Products
        </a>
        <a href="{{ route('admin.orders.index') }}" class="nav-item nav-link active">
          <i class="fa fa-receipt me-2"></i>Orders
        </a>
        <a href="{{ route('admin.logs') }}" class="nav-item nav-link">
          <i class="fa fa-history me-2"></i>Activity Logs
        </a>
      </div>
    </nav>
  </div>

  <!-- Content -->
  <div class="content">
    <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
      <a href="#" class="sidebar-toggler flex-shrink-0"><i class="fa fa-bars"></i></a>

      <div class="navbar-nav align-items-center ms-auto">
        <div class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
            <i class="fa fa-user me-lg-2"></i>
            <span class="d-none d-lg-inline-flex">{{ Auth::user()->name ?? 'Admin' }}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
            <form action="{{ route('logout') }}" method="POST" style="margin:0;">
              @csrf
              <button class="dropdown-item" type="submit">Log Out</button>
            </form>
          </div>
        </div>
      </div>
    </nav>

    <div class="container-fluid pt-4 px-4">
      <div class="bg-secondary rounded p-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="mb-0">Orders</h5>
          <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-primary">Back</a>
        </div>

        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
          <table class="table text-start align-middle table-bordered table-hover mb-0">
            <thead>
              <tr>
                <th>Date</th>
                <th>#</th>
                <th>Customer</th>
                <th>Payment</th>
                <th>Total</th>
                <th>Status</th>
                <th style="width:260px;">Update</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($orders as $order)
                <tr>
                  <td>{{ optional($order->created_at)->format('M d, Y h:i A') }}</td>
                  <td>#{{ $order->id }}</td>
                  <td>{{ $order->user->name ?? $order->full_name ?? '—' }}</td>
                  <td>{{ $order->payment_method }}</td>
                  <td>₱ {{ number_format($order->total_amount, 2) }}</td>
                  <td>{{ strtoupper($order->status) }}</td>

                  <td>
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="d-flex gap-2">
                      @csrf
                      @method('PUT')
                      <select name="status" class="form-select form-select-sm">
                        <option value="pending" {{ $order->status=='pending'?'selected':'' }}>Pending</option>
                        <option value="processing" {{ $order->status=='processing'?'selected':'' }}>Processing</option>
                        <option value="paid" {{ $order->status=='paid'?'selected':'' }}>Paid</option>
                        <option value="delivered" {{ $order->status=='delivered'?'selected':'' }}>Delivered</option>
                        <option value="cancelled" {{ $order->status=='cancelled'?'selected':'' }}>Cancelled</option>
                      </select>
                      <button class="btn btn-sm btn-primary" type="submit">Save</button>
                    </form>
                  </td>

                  <td>
                    <a class="btn btn-sm btn-primary" href="{{ route('admin.orders.show', $order->id) }}">Detail</a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <div class="mt-3">
          {{ $orders->links() }}
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('admin/darkpan/js/main.js') }}"></script>
</body>
</html>
