@extends('layouts.app')

@section('title', 'About Us - Paw Paradise')

@section('content')
<div class="container-fluid page-header py-5 mb-5" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1415369629372-26f2fe60c467?w=1200') center/cover;">
    <div class="container py-5">
        <h1 class="display-3 text-white mb-3">About Us</h1>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <div class="col-lg-6">
            <h1 class="mb-4">Welcome to <span class="text-primary">Paw Paradise</span></h1>
            <p class="mb-4">Paw Paradise is your trusted partner in finding the perfect pet companion. With years of experience in pet care and animal welfare, we pride ourselves on providing healthy, happy pets to loving homes.</p>
            <p class="mb-4">Our mission is to connect families with pets that bring joy, companionship, and unconditional love. Every pet in our care receives the highest standard of veterinary attention, nutrition, and socialization.</p>
            <div class="row g-4">
                <div class="col-6">
                    <div class="border-start border-5 border-primary ps-4">
                        <h2 class="display-5 text-primary mb-0" data-toggle="counter-up">500+</h2>
                        <p class="mb-0">Happy Families</p>
                    </div>
                </div>
                <div class="col-6">
                    <div class="border-start border-5 border-primary ps-4">
                        <h2 class="display-5 text-primary mb-0" data-toggle="counter-up">100+</h2>
                        <p class="mb-0">Pets Available</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <img src="https://images.unsplash.com/photo-1601758003122-53c40e686a19?w=600" class="img-fluid rounded" alt="Pet Shop">
        </div>
    </div>
</div>

<div class="container-fluid py-5 bg-light">
    <div class="container">
        <div class="text-center mx-auto mb-5" style="max-width: 600px;">
            <h1 class="display-5 mb-3">Why Choose Us?</h1>
            <p>We are committed to excellence in pet care and customer service</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 text-center p-4">
                    <i class="fas fa-check-circle fa-3x text-primary mb-3"></i>
                    <h5>Certified & Healthy Pets</h5>
                    <p>All pets are vaccinated, health-checked, and come with complete documentation.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 text-center p-4">
                    <i class="fas fa-hands-helping fa-3x text-primary mb-3"></i>
                    <h5>Expert Guidance</h5>
                    <p>Our knowledgeable team provides ongoing support and advice for pet care.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 text-center p-4">
                    <i class="fas fa-home fa-3x text-primary mb-3"></i>
                    <h5>Perfect Match</h5>
                    <p>We help you find the ideal pet that fits your lifestyle and family.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
