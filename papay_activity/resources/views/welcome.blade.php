<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cloud Haven Vape Shop</title>

  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <style>
    .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5); }
    .modal-content { background-color: #fff; margin: 5% auto; padding: 20px; width: 90%; max-width: 400px; border-radius: 8px; position: relative; }
    .close { position: absolute; top: 10px; right: 15px; font-size: 24px; cursor: pointer; }
    .tabs { display: flex; justify-content: space-around; margin-bottom: 15px; }
    .tabs button { flex: 1; padding: 10px; cursor: pointer; background: #eee; border: none; border-bottom: 2px solid transparent; font-weight: bold; }
    .tabs button.active { border-bottom: 2px solid #8B4513; background: #fff; }
    .form-container { display: none; }
    .form-container.active { display: block; }
    .form-container form { display: flex; flex-direction: column; }
    .form-container input { margin-bottom: 10px; padding: 8px; border-radius: 4px; border: 1px solid #ccc; }
    .form-container button { padding: 10px; border: none; background: #8B4513; color: #fff; border-radius: 4px; cursor: pointer; }
    .form-container button:hover { background: #6b3410; }
    .error-msg p, .success-msg { color: red; font-size: 14px; margin-bottom: 5px; }
    .success-msg { color: green; }
    .links { font-size: 13px; margin-top: 10px; }
    .links a { color: #8B4513; text-decoration: none; }
    .links a:hover { text-decoration: underline; }
  </style>
</head>
<body>
  <header class="site-header">
    <div class="container header-inner">
      <div class="logo">
        <img src="{{ asset('css/img/a.jpg') }}" alt="Vape Logo">
        <span class="brand">Cloud Haven Vape Shop</span>
      </div>

      <nav class="main-nav">
        <ul>  
          <li><a href="{{ url('/') }}">Home</a></li>
          <li><a href="{{ url('/userdashboard') }}">Products</a></li>
        </ul>
      </nav>

      <div class="user-option">
        @auth
          <a href="{{ route('dashboard') }}" class="btn small">Dashboard</a>
          <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" class="btn outline small">Logout</button>
          </form>
        @else
          <button id="loginBtn" class="btn outline small">Login</button>
          <button id="signupBtn" class="btn small">Sign Up</button>
        @endauth
      </div>
    </div>
  </header>

  <section class="hero container">
    <div class="hero-inner">
      <div class="hero-copy">
        <h1>Elevate Your Clouds Today!</h1>
        <p class="lead">
          Discover premium vape juices, mods, and accessories at Cloud Haven — where every puff hits just right.
        </p>
        <div class="hero-ctas">
          <a href="{{ route('user.dashboard') }}" class="btn cta">Shop Now</a>
          <a href="#featured" class="text-link">View Best Sellers</a>
        </div>
      </div>
      <div class="hero-media">
        <img id="hero-img" src="{{ asset('css/img/x.jpg') }}" alt="Vape Device">
      </div>
    </div>
  </section>

  <!-- Modal -->
  <div id="authModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>

      <div class="tabs">
        <button id="tabLogin" class="active">Login</button>
        <button id="tabRegister">Register</button>
      </div>

      <!-- Login Form -->
      <div id="loginForm" class="form-container active">
        <form method="POST" action="{{ url('/login') }}">
          @csrf
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" placeholder="Enter your email" required>

          <label for="password">Password:</label>
          <input type="password" id="password" name="password" placeholder="Enter your password" required>

          <button type="submit">Login</button>
        </form>
        <a href="{{ route('google.login') }}" class="google-btn">
          <img src="{{ asset('css/img/google.png') }}" alt="Google Icon"> Login with Google
        </a>
        <div class="links">
          <p>Don't have an account? <a href="#" id="switchToRegister">Register here</a></p>
          <p>Forgot your password? <a href="{{ url('/forgotpassword') }}">Click here</a></p>
        </div>
      </div>

      <!-- Register Form -->
      <div id="registerForm" class="form-container">
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
        <div class="links">
          <p>Already have an account? <a href="#" id="switchToLogin">Login here</a></p>
        </div>
      </div>
    </div>
  </div>

<script>
  // Hero floating effect
  const hero = document.querySelector('.hero-inner');
  const heroText = document.querySelector('.hero-copy');
  const heroImg = document.getElementById('hero-img');
  let floatTimeout;
  function resetFloating() {
    heroText.classList.add('float-animate');
    heroImg.classList.add('float-animate');
  }
  if (window.innerWidth > 768) {
    resetFloating();
    window.addEventListener('mousemove', (e) => {
      const x = (window.innerWidth / 2 - e.clientX) / 40;
      const y = (window.innerHeight / 2 - e.clientY) / 40;
      heroText.style.transform = `translate(${x}px, ${y}px)`;
      heroImg.style.transform = `translate(${-x}px, ${-y}px) rotateY(${x}deg)`;
      heroText.classList.remove('float-animate');
      heroImg.classList.remove('float-animate');
      clearTimeout(floatTimeout);
      floatTimeout = setTimeout(resetFloating, 1500);
    });
  }

  // Modal functionality
  const modal = document.getElementById('authModal');
  const loginBtn = document.getElementById('loginBtn');
  const signupBtn = document.getElementById('signupBtn');
  const closeBtn = document.querySelector('.close');

  const tabLogin = document.getElementById('tabLogin');
  const tabRegister = document.getElementById('tabRegister');
  const loginForm = document.getElementById('loginForm');
  const registerForm = document.getElementById('registerForm');
  const switchToRegister = document.getElementById('switchToRegister');
  const switchToLogin = document.getElementById('switchToLogin');

  loginBtn.onclick = () => { modal.style.display = 'block'; showLogin(); }
  signupBtn.onclick = () => { modal.style.display = 'block'; showRegister(); }
  closeBtn.onclick = () => modal.style.display = 'none';
  window.onclick = (e) => { if(e.target == modal) modal.style.display = 'none'; }

  tabLogin.onclick = showLogin;
  tabRegister.onclick = showRegister;
  switchToRegister.onclick = showRegister;
  switchToLogin.onclick = showLogin;

  function showLogin() {
    loginForm.classList.add('active');
    registerForm.classList.remove('active');
    tabLogin.classList.add('active');
    tabRegister.classList.remove('active');
  }

  function showRegister() {
    registerForm.classList.add('active');
    loginForm.classList.remove('active');
    tabRegister.classList.add('active');
    tabLogin.classList.remove('active');
  }
</script>
</body>
</html>
