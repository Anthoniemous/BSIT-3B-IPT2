<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Optional: Tailwind CSS or other styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="font-sans antialiased text-gray-900">
    <div class="min-h-screen flex flex-col items-center justify-center">
        {{ $slot }}
    </div>
</body>
</html>
