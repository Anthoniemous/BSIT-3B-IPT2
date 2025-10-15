@extends('layouts.admin')

@section('content')
<div class="container">
  <h1 class="text-center mb-4">Welcome, {{ session('admin_name') ?? Auth::user()->name ?? 'Admin' }}!</h1>

  @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
  @endif

  <!-- Products Overview Card -->
  <div class="mb-4">
      <div class="card p-3 bg-transparent border-0">
          <h2>🛍 Products Overview</h2>
          <a href="{{ route('products.index') }}" class="btn btn-custom mt-3 w-100">Go to Product Management</a>
      </div>
  </div>

  <!-- Product Cards -->
  <div class="row g-4">
      @if(isset($products) && count($products) > 0)
          @foreach($products as $product)
              <div class="col-md-6 col-lg-4">
                  <div class="product-card">
                      <img src="{{ asset('storage/products/' . ($product->image ?? 'default.png')) }}" alt="{{ $product->name }}" class="img-fluid">
                      <div class="product-card-body">
                          <h5 class="product-card-title">{{ $product->name }}</h5>
                          <p class="product-card-price">₱ {{ number_format($product->price, 2) }}</p>
                          <p>Category: {{ $product->category ?? '-' }}</p>
                      </div>
                  </div>
              </div>
          @endforeach
      @else
          <p class="text-center mt-4">No products yet.</p>
      @endif
  </div>
</div>
@endsection
