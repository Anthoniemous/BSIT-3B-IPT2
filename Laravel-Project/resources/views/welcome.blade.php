<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NBA Fan Store</title>
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<header>
  <div class="logo">
    <img src="{{ asset('css/img/image.png') }}" alt="NBA Logo">
    <span>NBA Fan Store</span>
  </div>
  <nav>
    <ul>
      <li><a href="#">Home</a></li>
      <li><a href="#">Merch</a></li>
      <li><a href="#">Teams</a></li>
      <li><a href="#">About</a></li>
    </ul>
  </nav>

  <div class="user-option">
    <button class="btn" id="openLogin">Login</button>
    <button class="btn" id="openRegister">Sign Up</button>
  </div>
</header>

<!-- Login Modal -->
<div id="loginModal" class="modal">
  <div class="modal-content">
    <span class="close" id="closeLogin">&times;</span>
    <h2>Login</h2>
    
    <form method="POST" action="{{ url('/login') }}">
        @csrf
        <label>Email:</label>
        <input type="email" name="email" required>
        
        <label>Password:</label>
        <input type="password" name="password" required>
        
        <button type="submit">Login</button>
    </form>

    <a href="{{ route('google.login') }}" class="btn google-login">
        <i class="fa fa-google"></i> Login with Google
    </a>

    <p>Don't have an account? <a href="#" id="switchToRegister">Register here</a></p>
  </div>
</div>

<!-- Register Modal -->
<div id="registerModal" class="modal">
  <div class="modal-content">
    <span class="close" id="closeRegister">&times;</span>
    <h2>Register</h2>
    <form method="POST" action="{{ url('/register') }}">
        @csrf
        <label>Name:</label>
        <input type="text" name="name" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <label>Confirm Password:</label>
        <input type="password" name="password_confirmation" required>

        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="#" id="switchToLogin">Login here</a></p>
  </div>
</div>

<section class="hero">
  <h1>Welcome to NBA Fan Store</h1>
  <p>Get your favorite NBA merch and gear!</p>
</section>

<div class="content">
  <h2>Featured Merch</h2>
  <div class="product-cards">
    <div class="product-card">
      <img src="{{ asset('css/img/jordan.png') }}" alt="Jordan Shoes">
      <h3>Jordan Shoes</h3>
      <p>$250.00</p>
      <button>Add to Cart</button>
    </div>
    <div class="product-card">
      <img src="{{ asset('css/img/jersey.png') }}" alt="Lakers Jersey">
      <h3>Lakers Jersey</h3>
      <p>$120.00</p>
      <button>Add to Cart</button>
    </div>
    <div class="product-card">
      <img src="{{ asset('css/img/cap.png') }}" alt="Brooklyn Cap">
      <h3>Brooklyn Cap</h3>
      <p>$45.00</p>
      <button>Add to Cart</button>
    </div>
  </div>
</div>

<script>
  const loginModal = document.getElementById("loginModal");
  const registerModal = document.getElementById("registerModal");
  const openLogin = document.getElementById("openLogin");
  const openRegister = document.getElementById("openRegister");
  const closeLogin = document.getElementById("closeLogin");
  const closeRegister = document.getElementById("closeRegister");
  const switchToRegister = document.getElementById("switchToRegister");
  const switchToLogin = document.getElementById("switchToLogin");

  openLogin.onclick = () => loginModal.style.display = "flex";
  openRegister.onclick = () => registerModal.style.display = "flex";
  closeLogin.onclick = () => loginModal.style.display = "none";
  closeRegister.onclick = () => registerModal.style.display = "none";

  switchToRegister.onclick = (e) => {
    e.preventDefault();
    loginModal.style.display = "none";
    registerModal.style.display = "flex";
  };
  switchToLogin.onclick = (e) => {
    e.preventDefault();
    registerModal.style.display = "none";
    loginModal.style.display = "flex";
  };

  window.onclick = (event) => {
    if (event.target === loginModal) loginModal.style.display = "none";
    if (event.target === registerModal) registerModal.style.display = "none";
  };
</script>

</body>
</html>
