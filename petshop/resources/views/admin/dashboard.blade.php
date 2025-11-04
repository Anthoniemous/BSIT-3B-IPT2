@extends('layouts.app')

@section('title', 'Admin Dashboard - Paw Paradise')

@section('content')
<div class="container-fluid py-4">
    <h1 class="mb-4">Admin Dashboard</h1>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card text-white bg-primary h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">Total Pets</h6>
                            <h2 class="mb-0">{{ $totalPets }}</h2>
                        </div>
                        <i class="fas fa-paw fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card text-white bg-success h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">Total Sales</h6>
                            <h2 class="mb-0">₱{{ number_format($totalSales, 2) }}</h2>
                        </div>
                        <i class="fas fa-dollar-sign fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card text-white bg-warning h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">Pending Orders</h6>
                            <h2 class="mb-0">{{ $pendingOrders }}</h2>
                        </div>
                        <i class="fas fa-clock fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card text-white bg-info h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">Species</h6>
                            <h2 class="mb-0">{{ $totalSpecies }}</h2>
                        </div>
                        <i class="fas fa-list fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4">
        <div class="col-lg-3 col-md-6">
            <a href="{{ route('admin.pets.index') }}" class="card text-decoration-none hover-shadow">
                <div class="card-body text-center py-4">
                    <i class="fas fa-paw fa-3x text-primary mb-3"></i>
                    <h5>Manage Pets</h5>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6">
            <a href="{{ route('admin.species.index') }}" class="card text-decoration-none hover-shadow">
                <div class="card-body text-center py-4">
                    <i class="fas fa-list fa-3x text-success mb-3"></i>
                    <h5>Manage Species</h5>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6">
            <a href="{{ route('admin.suppliers.index') }}" class="card text-decoration-none hover-shadow">
                <div class="card-body text-center py-4">
                    <i class="fas fa-truck fa-3x text-warning mb-3"></i>
                    <h5>Manage Suppliers</h5>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6">
            <a href="{{ route('admin.sales.index') }}" class="card text-decoration-none hover-shadow">
                <div class="card-body text-center py-4">
                    <i class="fas fa-shopping-cart fa-3x text-info mb-3"></i>
                    <h5>View Sales</h5>
                </div>
            </a>
        </div>
    </div>
</div>

<style>
.hover-shadow:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    transform: translateY(-2px);
    transition: all 0.3s;
}
</style>
@endsection