<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/admindashboard.css') }}">
    
</head>
<body>

    <!-- 🔶 Header Section -->
    <header class="dashboard-header">
        <div class="header-content">
            
            <!-- 🧡 Left: Title -->
            <div class="header-left">
                <h1>Admin Dashboard</h1>
            </div>

            <!-- 💛 Center: Buttons -->
            <div class="header-buttons">
                <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
                <a href="{{ route('admin.orders') }}" class="btn btn-primary">View All Orders</a>
            </div>

            <!-- ❤️ Right: Logout -->
            <div class="header-right">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-logout">Logout</button>
                </form>
            </div>

        </div>
    </header>

    <!-- 📋 Table Section -->
    <main class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td><img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}"></td>
                    <td>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>

</body>
</html>
