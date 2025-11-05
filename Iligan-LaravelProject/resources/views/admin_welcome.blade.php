<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @vite(['resources/css/app.css'])
    </head>

    <body class="bg-[#242424] flex flex-col items-center justify-center min-h-screen text-white">

        <h1 class="text-4xl mb-10 font-bold">Administrator Authentication</h1>

        <div class="flex gap-6">
            <a
                href="{{ route('admin_login') }}"
                class="inline-block px-5 py-1.5 text-white border border-white hover:bg-[#cc5500] rounded-sm text-sm leading-normal"
            >
                Proceed to Login
            </a>
        </div>

    </body>
</html>


