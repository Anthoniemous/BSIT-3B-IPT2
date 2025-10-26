<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to PAWer</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lilita+One&family=Permanent+Marker&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="public/assets/css/landingpage.css">
  @vite(['resources/css/app.css', 'resources/js/dropdown.js'])
</head>
<body class="bg-white text-gray-800 font-sans">

  <!-- NAVIGATION -->
  <header>
    <div class="flex items-center justify-between bg-sky-950 text-white px-6 py-3 flex-wrap">
      <div class="flex flex-col">
        <div class="flex items-center gap-2 text-l text-white]">
          <img src="{{ asset('images/Logo.png') }}" alt="Cart Logo" class="w-14">
          PAWer
        </div>
      </div>

      <nav class="flex space-x-4 text-sm font-medium">
        <a href="#" class="hover:underline">Home</a>
        <a href="#" class="hover:underline">About Us</a>
        <a href="#" class="hover:underline">Shop Deals</a>
        <a href="#" class="hover:underline">Categories</a>
        <a href="#" class="hover:underline">Contact Us</a>
      </nav>

      <div class="flex items-center space-x-2 mt-2">
        <input type="text" placeholder="Search for products..."
               class="px-3 py-1 rounded-l-md border-none outline-none text-gray-700">
        <button class="bg-[#e67e22] text-white px-3 py-1 rounded-r-md">
          <i class="fa fa-search"></i>
        </button>
      </div>

      <div class="flex items-center space-x-4 text-lg mt-2">
        <!-- Shopping Cart Icon -->
        <a href="#"><i class="fa fa-shopping-cart"></i></a>

          <!-- USER DROPDOWN -->
          <div class="relative" id="user-dropdown-wrapper">
              <!-- User Button (Profile Photo or Default Icon) -->
              <button id="user-dropdown-btn" class="focus:outline-none relative w-10 h-10 rounded-full overflow-hidden border border-gray-300 hover:ring-2 hover:ring-blue-400 transition" aria-haspopup="true" aria-expanded="false" type="button">
                @if(Auth::user()->profile_photo)
                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile Photo" class="object-cover w-full h-full">
                @else
                    <div class="flex items-center justify-center w-full h-full bg-gray-200 text-gray-500">
                        <i class="fa fa-user text-lg"></i>
                    </div>
                @endif
            </button>


              <!-- Dropdown Menu -->
              <div id="user-dropdown-menu" 
                  class="hidden absolute right-0 mt-2 w-36 bg-white text-gray-800 rounded-md shadow-lg border z-50">
                  
                  <form method="GET" action="{{ route('profile.edit') }}">
                      <button type="submit" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">
                          Profile
                      </button>
                  </form>

                  <form method="POST" action="{{ route('logout') }}">
                      @csrf
                      <button type="submit" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">
                          Logout
                      </button>
                  </form>

                  <a href="{{ route('admin_dashboard') }}" 
                    class="block px-4 py-2 text-sm hover:bg-gray-100">
                      Admin
                  </a>
              </div>
          </div>
      </div>
    </div>
  </header>

  <!-- BANNER -->
  <section class="relative h-[89vh] bg-cover bg-center text-white flex items-center justify-start shadow-lg animate-[zoomIn_20s_ease-in-out_infinite_alternate]"
           style="background-image: url('{{ asset('images/background.png') }}')">
    <div class="px-12">
      <h1 class="lilita-one-regular text-6xl font-bold mb-4 text-black">Welcome to PAWer</h1>
      <p class="text-lg mb-6 text-black">Your one-stop shop for all your pet’s needs.</p>
      <a href="#" class="bg-[#e67e22] text-white px-5 py-3 rounded-md font-semibold hover:bg-[#cf6d17]">Shop Now</a>
    </div>
  </section>

  <!-- FEATURED PRODUCTS -->
  <section class="py-16 text-center bg-white font-[Poppins]">
    <h2 class="text-3xl font-bold mb-8 text-gray-800">Featured Products</h2>
    <div class="flex flex-wrap justify-center gap-6 px-4">
      
      @php
        $products = [
          ['img' => 'collar.jpg', 'name' => 'Collars'],
          ['img' => 'leash.jpg', 'name' => 'Leashes'],
          ['img' => 'bed.jpg', 'name' => 'Bed and Comfort'],
          ['img' => 'food.jpg', 'name' => 'Feeding and Drinking'],
          ['img' => 'toy.jpg', 'name' => 'Toys and Entertainment'],
          ['img' => 'cloth.jpg', 'name' => 'Clothing and Fashion'],
        ];
      @endphp

      @foreach ($products as $item)
      <div class="relative w-[320px] h-[220px] rounded-xl overflow-hidden shadow-lg hover:-translate-y-1 hover:shadow-2xl transition-all duration-300 group">
        <img src="{{ asset('images/' . $item['img']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover brightness-90 group-hover:brightness-75 transition-all">
        <h3 class="absolute bottom-14 left-5 text-white text-lg font-semibold drop-shadow-lg">{{ $item['name'] }}</h3>
        <span class="absolute bottom-4 left-5 bg-[#ff4500] text-white px-4 py-1 rounded text-sm font-medium group-hover:bg-[#e63e00] transition-colors cursor-pointer">
          Shop Now
        </span>
      </div>
      @endforeach

    </div>
  </section>

  <!-- FOOTER -->
  <footer class="bg-[#2c3e50] text-white px-6 py-10">
    <div class="flex flex-wrap justify-between gap-8">

      <div class="max-w-xs">
        <h3 class="text-2xl font-bold text-[#e67e22]">PAWer</h3>
        <p class="mt-2 text-sm text-gray-200">
          Your go-to online pet supply store. Authentic, fast, and affordable.
        </p>
      </div>

      <div>
        <h4 class="text-lg font-semibold">Quick Links</h4>
        <ul class="mt-3 space-y-2 text-sm">
          <li><a href="#" class="hover:underline">About Us</a></li>
          <li><a href="#" class="hover:underline">Privacy Policy</a></li>
          <li><a href="#" class="hover:underline">Terms & Conditions</a></li>
        </ul>
      </div>

      <div>
        <h4 class="text-lg font-semibold">Follow Us</h4>
        <div class="flex space-x-4 mt-3 text-xl">
          <a href="#" class="hover:text-[#e67e22]"><i class="fab fa-facebook"></i></a>
          <a href="#" class="hover:text-[#e67e22]"><i class="fab fa-instagram"></i></a>
          <a href="#" class="hover:text-[#e67e22]"><i class="fab fa-twitter"></i></a>
        </div>
      </div>
    </div>

    <p class="text-center text-sm mt-8 text-gray-300">
      &copy; 2025 PAWer. All Rights Reserved.
    </p>
  </footer>
</body>
</html>
