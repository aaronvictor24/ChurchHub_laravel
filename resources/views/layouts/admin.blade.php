<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-900">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title>ChurchHub - Admin</title>
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
                    <a href="{{ url('/admin') }}"
                        class="flex items-center px-3 py-2 rounded-md transition 
                              {{ request()->is('admin') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700 text-gray-300' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M3 12l2-2m0 0l7-7 7 7M13 5v14" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('admin.churches.index') }}"
                        class="flex items-center px-3 py-2 rounded-md transition 
                              {{ request()->is('churches*') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700 text-gray-300' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M3 7h18M3 12h18M3 17h18" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Churches
                    </a>

                    <a href="{{ route('admin.pastors.index') }}"
                        class="flex items-center px-3 py-2 rounded-md transition 
                              {{ request()->is('pastors*') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700 text-gray-300' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M16 11V7a4 4 0 00-8 0v4M5 11h14v10H5z" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        Pastors
                    </a>

                    <a href="{{ route('admin.secretaries.index') }}"
                        class="flex items-center px-3 py-2 rounded-md transition 
                              {{ request()->is('secretaries*') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700 text-gray-300' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M9 17v-2a4 4 0 018 0v2m-6 4h4a2 2 0 002-2v-4a6 6 0 10-12 0v4a2 2 0 002 2z"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Secretaries
                    </a>
                </nav>
            </div>

            <!-- Profile + Logout -->
            <div class="mt-auto border-t border-gray-700 pt-4">
                <div class="flex items-center mb-4">
                    <div class="ml-3">
                        <h4 class="text-sm font-semibold">{{ Auth::user()->name ?? 'Admin' }}</h4>
                        <p class="text-xs text-gray-400">Administrator</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 bg-red-600 hover:bg-red-500 text-white py-2 rounded-md transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M17 16l4-4m0 0l-4-4m4 4H7" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M7 20V4m0 0H4m3 0h3" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 lg:ml-64 bg-gray-900 p-6 overflow-auto">
        <!-- Top Bar (Mobile) -->
        <div class="lg:hidden flex justify-between items-center mb-6">
            <h1 class="text-xl font-semibold">ChurchHub Admin</h1>
            <button class="text-gray-300" @click="sidebarOpen = true">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 6h18M3 12h18M3 18h18" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div id="alert-message"
                class="mb-4 p-4 rounded bg-green-500/10 text-green-300 border border-green-400/30">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div id="alert-message" class="mb-4 p-4 rounded bg-red-500/10 text-red-300 border border-red-400/30">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div id="alert-message" class="mb-4 p-4 rounded bg-red-500/10 text-red-300 border border-red-400/30">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif



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
