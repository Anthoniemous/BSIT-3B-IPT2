<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ShoppingCart Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-400 to-blue-600">

  <!-- Login Card -->
  <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md text-center">
    
    <!-- Title -->
    <h1 class="text-2xl font-bold text-blue-800 mb-1">Welcome to <span class="text-blue-900">ShoppingCart</span></h1>
    <p class="text-sm text-gray-600 mb-6">
      Shop smarter and faster. Sign in to explore deals, track your cart, and enjoy a seamless shopping experience.
    </p>

    <!-- Form -->
    <form method="POST" action="{{ route('login') }}" class="space-y-5 text-left">
      @csrf

      <!-- Email -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
        <input type="email" name="email" required
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
          placeholder="you@example.com" />
      </div>

      <!-- Password -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input type="password" name="password" required
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
          placeholder="••••••••" />
      </div>

      <!-- Options -->
      <div class="flex items-center justify-between text-sm">
        <label class="flex items-center">
          <input type="checkbox" name="remember" class="mr-2 accent-blue-600" />
          Remember me
        </label>
        <a href="{{ route('password.request') }}" class="text-blue-600 hover:underline">Forgot password?</a>
      </div>

      <!-- Submit -->
      <button type="submit"
        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-md transition">
        LOGIN
      </button>

      <!-- Google Button -->
      <a href="{{ route('google-auth') }}"
        class="flex items-center justify-center gap-2 w-full border border-gray-300 rounded-md py-2 hover:bg-gray-100 transition">
        <img src="https://www.svgrepo.com/show/355037/google.svg" class="w-5 h-5" alt="Google Logo" />
        Sign in with Google
      </a>
    </form>

    <!-- Register -->
    <p class="mt-6 text-sm text-gray-600">
      Don’t have an account?
      <a href="{{ route('register') }}" class="text-blue-700 font-semibold hover:underline">Sign up</a>
    </p>
  </div>
</body>
</html>
