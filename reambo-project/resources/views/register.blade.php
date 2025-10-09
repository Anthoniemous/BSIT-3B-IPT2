<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">

</head>
<body>
    <div class="register-container">
        <h2>REGISTER NA GWAPO</h2>

        @if($errors->any())
            <div class="error-msg">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register.post') }}">
    @csrf
    <label for="name">Full Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <label for="password_confirmation">Confirm Password:</label>
    <input type="password" id="password_confirmation" name="password_confirmation" required>

    <button type="submit">Register</button>
</form>


        <p>Already have an account? <a href="{{ url('/login') }}">Login here</a></p>
    </div>
</body>
</html>
