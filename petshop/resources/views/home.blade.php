<!-- resources/views/home.blade.php -->
@extends('layouts.app')

@section('title', 'Home - Paw Paradise')

@section('content')
<!-- Hero Section -->
<div class="hero-section d-flex align-items-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <h1 class="display-3 fw-bold mb-4">Find Your Perfect Companion</h1>
                <p class="fs-5 mb-4">Discover adorable pets looking for their forever home. Quality pets, healthy and well-cared for.</p>
                <a href="{{ route('shop') }}" class="btn btn-primary btn-lg px-5 py-3">Shop Now</a>
            </div>
        </div>
    </div>
</div>

<!-- Features -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="text-center p-4">
                    <i class="fas fa-heart fa-3x text-primary mb-3"></i>
                    <h5>Healthy Pets</h5>
                    <p>All our pets are vaccinated and health-checked by certified veterinarians.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="text-center p-4">
                    <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
                    <h5>Quality Guarantee</h5>
                    <p>We ensure all pets are from reliable suppliers and well-cared for.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="text-center p-4">
                    <i class="fas fa-headset fa-3x text-primary mb-3"></i>
                    <h5>24/7 Support</h5>
                    <p>Our team is always ready to help you with any questions or concerns.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Categories -->
<div class="container-fluid py-5 bg-light">
    <div class="container">
        <div class="text-center mx-auto mb-5" style="max-width: 600px;">
            <h1 class="display-5 mb-3">Pet Categories</h1>
            <p>Browse pets by species to find your perfect match</p>
        </div>
        <div class="row g-4">
            @foreach($species as $specie)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <a href="{{ route('shop', ['species' => $specie->id]) }}" class="text-decoration-none">
                    <div class="card pet-card h-100 text-center p-4">
                        <i class="fas fa-paw fa-4x text-primary mb-3"></i>
                        <h5>{{ $specie->name }}</h5>
                        <p class="text-muted mb-0">{{ $specie->pets_count }} available</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Featured Pets -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5" style="max-width: 600px;">
            <h1 class="display-5 mb-3">Featured Pets</h1>
            <p>Check out our latest arrivals and find your new best friend</p>
        </div>
        <div class="row g-4">
            @forelse($featuredPets as $pet)
            <div class="col-lg-4 col-md-6">
                <div class="card pet-card h-100">
                    @if($pet->image)
                        <img src="{{ asset('storage/' . $pet->image) }}" class="card-img-top" alt="{{ $pet->name }}">
                    @else
                        <img src="https://via.placeholder.com/400x300?text={{ urlencode($pet->name) }}" class="card-img-top" alt="{{ $pet->name }}">
                    @endif
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-primary">{{ $pet->species->name }}</span>
                            <span class="text-muted small">{{ $pet->quantity }} available</span>
                        </div>
                        <h5 class="card-title">{{ $pet->name }}</h5>
                        @if($pet->breed)
                            <p class="text-muted small mb-2">Breed: {{ $pet->breed }}</p>
                        @endif
                        <p class="text-primary fw-bold fs-4 mb-3">₱{{ number_format($pet->price, 2) }}</p>
                        <div class="d-flex gap-2">
                            <a href="{{ route('pets.show', $pet->id) }}" class="btn btn-outline-primary flex-fill">View Details</a>
                            @auth
                                @if(auth()->user()->role !== 'admin')
                                    <form action="{{ route('cart.add', $pet) }}" method="POST" class="flex-fill">
                                        @csrf
                                        <button type="submit" class="btn btn-primary w-100" {{ $pet->quantity == 0 ? 'disabled' : '' }}>
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    No pets available at the moment. Please check back later!
                </div>
            </div>
            @endforelse
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('shop') }}" class="btn btn-primary btn-lg px-5">View All Pets</a>
        </div>
    </div>
</div>

<!-- Testimonials -->
<div class="container-fluid py-5 bg-light">
    <div class="container">
        <div class="text-center mx-auto mb-5" style="max-width: 600px;">
            <h1 class="display-5 mb-3">What Our Customers Say</h1>
            <p>Read reviews from our happy pet parents</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="ps-3">
                            <h6 class="mb-1">Maria Santos</h6>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mb-0">"I got my adorable puppy from Paw Paradise and couldn't be happier! The staff was knowledgeable and caring. Highly recommended!"</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="ps-3">
                            <h6 class="mb-1">Juan Dela Cruz</h6>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mb-0">"Great experience! All pets are healthy and well-maintained. The team really cares about the animals. Will definitely come back!"</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="ps-3">
                            <h6 class="mb-1">Ana Reyes</h6>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mb-0">"Perfect place to find your furry companion. The variety of pets and excellent customer service made my experience wonderful!"</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection