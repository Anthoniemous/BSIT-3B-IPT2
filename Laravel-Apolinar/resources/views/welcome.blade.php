<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Glamour Makeup Store</title>
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<header>
  <div class="logo">Glamour</div>
  <nav>
    <ul>
      <li><a href="#">Home</a></li>
      <li><a href="#">Products</a></li>
      <li><a href="#">Offers</a></li>
      <li><a href="#">About</a></li>
    </ul>
  </nav>

 <div class="user-option">
  <button class="btn" onclick="window.location.href='{{ url('/login') }}'">Login</button>
  <button class="btn" onclick="window.location.href='{{ url('/register') }}'">Sign Up</button>
</div>
</header>



<section class="hero">
  <h1>Welcome to Glamour Makeup</h1>
  <p>Discover your beauty. Shine every day.</p>
   <div class="hero-media">
        <img id="hero-img" src="{{ asset('css/img/image copy.png') }}" alt="Product">
      </div>
</section>



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
