<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create ShoppingCart Account</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-900 via-blue-700 to-sky-500 font-sans">

  <div class="w-full max-w-md bg-white rounded-xl shadow-2xl overflow-hidden">
    
    <!-- Top Section -->
    <div class="bg-gradient-to-br from-blue-600 to-sky-400 p-8 text-white text-center">
      <h1 class="text-3xl font-bold">Join ShoppingCart</h1>
      <p class="mt-2 text-sm text-blue-100">
        Create your free account today and start filling your cart with amazing deals.  
        Shop anytime, anywhere.
      </p>
      <a href="{{ route('login') }}" 
         class="mt-4 inline-block text-sm font-semibold text-white hover:underline">
        Already have an account? Login
      </a>
    </div>

    <!-- Bottom Section (Register Form) -->
    <div class="p-8">
      <h2 class="text-center text-gray-700 text-sm tracking-widest mb-6">SIGN UP ACCOUNT</h2>

      <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div class="relative">
          <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-500">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5.121 17.804A9.969 9.969 0 0112 15c2.21 0 4.237.72 5.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
          </span>
          <input type="text" id="name" name="name" value="{{ old('name') }}"
                 class="w-full pl-10 pr-4 py-2 border rounded-lg bg-blue-50 border-blue-300 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                 placeholder="Full Name" required>
          @error('name')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Email -->
        <div class="relative">
          <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-500">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 12a4 4 0 01-8 0 4 4 0 018 0zm6 0a10 10 0 11-20 0 10 10 0 0120 0z"/>
            </svg>
          </span>
          <input type="email" id="email" name="email" value="{{ old('email') }}"
                 class="w-full pl-10 pr-4 py-2 border rounded-lg bg-blue-50 border-blue-300 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                 placeholder="Email Address" required>
          @error('email')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
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
          @error('password')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Confirm Password -->
        <div class="relative">
          <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-500">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 11c0-1.104.896-2 2-2s2 .896 2 2v1h-4v-1zm-2 0v1H6v-1c0-1.104.896-2 2-2s2 .896 2 2z"/>
            </svg>
          </span>
          <input type="password" id="password_confirmation" name="password_confirmation"
                 class="w-full pl-10 pr-4 py-2 border rounded-lg bg-blue-50 border-blue-300 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                 placeholder="Confirm Password" required>
          @error('password_confirmation')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Register Button -->
        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg shadow-md transition">
          Sign Up
        </button>
      </form>
    </div>
  </div>

</body>
</html>

