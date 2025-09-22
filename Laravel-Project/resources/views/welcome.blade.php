<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Feane FoodStore</title>
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>

  <header>
    <div class="logo">Feane</div>
     <section class="hero text-center">
    <h1>Welcome to Feane FoodStore</h1>
    <p>Discover the best food collections made fresh for you!</p>
    <a href="#menu" class="btn btn-primary">Explore Menu</a>
  </section>
    <div class="user-option">
      @guest
        <!-- If user is NOT logged in -->
        <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
        <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Sign Up</a>
      @else
        <!-- If user IS logged in -->
        <a href="{{ route('dashboard') }}">
          <i class="fa fa-user" aria-hidden="true"></i> {{ Auth::user()->name }}
        </a>

        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
          @csrf
          <button type="submit" class="logout-btn">Logout</button>
        </form>
      @endguest
    </div>
    
  </header>


  <div id="menu" class="content">
  <h2>Our Menu</h2>
  <div class="menu-grid">
    <div class="menu-item">
      <img src="{{ asset('/css/img/image0.png') }}" alt="Burger">
      <h3>Cheesy Burger</h3>
      <p>Juicy beef patty with melted cheese and fresh veggies.</p>
      <span class="price">₱120</span>
    </div>
    <div class="menu-item">
      <img src="{{ asset('/css/img/image1.png') }}" alt="Pizza">
      <h3>Italian Pizza</h3>
      <p>Thin crust pizza topped with mozzarella & pepperoni.</p>
      <span class="price">₱350</span>
    </div>
    <div class="menu-item">
      <img src="{{ asset('/css/img/image2.png') }}" alt="Fries">
      <h3>Crispy Fries</h3>
      <p>Golden crispy fries served with ketchup & mayo.</p>
      <span class="price">₱80</span>
    </div>
    <div class="menu-item">
      <img src="{{ asset('/css/img/image.png') }}" alt="Hotdog">
      <h3>Grilled Hotdog</h3>
      <p>Smoky grilled hotdog served with mustard & relish.</p>
      <span class="price">₱100</span>
    </div>
  </div>
</div>

  <!-- LOGIN MODAL -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content p-3">
        <div class="modal-header">
          <h5 class="modal-title">Log In</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif

          @if($errors->any())
            <div class="alert alert-danger">
              @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
              @endforeach
            </div>
          @endif

          <form method="POST" action="{{ url('/login') }}">
            @csrf
            <div class="mb-3">
              <label>Email:</label>
              <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
              <label>Password:</label>
              <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
          </form>

          <a href="{{ route('google.login') }}" class="btn btn-danger w-100 mt-2">Login with Google</a>

          <div class="mt-3 text-center">
            <p>Forgot your password? <a href="{{ url('/forgotpassword') }}">Click here</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- REGISTER MODAL -->
  <div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content p-3">
        <div class="modal-header">
          <h5 class="modal-title">REGISTER NA GWAPO</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          @if($errors->any())
            <div class="alert alert-danger">
              @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
              @endforeach
            </div>
          @endif

          <form method="POST" action="{{ url('/register') }}">
            @csrf
            <div class="mb-3">
              <label>Name:</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Email:</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Password:</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Confirm Password:</label>
              <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Register</button>
          </form>

          <div class="mt-3 text-center">
            <p>Already have an account? <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login here</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
