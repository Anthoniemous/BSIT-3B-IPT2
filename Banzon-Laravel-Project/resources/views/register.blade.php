<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Register</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>
    <div class="container">
        <h2>REGISTER AS CUSTOMER</h2>

        @if(session('success'))
            <div class="success-msg">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="error-msg">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ url('/register') }}">
            @csrf

            <label for="name">Full Name:</label>
            <input type="text" name="name" id="name" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <label for="password_confirmation">Confirm Password:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>

            <button type="submit">Register</button>

            <p>Already have an account? <a href="{{ url('/login') }}">Login here</a></p>
        </form>
    </div>
</body>
</html>
