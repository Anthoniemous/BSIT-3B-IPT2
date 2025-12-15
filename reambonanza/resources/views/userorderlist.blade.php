<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Management - Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/productsdashboard.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="logo">
                <h1>ADMIN<span>HUB</span></h1>
            </div>
            <nav class="nav-menu">
                <a href="{{ route('dashboard') }}" class="nav-item">
                    <span class="icon">📊</span>
                    <span>Analytics</span>
                </a>
                <a href="{{ route('admin.products.dashboard') }}" class="nav-item">
                    <span class="icon">📦</span>
                    <span>Products</span>
                </a>
                <a href="{{ route('admin.orders') }}" class="nav-item active">
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
                    <h1 class="page-title">Orders Management</h1>
                    <p class="page-subtitle">View and manage all customer orders</p>
                </div>
                <div class="header-stats">
                    <div class="stat-badge">
                        <span class="stat-number">{{ $orders->count() }}</span>
                        <span class="stat-label">Total Orders</span>
                    </div>
                </div>
            </header>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- Orders Section -->
            @if($orders->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">🛒</div>
                    <h2>No Orders Yet</h2>
                    <p>Orders will appear here once customers start purchasing</p>
                </div>
            @else
                <!-- Filter Options -->
                <div class="filters-container">
                    <div class="filter-group">
                        <label for="statusFilter">Filter by Status:</label>
                        <select id="statusFilter" class="filter-select" onchange="filterOrders()">
                            <option value="all">All Orders</option>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="search-group">
                        <input type="text" id="searchInput" class="search-input" placeholder="Search by name or order ID..." onkeyup="searchOrders()">
                    </div>
                </div>

                <!-- Orders Table -->
                <section class="orders-section">
                    <div class="orders-table-container">
                        <table class="orders-table" id="ordersTable">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Contact</th>
                                    <th>Date</th>
                                    <th>Products</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    @php
                                        // Group items by PRODUCT + SIZE + PRICE
                                        $grouped = $order->items->groupBy(function($item) {
                                            return $item->product_id . '-' . ($item->size ?? 'N/A') . '-' . $item->product->price;
                                        });

                                        // Compute Total
                                        $finalTotal = $grouped->sum(function($items) {
                                            return $items->first()->product->price * $items->sum('quantity');
                                        });
                                    @endphp

                                    <tr data-status="{{ strtolower($order->status) }}" data-search="{{ strtolower($order->name . ' ' . $order->order_id) }}">
                                        <td><strong>#{{ str_pad($order->order_id, 5, '0', STR_PAD_LEFT) }}</strong></td>
                                        <td>
                                            <div class="customer-info">
                                                <strong>{{ $order->name }}</strong>
                                                <small>{{ $order->address }}</small>
                                            </div>
                                        </td>
                                        <td>{{ $order->contact_number }}</td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <button class="view-items-btn" onclick="viewOrderItems({{ $order->order_id }})">
                                                {{ $order->items->count() }} item(s)
                                            </button>
                                        </td>
                                        <td><strong>₱{{ number_format($finalTotal, 2) }}</strong></td>
                                        <td>
                                            <span class="status-badge {{ strtolower($order->status) }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
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
            @endif
        </main>
    </div>

    <!-- Modal for Order Items -->
    <div id="orderModal" class="modal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeModal()">&times;</span>
            <h2>Order Details</h2>
            <div id="orderItemsContent"></div>
        </div>
    </div>

    <script>
        // Store orders data for modal
        const ordersData = {!! json_encode($orders) !!};

        // Filter Orders by Status
        function filterOrders() {
            const filter = document.getElementById('statusFilter').value;
            const rows = document.querySelectorAll('#ordersTable tbody tr');
            
            rows.forEach(row => {
                const status = row.dataset.status;
                if (filter === 'all' || status === filter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Search Orders
        function searchOrders() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#ordersTable tbody tr');
            
            rows.forEach(row => {
                const searchData = row.dataset.search;
                if (searchData.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // View Order Items Modal
        function viewOrderItems(orderId) {
            const order = ordersData.find(o => o.order_id === orderId);
            
            if (!order) return;

            // Group items
            const grouped = {};
            order.items.forEach(item => {
                const key = `${item.product_id}-${item.size || 'N/A'}-${item.product.price}`;
                if (!grouped[key]) {
                    grouped[key] = {
                        product: item.product,
                        size: item.size || 'N/A',
                        quantity: 0,
                        price: item.product.price
                    };
                }
                grouped[key].quantity += item.quantity;
            });

            let itemsHtml = '<table class="modal-table"><thead><tr><th>Product</th><th>Size</th><th>Quantity</th><th>Price</th><th>Subtotal</th></tr></thead><tbody>';
            
            let total = 0;
            Object.values(grouped).forEach(item => {
                const subtotal = item.quantity * item.price;
                total += subtotal;
                itemsHtml += `
                    <tr>
                        <td>${item.product.product_name}</td>
                        <td>${item.size}</td>
                        <td>${item.quantity}</td>
                        <td>₱${parseFloat(item.price).toFixed(2)}</td>
                        <td>₱${subtotal.toFixed(2)}</td>
                    </tr>
                `;
            });
            
            itemsHtml += `
                <tr class="total-row">
                    <td colspan="4" style="text-align: right;"><strong>Total:</strong></td>
                    <td><strong>₱${total.toFixed(2)}</strong></td>
                </tr>
            `;
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

    <style>
        /* Additional styles for orders page */
        .header-stats {
            display: flex;
            gap: 1rem;
        }

        .stat-badge {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1rem 2rem;
            background: rgba(255, 107, 107, 0.1);
            border: 2px solid var(--primary);
            border-radius: 12px;
        }

        .stat-number {
            font-family: var(--font-display);
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
        }

        .stat-label {
            font-size: 0.85rem;
            color: rgba(248, 249, 250, 0.6);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 0.5rem;
        }

        .orders-section {
            background: rgba(26, 26, 46, 0.6);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 107, 107, 0.1);
            border-radius: var(--radius-lg);
            padding: 2rem;
        }

        .search-group {
            flex: 1;
        }

        .search-input {
            width: 100%;
            padding: 0.75rem 1.5rem;
            background: rgba(26, 26, 46, 0.8);
            border: 2px solid rgba(255, 107, 107, 0.2);
            color: var(--light);
            border-radius: 8px;
            font-family: var(--font-mono);
            font-weight: 500;
            transition: var(--transition);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary);
        }

        .search-input::placeholder {
            color: rgba(248, 249, 250, 0.4);
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .filter-group label {
            color: rgba(248, 249, 250, 0.8);
            font-weight: 600;
            white-space: nowrap;
        }

        .total-row {
            border-top: 2px solid var(--primary);
            background: rgba(255, 107, 107, 0.05);
        }

        .total-row td {
            padding: 1rem !important;
            font-size: 1.1rem;
        }

        .alert-danger {
            background: rgba(255, 87, 87, 0.1);
            border: 2px solid var(--danger);
            color: var(--danger);
            padding: 1rem 1.5rem;
            border-radius: var(--radius);
            margin-bottom: 2rem;
            font-weight: 500;
            animation: slideIn 0.4s ease;
        }
    </style>
</body>
</html>