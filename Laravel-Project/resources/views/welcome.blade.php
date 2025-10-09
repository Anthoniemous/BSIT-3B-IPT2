<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NBA Fan Store</title>
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<header>
  <div class="logo">
    <img src="{{ asset('css/img/image.png') }}" alt="NBA Logo">
    <span>NBA Fan Store</span>
  </div>
  <nav>
    <ul>
      <li><a href="{{ url('/') }}">Home</a></li>
      <li><a href="{{ url('/merch') }}">Merch</a></li>
      <li><a href="#">Teams</a></li>
      <li><a href="#">About</a></li>
    </ul>
  </nav>

  <div class="user-option">
    @auth
      <a href="{{ route('dashboard') }}" class="btn">Dashboard</a>
      <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <button type="submit" class="btn">Logout</button>
      </form>
    @else
      <a href="{{ route('login') }}" class="btn">Login</a>
      <a href="{{ route('register') }}" class="btn">Sign Up</a>
    @endauth
  </div>
</header>

<section class="hero">
  <h1>Welcome to NBA Fan Store</h1>
  <p>Get your favorite NBA merch and gear!</p>
</section>

<div class="content">
  <h2>Featured Merch</h2>
  <h2>Available Products</h3>
  <div class="product-cards">
    @foreach($products as $product)
        <div class="product-card">
            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->product_name }}">
            <h3>{{ $product->product_name }}</h3>
            <p>${{ number_format($product->price, 2) }}</p>
            <form method="POST" action="{{ route('cart.add', $product->product_id) }}">
                @csrf
                <button type="submit">Add to Cart</button>
            </form>
        </div>
    @endforeach
  </div>
</div>

</body>
</html>
