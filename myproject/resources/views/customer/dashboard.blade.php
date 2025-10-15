@extends('layouts.app')

@section('content')
<style>
  h1, h2 {
    color: #FFD699;
    font-family: 'Merriweather', serif;
  }

  .header-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: wrap;
  }

  .search-bar {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .search-bar input {
    width: 250px;
    padding: 8px 12px;
    border-radius: 8px;
    border: none;
  }

  .search-bar button {
    padding: 8px 16px;
    background-color: #FFD699;
    color: #3B1F0D;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
  }

  .search-bar button:hover {
    background-color: #FFA500;
  }

  .main-content {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
  }

  .product-card {
    width: 220px;
    height: 350px;
    background-color: #4B2D19;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    display: flex;
    flex-direction: column;
    transition: transform 0.2s;
  }

  .product-card img {
    width: 100%;
    height: 150px;
    object-fit: cover;
  }

  .product-card:hover {
    transform: translateY(-5px);
  }

  .product-card-body {
    padding: 15px;
    flex: 1;
  }

  .product-card-title {
    font-weight: 700;
    font-size: 1.2rem;
    margin-bottom: 5px;
    color: #FFD699;
  }

  .product-card-price {
    font-weight: 600;
    margin-bottom: 10px;
    color: #FFA500;
  }

  .product-card-footer {
    padding: 10px 15px;
  }

  .btn-order {
    background-color: #FFD699;
    color: #3B1F0D;
    font-weight: 600;
    width: 100%;
    padding: 8px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
  }

  .btn-order:hover {
    transform: translateY(-2px);
    background-color: #FFA500;
  }

  .alert-success {
    background-color: #3B2615;
    color: #FFD699;
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 20px;
    text-align: center;
  }
</style>

<div class="header-bar">
  <h1>Welcome, {{ Auth::user()->name }}!</h1>
  <!-- Search Form -->
  <form method="GET" action="{{ route('customer.dashboard') }}" class="search-bar">
    <label for="search-input" style="color:#FFD699; font-weight:600;">Search:</label>
    <input type="text" id="search-input" name="search" placeholder="Type product..." value="{{ request('search') }}">
    <button type="submit">enter</button>
  </form>
</div>

@if(session('success'))
  <div class="alert-success">
    {{ session('success') }}
  </div>
@endif

<!-- Product List -->
<div class="main-content">
  @if(isset($products) && $products->count() > 0)
    @foreach($products as $product)
      <div class="product-card">
        <img src="{{ $product->image ? asset('storage/products/'.$product->image) : 'https://via.placeholder.com/300x200.png?text=Coffee' }}" alt="{{ $product->name }}">
        <div class="product-card-body">
          <h5 class="product-card-title">{{ $product->name }}</h5>
          <p class="product-card-price">₱ {{ number_format($product->price,2) }}</p>
          <p>{{ $product->description }}</p>
        </div>
        <div class="product-card-footer">
          <form action="{{ route('cart.add', $product->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn-order">Add to Cart</button>
          </form>
        </div>
      </div>
    @endforeach
  @else
    <p class="text-center">No products found.</p>
  @endif
</div>
@endsection
