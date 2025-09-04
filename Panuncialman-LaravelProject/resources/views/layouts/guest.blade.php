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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen flex items-center justify-center bg-cover bg-center" 
      style="background-image: url('{{ asset('img/background.jpg') }}');">
        <div class="formContainer min-h-screen flex flex-col sm:justify-center gap-5 items-center pt-6 sm:pt-0">
            <div>
                <a href="/" class="shop-logo">
                    <img src="{{ asset('img/boombot.png') }}" alt="Logo">
                </a>
            </div>

            <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
