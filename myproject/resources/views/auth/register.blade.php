<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

    <div class="card p-4 shadow" style="width: 400px;">
        <h2 class="text-center mb-4">Register</h2>

     <form action="{{ route('register.post') }}" method="POST">
    @csrf

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-3">
        <input type="text" name="name" class="form-control" placeholder="Full Name" value="{{ old('name') }}" required>
    </div>
    <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
    </div>
    <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
    </div>
    <div class="mb-3">
        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
    </div>
    <button type="submit" class="btn btn-success w-100">Register</button>
</form>

        <p class="mt-3 text-center">
            Already have an account? <a href="{{ route('login') }}">Login</a>
        </p>
    </div>

</body>
</html>
