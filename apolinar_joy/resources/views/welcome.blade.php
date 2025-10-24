<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Glamour Makeup Store</title>

  <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>
  <header class="site-header">
    <div class="container header-inner">
      <div class="logo">
        <img src="{{ asset('css/img/image.png') }}" alt="Glamour Logo">
        <span class="brand">Glamour Makeup Store</span>
      </div>

      <nav class="main-nav">
        <ul>
          <li><a href="{{ url('/') }}">Home</a></li>
          <li><a href="{{ url('/userdashboard') }}">Products</a></li>
          <li><a href="#">Offers</a></li>
          <li><a href="#">About</a></li>
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
          <button class="btn" onclick="window.location.href='{{ url('/login') }}'">Login</button>
         <button class="btn" onclick="window.location.href='{{ url('/register') }}'">Sign Up</button>
        @endauth
      </div>
    </div>
  </header>


  <section class="hero container">
    <div class="hero-inner">
      <div class="hero-copy">
        <h1>Discover Your Beauty!</h1>
        <p class="lead">
          Indulge in premium makeup essentials that bring out your natural glow. Shine every day with Glamour Makeup.
        </p>
        <div class="hero-ctas">
          <a href="{{ route('user.dashboard') }}" class="btn cta">Shop Now</a>
          <a href="#featured" class="text-link">Explore Collections</a>
        </div>
      </div>
      <div class="hero-media">
        <img id="hero-img" src="{{ asset('css/img/image1.png') }}" alt="Makeup Collection">
      </div>
    </div>
  </section>


  <section class="features container">
    <div class="feature-card">
      <i class="fa fa-truck"></i>
      <div class="feature-copy"><strong>Free Delivery</strong><span>On all beauty products</span></div>
    </div>
    <div class="feature-card">
      <i class="fa fa-refresh"></i>
      <div class="feature-copy"><strong>Easy Returns</strong><span>30-day money back</span></div>
    </div>
    <div class="feature-card">
      <i class="fa fa-headphones"></i>
      <div class="feature-copy"><strong>24/7 Support</strong><span>We’re always here for you</span></div>
    </div>
    <div class="feature-card">
      <i class="fa fa-credit-card"></i>
      <div class="feature-copy"><strong>Secure Payment</strong><span>Trusted and safe checkout</span></div>
    </div>
  </section>


  <footer class="site-footer">
    <div class="container">
      <div class="footer-left">
        <p>© {{ date('Y') }} Glamour Makeup Store — All Rights Reserved.</p>
      </div>
      <div class="footer-right">
        <nav>
          <a href="#">Privacy</a>
          <a href="#">Terms</a>
          <a href="#">Contact</a>
        </nav>
      </div>
    </div>
  </footer>


  

<script>
  // Floating animation
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

  // Modal logic
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
