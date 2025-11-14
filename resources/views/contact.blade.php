@extends('layouts.app')

@section('content')
<!-- ***** Contact Section Start ***** -->
<section class="py-5 bg-white" id="contact">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="font-weight-bold text-success">Contact Us</h2>
            <p class="text-muted">We’d love to hear from you. Send us a message and we’ll respond as soon as possible.</p>
        </div>

        <div class="row">
            <!-- Contact Form -->
            <div class="col-lg-6 mb-4">
                <form action="#" method="post" class="p-4 bg-light rounded shadow-sm">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="name" class="text-success font-weight-bold">Your Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter your full name">
                    </div>
                    <div class="form-group mb-3">
                        <label for="email" class="text-success font-weight-bold">Email Address</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email address">
                    </div>
                    <div class="form-group mb-3">
                        <label for="message" class="text-success font-weight-bold">Message</label>
                        <textarea name="message" id="message" rows="5" class="form-control" placeholder="Write your message here"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success px-4">Send Message</button>
                </form>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-6">
                <div class="p-4 bg-light rounded shadow-sm h-100">
                    <h5 class="text-success font-weight-bold mb-3">Get in Touch</h5>
                    <p class="text-muted mb-1"><i class="fa fa-map-marker text-success mr-2"></i>123 Street, Metro City, Philippines</p>
                    <p class="text-muted mb-1"><i class="fa fa-phone text-success mr-2"></i>+63 900 123 4567</p>
                    <p class="text-muted mb-4"><i class="fa fa-envelope text-success mr-2"></i>support@carshop.com</p>
                    <h6 class="font-weight-bold text-success mb-2">Business Hours</h6>
                    <p class="text-muted">Mon - Sat: 8:00 AM – 6:00 PM<br>Sunday: Closed</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ***** Contact Section End ***** -->
@endsection
