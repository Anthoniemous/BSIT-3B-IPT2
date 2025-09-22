<!DOCTYPE html>
<html lang="en">

<head>
  <title>{{ config('app.name', 'Laravel') }}</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="author" content="TemplatesJungle">
  <meta name="keywords" content="pet, store">
  <meta name="description" content="Pet Store HTML Website Template">

<link rel="shortcut icon" href="{{ asset('img/boombot_logo.png') }}" type="image/x-icon">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/vendor.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Chewy&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">

</head>

<body>

  <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasCart">
    <div class="offcanvas-header justify-content-center">
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <div class="order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Your cart</span>
          <span class="badge bg-primary rounded-pill">3</span>
        </h4>
        <ul class="list-group mb-3">
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="fs-5 fw-normal my-0">Item Name</h6>
              <small class="text-body-secondary">Brief description</small>
            </div>
            <span class="text-body-secondary">$12</span>
          </li>
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="fs-5 fw-normal my-0">Item Name</h6>
              <small class="text-body-secondary">Brief description</small>
            </div>
            <span class="text-body-secondary">$8</span>
          </li>
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="fs-5 fw-normal my-0">Item Name</h6>
              <small class="text-body-secondary">Brief description</small>
            </div>
            <span class="text-body-secondary">$5</span>
          </li>
          <li class="list-group-item d-flex justify-content-between">
            <span>Total (USD)</span>
            <strong>$20</strong>
          </li>
        </ul>

        <button class="w-100 btn btn-primary btn-lg" type="submit">Continue to checkout</button>
      </div>
    </div>
  </div>

  <div class="offcanvas offcanvas-top" data-bs-scroll="true" tabindex="-1" id="offcanvasSearch">
    <div class="offcanvas-header justify-content-center">
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <div class="order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Search</span>
        </h4>
        <form role="search" action="index.html" method="get" class="d-flex mt-3 gap-0">
          <input class="form-control rounded-start rounded-0 bg-light" type="email"
            placeholder="What are you looking for?" aria-label="What are you looking for?">
          <button class="btn btn-dark rounded-end rounded-0" type="submit">Search</button>
        </form>
      </div>
    </div>
  </div>

  <header>
    <div class="container-lg">
      <div class="row py-4">

        <div class="col-sm-6 col-md-5 col-lg-3 justify-content-center justify-content-lg-between text-center text-sm-start d-flex gap-3">
          <div class="d-flex align-items-center">
            <a href="index.html">
            <img src="{{ asset('img/boombot_land.png') }}" class="app-logo" alt="logo" class="img-fluid">
            </a>
            <button class="navbar navbar-toggler ms-3 d-block d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
              aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
          </div>
        </div>

        <div class="col-sm-12 col-md-4 col-lg-7 d-none d-md-block">
          <div class="search-bar row justify-content-between bg-light p-2 rounded-4">
            <div class="col-11">
              <form id="search-form" class="text-center" action="index.html" method="post">
                <input type="text" class="form-control border-0 bg-transparent"
                  placeholder="Search for more than 20,000 products">
              </form>
            </div>
            <div class="col-1">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="currentColor"
                  d="M21.71 20.29L18 16.61A9 9 0 1 0 16.61 18l3.68 3.68a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.39ZM11 18a7 7 0 1 1 7-7a7 7 0 0 1-7 7Z" />
              </svg>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-md-3 col-lg-2 d-flex justify-content-end gap-5 align-items-center mt-4 mt-sm-0 justify-content-center justify-content-sm-end">
          <ul class="d-flex justify-content-end list-unstyled m-0">
            <li>
              <a href="#" class="p-2 mx-1">
                <svg width="24" height="24">
                  <use xlink:href="#user"></use>
                </svg>
              </a>
            </li>
            <li>
              <a href="#" class="p-2 mx-1" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart"
                aria-controls="offcanvasCart">
                <svg width="24" height="24">
                  <use xlink:href="#shopping-bag"></use>
                </svg>
              </a>
            </li>
            <li class="d-md-none">
              <a href="#" class="p-2 mx-1" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSearch"
                aria-controls="offcanvasSearch">
                <svg width="24" height="24">
                  <use xlink:href="#search"></use>
                </svg>
              </a>
            </li>
          </ul>
          
        </div>

      </div>
        @if (Route::has('login'))
      <nav class="p-0 navbar navbar-expand-lg">
        
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
          <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Offcanvas</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body justify-content-center">

            <ul class="navbar-nav mb-0">
              <li class="nav-item border-end-0 border-lg-end-0 border-lg-end active">
                <a href="#" class="nav-link fw-bold px-4 py-3">Home</a>
              </li>
              <li class="nav-item border-end-0 border-lg-end-0 border-lg-end dropdown has-megamenu">
                <a class="nav-link fw-bold px-4 py-3 dropdown-toggle" href="#" data-bs-toggle="dropdown">
                  All Products </a>
                <div class="dropdown-menu megamenu p-lg-5 border-0 rounded-0 animate slide shadow" role="menu">
                  <div class="row g-3 row-cols-1 row-cols-lg-5">
                    <div class="col">
                      <div class="col-megamenu">
                        <h6 class="fs-5 fw-normal title">Items Title</h6>
                        <ul class="list-unstyled">
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                        </ul>
                      </div> <!-- col-megamenu.// -->
                      <div class="col-megamenu mt-4">
                        <h6 class="fs-5 fw-normal title">Items Title</h6>
                        <ul class="list-unstyled">
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                        </ul>
                      </div> <!-- col-megamenu.// -->
                    </div>
                    <div class="col">
                      <div class="col-megamenu">
                        <h6 class="fs-5 fw-normal title">Items Title</h6>
                        <ul class="list-unstyled">
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                        </ul>
                      </div> <!-- col-megamenu.// -->
                      <div class="col-megamenu mt-4">
                        <h6 class="fs-5 fw-normal title">Items Title</h6>
                        <ul class="list-unstyled">
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                        </ul>
                      </div> <!-- col-megamenu.// -->
                    </div><!-- end col-3 -->
                    <div class="col">
                      <div class="col-megamenu">
                        <h6 class="fs-5 fw-normal title">Items Title</h6>
                        <ul class="list-unstyled">
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                        </ul>
                      </div> <!-- col-megamenu.// -->
                      <div class="col-megamenu mt-4">
                        <h6 class="fs-5 fw-normal title">Items Title</h6>
                        <ul class="list-unstyled">
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                        </ul>
                      </div> <!-- col-megamenu.// -->
                    </div><!-- end col-3 -->
                    <div class="col">
                      <div class="col-megamenu">
                        <h6 class="fs-5 fw-normal title">Items Title</h6>
                        <ul class="list-unstyled">
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                        </ul>
                      </div> <!-- col-megamenu.// -->
                      <div class="col-megamenu mt-4">
                        <h6 class="fs-5 fw-normal title">Items Title</h6>
                        <ul class="list-unstyled">
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                        </ul>
                      </div> <!-- col-megamenu.// -->
                    </div>
                    <div class="col">
                      <div class="col-megamenu">
                        <h6 class="fs-5 fw-normal title">Items Title</h6>
                        <ul class="list-unstyled">
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                        </ul>
                      </div> <!-- col-megamenu.// -->
                      <div class="col-megamenu mt-4">
                        <h6 class="fs-5 fw-normal title">Items Title</h6>
                        <ul class="list-unstyled">
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                          <li><a href="#" class="nav-link p-0">Item Name</a></li>
                        </ul>
                      </div> <!-- col-megamenu.// -->
                    </div><!-- end col-3 -->
                  </div><!-- end row -->
                </div> <!-- dropdown-mega-menu.// -->
              </li>
              <li class="nav-item border-end-0 border-lg-end-0 border-lg-end">
                <a href="#sale" class="nav-link fw-bold px-4 py-3">Free Delivery</a>
              </li>
              <li class="nav-item border-end-0 border-lg-end-0 border-lg-end">
                <a href="#blog" class="nav-link fw-bold px-4 py-3">Blog</a>
              </li>
              <li class="nav-item border-end-0 border-lg-end-0 border-lg-end">
                <a href="#shop" class="nav-link fw-bold px-4 py-3">Shop</a>
              </li>
              <li class="nav-item border-end-0 border-lg-end-0 border-lg-end">
                <a href="#blog" class="nav-link fw-bold px-4 py-3">Offers</a>
              </li>
              <li class="nav-item border-end-0 border-lg-end-0 border-lg-end">
                <a href="#sale" class="nav-link fw-bold px-4 py-3">Sale</a>
              </li>
              <li class="nav-item border-end-0 border-lg-end-0 border-lg-end dropdown">
                <a class="nav-link fw-bold px-4 py-3 dropdown-toggle" role="button" id="pages"
                  data-bs-toggle="dropdown" aria-expanded="false">Pages</a>
                <ul class="dropdown-menu px-3 px-lg-0 pb-2 mt-0 border-0 rounded-0 animate slide shadow" aria-labelledby="pages">
                  <li><a href="about.html" class="dropdown-item">About Us <span
                        class="badge bg-dark text-light fs-7">PRO</span></a></li>
                  <li><a href="shop.html" class="dropdown-item">Shop <span
                        class="badge bg-dark text-light fs-7">PRO</span></a></li>
                  <li><a href="single-product.html" class="dropdown-item">Single Product <span
                        class="badge bg-dark text-light fs-7">PRO</span></a></li>
                  <li><a href="cart.html" class="dropdown-item">Cart <span
                        class="badge bg-dark text-light fs-7">PRO</span></a></li>
                  <li><a href="checkout.html" class="dropdown-item">Checkout <span
                        class="badge bg-dark text-light fs-7">PRO</span></a></li>
                  <li><a href="blog.html" class="dropdown-item">Blog <span
                        class="badge bg-dark text-light fs-7">PRO</span></a></li>
                  <li><a href="single-post.html" class="dropdown-item">Single Post <span
                        class="badge bg-dark text-light fs-7">PRO</span></a></li>
                  <li><a href="styles.html" class="dropdown-item">Styles <span
                        class="badge bg-dark text-light fs-7">PRO</span></a></li>
                  <li><a href="contact.html" class="dropdown-item">Contact <span
                        class="badge bg-dark text-light fs-7">PRO</span></a></li>
                  <li><a href="thank-you.html" class="dropdown-item">Thank You <span
                        class="badge bg-dark text-light fs-7">PRO</span></a></li>
                  <li><a href="account.html" class="dropdown-item">My Account <span
                        class="badge bg-dark text-light fs-7">PRO</span></a></li>
                  <li><a href="404.html" class="dropdown-item">404 Error <span
                        class="badge bg-dark text-light fs-7">PRO</span></a></li>
                </ul>
              </li>
          
                    @auth
                        <li class="nav-item border-end-0 border-lg-end-0 border-lg-end"><a href="{{ url('/dashboard') }}" class="nav-link fw-bold px-4 py-3 text-danger">Dashboard<span></a>
                    @else
                        <li class="nav-item border-end-0 border-lg-end-0 border-lg-end"><a href="{{ route('login') }}" class="nav-link fw-bold px-4 py-3 text-danger">Login<span></a>
                        @if (Route::has('register'))
                            <li class="nav-item border-end-0 border-lg-end-0 border-lg-end"><a href="{{ route('register') }}" class="nav-link fw-bold px-4 py-3 text-danger">Register<span></a>   
                        @endif
                    @endauth
                    </ul>

                </div>
            </div>
        </nav>
        @endif
    </div>
