<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Gym Website</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <!-- Favicon -->
  <link href="{{ asset('img/favicon.ico') }}" rel="icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

  <!-- Libraries CSS -->
  <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
  <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

  <!-- Bootstrap CSS -->
  <link href="{{ asset('lib/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

  <!-- Template Stylesheet -->
  <link href="{{ asset('css/style.min.css') }}" rel="stylesheet">
</head>

<body>
  <!-- Navbar Start -->
  <nav class="navbar navbar-expand-lg bg-dark navbar-dark sticky-top py-lg-0 px-lg-5">
    <a href="#" class="navbar-brand ms-4 ms-lg-0">
      <h1 class="fw-bold text-primary m-0">Gym<span class="text-white">Zone</span></h1>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <div class="navbar-nav ms-auto p-4 p-lg-0">
        <a href="#home" class="nav-item nav-link active">Home</a>
        <a href="#about" class="nav-item nav-link">About</a>
        <a href="#services" class="nav-item nav-link">Services</a>
        <a href="#contact" class="nav-item nav-link">Contact</a>

        <!-- Auth Links -->
        @guest
          <a href="{{ route('login') }}" class="nav-item nav-link">Login</a>
          @if (Route::has('register'))
            <a href="{{ route('register') }}" class="nav-item nav-link">Register</a>
          @endif
        @else
          <a href="{{ route('dashboard') }}" class="nav-item nav-link">Dashboard</a>
          <a href="{{ route('logout') }}" class="nav-item nav-link"
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
             Logout
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
          </form>
        @endguest
      </div>
    </div>
  </nav>
  <!-- Navbar End -->

  <!-- Carousel Start -->
  <div class="container-fluid p-0" id="home">
    <div id="blog-carousel" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img class="w-100" src="{{ asset('img/carousel-1.jpg') }}" alt="Image">
          <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
            <h3 class="text-primary text-capitalize m-0">Gym & Fitness Center</h3>
            <h2 class="display-2 m-0 mt-2 mt-md-4 text-white font-weight-bold text-capitalize">Best Gym Equipment in Town</h2>
            <a href="" class="btn btn-lg btn-outline-light mt-3 mt-md-5 py-md-3 px-md-5">Buy Now</a>
          </div>
        </div>
        <div class="carousel-item">
          <img class="w-100" src="{{ asset('img/carousel-2.jpg') }}" alt="Image">
        </div>
        <div class="carousel-item">
          <img class="w-100" src="{{ asset('img/carousel-3.jpg') }}" alt="Image">
        </div>
      </div>
    </div>
  </div>
  <!-- Carousel End -->

  <!-- About Start -->
  <div class="container-xxl py-5" id="about">
    <div class="container">
      <div class="row g-5 align-items-center">
        <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
          <img class="img-fluid rounded" src="{{ asset('img/about.jpg') }}" alt="About Us">
        </div>
        <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
          <h1 class="display-6 mb-4">About GymZone</h1>
          <p>We are committed to helping you achieve your fitness goals with professional trainers,
            world-class equipment, and motivating workout programs.</p>
        </div>
      </div>
    </div>
  </div>
  <!-- About End -->

  <!-- Footer Start -->
  <div class="container-fluid bg-dark text-light footer pt-5 wow fadeIn" data-wow-delay="0.3s">
    <div class="container py-5">
      <div class="row g-5">
        <div class="col-md-6">
          <h5 class="text-white mb-4">Get In Touch</h5>
          <p><i class="fa fa-map-marker-alt me-3"></i>Aguildo St., Lupon Davao Oriental </p>
          <p><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
          <p><i class="fa fa-envelope me-3"></i>lozadalozada111@gmail.com</p>
        </div>
      </div>
    </div>
    <div class="container-fluid copyright">
      <div class="container">
        <div class="row">
          <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
            &copy; {{ date('Y') }} <a class="border-bottom" href="#">GymZone</a>, All Rights Reserved.
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Footer End -->

  <!-- JavaScript Libraries -->
  <script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('lib/wow/wow.min.js') }}"></script>
  <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
  <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
  <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>

  <!-- Template Javascript -->
  <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
