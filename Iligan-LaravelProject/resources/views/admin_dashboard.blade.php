<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>PAWer Admin Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  @vite(['resources/js/admin_dropdown.js', 'resources/js/dropdown.js'])
</head>
<body class="bg-gray-100">

  <!-- MAIN CONTAINER -->
  <div class="flex h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-orange-600 text-white flex flex-col">
      <div class="p-5 flex items-center space-x-2 border-b border-orange-700">
        <img src="{{ asset('images/Logo.png') }}" alt="Cart Logo" class="w-14">
        <div>
          <h1 class="text-xl font-bold">PAWer</h1>
          <p class="text-sm">Happy pet, happy life</p>
        </div>
      </div>

      <nav class="flex-1 overflow-y-auto p-4 space-y-2">
        <div>
          <button id="productsDropdownBtn" class="w-full flex justify-between items-center text-left py-2 px-3 hover:bg-orange-700 rounded">
            <span class="font-semibold">Products</span>
            <i id="productsArrow" class="fas fa-chevron-down text-sm transition-transform duration-200"></i>
          </button>
          <div id="productsDropdown" class="ml-5 mt-1 space-y-1 hidden">
            <a href="#" class="block hover:text-orange-200">Collars</a>
            <a href="#" class="block hover:text-orange-200">Leashes</a>
            <a href="#" class="block hover:text-orange-200">Beds and Comforts</a>
            <a href="#" class="block hover:text-orange-200">Food and Drinks</a>
            <a href="#" class="block hover:text-orange-200">Toys</a>
            <a href="#" class="block hover:text-orange-200">Clothing</a>
          </div>
        </div>

        <a href="#" class="block py-2 px-3 hover:bg-orange-700 rounded">Users</a>
        <a href="#" class="block py-2 px-3 hover:bg-orange-700 rounded">Transactions</a>
      </nav>
    </aside>

    <!-- CONTENT AREA -->
    <main class="flex-1 flex flex-col">

      <!-- TOP BAR -->
      <header class="bg-gray-800 text-white flex items-center justify-end px-6 py-3 space-x-4">
        <!-- SEARCH BAR -->
        <div class="flex items-center">
            <input 
            type="text" 
            placeholder="Search for products..." 
            class="w-64 px-3 py-2 rounded-l bg-gray-100 text-black focus:outline-none"
            >
            <button class="bg-orange-600 px-4 py-2 rounded-r hover:bg-orange-700">
            <i class="fas fa-search"></i>
            </button>
        </div>

        <!-- USER DROPDOWN -->
        <div class="relative" id="user-dropdown-wrapper">
            <!-- User Icon Button -->
            <button 
            id="user-dropdown-btn" 
            class="text-2xl focus:outline-none" 
            aria-haspopup="true" 
            aria-expanded="false" 
            type="button"
            >
            <i class="fa-solid fa-user"></i>
            </button>

            <!-- Dropdown Menu -->
            <div id="user-dropdown-menu" class="hidden absolute right-0 mt-2 w-36 bg-white text-gray-800 rounded-md shadow-lg border z-50">
                <a href="{{ route('admin_dashboard') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Profile</a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">
                        Logout
                    </button>
                </form>
            </div>
        </div>
      </header>

    <!-- PRODUCT SECTIONS -->
    <section class="p-6 overflow-y-auto">
        <div id="productsContainer" class="space-y-10">
            @foreach($categories as $category)
            <div id="category-{{ $category->category_id }}" class="category {{ Str::slug($category->name) }}" data-id="{{ $category->category_id }}">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold">{{ $category->name }}</h2>
                    <button class="add-btn bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700">Add {{ $category->name }}</button>
                </div>

                <div class="grid grid-cols-4 gap-6 min-h-[100px]">
                    @php
                        $allProducts = $category->products;
                    @endphp

                    @forelse($allProducts as $product)
                    @php
                        $isInactive = $product->status !== 'active';
                    @endphp
                    <div id="product-{{ $product->product_id }}" class="bg-white rounded-lg shadow p-3 {{ $isInactive ? 'opacity-50' : '' }}">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/default.jpg') }}" alt="{{ $product->name }}" class="w-full h-40 object-cover rounded">
                        <div class="mt-3">
                            <h3 class="font-semibold">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-500 mb-1">{{ $product->description }}</p>
                            <p class="text-sm">Quantity: <span class="font-semibold">{{ $product->quantity }}</span> left</p>
                            <p class="font-bold text-lg mt-1">${{ $product->unit_price }}</p>
                            <div class="flex gap-2 mt-3">
                                <button 
                                    class="flex-1 bg-orange-500 text-white py-1 rounded hover:bg-orange-600 edit-btn {{ $isInactive ? 'opacity-50 cursor-not-allowed' : '' }}" 
                                    data-product-id="{{ $product->product_id }}"
                                    data-category-id="{{ $category->category_id }}"
                                    data-name="{{ $product->name }}"
                                    data-description="{{ $product->description }}"
                                    data-quantity="{{ $product->quantity }}"
                                    data-unit-price="{{ $product->unit_price }}"
                                    {{ $isInactive ? 'disabled' : '' }}
                                >Edit</button>
                                <!--<button 
                                    class="flex-1 toggle-status-btn bg-gray-600 text-white py-1 rounded hover:bg-gray-700"
                                    data-product-id="{{ $product->product_id }}"
                                    data-status="{{ $product->status }}"
                                >
                                    {{ $product->status === 'active' ? 'Deactivate' : 'Activate' }}
                                </button>-->

                                <form method="POST" action="{{ route('admin.products.softDelete', $product->product_id) }}" class="flex-1">
                                    @csrf
                                    @method('PUT')
                                    <button 
                                        type="submit" 
                                        class="w-full bg-red-600 text-white py-1 rounded hover:bg-red-700"
                                        onclick="return confirm('Are you sure you want to delete this product?')"
                                    >
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                  @endforelse
                </div>
            </div>
            @endforeach
        </div>
    </section>


    </main>
  </div>

 <!-- ADD PRODUCT MODAL -->
