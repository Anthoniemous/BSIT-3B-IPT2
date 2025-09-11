<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

    <div class="card p-4 shadow" style="width: 400px;">
        <h2 class="text-center mb-4">Login</h2>


    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif



   @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <p class="mt-3 text-center">
            Don’t have an account? <a href="{{ route('register') }}">Register</a>
        </p>

           <div class="mt-3 text-center">
           <p>or</p>
            </div>

            <div class="mt-3 text-center">
            <a href="{{ route('google-auth') }}"
             class="btn btn-danger w-50">
                <i class="fab fa-google"></i> Google
            </a>
            </div>

    </div>

     
</body>
</html>
