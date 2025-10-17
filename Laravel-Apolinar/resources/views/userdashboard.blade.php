<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Glamour Makeup Store</title>

  <!-- Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>

  <!-- HEADER -->
  <header>
    <div class="logo">Glamour</div>

    <nav>
      <ul>
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="#">Offers</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Tracker</a></li>
      </ul>
    </nav>

    <div class="user-option">
      @guest
        <button class="btn" onclick="window.location.href='{{ route('login') }}'">Login</button>
        <button class="btn" onclick="window.location.href='{{ route('register') }}'">Sign Up</button>
      @else
        <button class="btn logout-btn"
          onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</button>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
          @csrf
        </form>
      @endguest
    </div>
  </header>

  <!-- HERO SECTION -->
  <section class="hero">
    <h1>Welcome to Glamour Makeup</h1>
    <p>Discover your beauty. Shine every day.</p>
  </section>

 <div class="content">
  <h2>Featured Products</h2>

  <div class="product-cards">
    @if(isset($products) && count($products) > 0)
      @foreach($products as $product)
        <div class="product-card">
          @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
          @else
            <img src="{{ asset('css/img/default-product.png') }}" alt="Default Product">
          @endif

          <h3>{{ $product->name }}</h3>
          <p>₱{{ number_format($product->price, 2) }}</p>
          <button>Add to Cart</button>
        </div>
      @endforeach
    @else
      <p>No products available.</p>
    @endif
  </div>
</div>

  

</body>
</html>
