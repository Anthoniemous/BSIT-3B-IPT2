<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Dashboard</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* Your existing CSS styles remain unchanged */
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Coffee Sodoso</a> <!-- Updated route -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li> <!-- Updated route -->
                    <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>

                    <!-- Profile Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown">
                            Profile
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li class="px-3 py-2">
                                <p class="mb-1 fw-semibold">{{ session('admin_name') ?? Auth::user()->name }}</p> <!-- Works for hardcoded admin -->
                                <p class="mb-1 fw-bold">{{ Auth::user()->email ?? 'admin@example.com' }}</p> <!-- Fallback email -->
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-logout btn-sm w-100 mt-2">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item ms-3">
                        <button id="darkModeToggle" class="btn btn-nav btn-sm">Dark Mode</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Dashboard -->
    <div class="container dashboard-container">
        <div class="row justify-content-end">
            <div class="col-md-5">
                <div class="card text-center">
                    <h2 class="welcome">
                        Welcome, {{ session('admin_name') ?? Auth::user()->name }} ☕ <!-- Works for hardcoded admin -->
                    </h2>
                    <a href="#" class="btn btn-nav mt-3">Order Coffee</a>
                    <a href="#" class="btn btn-nav mt-3">View Menu</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const toggle = document.getElementById('darkModeToggle');
        toggle.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
        });
    </script>

</body>
</html>
