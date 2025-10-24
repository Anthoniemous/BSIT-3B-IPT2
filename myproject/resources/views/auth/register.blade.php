<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coffee ' Sodoso | Register</title>

  <!-- External CSS -->
  <link rel="stylesheet" href="{{ asset('css/register.css') }}">
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
           <a href="{{ route('login') }}" class="btn btn-register1 ">Login</a>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero">
    <div class="overlay"></div>
    <div class="register-box">
      <h2><i class="fas fa-user-plus"></i> Create Account</h2>

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

        <input type="text" name="name" class="form-control" placeholder="Full Name" value="{{ old('name') }}" required>
        <input type="email" name="email" class="form-control" placeholder="Email Address" value="{{ old('email') }}" required>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>

        <button type="submit" class="btn btn-login">Register</button>
      </form>

      <p  style="text-align: center; margin-top: 1rem;   text-decoration: none;">
    Already have an account? <a href="{{ route('login') }}" style=" text-decoration: none;">Login</a>
</p>

      <hr class="bg-light">

      <div class="text-center">
        <a href="{{ url('auth/google') }}" class="btn btn-google-login">
          <i class="fab fa-google"></i> Continue with Google
        </a>
      </div>
    </div>
  </section>

</body>
</html>
