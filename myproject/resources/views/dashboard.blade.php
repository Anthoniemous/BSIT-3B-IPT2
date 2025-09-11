<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar {
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .dashboard-container {
            margin-top: 80px;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .welcome {
            font-size: 1.8rem;
            font-weight: 600;
            color: #343a40;
        }

        .email-text {
            color: #6c757d;
            font-size: 1rem;
        }

        .btn-logout {
            background: #dc3545;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: bold;
            color: #fff;
            transition: 0.3s;
        }

        .btn-logout:hover {
            background: #c82333;
            transform: scale(1.03);
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="#">MyApp</a>
            <div class="ms-auto">
                <span class="me-3 fw-semibold">{{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-logout btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Dashboard -->
    <div class="container dashboard-container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card text-center p-5">
                    <h2 class="welcome">Welcome, {{ Auth::user()->name }} 🎉</h2>
                    <p class="email-text">You are logged in with email:</p>
                    <p class="fw-bold">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
