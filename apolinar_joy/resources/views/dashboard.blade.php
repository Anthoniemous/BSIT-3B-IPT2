<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-pink-600 leading-tight">
            <link rel="stylesheet" href="{{ asset('css/admindashboard.css') }}">
            <span class="header-title">💖 Glamour Makeup Store – Admin Dashboard</span>
            <a href="{{ route('products.create') }}" class="btn add-btn">+ Add Product</a>
             <a href="{{ route('admin.orders') }}" class="btn">View All Orders</a>
        </h2>
    </x-slot>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
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
                    <td>₱{{ number_format($product->price, 2) }}</td>
                    <td>
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}">
                    </td>
                    <td class="actions">
                        <a href="{{ route('products.edit', $product) }}" class="btn edit-btn">Edit</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
