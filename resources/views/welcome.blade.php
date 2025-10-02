<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ChurchHub</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 min-h-screen flex flex-col">

    <!-- Navbar -->
    <header class="w-full py-4 shadow-sm bg-white/80 dark:bg-gray-800/80 backdrop-blur-md fixed top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-blue-600">ChurchHub</h1>
            @if (Route::has('login'))
                <nav class="flex items-center gap-4">
                    @auth
                        @if (Auth::user()->role->name === 'admin')
                            <a href="{{ route('admin.dashboard') }}"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                Admin Dashboard
                            </a>
                        @elseif (Auth::user()->role->name === 'secretary')
                            <a href="{{ route('secretary.dashboard') }}"
                                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                                Secretary Dashboard
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 border border-blue-600 text-blue-600 rounded hover:bg-blue-50 dark:hover:bg-gray-700 transition">
                            Log in
                        </a>
                    @endauth
                </nav>
            @endif
        </div>
    </header>

    <!-- Hero Section -->
    <main class="flex-grow flex items-center justify-center relative">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="{{ asset('images/bg-image.jpg') }}" alt="Church background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-50"></div> <!-- dark overlay for readability -->
        </div>

        <!-- Hero Content -->
        <div class="relative text-center max-w-2xl px-4 z-10">
            <h2 class="text-4xl font-bold text-white mb-4">Hello ChurchHub!</h2>
            <p class="text-lg text-gray-200 mb-6">
                Welcome to the central hub for managing church activities, members, events, and more —
                all in one place.
            </p>
            @guest
                <a href="{{ route('login') }}"
                    class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                    Get Started
                </a>
            @endguest
        </div>
    </main>


    <!-- Features Section -->
    <section class="py-16 bg-white dark:bg-gray-900">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h3 class="text-3xl font-bold text-gray-800 dark:text-white mb-12">✨ Features</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="p-6 bg-gray-100 dark:bg-gray-800 rounded-xl shadow hover:shadow-lg transition">
                    <h4 class="text-xl font-semibold text-blue-600 mb-3">👥 Member Management</h4>
                    <p class="text-gray-600 dark:text-gray-300">Easily register, view, and manage church members with
                        detailed profiles.</p>
                </div>
                <div class="p-6 bg-gray-100 dark:bg-gray-800 rounded-xl shadow hover:shadow-lg transition">
                    <h4 class="text-xl font-semibold text-blue-600 mb-3">📅 Event Scheduling</h4>
                    <p class="text-gray-600 dark:text-gray-300">Plan and organize church events, track attendance, and
                        manage schedules.</p>
                </div>
                <div class="p-6 bg-gray-100 dark:bg-gray-800 rounded-xl shadow hover:shadow-lg transition">
                    <h4 class="text-xl font-semibold text-blue-600 mb-3">📊 Reports & Insights</h4>
                    <p class="text-gray-600 dark:text-gray-300">Generate insights to help church leaders make
                        data-driven decisions.</p>
                </div>
            </div>
        </div>
    </section>



</body>

</html>
