<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Dashboard</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --light-brown: #d9b08c;
            --medium-brown: #a37b60;
            --dark-brown: #6f4e37;
            --cream: #f2e9e4;
        }

        body {
            background: url('https://images.unsplash.com/photo-1511920170033-f8396924c348?auto=format&fit=crop&w=1470&q=80') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', sans-serif;
            transition: background 0.5s, color 0.5s;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(242, 233, 228, 0.6);
            z-index: -1;
            transition: background-color 0.5s;
        }

        /* Navbar Styles */
        .navbar {
            background-color: rgba(111, 78, 55, 0.95);
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            padding: 15px 30px;
            transition: background-color 0.5s;
        }

        .navbar-brand {
            color: #fff !important;
            font-weight: bold;
            font-size: 1.6rem;
            letter-spacing: 1px;
        }

        .nav-link {
            color: #fff !important;
            font-weight: 500;
            font-size: 1.1rem;
            margin-right: 15px;
            transition: color 0.3s;
        }

        .nav-link:hover {
            color: #ffd699 !important;
        }

        .dropdown-menu {
            background-color: rgba(242, 233, 228, 0.95);
            border-radius: 10px;
            min-width: 220px;
        }

        .dropdown-menu li p {
            margin: 0;
            font-size: 0.95rem;
            color: #6f4e37;
        }

        body.dark-mode .dropdown-menu {
            background-color: rgba(62, 47, 37, 0.95);
        }

        body.dark-mode .dropdown-menu li p {
            color: #ffd699;
        }

        .dashboard-container { margin-top: 120px; }

        /* Welcome Card */
        .card {
            border-radius: 25px;
            background-color: rgba(255, 247, 240, 0.6);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
            padding: 50px 30px;
            max-width: 450px;
            margin-left: auto;
            transition: all 0.4s ease;
        }

        .card:hover {
            box-shadow: 0 12px 30px rgba(0,0,0,0.3);
            transform: translateY(-5px);
        }

        .welcome { 
            font-size: 2rem; 
            font-weight: 600; 
            color: var(--dark-brown); 
        }

      

        /* Buttons */
        .btn-logout, .btn-nav {
            border-radius: 12px;
            padding: 10px 25px;
            font-weight: bold;
            color: #fff;
            transition: all 0.3s ease;
        }

        .btn-logout {
            background-color: #d9534f;
            box-shadow: 0 0 10px rgba(217, 83, 79, 0.5);
        }

        .btn-logout:hover {
            background-color: #c9302c;
            box-shadow: 0 0 15px rgba(217, 83, 79, 0.7);
            transform: scale(1.05);
        }

        .btn-nav {
            background-color: var(--medium-brown);
            margin-right: 10px;
            box-shadow: 0 0 10px rgba(163, 123, 96, 0.4);
        }

        .btn-nav:hover {
            background-color: var(--dark-brown);
            box-shadow: 0 0 15px rgba(111, 78, 55, 0.6);
        }

        /* Dark mode */
        body.dark-mode { background-color: #3e2f25; }
        body.dark-mode::before { background-color: rgba(62, 47, 37, 0.7); }
        body.dark-mode .card { background-color: rgba(62, 47, 37, 0.85); }
        body.dark-mode .welcome { color: #ffd699; }
        body.dark-mode .welcome span.email { color: #e0c7a1; }
        body.dark-mode .btn-nav { background-color: #a37b60; }
        body.dark-mode .btn-nav:hover { background-color: #6f4e37; }
        body.dark-mode .btn-logout { background-color: #b02a37; }

    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Coffee ' Sodoso</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>

                    <!-- Profile Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown">
                            Profile
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li class="px-3 py-2">
                                <p class="mb-1 fw-semibold">{{ Auth::user()->name }}</p>
                                <p class="mb-1 fw-bold">{{ Auth::user()->email }}</p>
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
                        Welcome, {{ Auth::user()->name }} ☕
                      
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
