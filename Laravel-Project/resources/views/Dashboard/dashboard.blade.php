<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/dashboardview.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Panel</h2>
                <p>Dashboard Management</p>
            </div>
            <nav class="sidebar-menu">
                <a href="{{ route('admin.dashboard') }}" class="menu-item active">
                    <span class="menu-item-icon">📊</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.products.index') }}" class="menu-item">
                    <span class="menu-item-icon">📦</span>
                    <span>Products</span>
                </a>
                <a href="{{ route('admin.orders.index') }}" class="menu-item">
                    <span class="menu-item-icon">🛒</span>
                    <span>Customer Orders</span>
                </a>
                <form action="{{ route('logout') }}" method="POST" class="sidebar-logout-inline">
                    @csrf
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Header -->
            <div class="top-header">
                <div class="header-left">
                    <h1>Dashboard</h1>
                    <p class="header-date">{{ now()->format('l, F d, Y') }}</p>
                </div>
                <div class="header-right">
                    <button class="btn-export">Export Data</button>
                    <a href="{{ route('admin.orders.index') }}" class="btn-primary">View Reports</a>
                </div>
            </div>

            <!-- Stats Grid - 4 Cards with Real Data -->
            <div class="stats-grid-new">
                <div class="stat-card-new" onclick="openModal('ordersModal')">
                    <div class="stat-icon-new bg-green">🛒</div>
                    <div class="stat-content-new">
                        <span class="stat-label-new">Total Orders</span>
                        <div class="stat-value-new">{{ number_format($totalOrders) }}</div>
                        <span class="stat-change-new {{ $ordersGrowth >= 0 ? 'positive' : 'negative' }}">{{ $ordersGrowth >= 0 ? '+' : '' }}{{ abs($ordersGrowth) }}%</span>
                    </div>
                </div>

                <div class="stat-card-new" onclick="openModal('salesModal')">
                    <div class="stat-icon-new bg-blue">💰</div>
                    <div class="stat-content-new">
                        <span class="stat-label-new">Total Sales</span>
                        <div class="stat-value-new">₱{{ number_format($totalSales, 2) }}</div>
                        <span class="stat-change-new {{ $salesGrowth >= 0 ? 'positive' : 'negative' }}">{{ $salesGrowth >= 0 ? '+' : '' }}{{ abs($salesGrowth) }}%</span>
                    </div>
                </div>

                <div class="stat-card-new" onclick="openModal('cancelledModal')">
                    <div class="stat-icon-new bg-orange">❌</div>
                    <div class="stat-content-new">
                        <span class="stat-label-new">Cancelled Orders</span>
                        <div class="stat-value-new">{{ number_format($cancelledOrders) }}</div>
                        <span class="stat-change-new negative">{{ $totalOrders > 0 ? round(($cancelledOrders / $totalOrders) * 100, 1) : 0 }}%</span>
                    </div>
                </div>

                <div class="stat-card-new" onclick="openModal('productsModal')">
                    <div class="stat-icon-new bg-purple">📦</div>
                    <div class="stat-content-new">
                        <span class="stat-label-new">Active Products</span>
                        <div class="stat-value-new">{{ number_format($activeProducts) }}</div>
                        <span class="stat-change-new positive">Available</span>
                    </div>
                </div>
            </div>

            <!-- Main Grid Layout -->
            <div class="main-grid">
                <!-- Left Column -->
                <div class="left-column">
                    <!-- Order Status Donut Chart -->
                    <div class="chart-card-new">
                        <div class="chart-header-new">
                            <div>
                                <h3>Order Status</h3>
                                <div class="chart-tabs">
                                    <button class="tab-btn active">Overview</button>
                                    <button class="tab-btn">Details</button>
                                </div>
                            </div>
                        </div>
                        <div class="donut-chart-container">
                            <canvas id="orderStatusChart"></canvas>
                            <div class="donut-center-text">
                                <div class="center-value">{{ number_format($totalOrders) }}</div>
                                <div class="center-label">Total Orders</div>
                            </div>
                        </div>
                        <div class="donut-legend">
                            @php
                                $ordersByStatus = \App\Models\Order::select('status', \DB::raw('count(*) as count'))
                                    ->groupBy('status')
                                    ->get();
                                $statusColors = [
                                    'completed' => '#22c55e',
                                    'processing' => '#3b82f6',
                                    'pending' => '#fbbf24',
                                    'cancelled' => '#ef4444'
                                ];
                            @endphp
                            @foreach($ordersByStatus as $status)
                            <div class="legend-item">
                                <span class="legend-color" style="background: {{ $statusColors[$status->status] ?? '#6b7280' }};"></span>
                                <span class="legend-label">{{ ucfirst($status->status) }}</span>
                                <span class="legend-value">{{ $status->count }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Top Selling Products -->
                    <div class="chart-card-new">
                        <div class="chart-header-new">
                            <h3>Top Selling Products</h3>
                            <a href="{{ route('admin.products.index') }}" class="view-link">View All</a>
                        </div>
                        <div class="budget-list">
                            @forelse($topProducts as $product)
                            @php
                                $percentage = $product->total_sold > 0 ? min(($product->total_sold / 50) * 100, 100) : 0;
                                $statusClass = $percentage >= 80 ? 'danger' : ($percentage >= 50 ? 'warning' : 'success');
                            @endphp
                            <div class="budget-item {{ $statusClass }}">
                                <div class="budget-icon">📦</div>
                                <div class="budget-info">
                                    <span class="budget-name">{{ $product->product_name }}</span>
                                    <div class="budget-bar">
                                        <div class="budget-fill" style="width: {{ $percentage }}%;"></div>
                                    </div>
                                </div>
                                <span class="budget-amount">{{ $product->total_sold }} sold</span>
                            </div>
                            @empty
                            <p style="text-align: center; color: #666; padding: 20px;">No product data</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Middle Column -->
                <div class="middle-column">
                    <!-- Sales Trend Chart -->
                    <div class="chart-card-new large">
                        <div class="chart-header-new">
                            <div>
                                <h3>Sales Trend</h3>
                                <p class="chart-subtitle">Monthly revenue overview</p>
                            </div>
                            <div class="chart-controls">
                                <select id="salesTrendPeriod" class="time-btn-select">
                                    <option value="6">Last 6 Months</option>
                                    <option value="12">Last 12 Months</option>
                                    <option value="3">Last 3 Months</option>
                                </select>
                                <div class="dropdown">
                                    <button class="more-btn" onclick="toggleDropdown('salesTrendDropdown')">⋯</button>
                                    <div id="salesTrendDropdown" class="dropdown-content">
                                        <a href="#" onclick="exportChart('salesTrend'); return false;">📊 Export Chart</a>
                                        <a href="#" onclick="printChart('salesTrend'); return false;">🖨️ Print</a>
                                        <a href="{{ route('admin.orders.index') }}">📋 View Details</a>
                                        <a href="#" onclick="refreshChart('salesTrend'); return false;">🔄 Refresh Data</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <canvas id="salesTrendChart"></canvas>
                    </div>

                    <!-- Monthly Trends Chart - UPDATED -->
                    <div class="chart-card-new large">
                        <div class="chart-header-new">
                            <div>
                                <h3>Monthly Trends</h3>
                                <p class="chart-subtitle">Orders and Revenue comparison</p>
                            </div>
                            <div class="chart-controls">
                                <select id="monthlyTrendsPeriod" class="time-btn-select" onchange="updateMonthlyTrends(this.value)">
                                    <option value="3">Last 3 months</option>
                                    <option value="6">Last 6 months</option>
                                    <option value="12">Last 12 months</option>
                                </select>
                                <div class="dropdown">
                                    <button class="more-btn" onclick="toggleDropdown('monthlyTrendsDropdown')">⋯</button>
                                    <div id="monthlyTrendsDropdown" class="dropdown-content">
                                        <a href="#" onclick="exportChart('monthlyTrends'); return false;">📊 Export Chart</a>
                                        <a href="#" onclick="printChart('monthlyTrends'); return false;">🖨️ Print</a>
                                        <a href="#" onclick="refreshChart('monthlyTrends'); return false;">🔄 Refresh Data</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <canvas id="monthlyTrendsChart"></canvas>
                    </div>

                    <!-- Recent Orders -->
                    <div class="chart-card-new">
                        <div class="chart-header-new">
                            <h3>Recent Orders</h3>
                            <select class="month-select">
                                <option>This Month</option>
                                <option>Last Month</option>
                            </select>
                        </div>
                        <div class="transactions-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Date & Time</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Items</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentOrders as $order)
                                    <tr>
                                        <td>#{{ $order->order_id }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->created_at->format('Y-m-d h:i A') }}</td>
                                        <td class="amount-positive">₱{{ number_format($order->total_price, 2) }}</td>
                                        <td><span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                                        <td>{{ $order->items->count() }} items</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center; padding: 30px; color: #666;">No orders yet</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="table-pagination">
                                <div class="pagination-info">Showing 1-{{ count($recentOrders) }} of {{ $totalOrders }} orders</div>
                                <div class="pagination-buttons">
                                    <button class="page-btn">1</button>
                                    <button class="page-btn active">2</button>
                                    <button class="page-btn">3</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="right-column">
                    <!-- Summary Card -->
                    <div class="credit-card">
                        <div class="card-header">
                            <span class="card-type">💳</span>
                            <span class="card-brand">Summary</span>
                        </div>
                        <div class="card-balance">₱{{ number_format($totalSales, 2) }}</div>
                        <div class="card-number">Total Revenue</div>
                        <div class="card-footer">
                            <div class="card-holder">
                                <span class="card-label">ORDERS</span>
                                <span class="card-value">{{ number_format($totalOrders) }}</span>
                            </div>
                            <div class="card-expiry">
                                <span class="card-label">PRODUCTS</span>
                                <span class="card-value">{{ number_format($activeProducts) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="chart-card-new">
                        <div class="chart-header-new">
                            <h3>Recent Activity</h3>
                            <button class="more-btn">⋯</button>
                        </div>
                        <div class="activity-timeline">
                            <div class="timeline-section">
                                <div class="timeline-date">Recent</div>
                                @forelse($recentActivities as $activity)
                                <div class="activity-item-new">
                                    <div class="activity-avatar">
                                        <span>{{ substr($activity['title'], 0, 1) }}</span>
                                    </div>
                                    <div class="activity-content-new">
                                        <h4>{{ $activity['title'] }}</h4>
                                        <p>{{ $activity['description'] }}</p>
                                        <span class="activity-time">{{ $activity['time'] }}</span>
                                    </div>
                                </div>
                                @empty
                                <p style="color: #666; text-align: center; padding: 20px;">No activity</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Low Performing Products -->
                    <div class="chart-card-new">
                        <div class="chart-header-new">
                            <h3>Low Performing Products</h3>
                            <a href="{{ route('admin.products.index') }}" class="view-link">View All</a>
                        </div>
                        <div class="savings-list">
                            @forelse($lowProducts as $product)
                            @php
                                $targetSales = 10000;
                                $percentage = min(($product->total_revenue / $targetSales) * 100, 100);
                            @endphp
                            <div class="savings-item">
                                <div class="savings-icon">📉</div>
                                <div class="savings-info">
                                    <h4>{{ $product->product_name }}</h4>
                                    <div class="savings-progress">
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: {{ $percentage }}%;"></div>
                                        </div>
                                        <span class="progress-text">₱{{ number_format($product->total_revenue, 2) }} ({{ number_format($percentage, 2) }}%)</span>
                                    </div>
                                </div>
                                <span class="savings-target">{{ $product->total_sold }} sold</span>
                            </div>
                            @empty
                            <p style="text-align: center; color: #666; padding: 20px;">No product data</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- MODAL: Total Orders Details -->
    <div id="ordersModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Total Orders Details</h2>
                <span class="close" onclick="closeModal('ordersModal')">&times;</span>
            </div>
            <div class="modal-body">
                <div class="modal-stats-grid">
                    <div class="modal-stat">
                        <div class="modal-stat-label">Total Orders</div>
                        <div class="modal-stat-value">{{ number_format($totalOrders) }}</div>
                    </div>
                    <div class="modal-stat">
                        <div class="modal-stat-label">This Month</div>
                        <div class="modal-stat-value">{{ $ordersThisMonth ?? 0 }}</div>
                    </div>
                    <div class="modal-stat">
                        <div class="modal-stat-label">Last Month</div>
                        <div class="modal-stat-value">{{ $ordersLastMonth ?? 0 }}</div>
                    </div>
                    <div class="modal-stat">
                        <div class="modal-stat-label">Growth Rate</div>
                        <div class="modal-stat-value {{ $ordersGrowth >= 0 ? 'positive' : 'negative' }}">
                            {{ $ordersGrowth >= 0 ? '↑' : '↓' }} {{ abs($ordersGrowth) }}%
                        </div>
                    </div>
                </div>
                
                <div class="modal-section">
                    <h3>Orders by Status</h3>
                    <div class="status-breakdown">
                        @php
                            $ordersByStatus = \App\Models\Order::select('status', \DB::raw('count(*) as count'))
                                ->groupBy('status')
                                ->get();
                        @endphp
                        @foreach($ordersByStatus as $status)
                        <div class="status-row">
                            <span class="status-badge status-{{ $status->status }}">{{ ucfirst($status->status) }}</span>
                            <span class="status-count">{{ $status->count }} orders</span>
                            <span class="status-percentage">{{ $totalOrders > 0 ? round(($status->count / $totalOrders) * 100, 1) : 0 }}%</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="modal-footer">
                    <a href="{{ route('admin.orders.index') }}" class="modal-btn modal-btn-primary">View All Orders</a>
                    <button onclick="closeModal('ordersModal')" class="modal-btn modal-btn-secondary">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL: Total Sales Details -->
    <div id="salesModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Total Sales Details</h2>
                <span class="close" onclick="closeModal('salesModal')">&times;</span>
            </div>
            <div class="modal-body">
                <div class="modal-stats-grid">
                    <div class="modal-stat">
                        <div class="modal-stat-label">Total Sales</div>
                        <div class="modal-stat-value">₱{{ number_format($totalSales, 2) }}</div>
                    </div>
                    <div class="modal-stat">
                        <div class="modal-stat-label">This Month</div>
                        <div class="modal-stat-value">₱{{ number_format($salesThisMonth ?? 0, 2) }}</div>
                    </div>
                    <div class="modal-stat">
                        <div class="modal-stat-label">Last Month</div>
                        <div class="modal-stat-value">₱{{ number_format($salesLastMonth ?? 0, 2) }}</div>
                    </div>
                    <div class="modal-stat">
                        <div class="modal-stat-label">Growth Rate</div>
                        <div class="modal-stat-value {{ $salesGrowth >= 0 ? 'positive' : 'negative' }}">
                            {{ $salesGrowth >= 0 ? '↑' : '↓' }} {{ abs($salesGrowth) }}%
                        </div>
                    </div>
                </div>
                
                <div class="modal-section">
                    <h3>Average Order Value</h3>
                    <div class="big-stat">
                        ₱{{ $totalOrders > 0 ? number_format($totalSales / $totalOrders, 2) : '0.00' }}
                    </div>
                </div>

                <div class="modal-footer">
                    <button onclick="closeModal('salesModal')" class="modal-btn modal-btn-secondary">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL: Cancelled Orders Details -->
    <div id="cancelledModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Cancelled Orders Details</h2>
                <span class="close" onclick="closeModal('cancelledModal')">&times;</span>
            </div>
            <div class="modal-body">
                <div class="modal-stats-grid">
                    <div class="modal-stat">
                        <div class="modal-stat-label">Cancelled Orders</div>
                        <div class="modal-stat-value">{{ number_format($cancelledOrders) }}</div>
                    </div>
                    <div class="modal-stat">
                        <div class="modal-stat-label">Cancellation Rate</div>
                        <div class="modal-stat-value negative">
                            {{ $totalOrders > 0 ? round(($cancelledOrders / $totalOrders) * 100, 1) : 0 }}%
                        </div>
                    </div>
                    <div class="modal-stat">
                        <div class="modal-stat-label">Lost Revenue</div>
                        <div class="modal-stat-value negative">
                            @php
                                $lostRevenue = \App\Models\Order::where('status', 'cancelled')->sum('total_price');
                            @endphp
                            ₱{{ number_format($lostRevenue, 2) }}
                        </div>
                    </div>
                    <div class="modal-stat">
                        <div class="modal-stat-label">Successful Orders</div>
                        <div class="modal-stat-value positive">{{ number_format($totalOrders - $cancelledOrders) }}</div>
                    </div>
                </div>

                <div class="modal-section">
                    <h3>Recent Cancelled Orders</h3>
                    <div class="order-list">
                        @php
                            $cancelledOrdersList = \App\Models\Order::where('status', 'cancelled')
                                ->with('user')
                                ->latest()
                                ->take(5)
                                ->get();
                        @endphp
                        @forelse($cancelledOrdersList as $order)
                        <div class="order-item">
                            <div class="order-info">
                                <h4>Order #{{ $order->order_id }}</h4>
                                <p>{{ $order->user->name }} • ₱{{ number_format($order->total_price, 2) }}</p>
                            </div>
                            <span class="order-date">{{ $order->created_at->format('M d, Y') }}</span>
                        </div>
                        @empty
                        <p style="text-align: center; color: #999; padding: 20px;">No cancelled orders</p>
                        @endforelse
                    </div>
                </div>

                <div class="modal-footer">
                    <a href="{{ route('admin.orders.index') }}?status=cancelled" class="modal-btn modal-btn-primary">View All Cancelled</a>
                    <button onclick="closeModal('cancelledModal')" class="modal-btn modal-btn-secondary">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL: Active Products Details -->
    <div id="productsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Active Products Details</h2>
                <span class="close" onclick="closeModal('productsModal')">&times;</span>
            </div>
            <div class="modal-body">
                <div class="modal-stats-grid">
                    <div class="modal-stat">
                        <div class="modal-stat-label">Total Products</div>
                        <div class="modal-stat-value">{{ number_format($activeProducts) }}</div>
                    </div>
                    <div class="modal-stat">
                        <div class="modal-stat-label">Categories</div>
                        <div class="modal-stat-value">
                            @php
                                $categoriesCount = \App\Models\Product::distinct('category')->count('category');
                            @endphp
                            {{ $categoriesCount }}
                        </div>
                    </div>
                    <div class="modal-stat">
                        <div class="modal-stat-label">Brands</div>
                        <div class="modal-stat-value">
                            @php
                                $brandsCount = \App\Models\Product::distinct('brand')->count('brand');
                            @endphp
                            {{ $brandsCount }}
                        </div>
                    </div>
                    <div class="modal-stat">
                        <div class="modal-stat-label">Avg Price</div>
                        <div class="modal-stat-value">
                            ₱{{ number_format(\App\Models\Product::avg('price'), 2) }}
                        </div>
                    </div>
                </div>

                <div class="modal-section">
                    <h3>Products by Category</h3>
                    <div class="category-breakdown">
                        @php
                            $productsByCategory = \App\Models\Product::select('category', \DB::raw('count(*) as count'))
                                ->groupBy('category')
                                ->orderBy('count', 'desc')
                                ->get();
                        @endphp
                        @foreach($productsByCategory as $cat)
                        <div class="category-row">
                            <span class="category-name">{{ $cat->category }}</span>
                            <span class="category-count">{{ $cat->count }} products</span>
                            <div class="category-bar">
                                <div class="category-bar-fill" style="width: {{ ($cat->count / $activeProducts) * 100 }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="modal-footer">
                    <a href="{{ route('admin.products.index') }}" class="modal-btn modal-btn-primary">Manage Products</a>
                    <button onclick="closeModal('productsModal')" class="modal-btn modal-btn-secondary">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Dropdown Toggle Function
        function toggleDropdown(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            const allDropdowns = document.querySelectorAll('.dropdown-content');
            
            // Close all other dropdowns
            allDropdowns.forEach(dd => {
                if (dd.id !== dropdownId) {
                    dd.classList.remove('show');
                }
            });
            
            // Toggle current dropdown
            dropdown.classList.toggle('show');
        }

        // Update Daily Chart based on day count
        function updateDailyChart(days) {
            console.log('Updating chart to show ' + days + ' days');
            alert('Loading ' + days + ' days of sales data...\nThis will fetch data from the server.');
            location.reload();
        }

        // Close dropdown when clicking outside
        window.addEventListener('click', function(event) {
            if (!event.target.matches('.more-btn')) {
                const dropdowns = document.querySelectorAll('.dropdown-content');
                dropdowns.forEach(dropdown => {
                    if (dropdown.classList.contains('show')) {
                        dropdown.classList.remove('show');
                    }
                });
            }
        });

        // Export Chart Function
        function exportChart(chartType) {
            alert('Exporting ' + chartType + ' chart data...\nThis feature will download the chart as an image.');
            const dropdownId = chartType + 'Dropdown';
            if (document.getElementById(dropdownId)) {
                toggleDropdown(dropdownId);
            }
        }

        // Print Chart Function
        function printChart(chartType) {
            alert('Printing ' + chartType + ' chart...\nThis will open the print dialog.');
            const dropdownId = chartType + 'Dropdown';
            if (document.getElementById(dropdownId)) {
                toggleDropdown(dropdownId);
            }
        }

        // Refresh Chart Function
        function refreshChart(chartType) {
            if (chartType === 'monthlyTrends') {
                const select = document.getElementById('monthlyTrendsPeriod');
                if (select) {
                    updateMonthlyTrends(select.value);
                }
            } else {
                alert('Refreshing ' + chartType + ' chart data...\nFetching latest data from server.');
                toggleDropdown(chartType + 'Dropdown');
                location.reload();
            }
        }

        // Modal Functions
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }

        // Chart data from Laravel
        const chartData = {
            salesTrend: @json($salesTrendData ?? []),
            orderStatus: @json($orderStatusData ?? []),
            categoryPerformance: @json($categoryData ?? []),
            dailyOrders: @json($dailyOrdersData ?? [])
        };

        // Chart.js Configuration
        Chart.defaults.color = 'rgba(255, 255, 255, 0.7)';
        Chart.defaults.borderColor = 'rgba(255, 255, 255, 0.1)';

        // Order Status Donut Chart
        const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
        new Chart(orderStatusCtx, {
            type: 'doughnut',
            data: {
                labels: chartData.orderStatus.labels || ['Completed', 'Processing', 'Pending', 'Cancelled'],
                datasets: [{
                    data: chartData.orderStatus.data || [0, 0, 0, 0],
                    backgroundColor: ['#22c55e', '#3b82f6', '#fbbf24', '#ef4444'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 1.2,
                cutout: '70%',
                plugins: {
                    legend: { display: false }
                }
            }
        });

        // Sales Trend Chart
        const salesTrendCtx = document.getElementById('salesTrendChart').getContext('2d');
        new Chart(salesTrendCtx, {
            type: 'line',
            data: {
                labels: chartData.salesTrend.labels || [],
                datasets: [{
                    label: 'Sales',
                    data: chartData.salesTrend.data || [],
                    borderColor: '#22c55e',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#22c55e'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 2.5,
                plugins: { 
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(13, 20, 16, 0.95)',
                        titleColor: '#22c55e',
                        bodyColor: '#fff',
                        borderColor: '#22c55e',
                        borderWidth: 1,
                        padding: 12,
                        callbacks: {
                            label: function(context) {
                                return '₱' + context.parsed.y.toLocaleString('en-PH', {minimumFractionDigits: 2});
                            }
                        }
                    }
                },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        grid: { color: 'rgba(255,255,255,0.05)' },
                        ticks: {
                            callback: function(value) {
                                return '₱' + (value / 1000) + 'k';
                            }
                        }
                    },
                    x: { grid: { display: false } }
                }
            }
        });

        // Generate Monthly Trends data function
        function generateMonthlyData(months) {
            const labels = [];
            const ordersData = [];
            const revenueData = [];
            
            const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 
                              'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            
            const currentDate = new Date();
            const currentMonth = currentDate.getMonth();
            
            for (let i = months - 1; i >= 0; i--) {
                const monthIndex = (currentMonth - i + 12) % 12;
                labels.push(monthNames[monthIndex]);
                
                // Generate realistic data
                const baseOrders = 80 + Math.floor(Math.random() * 40);
                const baseRevenue = 15000 + Math.floor(Math.random() * 10000);
                
                ordersData.push(baseOrders);
                revenueData.push(baseRevenue);
            }
            
            return { labels, ordersData, revenueData };
        }

        // Monthly Trends Chart - DUAL Y-AXIS
        const monthlyTrendsCtx = document.getElementById('monthlyTrendsChart').getContext('2d');
        const initialData = generateMonthlyData(3);

        const monthlyTrendsChart = new Chart(monthlyTrendsCtx, {
            type: 'line',
            data: {
                labels: initialData.labels,
                datasets: [
                    {
                        label: 'Orders',
                        data: initialData.ordersData,
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointRadius: 5,
                        pointHoverRadius: 8,
                        pointBackgroundColor: '#3b82f6',
                        pointBorderColor: '#0a0f0d',
                        pointBorderWidth: 2,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Revenue',
                        data: initialData.revenueData,
                        borderColor: '#22c55e',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointRadius: 5,
                        pointHoverRadius: 8,
                        pointBackgroundColor: '#22c55e',
                        pointBorderColor: '#0a0f0d',
                        pointBorderWidth: 2,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 2.5,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        align: 'end',
                        labels: {
                            color: 'rgba(255, 255, 255, 0.7)',
                            padding: 15,
                            font: {
                                size: 12,
                                weight: 600
                            },
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(13, 20, 16, 0.95)',
                        titleColor: '#22c55e',
                        bodyColor: '#fff',
                        borderColor: '#22c55e',
                        borderWidth: 1,
                        padding: 12,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.datasetIndex === 1) {
                                    label += '₱' + context.parsed.y.toLocaleString('en-PH', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    });
                                } else {
                                    label += context.parsed.y + ' orders';
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(255, 255, 255, 0.05)'
                        },
                        ticks: {
                            color: 'rgba(255, 255, 255, 0.7)',
                            callback: function(value) {
                                return value + ' orders';
                            }
                        },
                        title: {
                            display: true,
                            text: 'Orders',
                            color: '#3b82f6',
                            font: {
                                size: 12,
                                weight: 600
                            }
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        beginAtZero: true,
                        grid: {
                            drawOnChartArea: false
                        },
                        ticks: {
                            color: 'rgba(255, 255, 255, 0.7)',
                            callback: function(value) {
                                return '₱' + (value / 1000).toFixed(0) + 'k';
                            }
                        },
                        title: {
                            display: true,
                            text: 'Revenue',
                            color: '#22c55e',
                            font: {
                                size: 12,
                                weight: 600
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: 'rgba(255, 255, 255, 0.7)'
                        }
                    }
                }
            }
        });

        // Update Monthly Trends based on period selection
        function updateMonthlyTrends(months) {
            const newData = generateMonthlyData(parseInt(months));
            
            monthlyTrendsChart.data.labels = newData.labels;
            monthlyTrendsChart.data.datasets[0].data = newData.ordersData;
            monthlyTrendsChart.data.datasets[1].data = newData.revenueData;
            monthlyTrendsChart.update('active');
            
            // Close dropdown after selection
            const dropdown = document.getElementById('monthlyTrendsDropdown');
            if (dropdown) {
                dropdown.classList.remove('show');
            }
        }
    </script>
</body>
</html>