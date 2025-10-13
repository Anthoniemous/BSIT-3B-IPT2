<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coffee ' Sodoso | Homepage</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background: #0e0c0a;
      font-family: 'Segoe UI', sans-serif;
      color: #fff;
      overflow-x: hidden;
    }

    /* Navbar */
    .navbar {
      background: transparent;
      padding: 15px 50px;
      z-index: 1000;
    }

    .navbar-brand {
      font-weight: bold;
      color: #d9b08c;
      font-size: 1.5rem;
    }

    .navbar-nav .nav-link {
      color: #fff;
      margin: 0 12px;
      font-weight: 500;
    }

    .navbar-nav .nav-link:hover {
      color: #d9b08c;
    }

    .btn-register {
      background: #d9b08c;
      border-radius: 10px;
      padding: 6px 16px;
      font-weight: 600;
      color: #000;
    }

    /* Hero */
    .hero {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: flex-start;
      padding: 0 10%;
      background-size: cover;
      background-position: center;
      position: relative;
    }

    .hero::before {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(0,0,0,0.6);
    }

    .hero-content {
      position: relative;
      max-width: 550px;
      z-index: 2;
    }

    .hero-content h1 {
      font-size: 3rem;
      font-weight: bold;
      line-height: 1.3;
    }

    .hero-content h1 span {
      color: #d9b08c;
    }

    .hero-content p {
      margin: 20px 0;
      font-size: 1.1rem;
      color: #ddd;
    }

    .hero-content .btn {
      margin-right: 15px;
      margin-top: 10px;
      border-radius: 10px;
      padding: 10px 20px;
    }

    .btn-explore {
      background: #d9b08c;
      color: #000;
      font-weight: 600;
    }

    .btn-order {
      border: 1px solid #fff;
      color: #fff;
      font-weight: 600;
    }

    /* Modal Glass Effect */
    .modal-content {
      border-radius: 18px;
      padding: 25px;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      color: #fff;
    }

    .form-control {
      border-radius: 12px;
      padding: 12px;
      background: rgba(255, 255, 255, 0.15);
      border: 1px solid rgba(255, 255, 255, 0.3);
      color: #fff;
    }

    .form-control::placeholder {
      color: #ddd;
    }

    .btn-login, .btn-register-submit {
      background: #6f4e37;
      color: #fff;
      font-weight: 600;
      border-radius: 10px;
    }

    .btn-login:hover, .btn-register-submit:hover {
      background: #a37b60;
    }

    .btn-google-login {
      background: #db4437;
      color: #fff;
      border-radius: 10px;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><i class="fas fa-mug-hot"></i> Coffee ' Sodoso</a>
      <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#">About</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Our Product</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Category</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Contact Us</a></li>
          <li class="nav-item">
            <button class="btn btn-register" data-bs-toggle="modal" data-bs-target="#authModal">Login / Register</button>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Carousel -->
  <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <section class="hero" style="background-image:url('https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&w=1600&q=80');">
          <div class="hero-content">
            <h1>Enjoy The Most <span>Delicious Coffee</span></h1>
            <p>Start your day with coffee, enhancing productivity and mood. Its invigorating aroma sets a focused tone for tackling tasks with energy and positivity.</p>
            <button class="btn btn-explore">Explore</button>
            <button class="btn btn-order">Order Coffee</button>
          </div>
        </section>
      </div>
    </div>
  </div>

  <!-- Auth Modal -->
  <div class="modal fade" id="authModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <!-- Tabs -->
        <ul class="nav nav-tabs" id="authTab" role="tablist">
          <li class="nav-item">
            <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#loginTab" type="button" role="tab">Login</button>
          </li>
          <li class="nav-item">
            <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#registerTab" type="button" role="tab">Register</button>
          </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-3">
          <!-- Login Form -->
          <div class="tab-pane fade show active" id="loginTab" role="tabpanel">
            <form action="{{ route('login.post') }}" method="POST">
              @csrf
              <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email Address" required>
              </div>
              <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
              </div>
              <button type="submit" class="btn btn-login w-100">Login</button>
            </form>
          </div>

          <!-- Register Form -->
          <div class="tab-pane fade" id="registerTab" role="tabpanel">
            <form action="{{ route('register.post') }}" method="POST">
              @csrf
              <div class="mb-3">
                <input type="text" name="name" class="form-control" placeholder="Full Name" required>
              </div>
              <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
              </div>
              <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
              </div>
              <div class="mb-3">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
              </div>
              <button type="submit" class="btn btn-register-submit w-100">Register</button>
            </form>
            <hr class="bg-light">
            <div class="text-center">
              <a href="{{ url('auth/google') }}" class="btn btn-google-login w-100">
                <i class="fab fa-google"></i> Continue with Google
              </a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
