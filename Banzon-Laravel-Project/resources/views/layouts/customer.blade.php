<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title', 'Customer')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries -->
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Bootstrap + Template -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body>
    <!-- Spinner -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
    </div>

    <!-- Navbar -->
    <div class="container-fluid bg-white sticky-top">
        <div class="container">
            <nav class="navbar navbar-expand-lg bg-white navbar-light py-2 py-lg-0">
                <a href="{{ route('customer.dashboard') }}" class="navbar-brand {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                    <img class="img-fluid" src="{{ asset('img/logo.png') }}" alt="Logo">
                </a>

                <button type="button" class="navbar-toggler ms-auto me-0" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto">
                        <a href="{{ route('customer.dashboard') }}"
                           class="nav-item nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                            Store
                        </a>

                        <a href="{{ route('wishlist') }}"
                           class="nav-item nav-link {{ request()->routeIs('wishlist') ? 'active' : '' }}">
                            Wishlist
                        </a>

                        <a href="{{ route('cart.view') }}"
                           class="nav-item nav-link {{ request()->routeIs('cart.view') ? 'active' : '' }}">
                            Cart
                        </a>

                        <a href="{{ route('checkout') }}"
                           class="nav-item nav-link {{ request()->routeIs('checkout.view') ? 'active' : '' }}">
                            Checkout
                        </a>

                        <a href="{{ route('purchases.index') }}"
                            class="nav-item nav-link {{ request()->routeIs('purchases.*') ? 'active' : '' }}">
                            My Purchases
                            </a>


                        {{-- Profile (image) --}}
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle d-flex align-items-center gap-2"
                            data-bs-toggle="dropdown" aria-expanded="false">

                                @php
                                    // DB stores: uploads/profile_images/... :contentReference[oaicite:2]{index=2}
                                    $profileSrc = (!empty($navCustomer?->profile_image))
                                        ? asset('storage/' . $navCustomer->profile_image)
                                        : asset('img/default-profile.png');
                                @endphp

                                <img src="{{ $profileSrc }}"
                                    alt="Profile"
                                    class="rounded-circle border"
                                    style="width: 36px; height: 36px; object-fit: cover;">
                            </a>

                            <div class="dropdown-menu dropdown-menu-end bg-light rounded-0 m-0">
                                <a href="{{ route('profile.edit') }}"
                                class="dropdown-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                                    My Profile
                                </a>

                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>                  
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <!-- Page Header -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5">
            <h1 class="display-2 text-dark mb-4 animated slideInDown">@yield('page_heading', 'Page')</h1>

            @hasSection('breadcrumb')
                <nav aria-label="breadcrumb animated slideInDown">
                    <ol class="breadcrumb justify-content-center mb-0">
                        @yield('breadcrumb')
                    </ol>
                </nav>
            @endif
        </div>
    </div>

    <!-- Content -->
    @yield('content')

    <!-- Footer -->
    <div class="container-fluid bg-dark footer mt-5 py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-primary mb-4">Our Office</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt text-primary me-3"></i>123 Street, New York, USA</p>
                    <p class="mb-2"><i class="fa fa-phone-alt text-primary me-3"></i>+012 345 67890</p>
                    <p class="mb-2"><i class="fa fa-envelope text-primary me-3"></i>info@example.com</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-primary mb-4">Quick Links</h4>
                    <a class="btn btn-link" href="#">About Us</a>
                    <a class="btn btn-link" href="#">Contact Us</a>
                    <a class="btn btn-link" href="#">Support</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-primary mb-4">Business Hours</h4>
                    <p class="mb-1">Monday - Friday</p>
                    <h6 class="text-light">09:00 am - 07:00 pm</h6>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-primary mb-4">Newsletter</h4>
                    <div class="position-relative w-100">
                        <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                        <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top">
        <i class="bi bi-arrow-up"></i>
    </a>

    <!-- JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <script src="{{ asset('js/main.js') }}"></script>

    @stack('scripts')
</body>
</html>
