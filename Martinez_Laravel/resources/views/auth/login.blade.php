<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ShoppingCart Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-900 via-blue-700 to-sky-500 font-sans">

  <div class="w-full max-w-md bg-white rounded-xl shadow-2xl overflow-hidden">

    <!-- Top Section -->
    <div class="bg-gradient-to-br from-blue-600 to-sky-400 p-8 text-white text-center">
      <img src="{{ asset('images/CART.png') }}"
       alt="ShoppingCart Logo"
       class="mx-auto w-30 h-40">

      <h1 class="text-3xl font-bold">AutoCart</h1>
      <p class="mt-2 text-sm text-blue-100">
       From tears to checkout in seconds.. Sign in to explore deals, track your cart,
        and enjoy a seamless shopping experience.
      </p>
      <a href="{{ route('register') }}"
         class="mt-4 inline-block text-sm font-semibold text-white hover:underline">
        Create Account?
      </a>
    </div>

    <!-- Bottom Section (Login Form) -->
    <div class="p-8">
      <h2 class="text-center text-gray-700 text-sm tracking-widest mb-6">LOGIN</h2>

      <!-- Error Message -->
      @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
          <span class="block sm:inline">{{ session('error') }}</span>
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email -->
        <div class="relative">
          <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-500">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 12a4 4 0 01-8 0 4 4 0 018 0zm6 0a10 10 0 11-20 0 10 10 0 0120 0z"/>
            </svg>
          </span>
          <input type="email" id="email" name="email"
                 class="w-full pl-10 pr-4 py-2 border rounded-lg bg-blue-50 border-blue-300 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                 placeholder="Email Address" required>
        </div>

        <!-- Password -->
        <div class="relative">
          <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-500">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 11c0-1.104.896-2 2-2s2 .896 2 2v1h-4v-1zm-2 0v1H6v-1c0-1.104.896-2 2-2s2 .896 2 2z"/>
            </svg>
          </span>
          <input type="password" id="password" name="password"
                 class="w-full pl-10 pr-4 py-2 border rounded-lg bg-blue-50 border-blue-300 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                 placeholder="Password" required>
        </div>

        <!-- Remember + Forgot -->
        <div class="flex items-center justify-between text-sm text-gray-600">
          <label class="flex items-center">
            <input type="checkbox" name="remember" class="mr-2 text-blue-600 focus:ring-blue-500"> Remember Me
          </label>
          <a href="{{ route('password.request') }}" class="text-blue-600 hover:underline">Forgot password?</a>
        </div>
        <a href="{{ url('auth/google') }}"
   class="w-full flex items-center justify-center bg-white border border-gray-300 rounded-lg shadow-sm py-2 text-gray-700 font-medium hover:bg-gray-100 transition">
  <img src="https://www.svgrepo.com/show/355037/google.svg"
       alt="Google Logo"
       class="w-5 h-5 mr-2">
  Continue with Google
</a>

        <!-- Login Button -->
        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg shadow-md transition">
          LOGIN
        </button>
      </form>
    </div>
  </div>

</body>
</html>
