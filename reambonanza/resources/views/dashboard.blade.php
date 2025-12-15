<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Analytics Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/admindashboard.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="logo">
                <h1>ADMIN<span>HUB</span></h1>
            </div>
            <nav class="nav-menu">
                <a href="{{ route('dashboard') }}" class="nav-item active">
                    <span class="icon">📊</span>
                    <span>Analytics</span>
                </a>
                <a href="{{ route('admin.products.dashboard') }}" class="nav-item">
                    <span class="icon">📦</span>
                    <span>Products</span>
                </a>
                <a href="{{ route('admin.orders') }}" class="nav-item">
                    <span class="icon">🛒</span>
                    <span>Orders</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="nav-item logout-form">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <span class="icon">🚪</span>
                        <span>Logout</span>
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="page-header">
                <div class="header-content">
                    <h1 class="page-title">Analytics Dashboard</h1>
                    <p class="page-subtitle">Real-time business insights and performance metrics</p>
                </div>
                <div class="header-date">
                    <span id="currentDate"></span>
                </div>
            </header>

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Key Metrics Cards -->
            <section class="metrics-grid">
                <div class="metric-card" data-metric="orders">
                    <div class="metric-icon">📦</div>
                    <div class="metric-content">
                        <h3 class="metric-value">{{ $totalOrders }}</h3>
                        <p class="metric-label">Total Orders</p>
                    </div>
                    <div class="metric-trend positive">↑ View Details</div>
                </div>

                <div class="metric-card" data-metric="sales">
                    <div class="metric-icon">💰</div>
                    <div class="metric-content">
                        <h3 class="metric-value">₱{{ number_format($totalSales, 2) }}</h3>
                        <p class="metric-label">Total Sales</p>
                    </div>
                    <div class="metric-trend positive">↑ Completed</div>
                </div>

                <div class="metric-card" data-metric="cancelled">
                    <div class="metric-icon">❌</div>
                    <div class="metric-content">
                        <h3 class="metric-value">{{ $cancelledProducts }}</h3>
                        <p class="metric-label">Cancelled Items</p>
                    </div>
                    <div class="metric-trend negative">↓ Products</div>
                </div>

                <div class="metric-card" data-metric="categories">
                    <div class="metric-icon">📂</div>
                    <div class="metric-content">
                        <h3 class="metric-value">{{ $categoryPerformance->count() }}</h3>
                        <p class="metric-label">Active Categories</p>
                    </div>
                    <div class="metric-trend neutral">→ View All</div>
                </div>
            </section>

            <!-- Charts Section -->
            <section class="charts-section">
                <div class="chart-container large">
                    <div class="chart-header">
                        <h2>Monthly Sales Trend</h2>
                        <button class="chart-toggle" onclick="toggleDataTable('monthly-data')">Show Data</button>
                    </div>
                    <canvas id="monthlySalesChart"></canvas>
                    <div id="monthly-data" class="data-table hidden">
                        <table>
                            <thead>
                                <tr>
                                    <th>Month</th>
                                    <th>Orders</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($monthlySales as $sale)
                                <tr>
                                    <td>{{ date('F Y', strtotime($sale->month . '-01')) }}</td>
                                    <td>{{ $sale->order_count }}</td>
                                    <td>₱{{ number_format($sale->total, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="chart-container medium">
                    <div class="chart-header">
                        <h2>Order Status Distribution</h2>
                        <button class="chart-toggle" onclick="toggleDataTable('status-data')">Show Data</button>
                    </div>
                    <canvas id="orderStatusChart"></canvas>
                    <div id="status-data" class="data-table hidden">
                        <table>
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Count</th>
                                    <th>Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ordersByStatus as $status)
                                <tr>
                                    <td><span class="status-badge {{ $status->status }}">{{ ucfirst($status->status) }}</span></td>
                                    <td>{{ $status->count }}</td>
                                    <td>{{ round(($status->count / $totalOrders) * 100, 1) }}%</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="chart-container medium">
                    <div class="chart-header">
                        <h2>Category Performance</h2>
                        <button class="chart-toggle" onclick="toggleDataTable('category-data')">Show Data</button>
                    </div>
                    <canvas id="categoryChart"></canvas>
                    <div id="category-data" class="data-table hidden">
                        <table>
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categoryPerformance as $category)
                                <tr>
                                    <td>{{ $category->category }}</td>
                                    <td>₱{{ number_format($category->revenue, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Product Performance -->
            <section class="products-performance">
                <div class="performance-container">
                    <div class="performance-header">
                        <h2>🔥 Most Marketable Products</h2>
                        <button class="chart-toggle" onclick="toggleDataTable('marketable-data')">Show Table</button>
                    </div>
                    <canvas id="marketableChart"></canvas>
                    <div id="marketable-data" class="data-table hidden">
                        <table>
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Product</th>
                                    <th>Brand</th>
                                    <th>Category</th>
                                    <th>Units Sold</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mostMarketable as $index => $item)
                                <tr>
                                    <td><span class="rank-badge">#{{ $index + 1 }}</span></td>
                                    <td>{{ $item->product->product_name ?? 'N/A' }}</td>
                                    <td>{{ $item->product->brand ?? 'N/A' }}</td>
                                    <td>{{ $item->product->category ?? 'N/A' }}</td>
                                    <td><strong>{{ $item->total_sold }}</strong></td>
                                    <td>₱{{ number_format(($item->product->price ?? 0) * $item->total_sold, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="performance-container">
                    <div class="performance-header">
                        <h2>📉 Non-Marketable Products</h2>
                        <button class="chart-toggle" onclick="toggleDataTable('nonmarketable-data')">Show Table</button>
                    </div>
                    <canvas id="nonMarketableChart"></canvas>
                    <div id="nonmarketable-data" class="data-table hidden">
                        <table>
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Brand</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Units Sold</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($nonMarketable as $product)
                                <tr>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->brand }}</td>
                                    <td>{{ $product->category }}</td>
                                    <td>₱{{ number_format($product->price, 2) }}</td>
                                    <td><span class="low-stock">{{ $product->total_sold }}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Recent Orders with Update Status -->
            <section class="recent-orders">
                <div class="section-header">
                    <h2>Recent Orders & Status Management</h2>
                    <button class="filter-btn" onclick="toggleFilters()">Filter Orders</button>
                </div>
                
                <div id="order-filters" class="order-filters hidden">
                    <select id="statusFilter" onchange="filterOrders()">
                        <option value="all">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <div class="orders-table-container">
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Products</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="ordersTableBody">
                            @foreach($orderDetails as $order)
                            <tr data-status="{{ $order->status }}">
                                <td><strong>#{{ str_pad($order->order_id, 5, '0', STR_PAD_LEFT) }}</strong></td>
                                <td>
                                    <div class="customer-info">
                                        <strong>{{ $order->name }}</strong>
                                        <small>{{ $order->user->email ?? 'N/A' }}</small>
                                    </div>
                                </td>
                                <td>
                                    <button class="view-items-btn" onclick="viewOrderItems({{ $order->order_id }})">
                                        {{ $order->items->count() }} item(s)
                                    </button>
                                </td>
                                <td><strong>₱{{ number_format($order->total_price, 2) }}</strong></td>
                                <td>
                                    <span class="status-badge {{ $order->status }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                <td>
                                    <form method="POST" action="{{ route('admin.orders.updateStatus', $order->order_id) }}" class="status-form">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="status-select" onchange="this.form.submit()">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <!-- Modal for Order Items -->
    <div id="orderModal" class="modal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeModal()">&times;</span>
            <h2>Order Items</h2>
            <div id="orderItemsContent"></div>
        </div>
    </div>

    <script>
        // Display current date
        document.getElementById('currentDate').textContent = new Date().toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        // Chart colors
        const chartColors = {
            primary: '#FF6B6B',
            secondary: '#4ECDC4',
            tertiary: '#FFE66D',
            quaternary: '#A8E6CF',
            accent: '#FF8B94'
        };

        // Monthly Sales Chart
        const monthlySalesCtx = document.getElementById('monthlySalesChart').getContext('2d');
        new Chart(monthlySalesCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($monthlySales->pluck('month')->map(function($m) { return date('M Y', strtotime($m . '-01')); })) !!},
                datasets: [{
                    label: 'Revenue (₱)',
                    data: {!! json_encode($monthlySales->pluck('total')) !!},
                    borderColor: chartColors.primary,
                    backgroundColor: chartColors.primary + '20',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: true, position: 'top' },
                    tooltip: { mode: 'index', intersect: false }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { callback: value => '₱' + value.toLocaleString() } }
                }
            }
        });

        // Order Status Chart
        const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
        new Chart(orderStatusCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($ordersByStatus->pluck('status')->map(function($s) { return ucfirst($s); })) !!},
                datasets: [{
                    data: {!! json_encode($ordersByStatus->pluck('count')) !!},
                    backgroundColor: [chartColors.primary, chartColors.secondary, chartColors.tertiary, chartColors.quaternary],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });

        // Category Performance Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($categoryPerformance->pluck('category')) !!},
                datasets: [{
                    label: 'Revenue (₱)',
                    data: {!! json_encode($categoryPerformance->pluck('revenue')) !!},
                    backgroundColor: chartColors.secondary,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { callback: value => '₱' + value.toLocaleString() } }
                }
            }
        });

        // Most Marketable Products Chart
        const marketableCtx = document.getElementById('marketableChart').getContext('2d');
        new Chart(marketableCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($mostMarketable->pluck('product.product_name')) !!},
                datasets: [{
                    label: 'Units Sold',
                    data: {!! json_encode($mostMarketable->pluck('total_sold')) !!},
                    backgroundColor: chartColors.primary,
                    borderRadius: 8
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });

        // Non-Marketable Products Chart
        const nonMarketableCtx = document.getElementById('nonMarketableChart').getContext('2d');
        new Chart(nonMarketableCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($nonMarketable->pluck('product_name')) !!},
                datasets: [{
                    label: 'Units Sold',
                    data: {!! json_encode($nonMarketable->pluck('total_sold')) !!},
                    backgroundColor: chartColors.quaternary,
                    borderRadius: 8
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });

        // Toggle Data Tables
        function toggleDataTable(tableId) {
            const table = document.getElementById(tableId);
            table.classList.toggle('hidden');
            event.target.textContent = table.classList.contains('hidden') ? 'Show Data' : 'Hide Data';
        }

        // Filter Orders
        function toggleFilters() {
            document.getElementById('order-filters').classList.toggle('hidden');
        }

        function filterOrders() {
            const filter = document.getElementById('statusFilter').value;
            const rows = document.querySelectorAll('#ordersTableBody tr');
            
            rows.forEach(row => {
                if (filter === 'all' || row.dataset.status === filter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // View Order Items Modal
        function viewOrderItems(orderId) {
            const order = {!! json_encode($orderDetails) !!}.find(o => o.order_id === orderId);
            
            let itemsHtml = '<table class="modal-table"><thead><tr><th>Product</th><th>Quantity</th><th>Price</th><th>Subtotal</th></tr></thead><tbody>';
            
            order.items.forEach(item => {
                const subtotal = item.quantity * item.price;
                itemsHtml += `
                    <tr>
                        <td>${item.product.product_name}</td>
                        <td>${item.quantity}</td>
                        <td>₱${item.price.toFixed(2)}</td>
                        <td>₱${subtotal.toFixed(2)}</td>
                    </tr>
                `;
            });
            
            itemsHtml += '</tbody></table>';
            document.getElementById('orderItemsContent').innerHTML = itemsHtml;
            document.getElementById('orderModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('orderModal').style.display = 'none';
        }

        // Close modal on outside click
        window.onclick = function(event) {
            const modal = document.getElementById('orderModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>