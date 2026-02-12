<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-900">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title>ChurchHub - Secretary</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
</head>

<body class="h-full flex bg-gray-900 text-gray-100" x-data="{ sidebarOpen: false }">

    <!-- Mobile backdrop -->
    <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false"
        class="fixed inset-0 bg-black/50 z-40 lg:hidden"></div>

    <!-- Sidebar -->
    <aside
        class="fixed inset-y-0 left-0 w-64 bg-gray-800 border-r border-gray-700 shadow-lg z-50 transform
               transition-transform duration-300 ease-in-out lg:translate-x-0"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

        <div class="flex flex-col justify-between h-full p-5">
            <div>
                <!-- Logo -->
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="ChurchHub Logo" class="h-10 w-10 rounded-full" />
                        <h1 class="ml-3 text-xl font-bold text-white">ChurchHub</h1>
                    </div>
                    <button class="text-gray-400 lg:hidden" @click="sidebarOpen = false">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Navigation -->
                <nav class="space-y-1">
                    <a href="{{ route('secretary.dashboard') }}"
                        class="flex items-center px-3 py-2 rounded-md transition
                              {{ request()->routeIs('secretary.dashboard') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700 text-gray-300' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M3 12l2-2m0 0l7-7 7 7M13 5v14" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('secretary.members.index') }}"
                        class="flex items-center px-3 py-2 rounded-md transition
                              {{ request()->routeIs('secretary.members.*') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700 text-gray-300' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M17 20h5V10H2v10h5m10 0v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6m10 0H7"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Members
                    </a>

                    <!-- Events -->
                    <div x-data="{ open: {{ request()->routeIs('secretary.events.*', 'secretary.masses.*', 'secretary.calendar') ? 'true' : 'false' }} }">
                        <button type="button"
                            class="flex justify-between items-center w-full px-3 py-2 rounded-md hover:bg-gray-700 transition"
                            @click="open = !open">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7H3v12a2 2 0 002 2z"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                Event / Schedules
                            </span>
                            <svg class="w-4 h-4 transform" :class="{ 'rotate-180': open }" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>

                        <div x-show="open" x-collapse class="ml-8 mt-2 space-y-1">
                            <a href="{{ route('secretary.events.index') }}"
                                class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('secretary.events.index') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700 text-gray-300' }}">
                                Events
                            </a>
                            <a href="{{ route('secretary.masses.index') }}"
                                class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('secretary.masses.index') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700 text-gray-300' }}">
                                Servies
                            </a>
                            <a href="{{ route('secretary.calendar') }}"
                                class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('secretary.calendar') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700 text-gray-300' }}">
                                Calendar
                            </a>
                        </div>
                    </div>

                    <!-- Finance -->
                    <div x-data="{ open: {{ request()->routeIs('secretary.finance.*') ? 'true' : 'false' }} }">
                        <button type="button"
                            class="flex justify-between items-center w-full px-3 py-2 rounded-md hover:bg-gray-700 transition"
                            @click="open = !open">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M12 8c-1.657 0-3 1.343-3 3v1H7v2h2v1a3 3 0 003 3h1v-2h-1a1 1 0 01-1-1v-1h2v-2h-2v-1a1 1 0 011-1h1V8h-1z" />
                                </svg>
                                Finance
                            </span>
                            <svg class="w-4 h-4 transform" :class="{ 'rotate-180': open }" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>

                        <div x-show="open" x-collapse class="ml-8 mt-2 space-y-1">
                            <a href="{{ route('secretary.financial.offerings') }}"
                                class="block px-3 py-2 rounded-md text-sm hover:bg-gray-700 text-gray-300">
                                Offerings
                            </a>
                            <a href="{{ route('secretary.tithes.index') }}"
                                class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('secretary.tithes.*') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700 text-gray-300' }}">
                                Tithes
                            </a>
                            <a href="{{ route('secretary.expenses.index') }}"
                                class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('secretary.expenses.*') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700 text-gray-300' }}">
                                Expenses
                            </a>
                        </div>
                    </div>

                    <!-- Reports -->
                    <div x-data="{ open: {{ request()->routeIs('secretary.reports.*') ? 'true' : 'false' }} }">
                        <button type="button"
                            class="flex justify-between items-center w-full px-3 py-2 rounded-md hover:bg-gray-700 transition"
                            @click="open = !open">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M11 3a1 1 0 011 1v4a1 1 0 11-2 0V4a1 1 0 011-1zm-7 8a1 1 0 011 1v4a1 1 0 11-2 0v-4a1 1 0 011-1zm14 0a1 1 0 011 1v4a1 1 0 11-2 0v-4a1 1 0 011-1z" />
                                </svg>
                                Reports
                            </span>
                            <svg class="w-4 h-4 transform" :class="{ 'rotate-180': open }" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>

                        <div x-show="open" x-collapse class="ml-8 mt-2 space-y-1">
                            <a href="{{ route('secretary.reports.finance') }}"
                                class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('secretary.reports.finance') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700 text-gray-300' }}">
                                Finance Reports
                            </a>

                        </div>
                    </div>
                </nav>
            </div>

            <div class="mt-auto border-t border-gray-700 pt-4">
                <div class="flex items-center mb-4">
                    <img src="{{ Auth::user()->profile_photo_url ?? asset('default-profile.png') }}"
                        class="w-10 h-10 rounded-full border border-gray-600 shadow" alt="Profile">
                    <div class="ml-3">
                        <h4 class="text-sm font-semibold">{{ Auth::user()->name ?? 'Secretary' }}</h4>
                        <p class="text-xs text-gray-400">Secretary</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 bg-red-600 hover:bg-red-500 text-white py-2 rounded-md transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M17 16l4-4m0 0l-4-4m4 4H7" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M7 20V4m0 0H4m3 0h3" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <main class="flex-1 lg:ml-64 bg-gray-900 p-6 overflow-auto">
        <div class="lg:hidden flex justify-between items-center mb-6">
            <h1 class="text-xl font-semibold">ChurchHub Secretary</h1>
            <button class="text-gray-300" @click="sidebarOpen = true">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 6h18M3 12h18M3 18h18" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </div>

        @if (session('success'))
            <div id="alert-message"
                class="max-w-full md:max-w-xl mx-auto p-4 mb-4 rounded-lg bg-green-500/20 text-green-300 border border-green-400/40 shadow-md transition-all duration-300 text-center">
                <span class="text-sm md:text-base font-medium">{{ session('success') }}</span>
            </div>
        @endif



        {{-- @if (session('error'))
            <div id="alert-message" class="mb-4 p-4 rounded bg-red-500/10 text-red-300 border border-red-400/30">
                {{ session('error') }}
            </div>
        @endif --}}

        {{-- @if ($errors->any())
            <div id="alert-message" class="mb-4 p-4 rounded bg-red-500/10 text-red-300 border border-red-400/30">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}

        @yield('content')
    </main>

    <script>
        document.querySelectorAll("#alert-message").forEach(alertBox => {
            setTimeout(() => {
                alertBox.classList.add("opacity-0");
                setTimeout(() => alertBox.remove(), 500);
            }, 3000);
        });
    </script>
</body>

</html>
