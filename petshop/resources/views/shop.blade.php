@extends('layouts.app')

@section('title', 'Shop - Paw Paradise')

@section('content')
<div class="container-fluid py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Filters Sidebar -->
            <div class="col-lg-3">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Filters</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('shop') }}" method="GET">
                            <!-- Search -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Search</label>
                                <input type="text" name="search" class="form-control" placeholder="Search pets..." value="{{ request('search') }}">
                            </div>

                            <!-- Species Filter -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Species</label>
                                <select name="species" class="form-select">
                                    <option value="">All Species</option>
                                    @foreach($species as $specie)
                                        <option value="{{ $specie->id }}" {{ request('species') == $specie->id ? 'selected' : '' }}>
                                            {{ $specie->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Price Range -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Price Range</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="number" name="min_price" class="form-control" placeholder="Min" value="{{ request('min_price') }}">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" name="max_price" class="form-control" placeholder="Max" value="{{ request('max_price') }}">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                            <a href="{{ route('shop') }}" class="btn btn-outline-secondary w-100 mt-2">Clear Filters</a>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4>Showing {{ $pets->count() }} of {{ $pets->total() }} pets</h4>
                </div>

                <div class="row g-4">
                    @forelse($pets as $pet)
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
                                    <span class="text-muted small">{{ $pet->quantity }} in stock</span>
                                </div>
                                <h5 class="card-title">{{ $pet->name }}</h5>
                                @if($pet->breed)
                                    <p class="text-muted small mb-2">Breed: {{ $pet->breed }}</p>
                                @endif
                                <p class="text-primary fw-bold fs-4 mb-3">₱{{ number_format($pet->price, 2) }}</p>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('pets.show', $pet->id) }}" class="btn btn-outline-primary flex-fill">Details</a>
                                    @auth
                                        @if(auth()->user()->role !== 'admin')
                                            <form action="{{ route('cart.add', $pet) }}" method="POST" class="flex-fill">
                                                @csrf
                                                <button type="submit" class="btn btn-primary w-100" {{ $pet->quantity == 0 ? 'disabled' : '' }}>
                                                    <i class="fas fa-cart-plus"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-primary flex-fill">
                                            <i class="fas fa-cart-plus"></i>
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <h5>No pets found</h5>
                            <p>Try adjusting your filters or check back later for new arrivals!</p>
                        </div>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-5">
                    {{ $pets->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection