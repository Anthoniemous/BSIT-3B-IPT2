@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Welcome, {{ Auth::user()->name }}</h2>
    
    <h3>Products</h3>
    <div class="row">
        @foreach($products as $product)
        <div class="col-md-4">
            <div class="card mb-3">
                <img src="{{ asset('storage/products/'.$product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ $product->description }}</p>
                    <p class="card-text">Price: ₱{{ $product->price }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
