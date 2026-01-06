<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ChurchHub</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-900 text-white">

    <!-- ✅ Navbar -->
    <header class="absolute inset-x-0 top-0 z-50">
        <nav class="flex items-center justify-between p-6 lg:px-8">
            <div class="flex lg:flex-1 items-center">
                <a href="{{ url('/') }}" class="-m-1.5 p-1.5 flex items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" alt="ChurchHub"
                        class="h-8 w-8 rounded-full border border-white/20">
                    <span class="text-lg font-semibold text-white">ChurchHub</span>
                </a>
            </div>

            <div class="flex lg:hidden">
                <button type="button" id="menu-toggle"
                    class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-200">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-6 h-6">
                        <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </button>
            </div>

            <div class="hidden lg:flex lg:gap-x-12">
                <a href="#" class="text-sm font-semibold text-white hover:text-indigo-300">About</a>
                <a href="#" class="text-sm font-semibold text-white hover:text-indigo-300">Features</a>
                <a href="#" class="text-sm font-semibold text-white hover:text-indigo-300">Events</a>
                <a href="#" class="text-sm font-semibold text-white hover:text-indigo-300">Contact</a>
            </div>

            <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                @auth
                    @if (Auth::user()->role->name === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                            class="text-sm font-semibold text-white hover:text-indigo-400">
                            Admin Dashboard →
                        </a>
                    @elseif (Auth::user()->role->name === 'secretary')
                        <a href="{{ route('secretary.dashboard') }}"
                            class="text-sm font-semibold text-white hover:text-indigo-400">
                            Secretary Dashboard →
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-white hover:text-indigo-400">
                        Log in →
                    </a>
                @endauth
            </div>
        </nav>
    </header>

    <!-- ✅ Hero Section -->
    <main class="relative isolate px-6 pt-14 lg:px-8">
        <div aria-hidden="true"
            class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
            <div style="clip-path: polygon(74.1% 44.1%,100% 61.6%,97.5% 26.9%,85.5% 0.1%,80.7% 2%,72.5% 32.5%,60.2% 62.4%,52.4% 68.1%,47.5% 58.3%,45.2% 34.5%,27.5% 76.7%,0.1% 64.9%,17.9% 100%,27.6% 76.8%,76.1% 97.7%,74.1% 44.1%)"
                class="relative left-[calc(50%-11rem)] w-[36rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-indigo-500 to-pink-500 opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72rem]">
            </div>
        </div>

        <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56 text-center">
            <h1 class="text-5xl font-bold tracking-tight text-balance text-white sm:text-7xl">
                Empowering Churches Through Technology
            </h1>
            <p class="mt-8 text-lg font-medium text-gray-400 sm:text-xl">
                Manage members, pastors, and events seamlessly. A unified platform for modern church operations.
            </p>
            <div class="mt-10 flex items-center justify-center gap-x-6">
                <a href="{{ route('login') }}"
                    class="rounded-md bg-indigo-500 px-5 py-3 text-sm font-semibold text-white shadow hover:bg-indigo-400 transition">
                    Get Started
                </a>
                <a href="#features" class="text-sm font-semibold text-white hover:text-indigo-300">
                    Learn more →
                </a>
            </div>
        </div>

        <div aria-hidden="true"
            class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]">
            <div style="clip-path: polygon(74.1% 44.1%,100% 61.6%,97.5% 26.9%,85.5% 0.1%,80.7% 2%,72.5% 32.5%,60.2% 62.4%,52.4% 68.1%,47.5% 58.3%,45.2% 34.5%,27.5% 76.7%,0.1% 64.9%,17.9% 100%,27.6% 76.8%,76.1% 97.7%,74.1% 44.1%)"
                class="relative left-[calc(50%+3rem)] w-[36rem] -translate-x-1/2 bg-gradient-to-tr from-pink-500 to-indigo-500 opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72rem]">
            </div>
        </div>
    </main>

    <!-- ✅ Features Section -->
    <section id="features" class="py-20 bg-gray-950">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-12 text-white">✨ Core Features</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="p-6 bg-gray-800 rounded-xl shadow hover:shadow-lg transition">
                    <h4 class="text-xl font-semibold text-indigo-400 mb-3">👥 Member Management</h4>
                    <p class="text-gray-400">Easily register and track members with full profile control.</p>
                </div>
                <div class="p-6 bg-gray-800 rounded-xl shadow hover:shadow-lg transition">
                    <h4 class="text-xl font-semibold text-indigo-400 mb-3">📅 Event Scheduling</h4>
                    <p class="text-gray-400">Plan events, manage attendance, and keep the congregation connected.</p>
                </div>
                <div class="p-6 bg-gray-800 rounded-xl shadow hover:shadow-lg transition">
                    <h4 class="text-xl font-semibold text-indigo-400 mb-3">📊 Reports & Insights</h4>
                    <p class="text-gray-400">Gain valuable insights with data-driven reports and summaries.</p>
                </div>
            </div>
        </div>
    </section>

</body>

</html>
