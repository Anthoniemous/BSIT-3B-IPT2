<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ShoppingCart Register</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-400 to-blue-600">

  <!-- Register Card -->
  <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md text-center">

    <!-- Logo and Title -->
    <div class="flex items-center justify-center gap-2 mb-6">
      <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437m0 0L6.75 14.25h10.5l2.25-8.25H5.106m0 0L4.5 6.75m4.5 14.25a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm9 0a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
      </svg>
      <span class="text-xl font-bold text-gray-800">ShoppingCart</span>
    </div>

    <h1 class="text-2xl font-bold text-blue-800 mb-1">Create your account</h1>
    <p class="text-sm text-gray-600 mb-6">Fill in the details to get started</p>

    <!-- Form -->
    <form method="POST" action="{{ route('register') }}" class="space-y-5 text-left">
      @csrf

      <!-- Name -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
        <input type="text" name="name" value="{{ old('name') }}" required
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
          placeholder="John Doe" />
      </div>

      <!-- Email -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
        <input type="email" name="email" value="{{ old('email') }}" required
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

      <!-- Confirm Password -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
        <input type="password" name="password_confirmation" required
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
          placeholder="••••••••" />
      </div>

      <!-- Submit Button -->
      <button type="submit"
        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-md transition">
        Sign up
      </button>

      <!-- Google Button -->
      <a href="{{ route('google-auth') }}"
        class="flex items-center justify-center gap-2 w-full border border-gray-300 rounded-md py-2 hover:bg-gray-100 transition">
        <img src="https://www.svgrepo.com/show/355037/google.svg" class="w-5 h-5" alt="Google Logo">
        Sign up with Google
      </a>
    </form>

    <!-- Login Link- -->
    <p class="mt-6 text-sm text-gray-600 text-center">
      Already have an account?
      <a href="{{ route('login') }}" class="text-blue-700 font-semibold hover:underline">Sign in</a>
    </p>
  </div>

</body>
</html>
