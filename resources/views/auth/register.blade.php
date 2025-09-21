<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ShoppingCart Register</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    input:focus {
      box-shadow: 0 0 12px rgba(239, 68, 68, 0.8);
      transition: 0.3s;
    }
    .btn-hover:hover {
      transform: scale(1.05);
      box-shadow: 0 0 20px rgba(239, 68, 68, 0.9);
    }
  </style>
</head>
<body class="h-screen w-full flex">

  <!-- Left Panel (Logo + Branding) -->
  <div class="hidden lg:flex w-1/2 bg-gradient-to-br from-black via-gray-900 to-red-900 text-white flex-col justify-center items-center p-12">
    <svg class="w-20 h-20 text-red-500 mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round"
            d="M6 2l1 4h10l1-4m-1 4v14a2 2 0 01-2 2H9a2 2 0 01-2-2V6h10z" />
    </svg>
    <h1 class="text-4xl font-extrabold tracking-wide text-red-500">ShoppingCart</h1>
    <p class="mt-3 text-gray-300 text-center max-w-md">
      Create your free account and start filling up your cart today!  
      Shop smarter, faster, and better. 🛍️
    </p>
  </div>

  <!-- Right Panel (Register Form) -->
  <div class="flex w-full lg:w-1/2 items-center justify-center bg-black">
    <div class="bg-gray-900 p-10 rounded-2xl shadow-2xl w-full max-w-md border border-red-600">
      
      <!-- Heading -->
      <h2 class="text-3xl font-bold text-center text-red-500 mb-6">Create Account</h2>

      <!-- Register Form -->
      <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
          <label for="name" class="block text-sm text-gray-300 mb-1">Full Name</label>
          <input type="text" id="name" name="name"
                 class="w-full px-4 py-2 bg-black border border-red-500 text-white rounded-lg focus:outline-none transition duration-300"
                 placeholder="Aray Koe" required>
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="block text-sm text-gray-300 mb-1">Email Address</label>
          <input type="email" id="email" name="email"
                 class="w-full px-4 py-2 bg-black border border-red-500 text-white rounded-lg focus:outline-none transition duration-300"
                 placeholder="idoy@example.com" required>
        </div>

        <!-- Password -->
        <div>
          <label for="password" class="block text-sm text-gray-300 mb-1">Password</label>
          <input type="password" id="password" name="password"
                 class="w-full px-4 py-2 bg-black border border-red-500 text-white rounded-lg focus:outline-none transition duration-300"
                 placeholder="••••••••" required>
        </div>

        <!-- Confirm Password -->
        <div>
          <label for="password_confirmation" class="block text-sm text-gray-300 mb-1">Confirm Password</label>
          <input type="password" id="password_confirmation" name="password_confirmation"
                 class="w-full px-4 py-2 bg-black border border-red-500 text-white rounded-lg focus:outline-none transition duration-300"
                 placeholder="••••••••" required>
        </div>

        <!-- Register Button -->
        <button type="submit"
                class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 rounded-lg shadow-lg transition duration-300 btn-hover">
          Register
        </button>
      </form>

      <!-- Divider -->
      <div class="my-6 flex items-center">
        <hr class="flex-grow border-gray-700">
        <span class="mx-2 text-gray-500 text-sm">OR</span>
        <hr class="flex-grow border-gray-700">
      </div>

      <!-- Login Link -->
      <p class="text-center text-sm text-gray-400">
        Already have an account?
        <a href="{{ route('login') }}" class="text-red-400 hover:text-red-500 hover:underline font-semibold">Login here</a>
      </p>
    </div>
  </div>

</body>
</html>
