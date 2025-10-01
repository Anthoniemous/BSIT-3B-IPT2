<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to Shoppify</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/landingpage.css') }}">
</head>
<body>
  <!-- NAVIGATION -->
  <header>
    <div class="top-nav">
      <div class="logo">
        <img src="{{ asset('images/cart.png') }}" alt="Cart Logo" style="width: 50px;"> Shoppify
      </div>
      <nav class="nav-links">
        <a href="#">Home</a>
        <a href="#">Shop</a>
        <a href="#">Deals</a>
        <a href="#">Contact</a>
      </nav>
      <div class="search-bar">
        <input type="text" placeholder="Search for products...">
        <button><i class="fa fa-search"></i></button>
      </div>
      <div class="icons">
        <a href="#"><i class="fa fa-user"></i></a>
        <a href="#"><i class="fa fa-shopping-cart"></i></a>
      </div>
    </div>
  </header>

  <!-- BANNER -->
  <section class="banner">
    <div class="banner-content">
      <h1>Fresh Groceries Delivered to Your Doorstep</h1>
      <p>Order your daily needs easily and quickly with Shoppify</p>
      <a href="#" class="btn">Start Shopping</a>
    </div>
  </section>

  <!-- CSS-ONLY CAROUSEL -->
  <section class="carousel">
    <h2>Featured Products</h2>
    <div class="carousel-wrapper">
      <div class="carousel-track">
        <div class="carousel-item">
          <img src="{{ asset('assets/images/fruits.jpg') }}" alt="Fruits">
          <h3>Fresh Fruits</h3>
        </div>
        <div class="carousel-item">
          <img src="{{ asset('assets/images/vegetables.jpg') }}" alt="Vegetables">
          <h3>Green Vegetables</h3>
        </div>
        <div class="carousel-item">
          <img src="{{ asset('assets/images/dairies.jpg') }}" alt="Dairy">
          <h3>Dairy Products</h3>
        </div>
        <div class="carousel-item">
          <img src="{{ asset('assets/images/snacks.jpg') }}" alt="Snacks">
          <h3>Snacks & Beverages</h3>
        </div>
        <!-- duplicate for infinite effect -->
        <div class="carousel-item">
          <img src="{{ asset('assets/images/meat.jpg') }}" alt="Meat">
          <h3>Meat, Poultry, and Seafoods</h3>
        </div>
        <div class="carousel-item">
          <img src="{{ asset('assets/images/baking.jpg') }}" alt="Baking">
          <h3>Bakery and Grains</h3>
        </div>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer>
    <div class="footer-container">
      <div class="footer-about">
        <h3>Shoppify</h3>
        <p>Your go-to online grocery store. Fresh, fast, and affordable.</p>
      </div>
      <div class="footer-links">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="#">About Us</a></li>
          <li><a href="#">Privacy Policy</a></li>
          <li><a href="#">Terms & Conditions</a></li>
        </ul>
      </div>
      <div class="footer-social">
        <h4>Follow Us</h4>
        <a href="#"><i class="fab fa-facebook"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
      </div>
    </div>
    <p class="footer-bottom">&copy; 2025 Shoppify. All Rights Reserved.</p>
  </footer>
</body>
</html>
