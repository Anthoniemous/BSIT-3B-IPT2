<!DOCTYPE html>
<html lang="en-US" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'LAPAY Dashboard'))</title>

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicons/favicon-32x32.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicons/favicon.ico') }}">
    
    <!-- Stylesheets -->
    <link href="{{ asset('assets/css/theme.css') }}" rel="stylesheet" />
    @stack('styles')
</head>

<body>
    <main class="main" id="top">
        @include('partials.navbar')
        
        @yield('content')
        
        @include('partials.footer')
    </main>

    <!-- JavaScripts -->
    <script src="{{ asset('vendors/@popperjs/popper.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/is/is.min.js') }}"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="{{ asset('vendors/feather-icons/feather.min.js') }}"></script>
    <script>
        feather.replace();
    </script>
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;700&display=swap" rel="stylesheet">
    
    @stack('scripts')
</body>
</html>