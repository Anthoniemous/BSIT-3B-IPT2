<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product – Brew Haven Coffee</title>
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <header class="bg-white shadow p-4">
        <h2 class="font-semibold text-xl text-gray-800 text-center">
            Edit Product – Brew Haven Coffee
        </h2>
    </header>

    <main class="container mx-auto mt-6">
        <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
            <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Product Name -->
                <div class="mb-4">
                    <label class="block text-gray-800 font-semibold mb-2">Product Name</label>
                    <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}" class="w-full p-2 border rounded">
                    @error('product_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label class="block text-gray-800 font-semibold mb-2">Description</label>
                    <textarea name="description" class="w-full p-2 border rounded">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                    @enderror
                </div>

                <!-- Price -->
                <div class="mb-4">
                    <label class="block text-gray-800 font-semibold mb-2">Price</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="w-full p-2 border rounded">
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div class="mb-4">
                    <label class="block text-gray-800 font-semibold mb-2">Category</label>
                    <select name="category" class="w-full p-2 border rounded">
                        <option value="" disabled>-- Select Category --</option>
                        <option value="Coffee" {{ old('category', $product->category) == 'Coffee' ? 'selected' : '' }}>Coffee</option>
                        <option value="Beverage" {{ old('category', $product->category) == 'Beverage' ? 'selected' : '' }}>Beverage</option>
                        <option value="Snack" {{ old('category', $product->category) == 'Snack' ? 'selected' : '' }}>Snack</option>
                        <option value="Merchandise" {{ old('category', $product->category) == 'Merchandise' ? 'selected' : '' }}>Merchandise</option>
                    </select>
                    @error('category')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Brand -->
                <div class="mb-4">
                    <label class="block text-gray-800 font-semibold mb-2">Brand</label>
                    <select name="brand" class="w-full p-2 border rounded">
                        <option value="" disabled>-- Select Brand --</option>
                        <option value="Brew Haven" {{ old('brand', $product->brand) == 'Brew Haven' ? 'selected' : '' }}>Brew Haven</option>
                        <option value="Brew Masters" {{ old('brand', $product->brand) == 'Brew Masters' ? 'selected' : '' }}>Brew Masters</option>
                        <option value="Coffee Lovers" {{ old('brand', $product->brand) == 'Coffee Lovers' ? 'selected' : '' }}>Coffee Lovers</option>
                        <option value="Bean & Cup" {{ old('brand', $product->brand) == 'Bean & Cup' ? 'selected' : '' }}>Bean & Cup</option>
                    </select>
                    @error('brand')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current Image -->
                <div class="mb-4">
                    <label class="block text-gray-800 font-semibold mb-2">Current Image</label>
                    <img src="{{ asset('storage/'.$product->image) }}" width="100" class="mb-2 rounded">
                </div>

                <!-- Upload New Image -->
                <div class="mb-4">
                    <label class="block text-gray-800 font-semibold mb-2">Change Image</label>
                    <input type="file" name="image" class="w-full p-2 border rounded">
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-between">
                    <a href="{{ route('products.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancel</a>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update Product</button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>
