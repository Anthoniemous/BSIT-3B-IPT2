<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | Coffee Shop</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<!-- Owl + TempusDominus (needed by main.js) -->
<link href="https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/assets/owl.carousel.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/tempusdominus-bootstrap-4@5.39.0/build/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('admin/darkpan/css/light.css') }}">


<!-- DarkPan LAST -->
<link rel="stylesheet" href="{{ asset('admin/darkpan/css/style.css') }}">


</head>

<body>
<div class="container-fluid position-relative d-flex p-0">

  <!-- Spinner (supported by main.js) -->
  <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status"></div>
  </div>

  <!-- Sidebar -->
  <div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-secondary navbar-dark">
      <a href="{{ route('admin.dashboard') }}" class="navbar-brand mx-4 mb-3">
        <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>Coffee Admin</h3>
      </a>

      <div class="navbar-nav w-100">
        <a href="{{ route('admin.dashboard') }}" class="nav-item nav-link active">
          <i class="fa fa-tachometer-alt me-2"></i>Dashboard
        </a>

        <a href="{{ route('products.index') }}" class="nav-item nav-link">
          <i class="fa fa-shopping-bag me-2"></i>Products
        </a>

        <a href="{{ route('admin.orders.index') }}" class="nav-item nav-link">
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

    <!-- Top Navbar -->
    <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
      <a href="#" class="sidebar-toggler flex-shrink-0">
        <i class="fa fa-bars"></i>
      </a>

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
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
    </div>

    <!-- KPI CARDS -->
    <div class="container-fluid pt-4 px-4">
      <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
          <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-receipt fa-3x text-primary"></i>
            <div class="ms-3">
              <p class="mb-2">Total Orders</p>
              <h6 class="mb-0">{{ $totalOrders }}</h6>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-xl-3">
          <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-coins fa-3x text-primary"></i>
            <div class="ms-3">
              <p class="mb-2">Total Sales</p>
              <h6 class="mb-0">₱ {{ number_format($totalSales, 2) }}</h6>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-xl-3">
          <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-times-circle fa-3x text-primary"></i>
            <div class="ms-3">
              <p class="mb-2">Cancelled Products</p>
              <h6 class="mb-0">{{ $cancelledProducts }}</h6>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-xl-3">
          <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-chart-line fa-3x text-primary"></i>
            <div class="ms-3">
              <p class="mb-2">Today Sales</p>
              <h6 class="mb-0">₱ {{ number_format($todaySales, 2) }}</h6>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Charts -->
<div class="container-fluid pt-4 px-4">
  <div class="row g-4">

    <!-- Line Chart: Total Sales -->
    <div class="col-sm-12 col-xl-8">
      <div class="bg-secondary rounded p-4">
        <h6 class="mb-3">Total Sales (per day)</h6>
        <canvas id="totalSalesLine" height="110"></canvas>
      </div>
    </div>

    <!-- Doughnut Chart: Order Status -->
    <div class="col-sm-12 col-xl-4">
      <div class="bg-secondary rounded p-4">
        <h6 class="mb-3">Order Status</h6>
        <canvas id="orderStatusDoughnut" height="220"></canvas>
      </div>
    </div>

  </div>
