@extends('layouts.app')

@section('title', 'Contact Us - Paw Paradise')

@section('content')
<div class="container-fluid page-header py-5 mb-5" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1423666639041-f56000c27a9a?w=1200') center/cover;">
    <div class="container py-5">
        <h1 class="display-3 text-white mb-3">Contact Us</h1>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <div class="col-lg-6">
            <h2 class="mb-4">Get In Touch</h2>
            <p class="mb-4">Have questions about our pets or services? We'd love to hear from you! Fill out the form and we'll respond as soon as possible.</p>
            
            <div class="d-flex mb-3">
                <div class="flex-shrink-0 btn-square bg-primary rounded-circle me-3">
                    <i class="fa fa-map-marker-alt text-white"></i>
                </div>
                <div>
                    <h6>Visit Us</h6>
                    <span>123 Pet Street, Davao City, Philippines</span>
                </div>
            </div>
            
            <div class="d-flex mb-3">
                <div class="flex-shrink-0 btn-square bg-primary rounded-circle me-3">
                    <i class="fa fa-phone-alt text-white"></i>
                </div>
                <div>
                    <h6>Call Us</h6>
                    <span>+63 123 456 7890</span>
                </div>
            </div>
            
            <div class="d-flex mb-3">
                <div class="flex-shrink-0 btn-square bg-primary rounded-circle me-3">
                    <i class="fa fa-envelope text-white"></i>
                </div>
                <div>
                    <h6>Email Us</h6>
                    <span>info@pawparadise.com</span>
                </div>
            </div>

            <div class="d-flex">
                <div class="flex-shrink-0 btn-square bg-primary rounded-circle me-3">
                    <i class="fa fa-clock text-white"></i>
                </div>
                <div>
                    <h6>Opening Hours</h6>
                    <span>Mon - Sat: 9:00 AM - 7:00 PM</span><br>
                    <span>Sunday: 10:00 AM - 5:00 PM</span>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-body p-5">
                    <form method="POST" action="{{ route('contact.submit') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                       placeholder="Your Name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                       placeholder="Your Email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" 
                                       placeholder="Subject" value="{{ old('subject') }}" required>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <textarea name="message" class="form-control @error('message') is-invalid @enderror" 
                                          placeholder="Your Message" rows="5" required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
