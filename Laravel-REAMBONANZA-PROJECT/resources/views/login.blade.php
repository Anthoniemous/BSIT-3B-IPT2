<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Link sa separate CSS -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">


</head>
<body>
    <div class="login-container">
        <h2>LOGIN</h2>

        @if(session('success'))
            <div class="success-msg">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="error-msg">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}">
            @csrf
            <label>Email:</label>
            <input type="email" name="email" required>
            
            <label>Password:</label>
            <input type="password" name="password" required>
            php artisan serve

            <button type="submit">Login</button>
            
        </form>

        <!-- Continue with Google Button -->
<div style="text-align: center; margin: 20px 0;">
    <a href="{{ route('google-auth') }}" class="google-btn">
        <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" 
             alt="Google Logo" 
             style="width:20px; vertical-align:middle; margin-right:8px;">
        Continue with Google
    </a>
</div>

<style>
    .google-btn {
        display: inline-block;
        padding: 10px 20px;
        border: 1px solid #ddd;
        border-radius: 4px;
        text-decoration: none;
        color: #444;
        font-weight: bold;
        background: #fff;
        transition: 0.3s;
    }   
    .google-btn:hover {
        background: #f5f5f5;
    }
</style>


     <p style="text-align: center;">
    Don't have an account? <a href="{{ url('/register') }}">Register here</a>
</p>
    </div>
</body>
</html>
