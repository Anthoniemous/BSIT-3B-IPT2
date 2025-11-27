<x-app-layout>
    <x-slot name="header">
        <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-6">
        <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
            <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Product Name -->
                <div class="mb-4">
                    <label class="block text-gray-800 font-semibold mb-2">Product Name</label>
                    <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}" class="w-full p-2 border rounded">
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label class="block text-gray-800 font-semibold mb-2">Description</label>
                    <textarea name="description" class="w-full p-2 border rounded">{{ old('description', $product->description) }}</textarea>
                </div>

                <!-- Price -->
                <div class="mb-4">
                    <label class="block text-gray-800 font-semibold mb-2">Price</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="w-full p-2 border rounded">
                </div>

                <!-- Category -->
                <div class="mb-4">
                    <label class="block text-gray-800 font-semibold mb-2">Category</label>
                    <select name="category" class="w-full p-2 border rounded">
                        <option disabled>-- Select Category --</option>

                        <option value="Cosmetics" {{ $product->category == 'Cosmetics' ? 'selected' : '' }}>Cosmetics</option>
                        <option value="Makeup" {{ $product->category == 'Makeup' ? 'selected' : '' }}>Makeup</option>
                        <option value="Skin Care" {{ $product->category == 'Skin Care' ? 'selected' : '' }}>Skin Care</option>
                        <option value="Package" {{ $product->category == 'Package' ? 'selected' : '' }}>Package</option>
                    </select>
                </div>

                <!-- Brand -->
                <div class="mb-4">
                    <label class="block text-gray-800 font-semibold mb-2">Brand</label>
                    <select name="brand" class="w-full p-2 border rounded">
                        <option disabled>-- Select Brand --</option>

                        <option value="Mary" {{ $product->brand == 'Mary' ? 'selected' : '' }}>Mary</option>
                        <option value="MakeupX" {{ $product->brand == 'MakeupX' ? 'selected' : '' }}>MakeupX</option>
                        <option value="BeautyPlus" {{ $product->brand == 'BeautyPlus' ? 'selected' : '' }}>BeautyPlus</option>
                        <option value="GlowUp" {{ $product->brand == 'GlowUp' ? 'selected' : '' }}>GlowUp</option>
                    </select>
                </div>

                <!-- Current Image -->
                <div class="mb-4">
                    <label class="block text-gray-800 font-semibold mb-2">Current Image</label>
                    <img src="{{ asset('storage/'.$product->image) }}" width="100" class="mb-2">
                </div>

                <!-- Upload New Image -->
                <div class="mb-4">
                    <label class="block text-gray-800 font-semibold mb-2">Change Image</label>
                    <input type="file" name="image" class="w-full p-2 border rounded">
                </div>

                <div class="flex justify-between">
                    <a href="{{ route('products.index') }}" class="btn bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancel</a>
                    <button type="submit" class="btn bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update Product</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
