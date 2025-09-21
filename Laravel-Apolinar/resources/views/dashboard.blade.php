<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Glamour Makeup Store</title>
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

  <header>
    <div class="logo">Glamour</div>
    <nav>
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">Products</a></li>
        <li><a href="#">Offers</a></li>
        <li><a href="#">About</a></li>
      </ul>
    </nav>

    <div class="user-option">
      <!-- Profile icon -->
      <a href="#" class="user_link">
        <i class="fa fa-user" aria-hidden="true"></i>
      </a>

      <!-- Cart icon -->
      <a href="#" class="cart_link">
        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
      </a>

      <!-- Profile text -->
      <a href="#">Profile</a>

      <!-- Proper Laravel logout -->
      <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="logout-btn">
              {{ __('Logout') }}
          </button>
      </form>
    </div>
  </header>

  <section class="hero">
    <h1>Welcome to Glamour Makeup</h1>
    <p>Discover your beauty. Shine every day.</p>
  </section>

  <div class="content">
    <h2>Featured Products</h2>
    <div class="product-cards">
      <div class="product-card">
        <img src="{{ asset('css/img/image.png') }}" alt="Lipstick">
        <h3>Velvet Lipstick</h3>
        <p>$25.00</p>
        <button>Add to Cart</button>
      </div>
      <div class="product-card">
        <img src="{{ asset('css/img/image copy.png') }}" alt="Foundation">
        <h3>Liquid Foundation</h3>
        <p>$30.00</p>
        <button>Add to Cart</button>
      </div>
      <div class="product-card">
        <img src="{{ asset('css/img/image copy 2.png') }}" alt="Blush">
        <h3>Rosy Blush</h3>
        <p>$18.00</p>
        <button>Add to Cart</button>
      </div>
    </div>
  </div>

</body>
</html>
