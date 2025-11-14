<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="utf-8">
    <title>Cental - Car Shop</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
   <!-- ======= Navbar Start ======= -->
<nav class="navbar navbar-expand-lg navbar-light bg-light py-3 shadow-sm">
    <div class="container">
        <a class="navbar-brand font-weight-bold text-success" href="{{ url('/') }}"
   style="font-size: 2rem; letter-spacing: 1px;">
    <i class="fa fa-car mr-2"></i>CarShop
</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <!-- Left Nav Links -->
            <ul class="navbar-nav align-items-center mr-auto">
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/products') }}">Products</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">About</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/contact') }}">Contact</a></li>
            </ul>

            <!-- Right Side (Auth Links / Dropdown) -->
            <ul class="navbar-nav align-items-center">
                @guest
                    <!-- Sign In / Sign Up Buttons -->
                    <li class="nav-item mx-1">
                        <a href="{{ route('login') }}" class="btn btn-outline-success btn-sm px-3 py-1">
                            <i class="fa fa-sign-in mr-1"></i> Sign In
                        </a>
                    </li>
                    <li class="nav-item mx-1">
                        <a href="{{ route('register') }}" class="btn btn-success btn-sm px-3 py-1 text-white">
                            <i class="fa fa-user-plus mr-1"></i> Sign Up
                        </a>
                    </li>
                @else
                    <!-- Profile Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                           role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('assets/images/default-avatar.png') }}"
                                 class="rounded-circle mr-2"
                                 style="width:32px; height:32px; object-fit:cover;">
                            <span class="text-dark font-weight-bold">{{ Auth::user()->name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow-sm border-0 rounded">
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="fa fa-user text-success mr-2"></i>Edit Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('logout') }}" method="POST" class="px-3">
                                @csrf
                                <button type="submit" class="btn btn-link p-0 text-danger">
                                    <i class="fa fa-sign-out mr-2"></i>Logout
                                </button>
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
<!-- ======= Navbar End ======= -->

    <!-- ======= Navbar End ======= -->

     <!-- Carousel Start -->
    <div class="header-carousel">
        <div id="carouselId" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <ol class="carousel-indicators">
                <li data-bs-target="#carouselId" data-bs-slide-to="0" class="active"></li>
                <li data-bs-target="#carouselId" data-bs-slide-to="1"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active">
                    <img src="assets/img/carousel-2.jpg" class="img-fluid w-100" alt="First slide"/>
                    <div class="carousel-caption">
                        <div class="container py-4">
                            <div class="row g-5">
                                <div class="col-lg-6 fadeInLeft animated">
                                    <div class="bg-secondary rounded p-5">
                                        <h4 class="text-white mb-4">FIND YOUR DREAM CAR</h4>
                                        <form>
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <select class="form-select" aria-label="Select car type">
                                                        <option selected>Select Your Car type</option>
                                                        <option value="1">Mercedes Benz R3</option>
                                                        <option value="2">Toyota Corolla Cross</option>
                                                        <option value="3">Tesla Model S Plaid</option>
                                                        <option value="4">Hyundai Kona Electric</option>
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <input class="form-control" type="text" placeholder="Enter your budget" aria-label="Budget">
                                                </div>
                                                <div class="col-12">
                                                    <button type="button" class="btn btn-light w-100 py-2">Search Now</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-6 d-none d-lg-flex fadeInRight animated">
                                    <div class="text-start">
                                        <h1 class="display-5 text-white">Get Your Dream Car Today!</h1>
                                        <p class="text-white">Find the perfect car for you</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="assets/img/carousel-1.jpg" class="img-fluid w-100" alt="Second slide"/>
                    <div class="carousel-caption">
                        <div class="container py-4">
                            <div class="row g-5">
                                <div class="col-lg-6 fadeInLeft animated">
                                    <div class="bg-secondary rounded p-5">
                                        <h4 class="text-white mb-4">FIND YOUR DREAM CAR</h4>
                                        <form>
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <select class="form-select" aria-label="Select car type">
                                                        <option selected>Select Your Car type</option>
                                                        <option value="1">Mercedes Benz R3</option>
                                                        <option value="2">Toyota Corolla Cross</option>
                                                        <option value="3">Tesla Model S Plaid</option>
                                                        <option value="4">Hyundai Kona Electric</option>
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <input class="form-control" type="text" placeholder="Enter your budget" aria-label="Budget">
                                                </div>
                                                <div class="col-12">
                                                    <button type="button" class="btn btn-light w-100 py-2">Search Now</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-6 d-none d-lg-flex fadeInRight animated">
                                    <div class="text-start">
                                        <h1 class="display-5 text-white">Choose Your Perfect Model</h1>
                                        <p class="text-white">Quality cars at great prices</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->


    <!-- ======= Hero Section Start ======= -->
    <header class="hero bg-dark text-white text-center py-5" style="background: url('{{ asset('assets/images/hero-bg.jpg') }}') center/cover no-repeat;">
        <div class="container">
            <h1 class="display-4 font-weight-bold">Welcome to CarShop</h1>
            <p class="lead">Find the best deals on car accessories and parts.</p>
            <a href="{{ url('/products') }}" class="btn btn-success btn-lg mt-3">Shop Now</a>
        </div>
         <style>
        :root {
            --primary: #F39C12;
            --secondary: #2C3E50;
            --light: #F8F9FA;
            --dark: #1C2A38;
        }

        body {
            font-family: 'Lato', sans-serif;
            color: #666;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
        }

        .text-primary {
            color: var(--primary) !important;
        }

        .bg-primary {
            background-color: var(--primary) !important;
        }

        .bg-secondary {
            background-color: var(--secondary) !important;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: #E67E22;
            border-color: #E67E22;
        }

        .btn-secondary {
            background-color: var(--secondary);
            border-color: var(--secondary);
        }

        /* Spinner */
        #spinner {
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.5s ease-out, visibility 0s linear 0.5s;
            z-index: 99999;
        }

        #spinner.show {
            transition: opacity 0.5s ease-out, visibility 0s linear 0s;
            visibility: visible;
            opacity: 1;
        }

        /* Navbar */
        .nav-bar {
            background: #fff;
        }

        .navbar-light .navbar-nav .nav-link {
            color: var(--dark);
            font-weight: 500;
            padding: 15px 20px;
        }

        .navbar-light .navbar-nav .nav-link:hover,
        .navbar-light .navbar-nav .nav-link.active {
            color: var(--primary);
        }

        .sticky-top {
            top: 0;
            z-index: 999;
        }

        /* Hero Carousel */
        .header-carousel .carousel-item {
            position: relative;
            min-height: 600px;
        }

        .header-carousel .carousel-item img {
            object-fit: cover;
            min-height: 600px;
        }

        .header-carousel .carousel-caption {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.4);
        }

        /* Categories */
        .categories-item {
            background: #fff;
            border-radius: 10px;
            transition: 0.3s;
        }

        .categories-item:hover {
            box-shadow: 0 0 45px rgba(0, 0, 0, 0.1);
            transform: translateY(-5px);
        }

        .categories-img {
            overflow: hidden;
        }

        .categories-img img {
            transition: 0.5s;
        }

        .categories-item:hover .categories-img img {
            transform: scale(1.1);
        }

        .categories-content {
            background: #f8f9fa;
        }

        /* Category Logo Placeholder */
        .category-logo {
            width: 120px;
            height: 120px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            transition: 0.3s;
        }

        .category-logo:hover {
            background: var(--secondary);
            transform: scale(1.1);
        }

        .category-logo i {
            font-size: 50px;
            color: #fff;
        }

        /* About */
        .about-img {
            position: relative;
        }

        .about-img .img-1 {
            height: 450px;
        }

        /* Banner */
        .banner-item {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
        }

        .banner-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            width: 100%;
        }

        /* Footer */
        .footer {
            background: var(--dark);
        }

        .footer .footer-item a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: 0.3s;
        }

        .footer .footer-item a:hover {
            color: var(--primary);
        }

        .copyright {
            background: #1a1a1a;
        }

        /* Back to Top */
        .back-to-top {
            position: fixed;
            display: none;
            right: 30px;
            bottom: 30px;
            z-index: 99;
            width: 45px;
            height: 45px;
            text-align: center;
            line-height: 45px;
            border-radius: 50%;
        }
        
    </style>
    </header>
    <!-- ======= Hero Section End ======= -->

