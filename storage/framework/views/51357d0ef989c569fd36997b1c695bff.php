<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Nami Shop - Welcome</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-purple-400 via-pink-500 to-red-500 min-h-screen text-white">

    <header class="bg-transparent shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <h1 class="text-3xl font-bold">Nami Shop</h1>
            <nav class="space-x-4">
                <?php if(Route::has('login')): ?>
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(url('/dashboard')); ?>" class="text-white font-semibold hover:underline">Dashboard</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="text-white hover:underline">Log in</a>
                        <?php if(Route::has('register')): ?>
                            <a href="<?php echo e(route('register')); ?>" class="text-white hover:underline">Register</a>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">

        <section class="mb-12 text-center">
            <h2 class="text-5xl font-extrabold mb-4 drop-shadow-lg">Welcome to Nami Shop</h2>
            <p class="text-lg max-w-2xl mx-auto drop-shadow-md">Your one-stop online shopping destination. Discover amazing products and deals.</p>
        </section>

        <section>
            <h3 class="text-3xl font-semibold mb-6 drop-shadow-md">Featured Products</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">

                <div class="bg-white bg-opacity-20 rounded-lg shadow-lg p-4 flex flex-col text-black">
                    <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=150&q=80" alt="Elegant Watch" class="mb-4 rounded" />
                    <h4 class="text-lg font-semibold mb-2">Elegant Watch</h4>
                    <p class="text-gray-800 mb-4">A stylish watch to complement your outfit.</p>
                    <button class="mt-auto bg-pink-600 text-white py-2 rounded hover:bg-pink-700 transition">Add to Cart</button>
                </div>

                <div class="bg-white bg-opacity-20 rounded-lg shadow-lg p-4 flex flex-col text-black">
                    <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=150&q=80" alt="Leather Bag" class="mb-4 rounded" />
                    <h4 class="text-lg font-semibold mb-2">Paintings</h4>
                    <p class="text-gray-800 mb-4">Premium Painting for display.</p>
                    <button class="mt-auto bg-pink-600 text-white py-2 rounded hover:bg-pink-700 transition">Add to Cart</button>
                </div>

                <div class="bg-white bg-opacity-20 rounded-lg shadow-lg p-4 flex flex-col text-black">
                    <img src="https://images.unsplash.com/photo-1512499617640-c2f9992c9a0b?auto=format&fit=crop&w=150&q=80" alt="Headphones" class="mb-4 rounded" />
                    <h4 class="text-lg font-semibold mb-2">Headphones</h4>
                    <p class="text-gray-800 mb-4">High-quality sound for music lovers.</p>
                    <button class="mt-auto bg-pink-600 text-white py-2 rounded hover:bg-pink-700 transition">Add to Cart</button>
                </div>

                <div class="bg-white bg-opacity-20 rounded-lg shadow-lg p-4 flex flex-col text-black">
                    <img src="https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?auto=format&fit=crop&w=150&q=80" alt="Sneakers" class="mb-4 rounded" />
                    <h4 class="text-lg font-semibold mb-2">Camera</h4>
                    <p class="text-gray-800 mb-4">Comfortable and upgradable cameras.</p>
                    <button class="mt-auto bg-pink-600 text-white py-2 rounded hover:bg-pink-700 transition">Add to Cart</button>
                </div>

            </div>
        </section>

    </main>

</body>
</html>
<?php /**PATH C:\mimi\Laravel-project\resources\views/welcome.blade.php ENDPATH**/ ?>