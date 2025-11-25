<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="{{ asset('css/editproduct.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <div class="container mx-auto mt-6">
        <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">Edit Product</h2>
            <form action="#" method="POST" enctype="multipart/form-data">

                <!-- Product Name -->
                <div class="mb-4">
                    <label class="block text-gray-800 font-semibold mb-2">Product Name</label>
                    <input type="text" name="product_name" value="" class="w-full p-2 border rounded">
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label class="block text-gray-800 font-semibold mb-2">Description</label>
                    <textarea name="description" class="w-full p-2 border rounded"></textarea>
                </div>

                <!-- Price -->
                <div class="mb-4">
                    <label class="block text-gray-800 font-semibold mb-2">Price</label>
                    <input type="number" step="0.01" name="price" value="" class="w-full p-2 border rounded">
                </div>

                <!-- Brand -->
                <div class="mb-4">
                    <label class="block text-gray-800 font-semibold mb-2">Brand</label>
                    <input type="text" name="brand" value="" class="w-full p-2 border rounded">
                </div>

                <!-- Category Dropdown -->
                <div class="mb-4">
                    <label class="block text-gray-800 font-semibold mb-2">Category</label>
                    <select name="category" class="w-full p-2 border rounded" required>
                        <option value="">Select Category</option>
                        <option value="Basketball Shoes">Basketball Shoes</option>
                        <option value="Running Shoes">Running Shoes</option>
                        <option value="Jerseys">Jerseys</option>
                        <option value="Accessories">Accessories</option>
                        <option value="Soccer Shoes">Soccer Shoes</option>
                    </select>
                </div>

                <!-- Current Image -->
                <div class="mb-4">
                    <label class="block text-gray-800 font-semibold mb-2">Current Image</label>
                    <img src="path-to-your-image.jpg" width="100" class="mb-2">
                </div>

                <!-- Upload New Image -->
                <div class="mb-4">
                    <label class="block text-gray-800 font-semibold mb-2">Change Image</label>
                    <input type="file" name="image" class="w-full p-2 border rounded">
                </div>

                <div class="flex justify-between">
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update Product</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
