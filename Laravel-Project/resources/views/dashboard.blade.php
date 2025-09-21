<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Feane FoodStore</title>
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

  <header>
    <div class="logo">Feane</div>
    <nav>
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">Menu</a></li>
        <li><a href="#">Orders</a></li>
        <li><a href="#">About</a></li>
      </ul>
    </nav>

    <div class="user-option">
      <!-- Profile icon -->
      <a href="#" class="user_link">
        <i class="fa fa-user" aria-hidden="true"></i>
      </a>

      <!-- Cart icon -->
      <a href="#" class="cart_link">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
          <path d="M0 1.5A.5.5 0 0 1 .5 1h1a.5.5 0 0 1 .485.379L2.89 5H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 14H4a.5.5 0 0 1-.491-.408L1.01 2H.5a.5.5 0 0 1-.5-.5zM4.415 6l.5 2.5h7.17l.5-2.5H4.415z"/>
        </svg>
      </a>

     
      

      <!-- Profile text -->
      <a href="#">Profile</a>

      <!-- Proper Laravel logout -->
      <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="logout-btn">
              {{ __('Logout') }}
          </button>
      </form>
    </div>
  </header>

  <section class="hero">
    <h1>Welcome to Feane Dashboard</h1>
  </section>

  <div class="content">
    <h2>Store Overview</h2>
    <p>
      This is a simple dashboard layout converted from the Feane template.
      You can use this in your <code>dashboard.blade.php</code> file.
      All styles are in <code>public/css/dashboard.css</code>.
    </p>
    <a href="#" class="btn">Explore</a>
  </div>

</body>
</html>
