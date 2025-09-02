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

    <body class="font-sans antialiased bg-[#cc5500]">
        <div class="min-h-screen flex flex-col items-center justify-center space-y-6">
            
            <!-- Heading -->
            <h1 class="text-5xl font-extrabold text-white tracking-wide drop-shadow-lg" style="font-family:Permanent Marker, cursive;">
                SHOP ME, BABY
            </h1>

            <!-- Form Box -->
            <div class="w-full max-w-md px-6 py-8 shadow-md rounded-2xl bg-white dark:bg-[#fff] dark:text-[#000] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
                {{ $slot }}
            </div>

        </div>
    </body>

</html>
