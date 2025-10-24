<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glamour Makeup Store</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="login-container">
        <h2>Log In</h2>

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
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <button type="submit">Login</button>
        </form>

        <a href="{{ route('google.login') }}" class="google-btn">Login with Google</a>

        <div class="links">
            <p>Don't have an account? <a href="{{ url('/register') }}">Register here</a></p>
            <p>Forgot your password? <a href="{{ url('/forgotpassword') }}">Click here</a></p>
        </div>
    </div>
</body>
</html>