<div id="addProductModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
    <div class="bg-white rounded-lg p-6 w-1/3">
        <h2 class="text-xl font-bold mb-4">Add Product</h2>
        <form id="addProductForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="category_id" id="modalCategoryId">
            <input type="hidden" name="product_id" id="modalProductId">
            
            <div class="mb-3">
                <label class="block mb-1">Name</label>
                <input type="text" name="name" class="w-full border px-3 py-2 rounded" required>
            </div>
            <div class="mb-3">
                <label class="block mb-1">Description</label>
                <textarea name="description" class="w-full border px-3 py-2 rounded"></textarea>
            </div>
            <div class="mb-3">
                <label class="block mb-1">Quantity</label>
                <input type="number" name="quantity" class="w-full border px-3 py-2 rounded" required>
            </div>
            <div class="mb-3">
                <label class="block mb-1">Unit Price</label>
                <input type="number" step="0.01" name="unit_price" class="w-full border px-3 py-2 rounded" required>
            </div>
            <div class="mb-3">
                <label class="block mb-1">Image</label>
                <input type="file" name="image" class="w-full">
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" id="closeModalBtn" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700">Add Product</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('addProductModal');
    const form = document.getElementById('addProductForm');
    const modalCategoryId = document.getElementById('modalCategoryId');
    const modalProductId = document.getElementById('modalProductId');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const searchInput = document.querySelector('input[placeholder="Search for products..."]');
    const searchBtn = document.querySelector('header button.bg-orange-600');
    const productsContainer = document.getElementById('productsContainer');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // ------------------ OPEN MODAL ------------------
    document.addEventListener('click', (e) => {
        // Add product
        if (e.target.classList.contains('add-btn')) {
            const categoryDiv = e.target.closest('.category');
            modalCategoryId.value = categoryDiv.dataset.id;
            modalProductId.value = '';
            form.reset();
            modal.classList.remove('hidden');
        }

        // Edit product
        if (e.target.classList.contains('edit-btn')) {
            const btn = e.target;
            modalProductId.value = btn.dataset.productId;
            modalCategoryId.value = btn.dataset.categoryId;
            form.name.value = btn.dataset.name;
            form.description.value = btn.dataset.description;
            form.quantity.value = btn.dataset.quantity;
            form.unit_price.value = btn.dataset.unitPrice;
            modal.classList.remove('hidden');
        }

        // Toggle status
        if (e.target.classList.contains('toggle-status-btn')) {
            const btn = e.target;
            const productId = btn.dataset.productId;
            fetch(`/admin/products/${productId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                btn.textContent = data.status === 'active' ? 'Deactivate' : 'Activate';
                btn.dataset.status = data.status;

                const card = btn.closest('div.bg-white');
                const editBtn = card.querySelector('.edit-btn');
                editBtn.disabled = data.status === 'inactive';
                editBtn.classList.toggle('opacity-50', data.status === 'inactive');
                editBtn.classList.toggle('cursor-not-allowed', data.status === 'inactive');
                card.classList.toggle('opacity-50', data.status === 'inactive');
            })
            .catch(() => alert('Could not update product status.'));
        }
    });

    // ------------------ CLOSE MODAL ------------------
    closeModalBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
        form.reset();
        modalProductId.value = '';
    });

    // ------------------ ADD / EDIT PRODUCT ------------------
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        const productId = modalProductId.value;

        let url = productId ? `/admin/products/${productId}` : "{{ route('admin.products.store') }}";
        let method = productId ? 'POST' : 'POST';
        if (productId) formData.append('_method', 'PUT');

        try {
            const response = await fetch(url, {
                method,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            });

            if (!response.ok) throw new Error('Failed to save product');
            const product = await response.json();

            let card = document.querySelector(`#product-${product.product_id}`);

            if (card) {
                // Update existing product card
                card.querySelector('h3').textContent = product.name;
                card.querySelector('p.text-gray-500').textContent = product.description ?? '';
                card.querySelector('span.font-semibold').textContent = product.quantity;
                card.querySelector('p.font-bold').textContent = `$${product.unit_price}`;
                if (product.image) card.querySelector('img').src = '/storage/' + product.image;
            } else {
                // Create new product card
                const categoryDiv = document.querySelector(`#category-${product.category_id}`);
                const grid = categoryDiv.querySelector('.grid');
                card = document.createElement('div');
                card.id = `product-${product.product_id}`;
                card.classList.add('bg-white', 'rounded-lg', 'shadow', 'p-3');
                card.innerHTML = `
                    <img src="${product.image ? '/storage/' + product.image : '/images/default.jpg'}" alt="${product.name}" class="w-full h-40 object-cover rounded">
                    <div class="mt-3">
                        <h3 class="font-semibold">${product.name}</h3>
                        <p class="text-sm text-gray-500 mb-1">${product.description ?? ''}</p>
                        <p class="text-sm">Quantity: <span class="font-semibold">${product.quantity}</span> left</p>
                        <p class="font-bold text-lg mt-1">$${product.unit_price}</p>
                        <div class="flex gap-2 mt-3">
                            <button class="flex-1 bg-orange-500 text-white py-1 rounded hover:bg-orange-600 edit-btn"
                                data-product-id="${product.product_id}"
                                data-category-id="${product.category_id}"
                                data-name="${product.name}"
                                data-description="${product.description}"
                                data-quantity="${product.quantity}"
                                data-unit-price="${product.unit_price}"
                            >Edit</button>
                            <form method="POST" action="/admin/products/${product.product_id}/soft-delete" class="flex-1">
                                <input type="hidden" name="_token" value="${csrfToken}">
                                <input type="hidden" name="_method" value="PUT">
                                <button type="submit" class="w-full bg-red-600 text-white py-1 rounded hover:bg-red-700"
                                    onclick="return confirm('Are you sure you want to delete this product?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                `;
                grid.prepend(card);
            }


            modal.classList.add('hidden');
            form.reset();
            modalProductId.value = '';
            alert(productId ? 'Product updated successfully!' : 'Product added successfully!');
        } catch (err) {
            console.error(err);
            alert(err.message);
        }
    });

    // ------------------ SEARCH PRODUCTS ------------------
    async function searchProducts() {
        const query = searchInput.value.trim().toLowerCase();
        try {
            const response = await fetch(`{{ route('admin.products.search') }}?query=${encodeURIComponent(query)}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            });
            if (!response.ok) throw new Error('Failed to fetch products');
            const products = await response.json();

            productsContainer.innerHTML = '';
            const filtered = products.filter(p =>
                p.name.toLowerCase().includes(query) ||
                (p.description && p.description.toLowerCase().includes(query))
            );

            if (!filtered.length) {
                productsContainer.innerHTML = '<p class="text-gray-500">No products found.</p>';
                return;
            }

            const categoriesMap = {};
            filtered.forEach(p => {
                if (!categoriesMap[p.category_id]) categoriesMap[p.category_id] = [];
                categoriesMap[p.category_id].push(p);
            });

            for (const categoryId in categoriesMap) {
                const categoryProducts = categoriesMap[categoryId];
                const categoryDiv = document.createElement('div');
                categoryDiv.classList.add('category', `category-${categoryId}`, 'mb-10');
                categoryDiv.dataset.id = categoryId;
                categoryDiv.innerHTML = `
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">${categoryProducts[0].category_name}</h2>
                        <button class="add-btn bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700">Add ${categoryProducts[0].category_name}</button>
                    </div>
                    <div class="grid grid-cols-4 gap-6"></div>
                `;
                const grid = categoryDiv.querySelector('.grid');

                categoryProducts.forEach(product => {
                    const card = document.createElement('div');
                    card.classList.add('bg-white', 'rounded-lg', 'shadow', 'p-3');
                    card.id = `product-${product.product_id}`;
                    card.innerHTML = `
                        <img src="${product.image ? '/storage/' + product.image : '/images/default.jpg'}" alt="${product.name}" class="w-full h-40 object-cover rounded">
                        <div class="mt-3">
                            <h3 class="font-semibold">${product.name}</h3>
                            <p class="text-sm text-gray-500 mb-1">${product.description ?? ''}</p>
                            <p class="text-sm">Quantity: <span class="font-semibold">${product.quantity}</span> left</p>
                            <p class="font-bold text-lg mt-1">$${product.unit_price}</p>
                            <div class="flex gap-2 mt-3">
                                <button class="flex-1 bg-orange-500 text-white py-1 rounded hover:bg-orange-600 edit-btn"
                                    data-product-id="${product.product_id}"
                                    data-category-id="${product.category_id}"
                                    data-name="${product.name}"
                                    data-description="${product.description}"
                                    data-quantity="${product.quantity}"
                                    data-unit-price="${product.unit_price}"
                                >Edit</button>
                                <form method="POST" action="/admin/products/${product.product_id}/soft-delete" class="flex-1">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <input type="hidden" name="_method" value="PUT">
                                    <button type="submit" class="w-full bg-red-600 text-white py-1 rounded hover:bg-red-700"
                                        onclick="return confirm('Are you sure you want to delete this product?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    `;
                    grid.appendChild(card);
                });

                productsContainer.appendChild(categoryDiv);
            }
        } catch (err) {
            console.error(err);
            alert('Something went wrong while searching.');
        }
    }

    searchInput.addEventListener('input', searchProducts);
    searchBtn.addEventListener('click', searchProducts);
});
</script>

</body>
</html>