<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Orders</title>
    <style>
        /* Background Image */
        body {
            font-family: Arial, sans-serif;
            background: url('/css/img/background.jpg') no-repeat center center fixed;
            background-size: cover;
            padding: 20px;
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: auto;
            background: rgba(255, 255, 255, 0.95); /* Slight transparency to see bg */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .page-title {
            font-size: 2rem;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Flash messages */
        .alert {
            padding: 10px 15px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .alert-success { background-color: #d4edda; color: #155724; }
        .alert-danger { background-color: #f8d7da; color: #721c24; }

        /* Table styling */
        .order-table {
            overflow-x: auto;
        }

        .order-table table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.95rem;
        }

        .order-table th, .order-table td {
            border: 1px solid #ddd;
            padding: 12px 10px;
            text-align: left;
        }

        .order-table th {
            background-color: #220101ff;
            color: #fff;
            position: sticky;
            top: 0;
        }

        .order-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .order-table tr:hover {
            background-color: #e9f5ff;
        }

        /* Status badges */
        .status {
            padding: 4px 10px;
            border-radius: 4px;
            color: #fff;
            font-weight: bold;
            display: inline-block;
        }
        .status.pending { background-color: orange; }
        .status.completed { background-color: green; }

        /* Buttons */
        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            transition: background 0.3s;
        }

        .btn:hover { background-color: #0056b3; }
        .btn-secondary { background-color: #6c757d; }
        .btn-secondary:hover { background-color: #545b62; }

        .mt-4 { margin-top: 20px; }

        /* Responsive */
        @media (max-width: 768px) {
            .order-table table, .order-table th, .order-table td {
                font-size: 0.85rem;
            }
            
        }
        .pagination-container {
  margin-top: 20px;
  text-align: center;
}

.pagination-info {
  font-weight: 500;
  margin-bottom: 8px;
}

.pagination {
  display: inline-flex;
  justify-content: center;
}

.pagination .page-link {
  color: #b30000;
  border: 1px solid #b30000;
}

.pagination .page-item.active .page-link {
  background-color: #b30000;
  border-color: #b30000;
  color: #fff;
}

        
    </style>
</head>
<body>

<div class="container">
    <h1 class="page-title">Customer Orders 🧾</h1>

    <!-- Flash Messages -->
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

    <!-- Orders Table -->
    <div class="order-table">
        <table>
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

     <!-- Pagination -->
    <div class="pagination-container text-center">
        <p class="pagination-info mb-2">Showing 1 to 2 of 2 results</p>
        <nav class="pagination-links d-inline-block">
            <ul class="pagination justify-content-center mb-0">
                <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </div>

   <div class="mt-4">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">← Back to Dashboard</a>
    </div>
</div>

</body>
</html>
