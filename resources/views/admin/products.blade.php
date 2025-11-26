@extends('admin.admin')
@section('main')

<div x-data="productDashboard()" class="space-y-6">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Products</h2>
        <button @click="addModal = true"
            class="px-5 py-2 bg-green-600 text-white font-semibold rounded-full hover:bg-green-700 transition shadow-md">
            + Add Product
        </button>
    </div>

    {{-- Product Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <template x-for="p in filteredProducts()" :key="p.product_id">
            <div class="border rounded-xl overflow-hidden shadow-md hover:shadow-lg transition relative bg-white">
                
                <!-- Product Image -->
                <div class="relative w-full h-56 overflow-hidden">
                    <img :src="p.image ? `/storage/${p.image}` : '/images/default.png'"
                         alt="Product Image"
                         class="object-cover w-full h-full transition-transform duration-300 hover:scale-105">
                </div>

                <!-- Product Info -->
                <div class="p-4 text-center">
                    <h3 class="text-lg font-semibold text-gray-800" x-text="p.name"></h3>
                    <p class="text-gray-500 text-sm mt-1" x-text="p.description"></p>
                    <p class="text-blue-600 font-bold mt-2" x-text="`$${parseFloat(p.price).toFixed(2)}`"></p>
                    <p class="text-sm text-gray-500 mt-1">Stock: <span x-text="p.stock"></span></p>
                    <p class="text-sm text-gray-500 mt-1">Category: <span x-text="p.category"></span></p>
                    <p class="text-sm text-gray-500 mt-1">Brand: <span x-text="p.brand"></span></p>
                </div>

                <!-- Action Buttons -->
                <div class="p-4 pt-0 flex justify-center gap-3">
                    <button @click="openEditModal(p)"
                        class="flex items-center gap-2 px-4 py-2 bg-green-500 text-white text-sm font-semibold rounded-full hover:bg-green-600 transition shadow-sm">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <form :action="`{{ url('admin/products/destroy') }}/${p.product_id}`" method="POST"
                          class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('Are you sure you want to delete this product?')"
                                class="flex items-center gap-2 px-4 py-2 bg-red-500 text-white text-sm font-semibold rounded-full hover:bg-red-600 transition shadow-sm">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </template>
    </div>

    {{-- Add Product Modal --}}
    <div x-show="addModal"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div @click.away="addModal = false"
             class="bg-white text-gray-900 p-6 rounded-2xl shadow-xl w-96">
            <h2 class="text-2xl font-bold mb-5 text-green-600 text-center">Add New Product</h2>
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="block font-semibold mb-1">Category</label>
                    <input type="text" name="category" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400" required>
                </div>

                <div class="mb-3">
                    <label class="block font-semibold mb-1">Brand</label>
                    <input type="text" name="brand" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400" required>
                </div>

                <div class="mb-3">
                    <label class="block font-semibold mb-1">Product Name</label>
                    <input type="text" name="name" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400" required>
                </div>

                <div class="mb-3">
                    <label class="block font-semibold mb-1">Description</label>
                    <input type="text" name="description" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400" required>
                </div>

                <div class="mb-3">
                    <label class="block font-semibold mb-1">Price</label>
                    <input type="number" step="0.01" name="price" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400" required>
                </div>

                <div class="mb-3">
                    <label class="block font-semibold mb-1">Stock</label>
                    <input type="number" name="stock" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400" required>
                </div>

                <div class="mb-3">
                    <label class="block font-semibold mb-1">Image</label>
                    <input type="file" name="image" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400" accept="image/*">
                </div>

                <div class="flex justify-end gap-3 mt-5">
                    <button type="button" @click="addModal = false"
                        class="px-5 py-2 bg-gray-300 text-gray-700 rounded-full hover:bg-gray-400 transition font-semibold">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-5 py-2 bg-green-600 text-white rounded-full hover:bg-green-700 transition font-semibold">
                        Add Product
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Product Modal --}}
    <div x-show="editModal"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div @click.away="editModal = false"
             class="bg-white text-gray-900 p-6 rounded-2xl shadow-xl w-96">
            <h2 class="text-2xl font-bold mb-5 text-green-600 text-center">Edit Product</h2>
            <form :action="`{{ url('admin/products/update') }}/${selected.product_id}`" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="block font-semibold mb-1">Category</label>
                    <input type="text" name="category" x-model="selected.category"
                           class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400" required>
                </div>

                <div class="mb-3">
                    <label class="block font-semibold mb-1">Brand</label>
                    <input type="text" name="brand" x-model="selected.brand"
                           class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400" required>
                </div>

                <div class="mb-3">
                    <label class="block font-semibold mb-1">Product Name</label>
                    <input type="text" name="name" x-model="selected.name"
                           class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400" required>
                </div>

                <div class="mb-3">
                    <label class="block font-semibold mb-1">Description</label>
                    <input type="text" name="description" x-model="selected.description"
                           class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400" required>
                </div>

                <div class="mb-3">
                    <label class="block font-semibold mb-1">Price</label>
                    <input type="number" step="0.01" name="price" x-model="selected.price"
                           class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400" required>
                </div>

                <div class="mb-3">
                    <label class="block font-semibold mb-1">Stock</label>
                    <input type="number" name="stock" x-model="selected.stock"
                           class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400" required>
                </div>

                <div class="mb-3">
                    <label class="block font-semibold mb-1">Change Image (optional)</label>
                    <input type="file" name="image" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400" accept="image/*">
                </div>

                <div class="flex justify-end gap-3 mt-5">
                    <button type="button" @click="editModal = false"
                        class="px-5 py-2 bg-gray-300 text-gray-700 rounded-full hover:bg-gray-400 transition font-semibold">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-5 py-2 bg-green-600 text-white rounded-full hover:bg-green-700 transition font-semibold">
                        Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
function productDashboard() {
    return {
        search: '',
        products: @json($products),
        addModal: false,
        editModal: false,
        selected: {},
        filteredProducts() {
            if (!this.search) return this.products;
            return this.products.filter(p =>
                p.name.toLowerCase().includes(this.search.toLowerCase()) ||
                p.description.toLowerCase().includes(this.search.toLowerCase())
            );
        },
        openAddModal() { this.addModal = true },
        openEditModal(product) { this.selected = { ...product }; this.editModal = true }
    }
}
</script>
@endsection
