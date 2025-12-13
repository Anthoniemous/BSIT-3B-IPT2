<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>NBA Fan Store</title>

 
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  
</head>
<body>
  <header class="site-header">
    <div class="container header-inner">
      <div class="logo">
        <img src="{{ asset('css/img/logo.jpg') }}" alt="NBA Logo">
        <span class="brand">NBA Fan Store</span>
      </div>

      <nav class="main-nav">
        <ul>
          <li><a href="{{ url('/') }}" style="font-weight: bold;">Home</a></li>
          <li><a href="{{ url('/userdashboard') }}">Shop</a></li>
          <li><a href="{{ route('orders.index') }}" style="font-weight: bold;">Orders</a></li>
          <li><a href="{{ route('cart.index') }}" style="font-weight: bold;">Cart</a></li>
          <li><a href="{{ route('wishlist.index') }}" style="font-weight: bold;">Wishlist</a></li>
          
        </ul>
      </nav>

      <div class="user-option">
        @auth
          <a href="{{ route('user.dashboard') }}" class="btn small">Dashboard</a>

          <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" class="btn outline small">Logout</button>
          </form>
        @else
          <button id="loginBtn" class="btn outline small">Login</button>
          
        @endauth
      </div>
    </div>
  </header>


  <section class="hero container">
    <div class="hero-inner">
      <div class="hero-copy">
        <h1>Basketll Shoes Collection!</h1>
        <p class="lead">
          Get the latest NBA-inspired sneakers and merch — premium quality, limited drops, and fast delivery.
        </p>
        <div class="hero-ctas">
          <a href="{{ route('user.dashboard') }}" class="btn cta">Shop Now</a>
          <a href="#featured" class="text-link">Explore featured</a>
        </div>
      </div>
      <div class="hero-media">
        <img id="hero-img" src="{{ asset('css/img/imglogo.jpg') }}" alt="Hero Product">
      </div>
    </div>
  </section>

  <section class="products-section container">

  
    <h2 class="section-title">
    Available Products
    <div class="arrow-emoji">▼</div>  
</h2>
    
   <div class="product-list">
    @foreach($products as $product)
        <div class="product-item">
            <div class="product-img">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}">
            </div>

            <div class="product-info">
                <h3>{{ $product->product_name }}</h3>
                <p class="desc">{{ $product->description }}</p>
                <p class="price">${{ number_format($product->price, 2) }}</p>

                <div class="actions">
                    @guest
                        <!-- Kung wala pa naka-login -->
                        <form action="{{ route('login') }}" method="GET">
                            <button type="submit" class="btn add-cart">Add to Cart</button>
                        </form>
                    @endguest

                    @auth
                        <!-- Kung naka-login na -->
                        <form action="{{ route('cart.index') }}" method="GET">
                            <button type="submit" class="btn add-cart">Add to Cart</button>
                        </form>
                    @endauth

                   
                </div>
            </div>
        </div>
    @endforeach
</div>

</section>


  <footer class="site-footer">
    <div class="container">
      <div class="footer-left">
        <p>© {{ date('Y') }} NBA Fan Store — All Rights Reserved.</p>
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

 <!-- Modal -->
