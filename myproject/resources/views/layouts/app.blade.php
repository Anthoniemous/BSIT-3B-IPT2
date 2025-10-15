<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coffee Shop</title>
  <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      margin: 0;
      font-family: 'Roboto', sans-serif;
      background: linear-gradient(180deg, #2C1B10 0%, #4B2D19 100%);
      color: #F0E6D2;
    }

    /* Navbar */
    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 12px 20px;
      background-color: #3B2615;
      box-shadow: 0 2px 8px rgba(0,0,0,0.4);
      position: fixed;
      width: 100%;
      top: 0;
      z-index: 1000;
      flex-wrap: wrap;
    }

    .brand {
      font-family: 'Merriweather', serif;
      font-size: 1.5rem;
      color: #FFD699;
      text-decoration: none;
    }

    .nav-links {
      display: flex;
      align-items: center;
      gap: 15px;
      flex-wrap: wrap;
      justify-content: flex-end; /* right aligned */
      margin-left: 20px; /* shift gamay pa-left */
    }

    .nav-links a {
      text-decoration: none;
      color: #FFD699;
      font-weight: 500;
      position: relative;
    }

    .nav-links a:hover {
      color: #FFA500;
    }

    /* Cart Badge */
    .cart-icon {
      font-size: 0.9rem;
      width: 28px;
      height: 28px;
      background-color: #4B2D19;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 8px; /* spacing sa dropdown */
      position: relative;
      transition: transform 0.2s;
    }

    .cart-icon:hover {
      transform: scale(1.1);
    }

    .badge {
      background-color: #FFA500;
      color: #3B1F0D;
      font-size: 0.45rem; 
      padding: 1px 3px;
      border-radius: 50%;
      position: absolute;
      top: -3px;
      right: -3px;
    }

    /* Dropdown */
    .dropdown {
      position: relative;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #3B2615;
      min-width: 140px;
      right: 0; /* align sa dropdown link */
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.4);
      z-index: 1000;
    }

    .dropdown-content a {
      display: block;
      padding: 10px 15px;
      color: #FFD699;
      text-decoration: none;
      transition: background 0.2s;
    }

    .dropdown-content a:hover {
      background-color: #4B2D19;
    }

    .dropdown:hover .dropdown-content {
      display: block;
    }

    /* Container */
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 80px 20px 40px 20px; /* top padding for fixed navbar */
    }

    /* Responsive adjustments */
    @media (max-width: 600px) {
      .navbar {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
      }
    }
  </style>
</head>
<body>
  <nav class="navbar">
    <a href="{{ url('/') }}" class="brand">☕ Coffee Shop</a>
    <div class="nav-links">
      @guest
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('register') }}">Register</a>
      @else
        <a href="{{ route('cart.index') }}" class="cart-icon">
          <i class="bi bi-cart-fill" style="color:#FFD699;"></i>
          @php
            $cart = session('cart', []);
            $cartCount = 0;
            foreach($cart as $item) $cartCount += $item['quantity'];
          @endphp
          @if($cartCount > 0)
            <span class="badge">{{ $cartCount }}</span>
          @endif
        </a>

        <div class="dropdown">
          <a href="#">{{ Auth::user()->name }} <i class="bi bi-caret-down-fill"></i></a>
          <div class="dropdown-content">
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
               Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </div>
        </div>
      @endguest
    </div>
  </nav>

  <div class="container">
    @yield('content')
  </div>
</body>
</html>
