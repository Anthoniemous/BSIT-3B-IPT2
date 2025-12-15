<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Register</title>

    {{-- Use the SAME CSS as login for consistent design --}}
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

    <div class="bg-overlay"></div>

    <div class="auth-wrap">
        <div class="container">

            <div class="brand">
                <h2>REGISTER AS CUSTOMER</h2>
                <p class="sub">Create your account to start shopping</p>
            </div>

            @if(session('success'))
                <div class="alert success-msg">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="alert error-msg">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ url('/register') }}">
                @csrf

                <div class="field">
                    <label for="name">Full Name</label>
                    <input type="text" name="name" id="name" placeholder="Your full name" required>
                </div>

                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="you@example.com" required>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="••••••••" required>
                </div>

                <div class="field">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••" required>
                </div>

                <button type="submit">Register</button>
            </form>

            <div class="links">
                <p>Already have an account? <a href="{{ url('/login') }}">Login here</a></p>
            </div>

        </div>
    </div>

</body>
</html>
