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
                    <span class="menu-item-icon"></span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.products.index') }}" class="menu-item">
                    <span class="menu-item-icon"></span>
                    <span>Products</span>
                </a>
                <a href="{{ route('admin.orders.index') }}" class="menu-item">
                    <span class="menu-item-icon"></span>
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
            <div class="header">
                <h1>Dashboard Overview</h1>
                <p>Welcome back! Here's what's happening with your store today.</p>
            </div>

            <!-- Stats Grid - Now Clickable! -->
            <div class="stats-grid">
                <div class="stat-card clickable-card" onclick="openModal('ordersModal')">
                    <div class="stat-card-header">
                        <span class="stat-card-title">Total Orders</span>
                        
                    </div>
                    <div class="stat-card-value">{{ number_format($totalOrders) }}</div>
                    <div class="stat-card-change {{ $ordersGrowth >= 0 ? '' : 'negative' }}">
                        {{ $ordersGrowth >= 0 ? '↑' : '↓' }} {{ abs($ordersGrowth) }}% from last month
                    </div>
                    <div class="click-hint">Click for details →</div>
                </div>

                <div class="stat-card clickable-card" onclick="openModal('salesModal')">
                    <div class="stat-card-header">
                        <span class="stat-card-title">Total Sales</span>
                        
                    </div>
                    <div class="stat-card-value">₱{{ number_format($totalSales, 2) }}</div>
                    <div class="stat-card-change {{ $salesGrowth >= 0 ? '' : 'negative' }}">
                        {{ $salesGrowth >= 0 ? '↑' : '↓' }} {{ abs($salesGrowth) }}% from last month
                    </div>
                    <div class="click-hint">Click for details →</div>
                </div>

                <div class="stat-card clickable-card" onclick="openModal('cancelledModal')">
                    <div class="stat-card-header">
                        <span class="stat-card-title">Cancelled Orders</span>
                      
                    </div>
                    <div class="stat-card-value">{{ number_format($cancelledOrders) }}</div>
                    <div class="stat-card-change">
                        {{ $totalOrders > 0 ? round(($cancelledOrders / $totalOrders) * 100, 1) : 0 }}% cancellation rate
                    </div>
                    <div class="click-hint">Click for details →</div>
                </div>

                <div class="stat-card clickable-card" onclick="openModal('productsModal')">
                    <div class="stat-card-header">
                        <span class="stat-card-title">Active Products</span>
                    
                    </div>
                    <div class="stat-card-value">{{ number_format($activeProducts) }}</div>
                    <div class="stat-card-change">Available in store</div>
                    <div class="click-hint">Click for details →</div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="charts-section">
                <div class="chart-card chart-large">
                    <div class="chart-header">
                        <div>
                            <h3>Sales Trend</h3>
                            <p>Monthly revenue overview</p>
                        </div>
                        <select id="salesPeriod" class="chart-select">
                            <option value="6">Last 6 Months</option>
                            <option value="12">Last 12 Months</option>
                            <option value="3">Last 3 Months</option>
                        </select>
                    </div>
                    <canvas id="salesTrendChart"></canvas>
                </div>

                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <h3>Order Status</h3>
                            <p>Current distribution</p>
                        </div>
                    </div>
                    <canvas id="orderStatusChart"></canvas>
                </div>
            </div>

            <div class="charts-section">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <h3>Category Performance</h3>
                            <p>Sales by product category</p>
                        </div>
                    </div>
                    <canvas id="categoryChart"></canvas>
                </div>

                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <h3>Daily Orders</h3>
                            <p>Last 7 days activity</p>
                        </div>
                    </div>
                    <canvas id="dailyOrdersChart"></canvas>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="content-grid">
                <div class="content-card">
                    <div class="content-card-header">
                        <h3 class="content-card-title">Recent Orders</h3>
                        <a href="{{ route('admin.orders.index') }}" class="view-all-btn">View All →</a>
                    </div>
                    <div class="order-list">
                        @forelse($recentOrders as $order)
                        <div class="order-item">
                            <div class="order-info">
                                <h4>Order #{{ $order->order_id }}</h4>
                                <p>{{ $order->user->name }} • {{ $order->items->count() }} items • ₱{{ number_format($order->total_price, 2) }}</p>
                            </div>
                            <span class="order-status status-{{ $order->status }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        @empty
                        <p style="text-align: center; color: #999; padding: 20px;">No orders yet</p>
                        @endforelse
                    </div>
                </div>

                <div class="content-card">
                    <div class="content-card-header">
                        <h3 class="content-card-title">Recent Activity</h3>
                        <a href="#" class="view-all-btn">View All →</a>
                    </div>
                    <div class="activity-list">
                        @forelse($recentActivities as $activity)
                        <div class="activity-item">
                            <span class="activity-icon bg-{{ $activity['color'] }}">{{ $activity['icon'] }}</span>
                            <div class="activity-content">
                                <h4>{{ $activity['title'] }}</h4>
                                <p>{{ $activity['description'] }} • {{ $activity['time'] }}</p>
                            </div>
                        </div>
                        @empty
                        <p style="text-align: center; color: #999; padding: 20px;">No recent activity</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="content-grid">
                <div class="content-card">
                    <div class="content-card-header">
                        <h3 class="content-card-title">Top Selling Products</h3>
                        <a href="{{ route('admin.products.index') }}" class="view-all-btn">View All →</a>
                    </div>
                    <div class="product-list">
                        @forelse($topProducts as $product)
                        <div class="product-item">
                            <div class="product-info">
                                <h4>{{ $product->product_name }}</h4>
                                <p>{{ $product->category }} • {{ $product->total_sold }} sold</p>
                            </div>
                            <div class="product-sales">
                                <div class="product-sales-value">₱{{ number_format($product->total_revenue, 2) }}</div>
                                <div class="product-sales-label">Total Revenue</div>
                            </div>
                        </div>
                        @empty
                        <p style="text-align: center; color: #999; padding: 20px;">No sales data yet</p>
                        @endforelse
                    </div>
                </div>

                <div class="content-card">
                    <div class="content-card-header">
                        <h3 class="content-card-title">Low Performing Products</h3>
                        <a href="{{ route('admin.orders.index') }}" class="view-all-btn">View All →</a>
                    </div>
                    <div class="product-list">
                        @forelse($lowProducts as $product)
                        <div class="product-item">
                            <div class="product-info">
                                <h4>{{ $product->product_name }}</h4>
                                <p>{{ $product->category }} • {{ $product->total_sold }} sold</p>
                            </div>
                            <div class="product-sales">
                                <div class="product-sales-value">₱{{ number_format($product->total_revenue, 2) }}</div>
                                <div class="product-sales-label">Total Revenue</div>
                            </div>
                        </div>
                        @empty
                        <p style="text-align: center; color: #999; padding: 20px;">No product data</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- MODAL: Total Orders Details -->
    <div id="ordersModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2> Total Orders Details</h2>
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
                <h2> Total Sales Details</h2>
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
                <h2> Cancelled Orders Details</h2>
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
        // Modal Functions
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
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
        Chart.defaults.font.family = "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif";

        // Sales Trend Chart
        const salesTrendCtx = document.getElementById('salesTrendChart').getContext('2d');
        const salesTrendChart = new Chart(salesTrendCtx, {
            type: 'line',
            data: {
                labels: chartData.salesTrend.labels || [],
                datasets: [{
                    label: 'Sales (₱)',
                    data: chartData.salesTrend.data || [],
                    borderColor: '#dc2626',
                    backgroundColor: 'rgba(220, 38, 38, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#dc2626',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(26, 26, 26, 0.95)',
                        titleColor: '#dc2626',
                        bodyColor: '#fff',
                        borderColor: '#dc2626',
                        borderWidth: 1,
                        padding: 12,
                        displayColors: false,
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
                        grid: { color: 'rgba(255, 255, 255, 0.05)' },
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

        // Order Status Chart
        const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
        const orderStatusChart = new Chart(orderStatusCtx, {
            type: 'doughnut',
            data: {
                labels: chartData.orderStatus.labels || [],
                datasets: [{
                    data: chartData.orderStatus.data || [],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(251, 191, 36, 0.8)',
                        'rgba(239, 68, 68, 0.8)'
                    ],
                    borderColor: [
                        'rgba(16, 185, 129, 1)',
                        'rgba(59, 130, 246, 1)',
                        'rgba(251, 191, 36, 1)',
                        'rgba(239, 68, 68, 1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 15, usePointStyle: true }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(26, 26, 26, 0.95)',
                        titleColor: '#dc2626',
                        bodyColor: '#fff',
                        borderColor: '#dc2626',
                        borderWidth: 1,
                        padding: 12
                    }
                },
                cutout: '65%'
            }
        });

        // Category Performance Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        const categoryChart = new Chart(categoryCtx, {
            type: 'bar',
            data: {
                labels: chartData.categoryPerformance.labels || [],
                datasets: [{
                    label: 'Revenue (₱)',
                    data: chartData.categoryPerformance.data || [],
                    backgroundColor: 'rgba(220, 38, 38, 0.8)',
                    borderColor: '#dc2626',
                    borderWidth: 2,
                    borderRadius: 8,
                    barThickness: 40
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(26, 26, 26, 0.95)',
                        titleColor: '#dc2626',
                        bodyColor: '#fff',
                        borderColor: '#dc2626',
                        borderWidth: 1,
                        padding: 12,
                        displayColors: false,
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
                        grid: { color: 'rgba(255, 255, 255, 0.05)' },
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

        // Daily Orders Chart
        const dailyOrdersCtx = document.getElementById('dailyOrdersChart').getContext('2d');
        const dailyOrdersChart = new Chart(dailyOrdersCtx, {
            type: 'bar',
            data: {
                labels: chartData.dailyOrders.labels || [],
                datasets: [{
                    label: 'Orders',
                    data: chartData.dailyOrders.data || [],
                    backgroundColor: function(context) {
                        const chart = context.chart;
                        const {ctx, chartArea} = chart;
                        if (!chartArea) return 'rgba(220, 38, 38, 0.8)';
                        
                        const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                        gradient.addColorStop(0, 'rgba(220, 38, 38, 0.4)');
                        gradient.addColorStop(1, 'rgba(220, 38, 38, 0.9)');
                        return gradient;
                    },
                    borderColor: '#dc2626',
                    borderWidth: 2,
                    borderRadius: 8,
                    barThickness: 35
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(26, 26, 26, 0.95)',
                        titleColor: '#dc2626',
                        bodyColor: '#fff',
                        borderColor: '#dc2626',
                        borderWidth: 1,
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' orders';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(255, 255, 255, 0.05)' },
                        ticks: { stepSize: 5 }
                    },
                    x: { grid: { display: false } }
                }
            }
        });

        // Period selector
        document.getElementById('salesPeriod').addEventListener('change', function() {
            console.log('Period changed to:', this.value + ' months');
        });
    </script>
</body>
</html>