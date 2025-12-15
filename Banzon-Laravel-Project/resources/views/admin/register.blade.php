<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Register</title>

    <!-- Uses the same enhanced CSS -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

    <!-- overlay for readability -->
    <div class="bg-overlay"></div>

    <div class="auth-wrap">
        <div class="container">

            <div class="brand">
                <h2>ADMIN REGISTER</h2>
                <p class="sub">Create a new admin account</p>
            </div>

            @if(session('success'))
                <div class="alert success-msg">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert error-msg">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('admin.register.post') }}">
                @csrf

                <div class="field">
                    <label>Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" placeholder="Admin username" required>
                </div>

                <div class="field">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@example.com" required>
                </div>

                <div class="field">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>

                <div class="field">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" placeholder="••••••••" required>
                </div>

                <button type="submit">Create Admin</button>
            </form>

            <div class="links">
                <p>Already have an admin account?
                    <a href="{{ route('admin.login') }}">Login here</a>
                </p>
            </div>

        </div>
    </div>

</body>
</html>
