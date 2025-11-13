<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <!-- Link sa separate CSS -->
    <link rel="stylesheet" href="{{ asset('css/forgotpassword.css') }}">
</head>
<body>
    <div class="login-container">
        <h2>FORGOT PASSWORD</h2>

        <!-- Success message -->
        @if(session('success'))
            <div class="success-msg">{{ session('success') }}</div>
        @endif

        <!-- Error messages -->
        @if($errors->any())
            <div class="error-msg">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Forgot password form -->
        <form method="POST" action="{{ url('/forgotpassword') }}">
            @csrf
            <label>Email:</label>
            <input type="email" name="email" placeholder="Enter your email" required>
            <button type="submit">Send Reset Link</button>
        </form>

        <!-- Link back to login using named route -->
        <p>Remembered your password? <a href="{{ route('login') }}">Login here</a></p>
    </div>
</body>
</html>
