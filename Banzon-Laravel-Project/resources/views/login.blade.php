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
    <div class="container">
        <h2>WELCOME<h2>

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
            
            <button type="submit">Login</button>
        </form>

        <p>Don't have an account? <a href="{{ url('/register')  }}">Register here</a></p>
        <p>Forgot your password? <a href="{{ url('/forgotpassword') }}">Click here</a></p>
    </div>
</body>
</html>