</header>

  <section>

    <div class="slideshow slide-in arrow-absolute text-white position-relative">
      <div class="swiper-wrapper">
        <div class="swiper-slide jarallax">
        <img src="{{ asset('img/slide-1.jpg') }}" class="jarallax-img" alt="slideshow">
          <div class="banner-content w-100 my-5">
            <div class="container">
              <div class="row justify-content-center text-center">
                <div class="col-md-12 pt-2">
                  <p class="fs-3">Premium pet supplies for happy tails</p>
                  <h2 class="display-1 text-white text-uppercase ls-0">Pet Shop</h2>
                  <a href="#" class="btn btn-primary rounded-3 px-3 py-2 mt-3">Shop Now</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="swiper-slide jarallax">
        <img src="{{ asset('img/slide-2.jpg') }}" class="jarallax-img" alt="slideshow">
          <div class="banner-content w-100 my-5">
            <div class="container">
              <div class="row justify-content-center text-center">
                <div class="col-md-12 pt-2">
                  <p class="fs-3">Quality products, expert advice, and loving care</p>
                  <h2 class="display-1 text-white text-uppercase ls-0">Pet Food</h2>
                  <a href="#" class="btn btn-primary rounded-3 px-3 py-2 mt-3">Shop Now</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="swiper-slide jarallax">
        <img src="{{ asset('img/slide-3.jpg') }}" class="jarallax-img" alt="slideshow">
          <div class="banner-content w-100 my-5">
            <div class="container">
              <div class="row justify-content-center text-center">
                <div class="col-md-12 pt-2">
                  <p class="fs-3">Your one-stop pet store</p>
                  <h2 class="display-1 text-white text-uppercase ls-0">Quality products</h2>
                  <a href="#" class="btn btn-primary rounded-3 px-3 py-2 mt-3">Shop Now</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="swiper-slide jarallax">
        <img src="{{ asset('img/slide-4.jpg') }}" class="jarallax-img" alt="slideshow">
          <div class="banner-content w-100 my-5">
            <div class="container">
              <div class="row justify-content-center text-center">
                <div class="col-md-12 pt-2">
                  <p class="fs-3">Your pets deserve the best</p>
                  <h2 class="display-1 text-white text-uppercase ls-0">furry friends</h2>
                  <a href="#" class="btn btn-primary rounded-3 px-3 py-2 mt-3">Shop Now</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="pagination-wrapper position-absolute bottom-0 mb-4 text-center">
        <div class="container">
          <div class="slideshow-swiper-pagination light"></div>
        </div>
      </div>
    </div>

  </section>

  <section id="shop-categories" class="section-padding">
    <div class="container-lg">
      <div class="row g-md-5">
        <div class="col-md-3">
          <ul class="navbar-nav justify-content-end menu-list list-unstyled d-flex gap-md-3 mb-0">
            <li class="nav-item">
              <a href="shop.html" class="nav-link d-flex align-items-center gap-3 p-2">
                <svg width="24" height="24" viewBox="0 0 24 24">
                  <use xlink:href="#dairy"></use>
                </svg>
                <span>Pet foods</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="shop.html" class="nav-link d-flex align-items-center gap-3 p-2">
                <svg width="24" height="24" viewBox="0 0 24 24">
                  <use xlink:href="#meat"></use>
                </svg>
                <span>Birds</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="shop.html" class="nav-link d-flex align-items-center gap-3 p-2">
                <svg width="24" height="24" viewBox="0 0 24 24">
                  <use xlink:href="#seafood"></use>
                </svg>
                <span>Fishes</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="shop.html" class="nav-link d-flex align-items-center gap-3 p-2">
                <svg width="24" height="24" viewBox="0 0 24 24">
                  <use xlink:href="#canned"></use>
                </svg>
                <span>Canned foods</span>
              </a>
            </li>
            <li class="nav-item position-relative">
              <a
                class="btn btn-toggle dropdown-toggle w-100 d-flex justify-content-between align-items-center p-2"
                data-bs-toggle="collapse" data-bs-target="#beverages-collapse" aria-expanded="false">
                <div class="d-flex gap-3">
                  <svg width="24" height="24" viewBox="0 0 24 24">
                    <use xlink:href="#health"></use>
                  </svg>
                  <span>Health products</span>
                </div>
              </a>
              <div class="collapse" id="beverages-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal ps-5 pb-1">
                  <li class="border-bottom py-2"><a href="shop.html" class="dropdown-item">Dogs</a></li>
                  <li class="border-bottom py-2"><a href="shop.html" class="dropdown-item">Cats</a></li>
                  <li class="border-bottom py-2"><a href="shop.html" class="dropdown-item">Rabbits</a></li>
                  <li class="border-bottom py-2"><a href="shop.html" class="dropdown-item">Birds</a></li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a href="shop.html" class="nav-link d-flex align-items-center gap-3 p-2">
                <svg width="24" height="24" viewBox="0 0 24 24">
                  <use xlink:href="#household"></use>
                </svg>
                <span>Household Supplies</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="shop.html" class="nav-link d-flex align-items-center gap-3 p-2">
                <svg width="24" height="24" viewBox="0 0 24 24">
                  <use xlink:href="#personal"></use>
                </svg>
                <span>Medications</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="shop.html" class="nav-link d-flex align-items-center gap-3 p-2">
                <svg width="24" height="24" viewBox="0 0 24 24">
                  <use xlink:href="#pet"></use>
                </svg>
                <span>Pet clothings</span>
              </a>
            </li>
          </ul>
        </div>
        <div class="col-md-9">
          <div class="row">
            <div class="col-md-12">

              <div class="section-header d-flex flex-wrap justify-content-between pb-2 mt-5 mt-lg-0">

                <h2 class="section-title">Best selling products</h2>

                <div class="d-flex align-items-center">
                  <a href="#" class="btn btn-primary rounded-1">View All</a>
                </div>
              </div>

            </div>
          </div>

          <div class="row">
            <div class="col-md-12">

              <div class="product-grid row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 row-cols-xl-4">

                <div class="col">
                  <div class="product-item mb-4">
                    <figure>
                      <a href="single-product.html" title="Product Title">
                      <img src="{{ asset('img/product-thumbnail-1.jpg') }}" alt="Product Thumbnail" class="tab-image img-fluid rounded-3">
                      </a>
                    </figure>
                    <div class="d-flex flex-column text-center">
                      <h3 class="fs-5 fw-normal"><a href="single-product.html" class="text-decoration-none">Product Item</a></h3>
                      <div class="d-flex justify-content-center align-items-center gap-2">
                        <del>$24.00</del>
                        <span class="text-dark fw-semibold">$18.00</span>
                      </div>
                      <div class="button-area p-3">
                        <div class="justify-content-center d-flex mb-3">
                          <div class="input-group product-qty">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-left-minus btn btn-light btn-number" data-type="minus" data-field="">
                                  <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                                </button>
                            </span>
                            <input type="text" id="quantity" name="quantity" class="quantity form-control input-number text-center" value="1" min="1" max="100">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
                                    <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                                </button>
                            </span>
                          </div>
                        </div>
                        <div><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg width="18" height="18">
                            <use xlink:href="#cart"></use>
                          </svg> Add to Cart</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="product-item mb-4">
                    <figure>
                      <a href="single-product.html" title="Product Title">
                      <img src="{{ asset('img/product-thumbnail-2.jpg') }}" alt="Product Thumbnail" class="tab-image img-fluid rounded-3">
                      </a>
                    </figure>
                    <div class="d-flex flex-column text-center">
                      <h3 class="fs-5 fw-normal"><a href="single-product.html" class="text-decoration-none">Product Item</a></h3>
                      <div class="d-flex justify-content-center align-items-center gap-2">
                        <del>$24.00</del>
                        <span class="text-dark fw-semibold">$18.00</span>
                      </div>
                      <div class="button-area p-3">
                        <div class="justify-content-center d-flex mb-3">
                          <div class="input-group product-qty">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-left-minus btn btn-light btn-number" data-type="minus" data-field="">
                                  <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                                </button>
                            </span>
                            <input type="text" id="quantity" name="quantity" class="quantity form-control input-number text-center" value="1" min="1" max="100">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
                                    <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                                </button>
                            </span>
                          </div>
                        </div>
                        <div><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg width="18" height="18">
                            <use xlink:href="#cart"></use>
                          </svg> Add to Cart</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="product-item mb-4">
                    <figure>
                      <a href="single-product.html" title="Product Title">
                      <img src="{{ asset('img/product-thumbnail-3.jpg') }}" alt="Product Thumbnail" class="tab-image img-fluid rounded-3">
                      </a>
                    </figure>
                    <div class="d-flex flex-column text-center">
                      <h3 class="fs-5 fw-normal"><a href="single-product.html" class="text-decoration-none">Product Item</a></h3>
                      <div class="d-flex justify-content-center align-items-center gap-2">
                        <del>$24.00</del>
                        <span class="text-dark fw-semibold">$18.00</span>
                      </div>
                      <div class="button-area p-3">
                        <div class="justify-content-center d-flex mb-3">
                          <div class="input-group product-qty">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-left-minus btn btn-light btn-number" data-type="minus" data-field="">
                                  <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                                </button>
                            </span>
                            <input type="text" id="quantity" name="quantity" class="quantity form-control input-number text-center" value="1" min="1" max="100">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
                                    <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                                </button>
                            </span>
                          </div>
                        </div>
                        <div><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg width="18" height="18">
                            <use xlink:href="#cart"></use>
                          </svg> Add to Cart</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="product-item mb-4">
                    <figure>
                      <a href="single-product.html" title="Product Title">
                      <img src="{{ asset('img/product-thumbnail-4.jpg') }}" alt="Product Thumbnail" class="tab-image img-fluid rounded-3">
                      </a>
                    </figure>
                    <div class="d-flex flex-column text-center">
                      <h3 class="fs-5 fw-normal"><a href="single-product.html" class="text-decoration-none">Product Item</a></h3>
                      <div class="d-flex justify-content-center align-items-center gap-2">
                        <del>$24.00</del>
                        <span class="text-dark fw-semibold">$18.00</span>
                      </div>
                      <div class="button-area p-3">
                        <div class="justify-content-center d-flex mb-3">
                          <div class="input-group product-qty">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-left-minus btn btn-light btn-number" data-type="minus" data-field="">
                                  <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                                </button>
                            </span>
                            <input type="text" id="quantity" name="quantity" class="quantity form-control input-number text-center" value="1" min="1" max="100">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
                                    <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                                </button>
                            </span>
                          </div>
                        </div>
                        <div><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg width="18" height="18">
                            <use xlink:href="#cart"></use>
                          </svg> Add to Cart</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="product-item mb-4">
                    <figure>
                      <a href="single-product.html" title="Product Title">
                      <img src="{{ asset('img/product-thumbnail-5.jpg') }}" alt="Product Thumbnail" class="tab-image img-fluid rounded-3">
                      </a>
                    </figure>
                    <div class="d-flex flex-column text-center">
                      <h3 class="fs-5 fw-normal"><a href="single-product.html" class="text-decoration-none">Product Item</a></h3>
                      <div class="d-flex justify-content-center align-items-center gap-2">
                        <del>$24.00</del>
                        <span class="text-dark fw-semibold">$18.00</span>
                      </div>
                      <div class="button-area p-3">
                        <div class="justify-content-center d-flex mb-3">
                          <div class="input-group product-qty">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-left-minus btn btn-light btn-number" data-type="minus" data-field="">
                                  <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                                </button>
                            </span>
                            <input type="text" id="quantity" name="quantity" class="quantity form-control input-number text-center" value="1" min="1" max="100">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
                                    <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                                </button>
                            </span>
                          </div>
                        </div>
                        <div><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg width="18" height="18">
                            <use xlink:href="#cart"></use>
                          </svg> Add to Cart</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="product-item mb-4">
                    <figure>
                      <a href="single-product.html" title="Product Title">
                      <img src="{{ asset('img/product-thumbnail-6.jpg') }}" alt="Product Thumbnail" class="tab-image img-fluid rounded-3">
                      </a>
                    </figure>
                    <div class="d-flex flex-column text-center">
                      <h3 class="fs-5 fw-normal"><a href="single-product.html" class="text-decoration-none">Product Item</a></h3>
                      <div class="d-flex justify-content-center align-items-center gap-2">
                        <del>$24.00</del>
                        <span class="text-dark fw-semibold">$18.00</span>
                      </div>
                      <div class="button-area p-3">
                        <div class="justify-content-center d-flex mb-3">
                          <div class="input-group product-qty">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-left-minus btn btn-light btn-number" data-type="minus" data-field="">
                                  <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                                </button>
                            </span>
                            <input type="text" id="quantity" name="quantity" class="quantity form-control input-number text-center" value="1" min="1" max="100">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
                                    <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                                </button>
                            </span>
                          </div>
                        </div>
                        <div><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg width="18" height="18">
                            <use xlink:href="#cart"></use>
                          </svg> Add to Cart</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="product-item mb-4">
                    <figure>
                      <a href="single-product.html" title="Product Title">
                      <img src="{{ asset('img/product-thumbnail-7.jpg') }}" alt="Product Thumbnail" class="tab-image img-fluid rounded-3">
                      </a>
                    </figure>
                    <div class="d-flex flex-column text-center">
                      <h3 class="fs-5 fw-normal"><a href="single-product.html" class="text-decoration-none">Product Item</a></h3>
                      <div class="d-flex justify-content-center align-items-center gap-2">
                        <del>$24.00</del>
                        <span class="text-dark fw-semibold">$18.00</span>
                      </div>
                      <div class="button-area p-3">
                        <div class="justify-content-center d-flex mb-3">
                          <div class="input-group product-qty">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-left-minus btn btn-light btn-number" data-type="minus" data-field="">
                                  <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                                </button>
                            </span>
                            <input type="text" id="quantity" name="quantity" class="quantity form-control input-number text-center" value="1" min="1" max="100">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
                                    <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                                </button>
                            </span>
                          </div>
                        </div>
                        <div><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg width="18" height="18">
                            <use xlink:href="#cart"></use>
                          </svg> Add to Cart</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="product-item mb-4">
                    <figure>
                      <a href="single-product.html" title="Product Title">
                      <img src="{{ asset('img/product-thumbnail-8.jpg') }}" alt="Product Thumbnail" class="tab-image img-fluid rounded-3">
                      </a>
                    </figure>
                    <div class="d-flex flex-column text-center">
                      <h3 class="fs-5 fw-normal"><a href="single-product.html" class="text-decoration-none">Product Item</a></h3>
                      <div class="d-flex justify-content-center align-items-center gap-2">
                        <del>$24.00</del>
                        <span class="text-dark fw-semibold">$18.00</span>
                      </div>
                      <div class="button-area p-3">
                        <div class="justify-content-center d-flex mb-3">
                          <div class="input-group product-qty">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-left-minus btn btn-light btn-number" data-type="minus" data-field="">
                                  <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                                </button>
                            </span>
                            <input type="text" id="quantity" name="quantity" class="quantity form-control input-number text-center" value="1" min="1" max="100">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
                                    <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                                </button>
                            </span>
                          </div>
                        </div>
                        <div><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg width="18" height="18">
                            <use xlink:href="#cart"></use>
                          </svg> Add to Cart</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="product-item mb-4">
                    <figure>
                      <a href="single-product.html" title="Product Title">
                      <img src="{{ asset('img/product-thumbnail-9.jpg') }}" alt="Product Thumbnail" class="tab-image img-fluid rounded-3">
                      </a>
                    </figure>
                    <div class="d-flex flex-column text-center">
                      <h3 class="fs-5 fw-normal"><a href="single-product.html" class="text-decoration-none">Product Item</a></h3>
                      <div class="d-flex justify-content-center align-items-center gap-2">
                        <del>$24.00</del>
                        <span class="text-dark fw-semibold">$18.00</span>
                      </div>
                      <div class="button-area p-3">
                        <div class="justify-content-center d-flex mb-3">
                          <div class="input-group product-qty">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-left-minus btn btn-light btn-number" data-type="minus" data-field="">
                                  <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                                </button>
                            </span>
                            <input type="text" id="quantity" name="quantity" class="quantity form-control input-number text-center" value="1" min="1" max="100">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
                                    <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                                </button>
                            </span>
                          </div>
                        </div>
                        <div><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg width="18" height="18">
                            <use xlink:href="#cart"></use>
                          </svg> Add to Cart</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="product-item mb-4">
                    <figure>
                      <a href="single-product.html" title="Product Title">
                      <img src="{{ asset('img/product-thumbnail-10.jpg') }}" alt="Product Thumbnail" class="tab-image img-fluid rounded-3">
                      </a>
                    </figure>
                    <div class="d-flex flex-column text-center">
                      <h3 class="fs-5 fw-normal"><a href="single-product.html" class="text-decoration-none">Product Item</a></h3>
                      <div class="d-flex justify-content-center align-items-center gap-2">
                        <del>$24.00</del>
                        <span class="text-dark fw-semibold">$18.00</span>
                      </div>
                      <div class="button-area p-3">
                        <div class="justify-content-center d-flex mb-3">
                          <div class="input-group product-qty">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-left-minus btn btn-light btn-number" data-type="minus" data-field="">
                                  <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                                </button>
                            </span>
                            <input type="text" id="quantity" name="quantity" class="quantity form-control input-number text-center" value="1" min="1" max="100">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
                                    <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                                </button>
                            </span>
                          </div>
                        </div>
                        <div><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg width="18" height="18">
                            <use xlink:href="#cart"></use>
                          </svg> Add to Cart</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="product-item mb-4">
                    <figure>
                      <a href="single-product.html" title="Product Title">
                      <img src="{{ asset('img/product-thumbnail-11.jpg') }}" alt="Product Thumbnail" class="tab-image img-fluid rounded-3">
                      </a>
                    </figure>
                    <div class="d-flex flex-column text-center">
                      <h3 class="fs-5 fw-normal"><a href="single-product.html" class="text-decoration-none">Product Item</a></h3>
                      <div class="d-flex justify-content-center align-items-center gap-2">
                        <del>$24.00</del>
                        <span class="text-dark fw-semibold">$18.00</span>
                      </div>
                      <div class="button-area p-3">
                        <div class="justify-content-center d-flex mb-3">
                          <div class="input-group product-qty">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-left-minus btn btn-light btn-number" data-type="minus" data-field="">
                                  <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                                </button>
                            </span>
                            <input type="text" id="quantity" name="quantity" class="quantity form-control input-number text-center" value="1" min="1" max="100">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
                                    <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                                </button>
                            </span>
                          </div>
                        </div>
                        <div><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg width="18" height="18">
                            <use xlink:href="#cart"></use>
                          </svg> Add to Cart</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="product-item mb-4">
                    <figure>
                      <a href="single-product.html" title="Product Title">
                      <img src="{{ asset('img/product-thumbnail-12.jpg') }}" alt="Product Thumbnail" class="tab-image img-fluid rounded-3">
                      </a>
                    </figure>
                    <div class="d-flex flex-column text-center">
                      <h3 class="fs-5 fw-normal"><a href="single-product.html" class="text-decoration-none">Product Item</a></h3>
                      <div class="d-flex justify-content-center align-items-center gap-2">
                        <del>$24.00</del>
                        <span class="text-dark fw-semibold">$18.00</span>
                      </div>
                      <div class="button-area p-3">
                        <div class="justify-content-center d-flex mb-3">
                          <div class="input-group product-qty">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-left-minus btn btn-light btn-number" data-type="minus" data-field="">
                                  <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                                </button>
                            </span>
                            <input type="text" id="quantity" name="quantity" class="quantity form-control input-number text-center" value="1" min="1" max="100">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
                                    <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                                </button>
                            </span>
                          </div>
                        </div>
                        <div><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg width="18" height="18">
                            <use xlink:href="#cart"></use>
                          </svg> Add to Cart</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
              <!-- / product-grid -->


            </div>
          </div>

        </div>
      </div>

    </div>
  </section>

  <section id="customers-reviews" class="position-relative section-padding jarallax"
    style="background-image: url(images/banner-image-bg.jpg); background-size: cover; background-repeat: no-repeat; background-position: center;">
    <div class="container offset-md-3 col-md-6 ">
      <div class="position-absolute top-50 end-0 pe-0 pe-xxl-5 me-0 me-xxl-5 testimonial-button-next">
        <svg class="chevron-forward-circle d-flex justify-content-center align-items-center p-2" width="80" height="80">
          <use xlink:href="#alt-arrow-right-outline"></use>
        </svg>
      </div>
      <div class="position-absolute top-50 start-0 ps-0 ps-xxl-5 ms-0 ms-xxl-5 testimonial-button-prev">
        <svg class="chevron-back-circle d-flex justify-content-center align-items-center p-2" width="80" height="80">
          <use xlink:href="#alt-arrow-left-outline"></use>
        </svg>
      </div>
      <div class="section-title mb-4 text-center">
        <h2 class="section-title">Customers reviews</h2>
      </div>
      <div class="swiper testimonial-swiper ">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <div class="card position-relative text-left p-5 border-light shadow-sm rounded-3">
              <blockquote>"This pet shop has everything my furry friend needs! The quality of the products is amazing, and the staff is so helpful. Highly recommended!"</blockquote>
              <h5 class="mt-1 fw-normal">Emma R., Dog Owner</h5>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="card position-relative text-left p-5 border-light shadow-sm rounded-3">
              <blockquote>"I found the perfect food and accessories for my cat here. The prices are great, and the delivery was super fast!"</blockquote>
              <h5 class="mt-1 fw-normal">Mark T., Cat Lover</h5>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="card position-relative text-left p-5 border-light shadow-sm rounded-3">
              <blockquote>"A fantastic place for pet owners! Their selection of toys and treats keeps my puppy entertained and happy."</blockquote>
              <h5 class="mt-1 fw-normal">Sophia L., Pet Parent</h5>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="card position-relative text-left p-5 border-light shadow-sm rounded-3">
              <blockquote>“I love shopping here for my rabbit! They have unique and high-quality pet products that I can’t find anywhere else.”</blockquote>
              <h5 class="mt-1 fw-normal">Daniel G., Rabbit Enthusiast</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  <section class="new-arrivals section-padding">
    <div class="container-lg position-relative">
      <div class="section-header d-flex flex-wrap justify-content-between pb-2">
        <h2 class="section-title">New arrivals</h2>
        <div class="d-flex align-items-center">
          <a href="#" class="btn btn-primary rounded-1">View All</a>
        </div>
      </div>

      <div class="swiper product-swiper">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <div class="product-item mb-4">
              <figure>
                <a href="single-product.html" title="Product Title">
                <img src="{{ asset('img/product-thumbnail-2.jpg') }}" alt="Product Thumbnail" class="tab-image img-fluid rounded-3">
                </a>
              </figure>
              <div class="d-flex flex-column text-center">
                <h3 class="fs-5 fw-normal"><a href="single-product.html" class="text-decoration-none">Product Item</a></h3>
                <div class="d-flex justify-content-center align-items-center gap-2">
                  <del>$24.00</del>
                  <span class="text-dark fw-semibold">$18.00</span>
                </div>
                <div class="button-area p-3">
                  <div class="justify-content-center d-flex mb-3">
                    <div class="input-group product-qty">
                      <span class="input-group-btn">
                          <button type="button" class="quantity-left-minus btn btn-light btn-number" data-type="minus" data-field="">
                            <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                          </button>
                      </span>
                      <input type="text" id="quantity" name="quantity" class="quantity form-control input-number text-center" value="1" min="1" max="100">
                      <span class="input-group-btn">
                          <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
                              <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                          </button>
                      </span>
                    </div>
                  </div>
                  <div><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg width="18" height="18">
                      <use xlink:href="#cart"></use>
                    </svg> Add to Cart</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="product-item mb-4">
              <figure>
                <a href="single-product.html" title="Product Title">
                <img src="{{ asset('img/product-thumbnail-1.jpg') }}" alt="Product Thumbnail" class="tab-image img-fluid rounded-3">
                </a>
              </figure>
              <div class="d-flex flex-column text-center">
                <h3 class="fs-5 fw-normal"><a href="single-product.html" class="text-decoration-none">Product Item</a></h3>
                <div class="d-flex justify-content-center align-items-center gap-2">
                  <del>$24.00</del>
                  <span class="text-dark fw-semibold">$18.00</span>
                </div>
                <div class="button-area p-3">
                  <div class="justify-content-center d-flex mb-3">
                    <div class="input-group product-qty">
                      <span class="input-group-btn">
                          <button type="button" class="quantity-left-minus btn btn-light btn-number" data-type="minus" data-field="">
                            <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                          </button>
                      </span>
                      <input type="text" id="quantity" name="quantity" class="quantity form-control input-number text-center" value="1" min="1" max="100">
                      <span class="input-group-btn">
                          <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
                              <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                          </button>
                      </span>
                    </div>
                  </div>
                  <div><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg width="18" height="18">
                      <use xlink:href="#cart"></use>
                    </svg> Add to Cart</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="product-item mb-4">
              <figure>
                <a href="single-product.html" title="Product Title">
                <img src="{{ asset('img/product-thumbnail-5.jpg') }}" alt="Product Thumbnail" class="tab-image img-fluid rounded-3">
                </a>
              </figure>
              <div class="d-flex flex-column text-center">
                <h3 class="fs-5 fw-normal"><a href="single-product.html" class="text-decoration-none">Product Item</a></h3>
                <div class="d-flex justify-content-center align-items-center gap-2">
                  <del>$24.00</del>
                  <span class="text-dark fw-semibold">$18.00</span>
                </div>
                <div class="button-area p-3">
                  <div class="justify-content-center d-flex mb-3">
                    <div class="input-group product-qty">
                      <span class="input-group-btn">
                          <button type="button" class="quantity-left-minus btn btn-light btn-number" data-type="minus" data-field="">
                            <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                          </button>
                      </span>
                      <input type="text" id="quantity" name="quantity" class="quantity form-control input-number text-center" value="1" min="1" max="100">
                      <span class="input-group-btn">
                          <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
                              <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                          </button>
                      </span>
                    </div>
                  </div>
                  <div><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg width="18" height="18">
                      <use xlink:href="#cart"></use>
                    </svg> Add to Cart</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="product-item mb-4">
              <figure>
                <a href="single-product.html" title="Product Title">
                <img src="{{ asset('img/product-thumbnail-3.jpg') }}" alt="Product Thumbnail" class="tab-image img-fluid rounded-3">
                </a>
              </figure>
              <div class="d-flex flex-column text-center">
                <h3 class="fs-5 fw-normal"><a href="single-product.html" class="text-decoration-none">Product Item</a></h3>
                <div class="d-flex justify-content-center align-items-center gap-2">
                  <del>$24.00</del>
                  <span class="text-dark fw-semibold">$18.00</span>
                </div>
                <div class="button-area p-3">
                  <div class="justify-content-center d-flex mb-3">
                    <div class="input-group product-qty">
                      <span class="input-group-btn">
                          <button type="button" class="quantity-left-minus btn btn-light btn-number" data-type="minus" data-field="">
                            <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                          </button>
                      </span>
                      <input type="text" id="quantity" name="quantity" class="quantity form-control input-number text-center" value="1" min="1" max="100">
                      <span class="input-group-btn">
                          <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
                              <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                          </button>
                      </span>
                    </div>
                  </div>
                  <div><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg width="18" height="18">
                      <use xlink:href="#cart"></use>
                    </svg> Add to Cart</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="product-item mb-4">
              <figure>
                <a href="single-product.html" title="Product Title">
                <img src="{{ asset('img/product-thumbnail-4.jpg') }}" alt="Product Thumbnail" class="tab-image img-fluid rounded-3">
                </a>
              </figure>
              <div class="d-flex flex-column text-center">
                <h3 class="fs-5 fw-normal"><a href="single-product.html" class="text-decoration-none">Product Item</a></h3>
                <div class="d-flex justify-content-center align-items-center gap-2">
                  <del>$24.00</del>
                  <span class="text-dark fw-semibold">$18.00</span>
                </div>
                <div class="button-area p-3">
                  <div class="justify-content-center d-flex mb-3">
                    <div class="input-group product-qty">
                      <span class="input-group-btn">
                          <button type="button" class="quantity-left-minus btn btn-light btn-number" data-type="minus" data-field="">
                            <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                          </button>
                      </span>
                      <input type="text" id="quantity" name="quantity" class="quantity form-control input-number text-center" value="1" min="1" max="100">
                      <span class="input-group-btn">
                          <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
                              <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                          </button>
                      </span>
                    </div>
                  </div>
                  <div><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg width="18" height="18">
                      <use xlink:href="#cart"></use>
                    </svg> Add to Cart</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="product-item mb-4">
              <figure>
                <a href="single-product.html" title="Product Title">
                <img src="{{ asset('img/product-thumbnail-9.jpg') }}" alt="Product Thumbnail" class="tab-image img-fluid rounded-3">
                </a>
              </figure>
              <div class="d-flex flex-column text-center">
                <h3 class="fs-5 fw-normal"><a href="single-product.html" class="text-decoration-none">Product Item</a></h3>
                <div class="d-flex justify-content-center align-items-center gap-2">
                  <del>$24.00</del>
                  <span class="text-dark fw-semibold">$18.00</span>
                </div>
                <div class="button-area p-3">
                  <div class="justify-content-center d-flex mb-3">
                    <div class="input-group product-qty">
                      <span class="input-group-btn">
                          <button type="button" class="quantity-left-minus btn btn-light btn-number" data-type="minus" data-field="">
                            <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                          </button>
                      </span>
                      <input type="text" id="quantity" name="quantity" class="quantity form-control input-number text-center" value="1" min="1" max="100">
                      <span class="input-group-btn">
                          <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
                              <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                          </button>
                      </span>
                    </div>
                  </div>
                  <div><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg width="18" height="18">
                      <use xlink:href="#cart"></use>
                    </svg> Add to Cart</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="product-item mb-4">
              <figure>
                <a href="single-product.html" title="Product Title">
                <img src="{{ asset('img/product-thumbnail-10.jpg') }}" alt="Product Thumbnail" class="tab-image img-fluid rounded-3">
                </a>
              </figure>
              <div class="d-flex flex-column text-center">
                <h3 class="fs-5 fw-normal"><a href="single-product.html" class="text-decoration-none">Product Item</a></h3>
                <div class="d-flex justify-content-center align-items-center gap-2">
                  <del>$24.00</del>
                  <span class="text-dark fw-semibold">$18.00</span>
                </div>
                <div class="button-area p-3">
                  <div class="justify-content-center d-flex mb-3">
                    <div class="input-group product-qty">
                      <span class="input-group-btn">
                          <button type="button" class="quantity-left-minus btn btn-light btn-number" data-type="minus" data-field="">
                            <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                          </button>
                      </span>
                      <input type="text" id="quantity" name="quantity" class="quantity form-control input-number text-center" value="1" min="1" max="100">
                      <span class="input-group-btn">
                          <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
                              <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                          </button>
                      </span>
                    </div>
                  </div>
                  <div><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg width="18" height="18">
                      <use xlink:href="#cart"></use>
                    </svg> Add to Cart</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="pagination-wrapper position-absolute z-3 start-0 end-0 bottom-0 text-center">
        <div class="container">
          <div class="product-swiper-pagination light"></div>
        </div>
      </div>
    </div>

  </section>

  <section id="latest-blog" class="section-padding pt-0">
    <div class="container-lg">
      <div class="row">
        <div class="section-header d-flex align-items-center justify-content-between mb-lg-2">
          <h2 class="section-title">Our recent blog</h2>
          <a href="#" class="btn btn-primary">View All</a>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <article class="post-item card border-1 border-light shadow-sm p-3">
            <div class="image-holder zoom-effect">
              <a href="#">
              <img src="{{ asset('img/post-thumbnail-1.jpg') }}" alt="post" class="card-img-top">
              </a>
            </div>
            <div class="card-body">
              <div class="post-meta d-flex text-uppercase gap-3 my-3 align-items-center">
                <div class="meta-date"><a href="blog.html" class="text-decoration-none">22 Aug 2021</a></div>
                <div class="meta-categories"><a href="blog.html" class="text-decoration-none">tips & tricks</a></div>
              </div>
              <div class="post-header">
                <h3 class="fs-5 fw-normal">
                  <a href="#" class="text-decoration-none">Tips for Keeping Your Furry Friend Happy and Healthy</a>
                </h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipi elit. Aliquet eleifend viverra enim tincidunt donec
                  quam...</p>
              </div>
            </div>
          </article>
        </div>
        <div class="col-md-4">
          <article class="post-item card border-1 border-light shadow-sm p-3">
            <div class="image-holder zoom-effect">
              <a href="#">
              <img src="{{ asset('img/post-thumbnail-2.jpg') }}" alt="post" class="card-img-top">
              </a>
            </div>
            <div class="card-body">
              <div class="post-meta d-flex text-uppercase gap-3 my-3 align-items-center">
                <div class="meta-date"><a href="blog.html" class="text-decoration-none">22 Aug 2021</a></div>
                <div class="meta-categories"><a href="blog.html" class="text-decoration-none">tips & tricks</a></div>
              </div>
              <div class="post-header">
                <h3 class="fs-5 fw-normal">
                  <a href="#" class="text-decoration-none">Top 10 Must-Have Pet Products Every Pet Owner Needs</a>
                </h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipi elit. Aliquet eleifend viverra enim tincidunt donec
                  quam...</p>
              </div>
            </div>
          </article>
        </div>
        <div class="col-md-4">
          <article class="post-item card border-1 border-light shadow-sm p-3">
            <div class="image-holder zoom-effect">
              <a href="#">
              <img src="{{ asset('img/post-thumbnail-3.jpg') }}" alt="post" class="card-img-top">
              </a>
            </div>
            <div class="card-body">
              <div class="post-meta d-flex text-uppercase gap-3 my-3 align-items-center">
                <div class="meta-date"><a href="blog.html" class="text-decoration-none">22 Aug 2021</a></div>
                <div class="meta-categories"><a href="blog.html" class="text-decoration-none">tips & tricks</a></div>
              </div>
              <div class="post-header">
                <h3 class="fs-5 fw-normal">
                  <a href="#" class="text-decoration-none">How to Choose the Perfect Pet: A Guide for First-Time Pet Owners</a>
                </h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipi elit. Aliquet eleifend viverra enim tincidunt donec
                  quam...</p>
              </div>
            </div>
          </article>
        </div>
      </div>
    </div>
  </section>

  <section class="mt-5 bg-light">
    <div class="container">
      <div class="row justify-content-center align-items-center">
        <div class="col-md-5">
          <h2 class="fw-bold fs-1 mt-5">Get <span class="text-primary">25% Discount</span> on your first purchase</h2>
          <p>Just Sign Up & Register it now to become member.</p>
          <form>
            <div class="mb-3">
              <label for="email" class="form-label d-none">Email</label>
              <input type="email" class="form-control form-control-lg" name="email" id="email" placeholder="Email"
                required>
            </div>
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-dark btn-lg">Subscribe</button>
            </div>
          </form>
        </div>
        <div class="col-md-7">
        <img src="{{ asset('img/banner-dog.png') }}" alt="image" class="img-fluid">
        </div>
      </div>
    </div>
  </section>

  <section class="section-padding">
    <div class="container">
      <div class="row justify-content-center align-items-center">
          <div class="col-md-3">
            <div class="mb-3">
              <svg class="text-primary flex-shrink-0 me-3" width="3em" height="3em">
                <use xlink:href="#delivery"></use>
              </svg>
            </div>
            <div>
              <h5 class="fs-5 fw-normal">Free Delivery</h5>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
            </div>
          </div>

          <div class="col-md-3">
            <div class="mb-3">
              <svg class="text-primary flex-shrink-0 me-3" width="3em" height="3em">
                <use xlink:href="#Shop"></use>
              </svg>
            </div>
            <div>
              <h5 class="fs-5 fw-normal">100% Secure Payment</h5>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
            </div>
          </div>

          <div class="col-md-3">
            <div class="mb-3">
              <svg class="text-primary flex-shrink-0 me-3" width="3em" height="3em">
                <use xlink:href="#fresh"></use>
              </svg>
            </div>
            <div>
              <h5 class="fs-5 fw-normal">Quality Guarantee</h5>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
            </div>
          </div>

          <div class="col-md-3">
            <div class="mb-3">
              <svg class="text-primary flex-shrink-0 me-3" width="3em" height="3em">
                <use xlink:href="#calendar"></use>
              </svg>
            </div>
            <div>
              <h5 class="fs-5 fw-normal">Daily Offers</h5>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
            </div>
          </div>
      </div>
    </div>
  </section>

  <footer class="section-padding pb-5 bg-dark text-secondary-emphasis" data-bs-theme="dark">
    <div class="container-lg">
      <div class="row my-5 justify-content-center">

        <div class="col-md-3 col-sm-6">
          <div class="footer-menu">
          <img src="{{ asset('img/boombot_land.png') }}" width="240" height="70" alt="logo">
            <div class="social-links mt-3">
              <ul class="d-flex list-unstyled gap-3">
                <li>
                  <a href="#" class="text-secondary-emphasis">
                    <svg width="32" height="32">
                      <use xlink:href="#facebook"></use>
                    </svg>
                  </a>
                </li>
                <li>
                  <a href="#" class="text-secondary-emphasis">
                    <svg width="32" height="32">
                      <use xlink:href="#twitter"></use>
                    </svg>
                  </a>
                </li>
                <li>
                  <a href="#" class="text-secondary-emphasis">
                    <svg width="32" height="32">
                      <use xlink:href="#youtube"></use>
                    </svg>
                  </a>
                </li>
                <li>
                  <a href="#" class="text-secondary-emphasis">
                    <svg width="32" height="32">
                      <use xlink:href="#instagram"></use>
                    </svg>
                  </a>
                </li>
                <li>
                  <a href="#" class="text-secondary-emphasis">
                    <svg width="32" height="32">
                      <use xlink:href="#amazon"></use>
                    </svg>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-sm-6">
          <div class="footer-menu">
            <h5 class="fs-5 fw-normal text-white">Shop</h5>
            <ul class="menu-list list-unstyled">
              <li class="menu-item">
                <a href="#" class="nav-link text-secondary-emphasis">About us</a>
              </li>
              <li class="menu-item">
                <a href="#" class="nav-link text-secondary-emphasis">Conditions</a>
              </li>
              <li class="menu-item">
                <a href="#" class="nav-link text-secondary-emphasis">Our Journals</a>
              </li>
              <li class="menu-item">
                <a href="#" class="nav-link text-secondary-emphasis">Careers</a>
              </li>
              <li class="menu-item">
                <a href="#" class="nav-link text-secondary-emphasis">Affiliate Programme</a>
              </li>
              <li class="menu-item">
                <a href="#" class="nav-link text-secondary-emphasis">Ultras Press</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-md-3 col-sm-6">
          <div class="footer-menu">
            <h5 class="fs-5 fw-normal text-white">Quick Links</h5>
            <ul class="menu-list list-unstyled">
              <li class="menu-item">
                <a href="#" class="nav-link text-secondary-emphasis">Offers</a>
              </li>
              <li class="menu-item">
                <a href="#" class="nav-link text-secondary-emphasis">Discount Coupons</a>
              </li>
              <li class="menu-item">
                <a href="#" class="nav-link text-secondary-emphasis">Stores</a>
              </li>
              <li class="menu-item">
                <a href="#" class="nav-link text-secondary-emphasis">Track Order</a>
              </li>
              <li class="menu-item">
                <a href="#" class="nav-link text-secondary-emphasis">Shop</a>
              </li>
              <li class="menu-item">
                <a href="#" class="nav-link text-secondary-emphasis">Info</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-md-3 col-sm-6">
          <div class="footer-menu">
            <h5 class="fs-5 fw-normal text-white">Customer Service</h5>
            <ul class="menu-list list-unstyled">
              <li class="menu-item">
                <a href="#" class="nav-link text-secondary-emphasis">FAQ</a>
              </li>
              <li class="menu-item">
                <a href="#" class="nav-link text-secondary-emphasis">Contact</a>
              </li>
              <li class="menu-item">
                <a href="#" class="nav-link text-secondary-emphasis">Privacy Policy</a>
              </li>
              <li class="menu-item">
                <a href="#" class="nav-link text-secondary-emphasis">Returns & Refunds</a>
              </li>
              <li class="menu-item">
                <a href="#" class="nav-link text-secondary-emphasis">Cookie Guidelines</a>
              </li>
              <li class="menu-item">
                <a href="#" class="nav-link text-secondary-emphasis">Delivery Information</a>
              </li>
            </ul>
          </div>
        </div>

      </div>
      <div class="row">
        <div class="col-md-6 copyright">
          <p>© 2025 Furry. All rights reserved.</p>
        </div>
        <div class="col-md-6 credit-link text-start text-md-end">
          <p>HTML Template by <a href="https://templatesjungle.com/" target="_blank" class="text-white text-decoration-none">TemplatesJungle</a></p>
        </div>
      </div>
    </div>
  </footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('public/js/plugins.js') }}"></script>
  <script src="{{ asset('public/js/script.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>

</body>

</html>