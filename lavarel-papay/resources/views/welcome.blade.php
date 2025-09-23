<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>VAPE SHOP</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
  <header class="site-header">
    <div class="container">
      <a href="#" class="brand">
        <img src="{{ asset('/css/img/logo.png') }}" alt="Vape Shop Logo" class="logo" />
        <span class="brand-name">VAPE SHOP</span>
      </a>

      <nav class="nav">
        <a href="#" class="nav-link">Home</a>
        <a href="#" class="nav-link">Products</a>
        <a href="#" class="nav-link">About</a>
        <a href="#" class="nav-link cta">Contact</a>
        <!-- login/signup buttons (trigger modal) -->
        <a href="#" class="nav-link auth" id="openLogin">Login</a>
        <a href="#" class="nav-link auth signup" id="openSignup">Sign Up</a>
      </nav>
    </div>
  </header>

  <main>
    <section class="hero">
      <div class="container hero-grid">
        <div class="hero-left">
          <h1>Premium Vapes & Flavors</h1>
          <p>Discover curated flavors, premium devices, and accessories — fast shipping and excellent support.</p>
          <div class="hero-actions">
            <a href="#" class="btn btn-primary">Shop Now</a>
            <a href="#" class="btn btn-outline">Explore Flavors</a>
          </div>
        </div>

        <div class="hero-right">
          <div class="product-card featured">
            <img src="{{ asset('/css/img/image.png') }}" alt="Featured Vape" />
            <div class="product-info">
              <h3>Cloud X Pro</h3>
              <p class="price">₱2,499</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="products container">
      <h2 class="section-title">Best Sellers</h2>
      <div class="grid">
        <article class="product-card">
          <img src="{{ asset('/css/img/flavor.png') }}" alt="">
          <h4>Flavor Mint</h4>
          <p class="price">₱299</p>
        </article>

        <article class="product-card">
          <img src="{{ asset('/css/img/berry.png') }}" alt="">
          <h4>Berry Blast</h4>
          <p class="price">₱349</p>
        </article>

        <article class="product-card">
          <img src="{{ asset('/css/img/pad.png') }}" alt="">
          <h4>Vanilla Pod</h4>
          <p class="price">₱399</p>
        </article>

        <article class="product-card">
          <img src="{{ asset('/css/img/salt.png') }}" alt="">
          <h4>Salt Nic Ice</h4>
          <p class="price">₱289</p>
        </article>
      </div>
    </section>
  </main>

  <footer class="site-footer">
    <div class="container footer-grid">
      <div>
        <h3>VAPE SHOP</h3>
        <p>Quality vapes &amp; accessories — made for cloud chasers.</p>
      </div>

      <div>
        <h4>Contact</h4>
        <p>Email: jhunabordo882@gmail.com</p>
        <p>Phone: +63 9070608233</p>
      </div>

      <div>
        <h4>Follow</h4>
        <p>@vapeshop_ph</p>
      </div>
    </div>
    <div class="copyright">© {{ date('Y') }} VAPE SHOP. All rights reserved.</div>
  </footer>

  <!-- 🔹 LOGIN MODAL -->
  <div id="loginModal" class="modal">
  <div class="modal-content">
    <span class="close" id="closeLogin">&times;</span>
    <h2>Login</h2>
    <form action="{{ url('/dashboard') }}" method="GET">
      <label>Email</label>
      <input type="email" name="email" required>
      
      <label>Password</label>
      <input type="password" name="password" required>

      <button type="submit" class="btn btn-primary">Login</button>
    </form>

    <!-- Divider -->
    <div class="divider">
      <span>or</span>
    </div>

    <!-- 🔹 GOOGLE LOGIN BUTTON -->
    <a href="{{ url('/auth/google') }}" class="btn-google">
      <img src="{{ asset('/css/img/google.png') }}" alt="Google Icon" />
      Login with Google
    </a>
  </div>
</div>

  <!-- 🔹 SIGNUP MODAL -->
  <div id="signupModal" class="modal">
    <div class="modal-content">
      <span class="close" id="closeSignup">&times;</span>
      <h2>Sign Up</h2>
      <form action="{{ url('/dashboard') }}" method="GET">
        <label>Name</label>
        <input type="text" name="name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit" class="btn btn-primary">Sign Up</button>
      </form>
    </div>
  </div>

  <!-- 🔹 SIMPLE JS FOR MODALS -->
  <script>
    const loginModal = document.getElementById("loginModal");
    const signupModal = document.getElementById("signupModal");
    const openLogin = document.getElementById("openLogin");
    const openSignup = document.getElementById("openSignup");
    const closeLogin = document.getElementById("closeLogin");
    const closeSignup = document.getElementById("closeSignup");

    openLogin.onclick = () => loginModal.style.display = "block";
    openSignup.onclick = () => signupModal.style.display = "block";

    closeLogin.onclick = () => loginModal.style.display = "none";
    closeSignup.onclick = () => signupModal.style.display = "none";

    window.onclick = (event) => {
      if (event.target == loginModal) loginModal.style.display = "none";
      if (event.target == signupModal) signupModal.style.display = "none";
    }
  </script>
</body>
</html>
