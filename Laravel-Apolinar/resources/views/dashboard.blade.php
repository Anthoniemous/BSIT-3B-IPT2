<x-app-layout>
    <x-slot name="header">
        
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          <link rel="stylesheet" href="{{ asset('css/admindashboard.css') }}">
            
      <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
       <a href="{{ route('orders.index') }}" class="btn btn-primary">View Orders</a>

        </h2>
    </x-slot>

   <div class="table-container">
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
                        <button class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

    
</x-app-layout>
