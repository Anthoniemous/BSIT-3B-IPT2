<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hairnic - Login & Signup Modal</title>
  <link rel="icon" href="img/favicon.ico">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Poppins:wght@400;700;800&display=swap" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
</head>
<body>

  <!-- Navbar -->
  <header class="navbar">
    <div class="container">
      <div class="logo">Hairnic</div>
      <nav>
        <ul class="nav-links">
          <li><a href="#" class="active">Home</a></li>
          <li><a href="#">About</a></li>
          <li><a href="#">Products</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
      </nav>
      <a href="#" class="btn open-login">Log In</a>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="hero">
    <div class="container hero-content">
      <div class="hero-text">
        <p class="subtitle">Natural & Organic</p>
        <h1>Hair <span class="thin">Shampoo</span> For <br> Healthy Hair</h1>
        <p class="desc">
          Experience the best organic shampoo made with love and nature. Carefully formulated to nourish and strengthen every strand.
        </p>
        <div class="btn-group">
          <a href="#" class="btn dark">Shop Now</a>
          <a href="#" class="btn outline open-login">Log In</a>
        </div>
      </div>
      <div class="hero-image">
        <img src="{{ asset('css/img/shampoo.png') }}" alt="Hairnic Shampoo">
      </div>
    </div>
  </section>

  <!-- LOGIN & REGISTER MODAL -->
  <div class="login-modal" id="loginModal">
    <div class="login-modal-content">
      <span class="close-btn" id="closeModal">&times;</span>

      <!-- LOGIN FORM -->
      <div class="form-container" id="loginForm">
        <h2>Log In</h2>
        <form method="POST" action="{{ url('/login') }}">
          @csrf
          <label>Email:</label>
          <input type="email" name="email" placeholder="Enter your email" required>
          <label>Password:</label>
          <input type="password" name="password" placeholder="Enter your password" required>
          <button type="submit">Login</button>
        </form>
        <a href="{{ route('google.login') }}" class="google-btn">Login with Google</a>
        <div class="links">
          <p>Don't have an account? <a href="#" id="openSignup">Register here</a></p>
          <p>Forgot your password? <a href="{{ url('/forgotpassword') }}">Click here</a></p>
        </div>
      </div>

      <!-- REGISTER FORM -->
      <div class="form-container hidden" id="signupForm">
        <h2>Register</h2>
        <form method="POST" action="{{ url('/register') }}">
          @csrf
          <label>Name:</label>
          <input type="text" name="name" placeholder="Enter your name" required>
          <label>Email:</label>
          <input type="email" name="email" placeholder="example@email.com" required>
          <label>Password:</label>
          <input type="password" name="password" placeholder="Enter your password" required>
          <label>Confirm Password:</label>
          <input type="password" name="password_confirmation" placeholder="Confirm password" required>
          <button type="submit">Register</button>
        </form>
        <div class="links">
          <p>Already have an account? <a href="#" id="openLogin">Login here</a></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="footer">
    <p>© 2025 Hairnic Template. All rights reserved.</p>
  </footer>

  <!-- Script -->
  <script>
    const loginModal = document.getElementById('loginModal');
    const openBtns = document.querySelectorAll('.open-login');
    const closeModal = document.getElementById('closeModal');
    const loginForm = document.getElementById('loginForm');
    const signupForm = document.getElementById('signupForm');

    // open modal
    openBtns.forEach(btn => btn.addEventListener('click', e => {
      e.preventDefault();
      loginModal.classList.add('show');
      loginForm.classList.remove('hidden');
      signupForm.classList.add('hidden');
    }));

    // close modal
    closeModal.addEventListener('click', () => loginModal.classList.remove('show'));

    // switch to signup
    document.getElementById('openSignup').addEventListener('click', e => {
      e.preventDefault();
      loginForm.classList.add('fadeOut');
      setTimeout(() => {
        loginForm.classList.add('hidden');
        signupForm.classList.remove('hidden');
        loginForm.classList.remove('fadeOut');
      }, 300);
    });

    // switch to login
    document.getElementById('openLogin').addEventListener('click', e => {
      e.preventDefault();
      signupForm.classList.add('fadeOut');
      setTimeout(() => {
        signupForm.classList.add('hidden');
        loginForm.classList.remove('hidden');
        signupForm.classList.remove('fadeOut');
      }, 300);
    });

    // close on outside click
    window.addEventListener('click', e => {
      if (e.target === loginModal) loginModal.classList.remove('show');
    });
  </script>
</body>
</html>
