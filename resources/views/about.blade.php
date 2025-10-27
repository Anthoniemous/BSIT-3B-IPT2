@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<section class="container py-5">
    <div class="row text-center pt-3">
        <div class="col-lg-6 m-auto">
            <h1 class="h1">About Our Company</h1>
            <p>We are a team of passionate designers and developers who love creating stylish and functional eCommerce experiences.</p>
        </div>
    </div>

    <div class="row py-5">
        <div class="col-md-6">
            <img src="{{ asset('assets/img/about-hero.svg') }}" alt="About Us" class="img-fluid">
        </div>
        <div class="col-md-6 d-flex align-items-center">
            <div>
                <h2 class="h2">Who We Are</h2>
                <p>
                    Zay Shop was founded with a simple mission — to make online shopping easy, modern, and enjoyable.  
                    We focus on creating beautiful layouts, reliable features, and easy-to-use navigation.
                </p>
                <p>
                    Every product in our collection is selected carefully to ensure high quality and customer satisfaction.
                </p>
                <a href="{{ url('/shop') }}" class="btn btn-success mt-3">Explore Our Shop</a>
            </div>
        </div>
    </div>
</section>
@endsection
