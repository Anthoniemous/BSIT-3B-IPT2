<nav class="navbar navbar-expand-lg navbar-light fixed-top py-3 d-block" data-navbar-on-scroll="data-navbar-on-scroll">
    <div class="container">
        <a class="navbar-brand d-inline-flex" href="{{ url('/') }}">
            <span class="text-light fs-2 fw-bold ms-2">LAPAY</span>
        </a>
        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse border-top border-lg-0 mt-4 mt-lg-0" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item px-2">
                    <a class="nav-link fw-bold active" aria-current="page" href="#dashboard">DASHBOARD</a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link fw-bold" href="#customers">CUSTOMERS</a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link fw-bold" href="#reports">REPORTS</a>
                </li>
            </ul>
            <form class="d-flex">
                <a class="text-primary" href="#!">
                    <svg class="feather feather-phone-call" xmlns="http://www.w3.org/2000/svg" 
                         width="24" height="24" viewBox="0 0 24 24" fill="none" 
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15.05 5A5 5 0 0 1 19 8.95M15.05 1A9 9 0 0 1 23 8.94m-1 7.98v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                </a>
                <div class="ms-4 text-light fw-bold">Admin Panel</div>
            </form>
        </div>
    </div>
</nav>