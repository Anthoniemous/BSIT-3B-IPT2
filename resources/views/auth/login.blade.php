<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ShoppingCart Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Input glow */
    input:focus {
      box-shadow: 0 0 12px rgba(239, 68, 68, 0.8);
      transition: 0.3s;
    }
    /* Button hover */
    .btn-hover:hover {
      transform: scale(1.05);
      box-shadow: 0 0 20px rgba(239, 68, 68, 0.9);
    }
  </style>
</head>
<body class="h-screen w-full flex">

  <!-- Left Panel (Logo + Branding) -->
  <div class="hidden lg:flex w-1/2 bg-gradient-to-br from-black via-gray-900 to-red-900 text-white flex-col justify-center items-center p-12">
    <!-- Bag Icon -->
    <svg class="w-20 h-20 text-red-500 mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round"
            d="M6 2l1 4h10l1-4m-1 4v14a2 2 0 01-2 2H9a2 2 0 01-2-2V6h10z" />
    </svg>
    <h1 class="text-4xl font-extrabold tracking-wide text-red-500">ShoppingCart</h1>
    <p class="mt-3 text-gray-300 text-center max-w-md">
      Your one-stop shop for everything you love.  
      Login now and keep your cart rolling! 🛒
    </p>
  </div>

  <!-- Right Panel (Login Form) -->
  <div class="flex w-full lg:w-1/2 items-center justify-center bg-black">
    <div class="bg-gray-900 p-10 rounded-2xl shadow-2xl w-full max-w-md border border-red-600">
      
      <!-- Heading -->
      <h2 class="text-3xl font-bold text-center text-red-500 mb-6">Welcome Back</h2>

      <!-- Login Form -->
      <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email -->
        <div>
          <label for="email" class="block text-sm text-gray-300 mb-1">Email Address</label>
          <input type="email" id="email" name="email"
                 class="w-full px-4 py-2 bg-black border border-red-500 text-white rounded-lg focus:outline-none transition duration-300"
                 placeholder="you@example.com" required>
        </div>

        <!-- Password -->
        <div>
          <label for="password" class="block text-sm text-gray-300 mb-1">Password</label>
          <input type="password" id="password" name="password"
                 class="w-full px-4 py-2 bg-black border border-red-500 text-white rounded-lg focus:outline-none transition duration-300"
                 placeholder="••••••••" required>
        </div>

        <!-- Remember + Forgot -->
        <div class="flex items-center justify-between text-sm">
          <label class="flex items-center text-gray-400">
            <input type="checkbox" name="remember" class="mr-2 text-red-500 focus:ring-red-500"> Remember Me
          </label>
          <a href="{{ route('password.request') }}" class="text-red-400 hover:text-red-500 hover:underline">Forgot?</a>
        </div>

        <!-- Login Button -->
        <button type="submit"
                class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 rounded-lg shadow-lg transition duration-300 btn-hover">
          Login
        </button>
      </form>

      <!-- Divider -->
      <div class="my-6 flex items-center">
        <hr class="flex-grow border-gray-700">
        <span class="mx-2 text-gray-500 text-sm">OR</span>
        <hr class="flex-grow border-gray-700">
      </div>

      <!-- Google Login Button -->
      <div class="flex justify-center">
        <a href="{{ route('google-auth') }}"
           class="flex items-center px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
            <img src="https://www.svgrepo.com/show/355037/google.svg" alt="Google" class="w-5 h-5 mr-2">
            {{ __('Continue with Google') }}
        </a>
    </div>

      <!-- Register Link -->
      <p class="text-center text-sm text-gray-400 mt-6">
        New here?
        <a href="{{ route('register') }}" class="text-red-400 hover:text-red-500 hover:underline font-semibold">Create an account</a>
      </p>
    </div>
  </div>

</body>
</html>
