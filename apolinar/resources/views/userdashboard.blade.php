<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>User Dashboard - Glamour Makeup Store</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="{{ asset('css/userdashboard.css') }}">
</head>
<body>

  <header class="site-header">
    <div class="container header-inner">
      <div class="logo">
        <img src="{{ asset('css/img/image.png') }}" alt="Glamour Logo">
        <span class="brand">Glamour Makeup Store 💋</span>
      </div>

      <nav class="main-nav">
        <ul>
          <li><a href="{{ url('/') }}">Home</a></li>
        </ul>
      </nav>

      <div class="user-option">
        @auth
          <a href="{{ route('orders.index') }}" class="btn small">My Orders</a>
          <a href="{{ route('cart.index') }}" class="btn small">My Cart 💄</a>
          <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" class="btn outline small">Logout</button>
          </form>
        @endauth
      </div>
    </div>
  </header>

  <main class="container" style="padding-top: 30px;">
    <header class="section-header">
      <h2>Our Glamorous Collection</h2>
      <p class="section-sub">Indulge in your favorite beauty essentials ✨</p>
    </header>

    <div class="product-cards">
      @foreach($products as $product)
        <div class="product-card">
          <div class="card-media">
            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->product_name }}">
          </div>
          <div class="card-body">
            <h3>{{ $product->product_name }}</h3>
            <p class="price">₱{{ number_format($product->price, 2) }}</p>

            <form method="POST" action="{{ route('cart.add', $product->product_id) }}">
              @csrf
              <button type="submit" class="btn add-cart">Add to Cart</button>
            </form>
          </div>
        </div>
      @endforeach
    </div>
  </main>

</body>
</html>
