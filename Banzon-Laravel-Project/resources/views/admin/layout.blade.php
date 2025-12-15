<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Admin Dashboard')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template CSS -->
    <link href="{{ asset('dashmin/css/style.css') }}" rel="stylesheet">
</head>

<body>
<div class="container-fluid position-relative bg-white d-flex p-0">

    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Sidebar Start -->
    <div class="sidebar pe-4 pb-3">
        <nav class="navbar bg-light navbar-light">
            <a href="{{ route('admin.dashboard') }}" class="navbar-brand mx-4 mb-3">
                <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>CALIBER</h3>
            </a>

            <div class="navbar-nav w-100">
                <a href="{{ route('admin.dashboard') }}"
                   class="nav-item nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa fa-tachometer-alt me-2"></i>Dashboard
                </a>

                <a href="{{ route('admin.products') }}"
                   class="nav-item nav-link {{ request()->routeIs('admin.products') ? 'active' : '' }}">
                    <i class="fa fa-table me-2"></i>Products
                </a>

                <a href="{{ route('admin.orders') }}"
                   class="nav-item nav-link {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                    <i class="fa fa-shopping-cart me-2"></i>Orders
                </a>
                <a href="{{ route('admin.activity_logs') }}"
                    class="nav-item nav-link {{ request()->routeIs('admin.activity_logs') ? 'active' : '' }}">
                        <i class="fa fa-history me-2"></i>Activity Logs
                    </a>
            </div>
        </nav>
    </div>
    <!-- Sidebar End -->


    <!-- Content Start -->
    <div class="content">

        <!-- Navbar Start (TEMPLATE DEFAULT) -->
        <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
            <a href="{{ route('admin.dashboard') }}" class="navbar-brand d-flex d-lg-none me-4">
                <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
            </a>

            <a href="#" class="sidebar-toggler flex-shrink-0">
                <i class="fa fa-bars"></i>
            </a>

            <form class="d-none d-md-flex ms-4">
                <input class="form-control border-0" type="search" placeholder="Search">
            </form>

            <div class="navbar-nav align-items-center ms-auto">
                <!-- Profile -->
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <span class="d-none d-lg-inline-flex">Admin</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                        <!-- Logout (POST) -->
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button class="dropdown-item" type="submit">Log Out</button>
                        </form>
                    </div>
                </div>

            </div>
        </nav>
        <!-- Navbar End -->

        <!-- Page Content -->
        @yield('content')

        <!-- Footer Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="bg-light rounded-top p-4 text-center">
                <small>&copy; {{ date('Y') }} Admin Panel</small>
            </div>
        </div>
        <!-- Footer End -->

    </div>
    <!-- Content End -->

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Template JS (safe minimal main.js is best) -->
<script src="{{ asset('dashmin/js/main.js') }}"></script>

@stack('scripts')
</body>
</html>
