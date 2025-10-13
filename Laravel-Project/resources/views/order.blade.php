<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Checkout 🧾') }}
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg mt-6">
        <h3 class="text-lg font-semibold mb-4 text-gray-800">Order Information</h3>

        <form method="POST" action="{{ route('orders.store') }}">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-2">Full Name</label>
                <input type="text" id="name" name="name"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:border-blue-400"
                    placeholder="Enter your full name" required>
            </div>

            <div class="mb-4">
                <label for="address" class="block text-gray-700 font-medium mb-2">Address</label>
                <textarea id="address" name="address" rows="3"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:border-blue-400"
                    placeholder="Enter your delivery address" required></textarea>
            </div>

            <div class="mb-4">
                <label for="contact" class="block text-gray-700 font-medium mb-2">Contact Number</label>
                <input type="text" id="contact" name="contact"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:border-blue-400"
                    placeholder="09XXXXXXXXX" required>
            </div>

            <div class="mb-4">
                <label for="payment_method" class="block text-gray-700 font-medium mb-2">Payment Method</label>
                <select id="payment_method" name="payment_method"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:border-blue-400" required>
                    <option value="">Select Payment Option</option>
                    <option value="cod">Cash on Delivery</option>
                    <option value="gcash">GCash</option>
                </select>
            </div>

            <div class="mt-6 text-right">
                <button type="submit"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition duration-200">
                    Place Order
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
