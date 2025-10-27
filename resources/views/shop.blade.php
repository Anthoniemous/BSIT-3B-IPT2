@extends('layouts.app')

@section('title', 'Shop')

@section('content')
<section class="container py-5">
    <div class="row text-center pt-3">
        <div class="col-lg-6 m-auto">
            <h1 class="h1">Shop</h1>
            <p>Browse our collection of high-quality products. Find something you'll love!</p>
        </div>
    </div>

    <div class="row">
        @foreach(range(1,6) as $i)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ asset("assets/img/shop_0$i.jpg") }}" class="card-img-top" alt="Product {{ $i }}">
                    <div class="card-body text-center">
                        <h5 class="card-title">Product {{ $i }}</h5>
                        <p class="card-text">High-quality and trendy item #{{ $i }} for your style and comfort.</p>
                        <p class="text-success fw-bold">$ {{ rand(25,99) }}</p>
                        <a href="#" class="btn btn-success">Add to Cart</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection
