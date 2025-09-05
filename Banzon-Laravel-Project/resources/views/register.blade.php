<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">

</head>
<body>
    <div class="container">
        <h2>REGISTER</h2>

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
            <input type="text" name="name" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <label>Confirm Password:</label>
            <input type="password" name="password_confirmation" required>

            <button type="submit">Register</button>
            
            <p>Already have an account? <a href="{{ url('/login') }}">Login here</a></p>
        </form>
    </div>
</body>
</html>
