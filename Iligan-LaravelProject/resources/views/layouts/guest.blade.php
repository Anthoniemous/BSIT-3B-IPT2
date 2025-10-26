<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans antialiased min-h-screen flex items-stretch text-black" style="background-image: url('/images/landing_background.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <!-- Left Panel (Form Section) -->
        <div class="w-1/2 bg-[#242424] flex items-center justify-center shadow-2xl">
            <div class="w-full max-w-lg px-12 py-16">
                {{ $slot }}
            </div>
        </div>

        <!-- Right Side (empty, just shows background image) -->
        <div class="w-1/2"></div>
    </body>

</html>
