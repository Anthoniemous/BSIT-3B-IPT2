<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coffee ' Sodoso | Register</title>

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

    .btn-register-nav {
      background: #d9b08c;
      border-radius: 10px;
      padding: 6px 16px;
      font-weight: 600;
      color: #000;
      margin-left: 10px;
    }

    /* Hero */
    .hero {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 0 10%;
      position: relative;
      background-image: url('https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&w=1600&q=80');
      background-size: cover;
      background-position: center;
    }

    .hero::before {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(0,0,0,0.6);
    }

    .register-card {
      position: relative;
      z-index: 2;
      width: 400px;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 18px;
      padding: 30px;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.5);
    }

    .register-card h2 {
      color: #d9b08c;
      font-weight: bold;
      text-align: center;
      margin-bottom: 25px;
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

    .form-control:focus {
      border-color: #d9b08c;
      box-shadow: 0 0 5px #d9b08c;
    }

    .btn-register {
      background: #d9b08c;
      color: #000;
      font-weight: 600;
      border-radius: 10px;
      padding: 10px;
      transition: all 0.2s ease;
    }

    .btn-register:hover {
      background: #b88a6a;
      transform: translateY(-2px);
    }

    a {
      color: #d9b08c;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }

    .alert {
      background: rgba(255, 0, 0, 0.1);
      color: #ffb6b6;
      border: 1px solid rgba(255, 0, 0, 0.3);
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
            <a href="{{ route('login') }}" class="btn btn-register-nav">Login</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section with Register Card -->
  <section class="hero">
    <div class="register-card">
      <h2><i class="fas fa-mug-hot"></i> Register</h2>

      <form action="{{ route('register.post') }}" method="POST">
        @csrf

        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <div class="mb-3">
          <input type="text" name="name" class="form-control" placeholder="Full Name" value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email Address" value="{{ old('email') }}" required>
        </div>
        <div class="mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="mb-3">
          <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
        </div>

        <button type="submit" class="btn btn-register w-100">Create Account</button>
      </form>

      <p class="mt-3 text-center">
        Already have an account? <a href="{{ route('login') }}">Login</a>
      </p>

      <hr class="bg-light">

      <div class="text-center">
        <a href="{{ url('auth/google') }}" class="btn btn-google-login w-100">
          <i class="fab fa-google"></i> Continue with Google
        </a>
      </div>
    </div>
  </section>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
