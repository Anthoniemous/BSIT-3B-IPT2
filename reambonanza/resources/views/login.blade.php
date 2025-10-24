<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Glow Shampoo Shop</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="login-container">
        <h2>LOGIN</h2>

        @if(session('error'))
            <div class="error-msg">{{ session('error') }}</div>
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

        <a href="{{ url('/auth/google') }}" class="google-btn">Continue with Google</a>

        <p>Don't have an account? <a href="{{ url('/register') }}">Register here</a></p>
    </div>
</body>
</html>
