@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<section class="container py-5">
    <div class="row text-center pt-3">
        <div class="col-lg-6 m-auto">
            <h1 class="h1">Contact Us</h1>
            <p>We’d love to hear from you! Use the form below or reach out through our social media.</p>
        </div>
    </div>

    <div class="row py-5">
        <div class="col-md-6">
            <h2 class="h2">Get in Touch</h2>
            <p><i class="fa fa-map-marker-alt me-2"></i> 123 Shopping Street, City, 10660</p>
            <p><i class="fa fa-phone me-2"></i> +01 020 0340</p>
            <p><i class="fa fa-envelope me-2"></i> info@company.com</p>
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.8354345086167!2d144.95373631531697!3d-37.81720997975171!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf577c1a4a1d2c0f5!2sEnvato!5e0!3m2!1sen!2sau!4v1614030241983!5m2!1sen!2sau" 
                width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>

        <div class="col-md-6">
            <form action="#" method="post">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Your Message</label>
                    <textarea id="message" name="message" rows="5" class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn btn-success">Send Message</button>
            </form>
        </div>
    </div>
</section>
@endsection
