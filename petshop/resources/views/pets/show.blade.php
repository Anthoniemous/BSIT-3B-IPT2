@extends('layouts.app')

@section('title', $pet->name . ' - Paw Paradise')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('shop') }}">Shop</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $pet->name }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        <!-- Pet Image -->
        <div class="col-lg-6">
            <div class="card">
                @if($pet->image)
                    <img src="{{ asset('storage/' . $pet->image) }}" class="card-img-top" alt="{{ $pet->name }}" style="height: 500px; object-fit: cover;">
                @else
                    <img src="https://via.placeholder.com/600x500?text={{ urlencode($pet->name) }}" class="card-img-top" alt="{{ $pet->name }}">
                @endif
            </div>
        </div>

        <!-- Pet Details -->
        <div class="col-lg-6">
            <div class="mb-3">
                <span class="badge bg-primary fs-6">{{ $pet->species->name }}</span>
                @if($pet->quantity > 0)
                    <span class="badge bg-success fs-6">In Stock ({{ $pet->quantity }})</span>
                @else
                    <span class="badge bg-danger fs-6">Out of Stock</span>
                @endif
            </div>

            <h1 class="display-5 mb-3">{{ $pet->name }}</h1>
            
            @if($pet->breed)
                <p class="text-muted fs-5 mb-3">Breed: {{ $pet->breed }}</p>
            @endif

            <h2 class="text-primary mb-4">₱{{ number_format($pet->price, 2) }}</h2>

            @if($pet->description)
                <div class="mb-4">
                    <h5>Description</h5>
                    <p>{{ $pet->description }}</p>
                </div>
            @endif

            <div class="mb-4">
                <h5>Details</h5>
                <ul class="list-unstyled">
                    <li><strong>Species:</strong> {{ $pet->species->name }}</li>
                    @if($pet->breed)
                        <li><strong>Breed:</strong> {{ $pet->breed }}</li>
                    @endif
                    @if($pet->trait)
                        <li><strong>Trait:</strong> {{ $pet->trait->description }}</li>
                    @endif
                    @if($pet->arrival_date)
                        <li><strong>Arrival Date:</strong> {{ $pet->arrival_date->format('M d, Y') }}</li>
                    @endif
                    @if($pet->supplier)
                        <li><strong>Supplier:</strong> {{ $pet->supplier->full_name }}</li>
                    @endif
                </ul>
            </div>

            @auth
                @if(auth()->user()->role !== 'admin')
                    <form action="{{ route('cart.add', $pet) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-lg px-5" {{ $pet->quantity == 0 ? 'disabled' : '' }}>
                            <i class="fas fa-cart-plus me-2"></i>Add to Cart
                        </button>
                    </form>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-5">
                    <i class="fas fa-sign-in-alt me-2"></i>Login to Purchase
                </a>
            @endauth
        </div>
    </div>

    <!-- Related Pets -->
    @if($relatedPets->count() > 0)
    <div class="mt-5">
        <h3 class="mb-4">Similar Pets</h3>
        <div class="row g-4">
            @foreach($relatedPets as $relatedPet)
            <div class="col-lg-3 col-md-6">
                <div class="card pet-card h-100">
                    @if($relatedPet->image)
                        <img src="{{ asset('storage/' . $relatedPet->image) }}" class="card-img-top" alt="{{ $relatedPet->name }}">
                    @else
                        <img src="https://via.placeholder.com/300x250?text={{ urlencode($relatedPet->name) }}" class="card-img-top" alt="{{ $relatedPet->name }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $relatedPet->name }}</h5>
                        <p class="text-primary fw-bold">₱{{ number_format($relatedPet->price, 2) }}</p>
                        <a href="{{ route('pets.show', $relatedPet->id) }}" class="btn btn-outline-primary w-100">View Details</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection-fluid page-header py-5 mb-5" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1601758228041-f3b2795255f1?w=1200') center/cover;">
    <div class="container py-5">
        <h1 class="display-3 text-white mb-3">Our Pets</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white">Home</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Shop</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container