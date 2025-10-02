<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ChurchHub') }}</title>


    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 min-h-screen flex flex-col">

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center px-4">
        <div class="w-full max-w-md bg-white shadow-md rounded-lg p-6 dark:bg-gray-800">



            <!-- 🔹 Page Content -->
            {{ $slot }}
        </div>
    </main>
</body>

</html>