<!-- Categories Start -->
    <div class="container-fluid py-5" id="categories">
        <div class="container py-5">
            <div class="text-center mx-auto pb-5" style="max-width: 800px;">
                <h1 class="display-5 text-capitalize mb-3">Vehicle <span class="text-primary">Categories</span></h1>
                <p class="mb-0">Explore our wide range of vehicle categories to find the perfect car for your needs</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="text-center">
                        <div class="category-logo">
                            <i class="fas fa-car-alt"></i>
                        </div>
                        <h4>Luxury Cars</h4>
                        <p>Premium vehicles for comfort</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="text-center">
                        <div class="category-logo">
                            <i class="fas fa-car-alt"></i>
                        </div>
                        <h4>SUVs</h4>
                        <p>Spacious and powerful</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="text-center">
                        <div class="category-logo">
                            <i class="fas fa-car-alt"></i>
                        </div>
                        <h4>Electric</h4>
                        <p>Eco-friendly options</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="text-center">
                        <div class="category-logo">
                            <i class="fas fa-car-alt"></i>
                        </div>
                        <h4>Compact</h4>
                        <p>Perfect for city driving</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Categories End -->

    
    <!-- Products Start -->
    <div class="container-fluid bg-light py-5" id="products">
        <div class="container py-5">
            <div class="text-center mx-auto pb-5" style="max-width: 800px;">
                <h1 class="display-5 text-capitalize mb-3">Our <span class="text-primary">Products</span></h1>
                <p class="mb-0">Choose from our premium selection of vehicles available for purchase</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="categories-item p-4">
                        <div class="categories-item-inner">
                            <div class="categories-img rounded-top">
                                <img src="assets/img/car-1.png" class="img-fluid w-100 rounded-top" alt="Mercedes Benz R3">
                            </div>
                            <div class="categories-content rounded-bottom p-4">
                                <h4>Mercedes Benz R3</h4>
                                <div class="categories-review mb-4">
                                    <div class="me-3">4.5 Review</div>
                                    <div class="d-flex justify-content-center text-secondary">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star text-body"></i>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <h4 class="bg-white text-primary rounded-pill py-2 px-4 mb-0">$99</h4>
                                </div>
                                <div class="row gy-2 gx-0 text-center mb-4">
                                    <div class="col-4 border-end border-white">
                                        <i class="fa fa-users text-dark"></i> <span class="text-body ms-1">4 Seat</span>
                                    </div>
                                    <div class="col-4 border-end border-white">
                                        <i class="fa fa-car text-dark"></i> <span class="text-body ms-1">AT/MT</span>
                                    </div>
                                    <div class="col-4">
                                        <i class="fa fa-gas-pump text-dark"></i> <span class="text-body ms-1">Petrol</span>
                                    </div>
                                </div>
                                <button class="btn btn-primary rounded-pill d-flex justify-content-center py-3 w-100">Buy</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="categories-item p-4">
                        <div class="categories-item-inner">
                            <div class="categories-img rounded-top">
                                <img src="assets/img/car-2.png" class="img-fluid w-100 rounded-top" alt="Toyota Corolla Cross">
                            </div>
                            <div class="categories-content rounded-bottom p-4">
                                <h4>Toyota Corolla Cross</h4>
                                <div class="categories-review mb-4">
                                    <div class="me-3">3.5 Review</div>
                                    <div class="d-flex justify-content-center text-secondary">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star text-body"></i>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <h4 class="bg-white text-primary rounded-pill py-2 px-4 mb-0">$128</h4>
                                </div>
                                <div class="row gy-2 gx-0 text-center mb-4">
                                    <div class="col-4 border-end border-white">
                                        <i class="fa fa-users text-dark"></i> <span class="text-body ms-1">4 Seat</span>
                                    </div>
                                    <div class="col-4 border-end border-white">
                                        <i class="fa fa-car text-dark"></i> <span class="text-body ms-1">AT/MT</span>
                                    </div>
                                    <div class="col-4">
                                        <i class="fa fa-gas-pump text-dark"></i> <span class="text-body ms-1">Petrol</span>
                                    </div>
                                </div>
                                <button class="btn btn-primary rounded-pill d-flex justify-content-center py-3 w-100">Buy</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="categories-item p-4">
                        <div class="categories-item-inner">
                            <div class="categories-img rounded-top">
                                <img src="assets/img/car-3.png" class="img-fluid w-100 rounded-top" alt="Tesla Model S Plaid">
                            </div>
                            <div class="categories-content rounded-bottom p-4">
                                <h4>Tesla Model S Plaid</h4>
                                <div class="categories-review mb-4">
                                    <div class="me-3">3.8 Review</div>
                                    <div class="d-flex justify-content-center text-secondary">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star text-body"></i>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <h4 class="bg-white text-primary rounded-pill py-2 px-4 mb-0">$170</h4>
                                </div>
                                <div class="row gy-2 gx-0 text-center mb-4">
                                    <div class="col-4 border-end border-white">
                                        <i class="fa fa-users text-dark"></i> <span class="text-body ms-1">4 Seat</span>
                                    </div>
                                    <div class="col-4 border-end border-white">
                                        <i class="fa fa-car text-dark"></i> <span class="text-body ms-1">AT/MT</span>
                                    </div>
                                    <div class="col-4">
                                        <i class="fa fa-gas-pump text-dark"></i> <span class="text-body ms-1">Petrol</span>
                                    </div>
                                </div>
                                <button class="btn btn-primary rounded-pill d-flex justify-content-center py-3 w-100">Buy</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="categories-item p-4">
                        <div class="categories-item-inner">
                            <div class="categories-img rounded-top">
                                <img src="assets/img/car-4.png" class="img-fluid w-100 rounded-top" alt="Hyundai Kona Electric">
                            </div>
                            <div class="categories-content rounded-bottom p-4">
                                <h4>Hyundai Kona Electric</h4>
                                <div class="categories-review mb-4">
                                    <div class="me-3">4.8 Review</div>
                                    <div class="d-flex justify-content-center text-secondary">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <h4 class="bg-white text-primary rounded-pill py-2 px-4 mb-0">$187</h4>
                                </div>
                                <div class="row gy-2 gx-0 text-center mb-4">
                                    <div class="col-4 border-end border-white">
                                        <i class="fa fa-users text-dark"></i> <span class="text-body ms-1">4 Seat</span>
                                    </div>
                                    <div class="col-4 border-end border-white">
                                        <i class="fa fa-car text-dark"></i> <span class="text-body ms-1">AT/MT</span>
                                    </div>
                                    <div class="col-4">
                                        <i class="fa fa-gas-pump text-dark"></i> <span class="text-body ms-1">Petrol</span>
                                    </div>
                                </div>
                                <button class="btn btn-primary rounded-pill d-flex justify-content-center py-3 w-100">Buy</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Products End -->

      <!-- About Section Start -->
    <div class="container-fluid overflow-hidden py-5" id="about">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-xl-6">
                    <div class="about-item">
                        <div class="pb-5">
                            <h1 class="display-5 text-capitalize">Cental <span class="text-primary">About</span></h1>
                            <p class="mb-0">We are dedicated to providing the best car buying experience. With years of expertise in the automotive industry, we offer a wide selection of quality vehicles to meet your needs.</p>
                        </div>
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="about-item-inner border p-4">
                                    <div class="about-icon mb-4">
                                        <i class="fas fa-eye fa-3x text-primary"></i>
                                    </div>
                                    <h5 class="mb-3">Our Vision</h5>
                                    <p class="mb-0">To be the leading car dealership providing exceptional service and quality vehicles.</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="about-item-inner border p-4">
                                    <div class="about-icon mb-4">
                                        <i class="fas fa-bullseye fa-3x text-primary"></i>
                                    </div>
                                    <h5 class="mb-3">Our Mission</h5>
                                    <p class="mb-0">Making car ownership accessible and enjoyable for everyone through trust and transparency.</p>
                                </div>
                            </div>
                        </div>
                        <p class="text-item my-4">We believe in building lasting relationships with our customers. Your satisfaction is our priority, and we're committed to helping you find the perfect vehicle that fits your lifestyle and budget.</p>
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="text-center rounded bg-secondary p-4">
                                    <h1 class="display-6 text-white">17</h1>
                                    <h5 class="text-light mb-0">Years Of Experience</h5>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="rounded">
                                    <p class="mb-2"><i class="fa fa-check-circle text-primary me-1"></i> Wide Vehicle Selection</p>
                                    <p class="mb-2"><i class="fa fa-check-circle text-primary me-1"></i> Quality Assurance</p>
                                    <p class="mb-2"><i class="fa fa-check-circle text-primary me-1"></i> Expert Team</p>
                                    <p class="mb-0"><i class="fa fa-check-circle text-primary me-1"></i> Customer Support</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="about-img">
                        <div class="img-1">
                            <img src="assets/img/banner-1.jpg" class="img-fluid rounded h-100 w-100" style="object-fit: cover;" alt="About Us">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About Section End -->

    <!-- Footer Start -->
    <div class="container-fluid footer py-5">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item d-flex flex-column">
                        <div class="footer-item">
                            <h4 class="text-white mb-4">About Us</h4>
                            <p class="mb-3">Your trusted partner in finding the perfect car. We provide quality vehicles and exceptional customer service.</p>
                        </div>
                        <div class="position-relative">
                            <input class="form-control rounded-pill w-100 py-3 ps-4 pe-5" type="text" placeholder="Enter your email">
                            <button type="button" class="btn btn-secondary rounded-pill position-absolute top-0 end-0 py-2 mt-2 me-2">Subscribe</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item d-flex flex-column">
                        <h4 class="text-white mb-4">Quick Links</h4>
                        <a href="#"><i class="fas fa-angle-right me-2"></i> Home</a>
                        <a href="#products"><i class="fas fa-angle-right me-2"></i> Products</a>
                        <a href="#categories"><i class="fas fa-angle-right me-2"></i> Categories</a>
                        <a href="#about"><i class="fas fa-angle-right me-2"></i> About Us</a>
                        <a href="{{ route('login') }}"><i class="fas fa-angle-right me-2"></i> Sign In</a>                
                        <a href="{{ route('register') }}"><i class="fas fa-angle-right me-2"></i> Sign Up</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item d-flex flex-column">
                        <h4 class="text-white mb-4">Business Hours</h4>
                        <div class="mb-3">
                            <h6 class="text-muted mb-0">Mon - Friday:</h6>
                            <p class="text-white mb-0">09.00 am to 07.00 pm</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-muted mb-0">Saturday:</h6>
                            <p class="text-white mb-0">10.00 am to 05.00 pm</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-muted mb-0">Vacation:</h6>
                            <p class="text-white mb-0">All Sunday is our vacation</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item d-flex flex-column">
                        <h4 class="text-white mb-4">Contact Info</h4>
                        <a href="#"><i class="fa fa-map-marker-alt me-2"></i> 123 Street, New York, USA</a>
                        <a href="mailto:info@example.com"><i class="fas fa-envelope me-2"></i> info@example.com</a>
                        <a href="tel:+012 345 67890"><i class="fas fa-phone me-2"></i> +012 345 67890</a>
                        <a href="tel:+012 345 67890" class="mb-3"><i class="fas fa-print me-2"></i> +012 345 67890</a>
                        <div class="d-flex">
                            <a class="btn btn-secondary btn-md-square rounded-circle me-3" href=""><i class="fab fa-facebook-f text-white"></i></a>
                            <a class="btn btn-secondary btn-md-square rounded-circle me-3" href=""><i class="fab fa-twitter text-white"></i></a>
                            <a class="btn btn-secondary btn-md-square rounded-circle me-3" href=""><i class="fab fa-instagram text-white"></i></a>
                            <a class="btn btn-secondary btn-md-square rounded-circle me-0" href=""><i class="fab fa-linkedin-in text-white"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    
  <!-- JS Dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
