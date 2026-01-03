<!DOCTYPE html>
<html lang="en-US" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Maison de Lux</title>


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicons/favicon.ico">
    <link rel="manifest" href="assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link href="assets/css/theme.css" rel="stylesheet" />

  </head>


  <body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
      <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3 d-block" data-navbar-on-scroll="data-navbar-on-scroll">
        <div class="container"><a class="navbar-brand d-inline-flex" href="index.html"><span class="text-light fs-2 fw-bold ms-2">Maison de Lux</span></a>
          <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
          <div class="collapse navbar-collapse border-top border-lg-0 mt-4 mt-lg-0" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item px-2"><a class="nav-link fw-bold active" aria-current="page" href="#collections">WATCHES</a></li>
              <li class="nav-item px-2"><a class="nav-link fw-bold" href="#store">STORE</a></li>
              <li class="nav-item px-2"><a class="nav-link fw-bold" href="#contact">CONTACT</a></li>
              <li class="nav-item px-2"><a class="nav-link fw-bold" href="{{ route('shop') }}">DESIGN & ORDER</a></li>
            </ul>
            <form class="d-flex"><a class="text-primary" href="#!">
                <svg class="feather feather-phone-call" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M15.05 5A5 5 0 0 1 19 8.95M15.05 1A9 9 0 0 1 23 8.94m-1 7.98v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                </svg></a>
              <div class="ms-4 text-light fw-bold">+63-197-0457-27</div>
            </form>
          </div>
        </div>
      </nav>
      <section class="py-0" id="header">
        <div class="bg-holder" style="background-image:url(assets/img/gallery/rolexwomen.png);background-position:right top;background-size:contain;">
        </div>
        <!--/.bg-holder-->

        <div class="container">
          <div class="row align-items-center min-vh-75 min-vh-xl-100">
            <div class="col-md-8 col-lg-6 text-md-start text-center">
                <h1 class="display-1 lh-sm text-uppercase text-light">Custom Watches For <br class="d-none d-xxl-block" /> Any Occasion</h1>
                <a class="btn btn-sm btn-outline-primary me-3" href="{{ route('shop') }}">DESIGN & ORDER</a>
            </div>
          </div>
        </div>
      </section>
      <section class="bg-black py-8 pt-0" id="store">
        <div class="bg-holder" style="background-image:url(assets/img/gallery/store-bg.png);background-position:left bottom;background-size:contain;">
        </div>
        <!--/.bg-holder-->

        <div class="container-lg">
          <div class="row flex-center">
            <div class="col-6 order-md-0 text-center text-md-start"></div>
            <div class="col-sm-10 col-md-6 col-lg-6 text-center text-md-start">
              <div class="col-4 position-relative ms-auto py-5"><a class="carousel-control-prev carousel-icon z-index-2" href="#carouselExampleFade" role="button" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Previous</span></a><a class="carousel-control-next carousel-icon z-index-2" href="#carouselExampleFade" role="button" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Next</span></a></div>
              <div class="carousel slide carousel-fade" id="carouselExampleFade" data-bs-ride="carousel">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <div class="row h-100">
                      <div class="col-12">
                        <h5 class="fs-3 fs-lg-5 lh-sm text-uppercase">Maison de Lux</h5>
                        <p class="my-4 pe-xl-5">Maison de Lux is a destination for timeless watches crafted with precision and purpose.
                                        Each piece in our collection reflects refined design, enduring quality, and an appreciation for moments that matter. From classic elegance to modern sophistication, we offer watches that elevate every second.</p>
                      </div>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <div class="row h-100">
                      <div class="col-12">
                        <h5 class="fs-3 fs-lg-5 lh-sm text-uppercase">Our store</h5>
                        <p class="my-4 pe-xl-5">Located at Banaybanay Davao Oriental and many more branches.</p>
                      </div>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <div class="row h-100">
                      <div class="col-12">
                        <h5 class="fs-3 fs-lg-5 lh-sm text-uppercase">The CEO</h5>
                        <p class="my-4 pe-xl-5">Ms. Jessel Lapay</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="py-0 pb-6" id="collections">
        <div class="container">
          <div class="row h-100">
            <div class="col-lg-7 mt-7">
              <h5 class="fs-3 fs-lg-5 lh-sm mb-0 text-uppercase">Collections</h5>
            </div>
            <div class="col-12">
              <nav>
                <div class="nav nav-tabs watch-tabs mb-4 justify-content-end" id="nav-tab" role="tablist">
                  <button class="nav-link active" id="nav-latest-tab" data-bs-toggle="tab" data-bs-target="#nav-latest" type="button" role="tab" aria-controls="nav-latest" aria-selected="true">LATEST </button>
                  <button class="nav-link" id="nav-popular-tab" data-bs-toggle="tab" data-bs-target="#nav-popular" type="button" role="tab" aria-controls="nav-popular" aria-selected="false">POPULAR</button>
                </div>
              </nav>
              <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active" id="nav-latest" role="tabpanel">
                <div class="row h-100 align-items-center">
                    <div class="col-sm-6 col-md-4 mb-3">
                    <div class="card bg-black text-white p-6 pb-8">
                        <img class="card-img" src="assets/img/gallery/rolex8.jpg" alt="">
                        <div class="card-img-overlay bg-dark-gradient d-flex flex-column-reverse align-items-center">
                        <h4 class="text-light">ROLEX</h4>
                        </div>
                    </div>
                    </div>
                    <div class="col-sm-6 col-md-4 mb-3">
                    <div class="card bg-black text-white p-6 pb-8">
                        <img class="card-img" src="assets/img/gallery/cartier3.jpg" alt="">
                        <div class="card-img-overlay bg-dark-gradient d-flex flex-column-reverse align-items-center">
                        <h4 class="text-light">CARTIER</h4>
                        </div>
                    </div>
                    </div>
                    <div class="col-sm-6 col-md-4 mb-3">
                    <div class="card bg-black text-white p-6 pb-8">
                        <img class="card-img" src="assets/img/gallery/patek4.jpg" alt="">
                        <div class="card-img-overlay bg-dark-gradient d-flex flex-column-reverse align-items-center">
                        <h4 class="text-light">PATEK</h4>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
                <div class="tab-pane fade" id="nav-popular" role="tabpanel">
                <div class="row h-100 align-items-center">
                <div class="col-sm-6 col-md-4 mb-3">
                <div class="card bg-black text-white p-6 pb-8">
                    <img class="card-img" src="assets/img/gallery/rolex9.jpg" alt="">
                    <div class="card-img-overlay bg-dark-gradient d-flex flex-column-reverse align-items-center">
                    <h4 class="text-light">ROLEX PEPSI</h4>
                    </div>
                </div>
                </div>
                <div class="col-sm-6 col-md-4 mb-3">
                  <div class="card bg-black text-white p-6 pb-8">
                    <img class="card-img" src="assets/img/gallery/cartier4.jpg" alt="">
                    <div class="card-img-overlay bg-dark-gradient d-flex flex-column-reverse align-items-center">
                      <h4 class="text-light">CARTIER</h4>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-4 mb-3">
                  <div class="card bg-black text-white p-6 pb-8">
                    <img class="card-img" src="assets/img/gallery/rolex10.jpg" alt="">
                    <div class="card-img-overlay bg-dark-gradient d-flex flex-column-reverse align-items-center">
                      <h4 class="text-light">ROLEX ICE OUT</h4>
                    </div>
                  </div>
                </div>
            </div>
        </div>
      </section>
      <!-- ============================================-->
      <!-- <section> begin ============================-->
      <section class="py-6 bg-dark">
        <div class="container">
          <div class="row">
            <div class="col-sm-6 col-lg-3 mb-4 mb-lg-0 d-flex flex-center"><img src="assets/img/gallery/rado.png" alt="brands" /></div>
            <div class="col-sm-6 col-lg-3 mb-4 mb-lg-0 d-flex flex-center"><img src="assets/img/gallery/swatch.png" alt="brands" /></div>
            <div class="col-sm-6 col-lg-3 mb-4 mb-lg-0 d-flex flex-center"><img src="assets/img/gallery/omega-1.png" alt="brands" /></div>
            <div class="col-sm-6 col-lg-3 mb-4 mb-lg-0 d-flex flex-center"><img src="assets/img/gallery/zenith.png" alt="brands" /></div>
          </div>
        </div>
        <!-- end of .container-->
      </section>
      <!-- <section> close ============================-->
      <!-- ============================================-->

      <!-- ============================================-->
      <!-- <section> begin ============================-->
      <section id="testimonial">

        <div class="container">
          <div class="row">
            <div class="col-lg-7 mx-auto text-center my-5">
              <h5 class="fs-3 fs-lg-5 lh-sm mb-0 text-uppercase">what customers are saying</h5>
            </div>
          </div>
          <div class="row flex-center h-100">
            <div class="col-xl-9">
              <div class="carousel slide" id="carouselTestimonials" data-bs-ride="carousel">
                <div class="carousel-inner">
                  <div class="carousel-item active" data-bs-interval="10000">
                    <div class="row h-100 justify-content-center">
                      <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow card-span p-3 bg-black">
                          <div class="card-body">
                            <div class="d-flex align-items-center"><img class="img-fluid" src="assets/img/gallery/jessel.jpg" width="80" alt="testimonials" />
                              <div class="flex-1 ms-4">
                                <h6 class="fs-lg-1 mb-1 text-uppercase">amanda smith</h6>
                              </div>
                            </div>
                            <p class="mb-0 mt-4 fw-light lh-lg">Nisi cumque in necessitatibus molestiae eaque excepturi ab. Laboriosam ipsam voluptatem voluptatibus labore quam nihil. Quasi occaecati quos ratione quia aut molestiae velit et.</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow card-span p-3 bg-black">
                          <div class="card-body">
                            <div class="d-flex align-items-center"><img class="img-fluid" src="assets/img/gallery/jessel.jpg" width="80" alt="testimonials" />
                              <div class="flex-1 ms-4">
                                <h6 class="fs-lg-1 mb-1 text-uppercase">Ainara Vergara</h6>
                              </div>
                            </div>
                            <p class="mb-0 mt-4 fw-light lh-lg">Nisi cumque in necessitatibus molestiae eaque excepturi ab. Laboriosam ipsam voluptatem voluptatibus labore quam nihil. Quasi occaecati quos ratione quia aut molestiae velit et.</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="carousel-item" data-bs-interval="5000">
                    <div class="row h-100 justify-content-center">
                      <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow card-span p-3 bg-black">
                          <div class="card-body">
                            <div class="d-flex align-items-center"><img class="img-fluid" src="assets/img/gallery/jessel.jpg" width="80" alt="testimonials" />
                              <div class="flex-1 ms-4">
                                <h6 class="fs-lg-1 mb-1 text-uppercase">Niek Bove</h6>
                              </div>
                            </div>
                            <p class="mb-0 mt-4 fw-light lh-lg">Nisi cumque in necessitatibus molestiae eaque excepturi ab. Laboriosam ipsam voluptatem voluptatibus labore quam nihil. Quasi occaecati quos ratione quia aut molestiae velit et.</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow card-span p-3 bg-black">
                          <div class="card-body">
                            <div class="d-flex align-items-center"><img class="img-fluid" src="assets/img/gallery/jessel.jpg" width="80" alt="testimonials" />
                              <div class="flex-1 ms-4">
                                <h6 class="fs-lg-1 mb-1 text-uppercase">Ainara Vergara</h6>
                              </div>
                            </div>
                            <p class="mb-0 mt-4 fw-light lh-lg">Nisi cumque in necessitatibus molestiae eaque excepturi ab. Laboriosam ipsam voluptatem voluptatibus labore quam nihil. Quasi occaecati quos ratione quia aut molestiae velit et.</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <div class="row h-100 justify-content-center">
                      <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow card-span p-3 bg-black">
                          <div class="card-body">
                            <div class="d-flex align-items-center"><img class="img-fluid" src="assets/img/gallery/jessel.jpg" width="80" alt="testimonials" />
                              <div class="flex-1 ms-4">
                                <h6 class="fs-lg-1 mb-1 text-uppercase">amanda smith</h6>
                              </div>
                            </div>
                            <p class="mb-0 mt-4 fw-light lh-lg">Nisi cumque in necessitatibus molestiae eaque excepturi ab. Laboriosam ipsam voluptatem voluptatibus labore quam nihil. Quasi occaecati quos ratione quia aut molestiae velit et.</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow card-span p-3 bg-black">
                          <div class="card-body">
                            <div class="d-flex align-items-center"><img class="img-fluid" src="assets/img/gallery/jessel.jpg" width="80" alt="testimonials" />
                              <div class="flex-1 ms-4">
                                <h6 class="fs-lg-1 mb-1 text-uppercase">Ainara Vergara</h6>
                              </div>
                            </div>
                            <p class="mb-0 mt-4 fw-light lh-lg">Nisi cumque in necessitatibus molestiae eaque excepturi ab. Laboriosam ipsam voluptatem voluptatibus labore quam nihil. Quasi occaecati quos ratione quia aut molestiae velit et.</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row mt-5 flex-center">
                  <div class="col-auto position-relative z-index-2">
                    <ol class="carousel-indicators">
                      <li class="active mx-2" data-bs-target="#carouselTestimonials" data-bs-slide-to="0"></li>
                      <li class="mx-2" data-bs-target="#carouselTestimonials" data-bs-slide-to="1"></li>
                      <li class="mx-2" data-bs-target="#carouselTestimonials" data-bs-slide-to="2"></li>
                    </ol>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- end of .container-->

      </section>
      <!-- <section> close ============================-->
      <!-- ============================================-->




      <!-- ============================================-->
      <!-- <section> begin ============================-->
      <section class="py-0 pt-7" id="contact">

        <div class="container">
          <div class="row">
            <div class="col-6 col-sm-4 col-xl-3 mb-3">
              <h4 class="lh-lg fw-bold text-light">WATCH</h4>
            </div>
            <div class="col-6 col-sm-4 col-xl-3 mb-3">
              <h5 class="lh-lg fw-bold text-light">MENU</h5>
              <ul class="list-unstyled mb-md-4 mb-lg-0">
                <li class="lh-lg"><a class="text-800 text-decoration-none text-uppercase fw-bold" href="#!">Shipping Info</a></li>
                <li class="lh-lg"><a class="text-800 text-decoration-none text-uppercase fw-bold" href="#!">Refunds</a></li>
                <li class="lh-lg"><a class="text-800 text-decoration-none text-uppercase fw-bold" href="#!">How to Order</a></li>
                <li class="lh-lg"><a class="text-800 text-decoration-none text-uppercase fw-bold" href="#!">How to Track</a></li>
                <li class="lh-lg"><a class="text-800 text-decoration-none text-uppercase fw-bold" href="#!">Size Guides</a></li>
              </ul>
            </div>
            <div class="col-6 col-sm-4 col-xl-3 mb-3">
              <h5 class="mb-5"></h5>
              <ul class="list-unstyled mb-md-4 mb-lg-0">
                <li class="lh-lg"><a class="text-800 text-decoration-none text-uppercase fw-bold" href="#!">Contact Us</a></li>
                <li class="lh-lg"><a class="text-800 text-decoration-none text-uppercase fw-bold" href="#!">my account</a></li>
              </ul>
            </div>
            <div class="col-12 col-xl-3">
              <h5 class="lh-lg fw-bold text-light text-uppercase">Signup For our Latest News</h5>
              <div class="row input-group-icon mb-5">
                <div class="col-12">
                  <form class="row row-cols-lg-auto g-0 align-items-center">
                    <div class="col-8 col-lg-9">
                      <label class="visually-hidden" for="colFormLabel">Username</label>
                      <div class="input-group">
                        <input class="rounded-end-0 form-control" id="colFormLabel" type="email" placeholder="email address" />
                      </div>
                    </div>
                    <div class="col-4 col-lg-3">
                      <button class="btn btn-primary rounded-start-0" type="submit">Submit</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="border-bottom border-700"></div>
          <div class="row flex-center my-3">
            <div class="col-md-6 order-1 order-md-0">
              <p class="my-2 text-800 text-center text-md-start"> Made with&nbsp;
                <svg class="bi bi-suit-heart-fill" xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="#EB6453" viewBox="0 0 16 16">
                  <path d="M4 1c2.21 0 4 1.755 4 3.92C8 2.755 9.79 1 12 1s4 1.755 4 3.92c0 3.263-3.234 4.414-7.608 9.608a.513.513 0 0 1-.784 0C3.234 9.334 0 8.183 0 4.92 0 2.755 1.79 1 4 1z"></path>
                </svg>&nbsp;by&nbsp;<a class="text-500" href="https://themewagon.com/" target="_blank">ThemeWagon </a>
              </p>
            </div>
            <div class="col-md-6">
              <div class="text-center text-md-end"><a href="#!"><span class="me-4" data-feather="facebook"></span></a><a href="#!"> <span class="me-4" data-feather="instagram"></span></a><a href="#!"> <span class="me-4" data-feather="youtube"></span></a><a href="#!"> <span class="me-4" data-feather="twitter"></span></a></div>
            </div>
          </div>
        </div>
        <!-- end of .container-->

      </section>
      <!-- <section> close ============================-->
      <!-- ============================================-->


    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->




    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="vendors/@popperjs/popper.min.js"></script>
    <script src="vendors/bootstrap/bootstrap.min.js"></script>
    <script src="vendors/is/is.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="vendors/feather-icons/feather.min.js"></script>
    <script>
      feather.replace();
    </script>
    <script src="assets/js/theme.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;700&amp;display=swap" rel="stylesheet">
  </body>

</html>