</div>

    

    <!-- Recent Orders + Update Status -->
    <div class="container-fluid pt-4 px-4">
      <div class="bg-secondary text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
          <h6 class="mb-0">Recent Orders</h6>
          <a href="{{ route('admin.orders.index') }}">Show All</a>
        </div>

        <div class="table-responsive">
          <table class="table text-start align-middle table-bordered table-hover mb-0">
            <thead>
              <tr class="text-white">
                <th>Date</th>
                <th>Order #</th>
                <th>Customer</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Update</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($recentOrders as $order)
                <tr>
                  <td>{{ optional($order->created_at)->format('M d, Y h:i A') }}</td>
                  <td>#{{ $order->id }}</td>
                  <td>{{ $order->user->name ?? $order->full_name ?? '—' }}</td>
                  <td>₱ {{ number_format($order->total_amount, 2) }}</td>
                  <td>{{ strtoupper($order->status) }}</td>
                  <td>
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="d-flex gap-2">
                      @csrf
                      @method('PUT')
                      <select name="status" class="form-select form-select-sm bg-dark border-0 text-white">
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
      </div>
    </div>

    <!-- Marketable / Non-marketable -->
    <div class="container-fluid pt-4 px-4">
      <div class="row g-4">

        <div class="col-sm-12 col-xl-6">
          <div class="bg-secondary text-start rounded p-4">
            <h6 class="mb-3">Most Marketable Products (Top 5)</h6>
            <ol class="mb-0">
              @foreach($topProducts as $p)
                <li>{{ $p->name }} — {{ $p->qty_sold }} sold</li>
              @endforeach
            </ol>
          </div>
        </div>

        <div class="col-sm-12 col-xl-6">
          <div class="bg-secondary text-start rounded p-4">
            <h6 class="mb-3">Non-marketable Products (Bottom 5)</h6>
            <ol class="mb-0">
              @foreach($lowProducts as $p)
                <li>{{ $p->name }} — {{ $p->qty_sold }} sold</li>
              @endforeach
            </ol>
          </div>
        </div>

      </div>
    </div>

    <!-- Your existing Product Grid (kept) -->
    <div class="table-responsive" style="margin-top : 80px; margin-left: 10px; margin-right: 10px;;">
  <table class="table table-bordered table-hover align-middle mb-0">
    <thead>
      <tr>
        <th style="min-width:90px;">Image</th>
        <th style="min-width:160px;">Name</th>
        <th style="min-width:120px;">Category</th>
        <th style="min-width:110px;">Price</th>
        <th style="min-width:240px;">Description</th>
        <th style="min-width:110px;">Featured</th>
      </tr>
    </thead>

    <tbody>
      @if(isset($products) && count($products) > 0)
        @foreach($products as $product)
          <tr>
            <td>
              <img
                src="{{ asset('storage/products/' . $product->image) }}"
                alt="{{ $product->name }}"
                style="width:70px;height:70px;object-fit:cover;border-radius:8px;"
              >
            </td>

            <td class="fw-semibold">{{ $product->name }}</td>

            <td>{{ $product->category->name ?? '-' }}</td>

            <td>₱ {{ number_format($product->price, 2) }}</td>

            <td style="max-width:360px;">
              <span class="text-truncate d-inline-block" style="max-width:360px;">
                {{ $product->description ?? '-' }}
              </span>
            </td>

            <td>
              <span class="badge {{ $product->featured ? 'bg-success' : 'bg-secondary' }}">
                {{ $product->featured ? 'Yes' : 'No' }}
              </span>
            </td>
          </tr>
        @endforeach
      @else
        <tr>
          <td colspan="6" class="text-center py-4">No products yet.</td>
        </tr>
      @endif
    </tbody>
  </table>
</div>


  </div><!-- content end -->
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- REQUIRED by main.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/owl.carousel.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tempusdominus-bootstrap-4@5.39.0/build/js/tempusdominus-bootstrap-4.min.js"></script>

<!-- ✅ Chart.js ONCE -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<!-- ✅ YOUR CHARTS (after Chart.js) -->
<script>
  const salesLabels = @json($salesLabels ?? []);
  const salesTotals = @json($salesTotals ?? []);
  const statusLabels = @json($statusLabels ?? []);
  const statusCounts = @json($statusCounts ?? []);

  // Line chart
  const lineEl = document.getElementById('totalSalesLine');
  if (lineEl && window.Chart) {
    new Chart(lineEl, {
      type: 'line',
      data: {
        labels: salesLabels,
        datasets: [{
          label: 'Total Sales',
          data: salesTotals,
          tension: 0.35,
          fill: false,
          borderWidth: 2,
          borderColor: '#0d6efd'
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { display: true } },
        scales: { y: { beginAtZero: true } }
      }
    });
  }

  // Doughnut chart
  const doughEl = document.getElementById('orderStatusDoughnut');
  if (doughEl && window.Chart) {
    new Chart(doughEl, {
      type: 'doughnut',
      data: {
        labels: statusLabels,
        datasets: [{
          data: statusCounts,
          borderWidth: 1,
          backgroundColor: ['#93c5fd','#a7f3d0','#fde68a','#fca5a5','#c4b5fd','#fbcfe8']
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { position: 'bottom' } }
      }
    });
  }
</script>

<!-- DarkPan main.js LAST -->
<script src="{{ asset('admin/darkpan/js/main.js') }}"></script>



</body>
</html>
