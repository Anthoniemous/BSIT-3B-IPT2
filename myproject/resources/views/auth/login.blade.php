<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coffee ' Sodoso | Homepage</title>

  <!-- Connect to your CSS -->
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar">
    <div class="navbar-container">
      <a href="#" class="navbar-brand"><i class="fas fa-mug-hot"></i> Coffee ' Sodoso</a>
      <div class="navbar-links">
        <a href="#">Home</a>
        <a href="#">About</a>
        <a href="#">Our Product</a>
        <a href="#">Category</a>
        <a href="#">Contact Us</a>
        <a href="{{ route('register') }}" class="btn btn-register ">Register</a>
        <a href="javascript:void(0)" id="loginBtn" class="btn btn-register1">Login</a>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero">
    <div class="overlay"></div>
    <div class="hero-content">
      <h1>Enjoy The Most <span>Delicious Coffee</span></h1>
      <p>Start your day with coffee, enhancing productivity and mood. Its invigorating aroma sets a focused tone for tackling tasks with energy and positivity.</p>
      <button class="btn btn-explore">Explore</button>
      <button class="btn btn-order">Order Coffee</button>
    </div>
  </section>

  <!-- Login Modal -->
  <div id="loginModal" class="modal">
    <div class="modal-content">
      <span class="close" id="closeModal">&times;</span>

      <h2 style="text-align: center; margin-top: 1rem;">Login to Your Account</h2>

      

      <hr class="bg-light">

      <!-- Traditional Login Form -->
      <form action="{{ route('login.post') }}" method="POST">
        @csrf
        @if(session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email Address" required>
        </div>
        <div class="mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <button type="submit" class="btn btn-login">Login</button>

         <!-- Google Login -->
      <div class="text-center" style="margin-bottom: 15px; margin-top: 10px; margin-right: 20px; margin-left: 10px; ">
        <a href="{{ url('auth/google') }}" class="btn btn-google-login">
          <i class="fab fa-google"></i> Continue with Google
        </a>
      </div>
      </form>

    </div>
  </div>

  <script>
    // Modal script
    const modal = document.getElementById('loginModal');
    const openBtn = document.getElementById('loginBtn');
    const closeBtn = document.getElementById('closeModal');

    openBtn.onclick = () => modal.style.display = 'flex';
    closeBtn.onclick = () => modal.style.display = 'none';
    window.onclick = e => { if (e.target === modal) modal.style.display = 'none'; }
  </script>
</body>
</html>
