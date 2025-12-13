<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
     <link rel="stylesheet" href="{{ asset('css/dashboardview.css') }}">
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
            <div class="header">
                <h1>Dashboard Overview</h1>
                <p>Welcome back! Here's what's happening with your store today.</p>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <span class="stat-card-title">Total Orders</span>
                        <span class="stat-card-icon bg-blue">📦</span>
                    </div>
                    <div class="stat-card-value">{{ number_format($totalOrders) }}</div>
                    <div class="stat-card-change {{ $ordersGrowth >= 0 ? '' : 'negative' }}">
                        {{ $ordersGrowth >= 0 ? '↑' : '↓' }} {{ abs($ordersGrowth) }}% from last month
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <span class="stat-card-title">Total Sales</span>
                        <span class="stat-card-icon bg-green">💰</span>
                    </div>
                    <div class="stat-card-value">₱{{ number_format($totalSales, 2) }}</div>
                    <div class="stat-card-change {{ $salesGrowth >= 0 ? '' : 'negative' }}">
                        {{ $salesGrowth >= 0 ? '↑' : '↓' }} {{ abs($salesGrowth) }}% from last month
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <span class="stat-card-title">Cancelled Orders</span>
                        <span class="stat-card-icon bg-red">❌</span>
                    </div>
                    <div class="stat-card-value">{{ number_format($cancelledOrders) }}</div>
                    <div class="stat-card-change">
                        {{ $totalOrders > 0 ? round(($cancelledOrders / $totalOrders) * 100, 1) : 0 }}% cancellation rate
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <span class="stat-card-title">Active Products</span>
                        <span class="stat-card-icon bg-purple">🏷️</span>
                    </div>
                    <div class="stat-card-value">{{ number_format($activeProducts) }}</div>
                    <div class="stat-card-change">Available in store</div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="content-grid">
                <!-- Recent Orders -->
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

                <!-- Recent Activity -->
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

            <!-- Product Performance -->
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
</body>
</html>