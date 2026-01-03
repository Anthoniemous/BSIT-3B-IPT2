<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.products.update', $product->product_id) }}" method="POST" enctype="multipart/form-data">

                @csrf
                        @method('PUT')

                        <!-- Admin ID (Hidden) -->
                        <input type="hidden" name="admin_id" value="{{ $product->admin_id }}">

                        <!-- Product Name -->
                        <div class="mb-4">
                            <label for="product_name" class="block text-gray-700 text-sm font-bold mb-2">Product Name</label>
                            <input type="text" name="product_name" id="product_name" value="{{ old('product_name', $product->product_name) }}" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('product_name') border-red-500 @enderror" required>
                            @error('product_name')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Brand -->
                        <div class="mb-4">
                            <label for="brand" class="block text-gray-700 text-sm font-bold mb-2">Brand</label>
                            <input type="text" name="brand" id="brand" value="{{ old('brand', $product->brand ?? '') }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('brand') border-red-500 @enderror" required>
                            @error('brand')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div class="mb-4">
                            <label for="category" class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                            <input type="text" name="category" id="category" value="{{ old('category', $product->category) }}" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('category') border-red-500 @enderror" required>
                            @error('category')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div class="mb-4">
                            <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Price</label>
                            <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $product->price) }}" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('price') border-red-500 @enderror" required>
                            @error('price')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stock Quantity -->
                        <div class="mb-4">
                            <label for="stock_quantity" class="block text-gray-700 text-sm font-bold mb-2">Stock Quantity</label>
                            <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('stock_quantity') border-red-500 @enderror" required>
                            @error('stock_quantity')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                            <textarea name="description" id="description" rows="4" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Product Image -->
                        <div class="mb-4">
                            <label for="product_image" class="block text-gray-700 text-sm font-bold mb-2">Product Image</label>
                            
                            @if($product->product_image)
                                <img src="{{ asset('storage/products/' . $product->product_image) }}" class="w-24 h-24 object-cover rounded mb-2">
                            @endif

                            <input type="file" name="product_image" id="product_image"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            
                            @error('product_image')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>


                        <!-- Buttons -->
                        <div class="flex items-center justify-between">
                            <button type="submit" 
                                class="bg-gradient-to-r from-asparagus via-fern-green to-cal-poly-green 
                                        hover:from-fern-green hover:to-dark-green
                                        text-white font-semibold py-3 px-6 rounded-lg 
                                        shadow-md border border-[#d4af37] 
                                        transition duration-300 transform hover:scale-105">
                                        Update Product
                            </button>
                            <a href="{{ route('admin.products.index') }}" 
                            class="bg-white hover:bg-gray-100 text-black font-semibold py-3 px-6 rounded-lg 
                                    border border-[#d4af37]/60 transition duration-300">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>