<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-fern-green/40">
                <div class="p-8 text-white-200">
                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="bg-mindaro border border-asparagus text-dark-green px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                        <!-- Product Name -->
                        <div class="mb-4">
                            <label for="product_name" class="block text-cal-poly-green text-sm font-semibold mb-2">Product Name</label>
                            <input type="text" name="product_name" id="product_name" value="{{ old('product_name') }}"
                                class="bg-white border border-asparagus/40 rounded-lg w-full py-3 px-4 text-black
                                       focus:outline-none focus:ring-2 focus:ring-fern-green focus:border-fern-green transition">
                            @error('product_name')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="brand" class="block text-cal-poly-green text-sm font-semibold mb-2">Brand</label>
                            <input type="text" name="brand" id="brand" value="{{ old('brand', $product->brand ?? '') }}"
                                class="bg-white border border-asparagus/40 rounded-lg w-full py-3 px-4 text-black
                                    focus:outline-none focus:ring-2 focus:ring-fern-green focus:border-fern-green transition 
                                    @error('brand') border-red-500 @enderror" required>
                            @error('brand')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div class="mb-4">
                            <label for="category" class="block text-cal-poly-green text-sm font-semibold mb-2">Category</label>
                            <input type="text" name="category" id="category" value="{{ old('category') }}"
                                class="bg-white border border-asparagus/40 rounded-lg w-full py-3 px-4 text-black
                                       focus:outline-none focus:ring-2 focus:ring-fern-green focus:border-fern-green transition">
                            @error('category')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div class="mb-4">
                            <label for="price" class="block text-cal-poly-green text-sm font-semibold mb-2">Price</label>
                            <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}"
                                class="bg-white border border-asparagus/40 rounded-lg w-full py-3 px-4 text-black
                                       focus:outline-none focus:ring-2 focus:ring-fern-green focus:border-fern-green transition">
                            @error('price')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stock Quantity -->
                        <div class="mb-4">
                            <label for="stock_quantity" class="block text-cal-poly-green text-sm font-semibold mb-2">Stock Quantity</label>
                            <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity') }}"
                                class="bg-white border border-asparagus/40 rounded-lg w-full py-3 px-4 text-black
                                       focus:outline-none focus:ring-2 focus:ring-fern-green focus:border-fern-green transition">
                            @error('stock_quantity')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label for="description" class="block text-cal-poly-green text-sm font-semibold mb-2">Description</label>
                            <textarea name="description" id="description" rows="4"
                                class="bg-white border border-asparagus/40 rounded-lg w-full py-3 px-4 text-black
                                       focus:outline-none focus:ring-2 focus:ring-fern-green focus:border-fern-green transition">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Product Image -->
                            <div class="mb-6">
                                <label for="product_image" class="block text-cal-poly-green text-sm font-semibold mb-2">Product Image</label>
                                <input type="file" name="product_image" id="product_image"
                                    class="bg-white border border-asparagus/40 rounded-lg w-full py-3 px-4 text-black
                                            focus:outline-none focus:ring-2 focus:ring-fern-green focus:border-fern-green transition">
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
                                       shadow-md border border-fern-green 
                                       transition duration-300 transform hover:scale-105">
                                Create Product
                            </button>

                            <a href="{{ route('admin.products.index') }}"
                               class="bg-white hover:bg-mindaro text-dark-green font-semibold py-3 px-6 rounded-lg 
                                      border border-asparagus/60 transition duration-300">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>