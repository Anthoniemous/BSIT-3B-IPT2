<x-app-layout>
    <x-slot name="header">
        <link rel="stylesheet" href="{{ asset('css/admindashboard.css') }}">
        <h2 class="font-semibold text-xl leading-tight">
            <a href="{{ route('products.create') }}" class="btn">Add Product</a>
            <a href="{{ route('admin.orders') }}" class="btn">View All Orders</a>
        </h2>
    </x-slot>

    <div class="table-container">
        <!-- Sort Dropdown -->
        <form method="GET" action="{{ route('products.index') }}" style="margin-bottom: 15px;">
            <label for="sort">Sort By:</label>
            <select name="sort" id="sort" onchange="this.form.submit()">
                <option value="">Featured</option>
                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                <option value="price_low_high" {{ request('sort') == 'price_low_high' ? 'selected' : '' }}>Price (Low-High)</option>
                <option value="price_high_low" {{ request('sort') == 'price_high_low' ? 'selected' : '' }}>Price (High-Low)</option>
            </select>
        </form>

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
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}">
                        @else
                            No Image
                        @endif
                    </td>
                    <td class="actions">
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
