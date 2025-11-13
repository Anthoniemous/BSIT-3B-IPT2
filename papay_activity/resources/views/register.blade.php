<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Cloud Haven Vape Shop</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>

    <div class="flex-center">
        <div class="register-container">
            <h2>REGISTER NOW 💨</h2>

            @if($errors->any())
                <div class="error-msg">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ url('/register') }}">
                @csrf
                <label>Name:</label>
                <input type="text" name="name" placeholder="Enter your name" required>

                <label>Email:</label>
                <input type="email" name="email" placeholder="Enter your email" required>

                <label>Password:</label>
                <input type="password" name="password" placeholder="Enter your password" required>

                <label>Confirm Password:</label>
                <input type="password" name="password_confirmation" placeholder="Confirm your password" required>

                <button type="submit">Register</button>
            </form>

            <p class="login-link">Already have an account? <a href="{{ url('/login') }}">Login here</a></p>
        </div>
    </div>

</body>
</html>