<div id="authModal" class="modal">
  <div class="modal-overlay"></div>
  <div class="modal-content">
    <button class="modal-close" onclick="closeModal()">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="18" y1="6" x2="6" y2="18"></line>
        <line x1="6" y1="6" x2="18" y2="18"></line>
      </svg>
    </button>

    <div class="modal-header">
      <h1>NBA STORE SHOES</h1>
      <p id="modalSubtitle">Welcome back! Please login to your account</p>
    </div>

    <div class="tabs">
      <button id="tabLogin" class="tab-btn active" onclick="switchTab('login')">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
          <polyline points="10 17 15 12 10 7"></polyline>
          <line x1="15" y1="12" x2="3" y2="12"></line>
        </svg>
        Login
      </button>
      <button id="tabRegister" class="tab-btn" onclick="switchTab('register')">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
          <circle cx="8.5" cy="7" r="4"></circle>
          <line x1="20" y1="8" x2="20" y2="14"></line>
          <line x1="23" y1="11" x2="17" y2="11"></line>
        </svg>
        Register
      </button>
    </div>

    <!-- Login Form -->
    <div id="loginForm" class="form-container active">
      <form method="POST" action="{{ url('/login') }}" class="auth-form">
        @csrf
        
        <div class="form-group">
          <label for="login-email">Email Address</label>
          <div class="input-wrapper">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
              <polyline points="22,6 12,13 2,6"></polyline>
            </svg>
            <input type="email" id="login-email" name="email" placeholder="Enter your email" required>
          </div>
        </div>

        <div class="form-group">
          <label for="login-password">Password</label>
          <div class="input-wrapper">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
              <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
            <input type="password" id="login-password" name="password" placeholder="Enter your password" required>
          </div>
        </div>

        <div class="form-options">
          <label class="remember-me">
            <input type="checkbox" name="remember">
            <span>Remember me</span>
          </label>
          <a href="{{ url('/forgotpassword') }}" class="forgot-link">Forgot password?</a>
        </div>

        <button type="submit" class="btn btn-primary">Sign In</button>
      </form>

      <div class="divider">
        <span>OR</span>
      </div>

      <a href="{{ route('google.login') }}" class="btn btn-google">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
          <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
          <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
          <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
          <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
        </svg>
        Continue with Google
      </a>

      <div class="switch-prompt">
        <p>Don't have an account? <a href="#" onclick="switchTab('register')">Create one now</a></p>
      </div>
    </div>

    <!-- Register Form -->
    <div id="registerForm" class="form-container">
      <form method="POST" action="{{ url('/register') }}" class="auth-form">
        @csrf
        
        <div class="form-group">
          <label for="register-name">Full Name</label>
          <div class="input-wrapper">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <input type="text" id="register-name" name="name" placeholder="Enter your full name" required>
          </div>
        </div>

        <div class="form-group">
          <label for="register-email">Email Address</label>
          <div class="input-wrapper">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
              <polyline points="22,6 12,13 2,6"></polyline>
            </svg>
            <input type="email" id="register-email" name="email" placeholder="Enter your email" required>
          </div>
        </div>

        <div class="form-group">
          <label for="register-password">Password</label>
          <div class="input-wrapper">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
              <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
            <input type="password" id="register-password" name="password" placeholder="Create a password" required>
          </div>
        </div>

        <div class="form-group">
          <label for="register-password-confirm">Confirm Password</label>
          <div class="input-wrapper">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
            <input type="password" id="register-password-confirm" name="password_confirmation" placeholder="Confirm your password" required>
          </div>
        </div>

        <button type="submit" class="btn btn-primary">Create Account</button>
      </form>

      <div class="switch-prompt">
        <p>Already have an account? <a href="#" onclick="switchTab('login')">Sign in here</a></p>
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
    if (heroText) heroText.classList.add('float-animate');
    if (heroImg) heroImg.classList.add('float-animate');
  }

  if (window.innerWidth > 768 && hero) {
    resetFloating();
    window.addEventListener('mousemove', (e) => {
      const x = (window.innerWidth / 2 - e.clientX) / 40;
      const y = (window.innerHeight / 2 - e.clientY) / 40;
      
      if (heroText) {
        heroText.style.transform = `translate(${x}px, ${y}px)`;
        heroText.classList.remove('float-animate');
      }
      
      if (heroImg) {
        heroImg.style.transform = `translate(${-x}px, ${-y}px) rotateY(${x}deg)`;
        heroImg.classList.remove('float-animate');
      }
      
      clearTimeout(floatTimeout);
      floatTimeout = setTimeout(resetFloating, 1500);
    });
  }

  // Modal functionality
  const modal = document.getElementById('authModal');
  const loginBtn = document.getElementById('loginBtn');
  const signupBtn = document.getElementById('signupBtn');
  const modalSubtitle = document.getElementById('modalSubtitle');

  // Tab elements
  const tabLogin = document.getElementById('tabLogin');
  const tabRegister = document.getElementById('tabRegister');
  const loginForm = document.getElementById('loginForm');
  const registerForm = document.getElementById('registerForm');

  // Open modal functions
  if (loginBtn) {
    loginBtn.onclick = () => { 
      modal.style.display = 'block'; 
      showLogin(); 
    }
  }

  if (signupBtn) {
    signupBtn.onclick = () => { 
      modal.style.display = 'block'; 
      showRegister(); 
    }
  }

  // Close modal function
  function closeModal() {
    if (modal) modal.style.display = 'none';
  }

  // Click outside to close
  window.onclick = (e) => { 
    if (e.target === modal) closeModal(); 
  }

  // Switch tab function
  function switchTab(tab) {
    if (tab === 'login') {
      showLogin();
    } else if (tab === 'register') {
      showRegister();
    }
  }

  // Show login form
  function showLogin() {
    if (loginForm) loginForm.classList.add('active');
    if (registerForm) registerForm.classList.remove('active');
    if (tabLogin) tabLogin.classList.add('active');
    if (tabRegister) tabRegister.classList.remove('active');
    if (modalSubtitle) modalSubtitle.textContent = 'Welcome back! Please login to your account';
  }

  // Show register form
  function showRegister() {
    if (registerForm) registerForm.classList.add('active');
    if (loginForm) loginForm.classList.remove('active');
    if (tabRegister) tabRegister.classList.add('active');
    if (tabLogin) tabLogin.classList.remove('active');
    if (modalSubtitle) modalSubtitle.textContent = 'Create your account and start shopping';
  }

  // Tab click handlers
  if (tabLogin) tabLogin.onclick = () => switchTab('login');
  if (tabRegister) tabRegister.onclick = () => switchTab('register');

  // Keyboard accessibility - Close modal on Escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && modal && modal.style.display === 'block') {
      closeModal();
    }
  });

  // Prevent body scroll when modal is open
  const observer = new MutationObserver(() => {
    if (modal && modal.style.display === 'block') {
      document.body.style.overflow = 'hidden';
    } else {
      document.body.style.overflow = '';
    }
  });

  if (modal) {
    observer.observe(modal, { 
      attributes: true, 
      attributeFilter: ['style'] 
    });
  }
</script>
</body>
</html>
