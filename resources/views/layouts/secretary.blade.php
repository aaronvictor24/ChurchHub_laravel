<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet" />

    <title>ChurchHub Portal - Secretary</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900 min-h-screen flex font-sans">

    <!-- Mobile Header -->
    <header
        class="lg:hidden w-full bg-green-700 text-white flex justify-between items-center px-4 py-3 shadow fixed top-0 left-0 z-50">
        <div class="flex items-center space-x-2">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="w-8 h-8 object-contain">
            <h1 class="text-lg font-bold">ChurchHub</h1>
        </div>
        <button id="menu-toggle" class="focus:outline-none text-2xl">☰</button>
    </header>

    <!-- Sidebar -->
    <aside id="sidebar"
        class="w-64 bg-green-700 text-white flex flex-col h-full p-6 fixed top-0 left-0 shadow-lg transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-50 lg:pt-6 pt-16">

        <!-- Secretary Profile -->
        <div
            class="mb-10 bg-green-800 p-5 rounded-2xl shadow-md flex flex-col items-center text-center transition hover:shadow-lg">
            <img src="{{ Auth::user()->profile_photo_url ?? asset('default-profile.png') }}" alt="Secretary Profile"
                class="w-24 h-24 object-cover rounded-full border-2 border-white shadow-md mb-3">
            <h2 class="text-lg font-semibold">{{ Auth::user()->name }}</h2>
            <p class="text-sm opacity-80">Secretary</p>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 flex flex-col space-y-2">
            <a href="{{ route('secretary.dashboard') }}"
                class="flex items-center px-4 py-3 rounded-lg transition {{ request()->routeIs('secretary.dashboard') ? 'bg-green-800 font-semibold shadow-md' : 'hover:bg-green-600' }}">📋
                <span class="ml-3">Dashboard</span></a>

            <!-- Members -->
            <a href="{{ route('secretary.members.index') }}"
                class="flex items-center px-4 py-3 rounded-lg transition {{ request()->routeIs('secretary.members.*') ? 'bg-green-800 font-semibold shadow-md' : 'hover:bg-green-600' }}">👥
                <span class="ml-3">Members</span></a>

            <!-- Events Dropdown -->
            @php $eventsActive = request()->routeIs('secretary.events.*', 'secretary.calendar'); @endphp
            <div>
                <button type="button"
                    class="flex justify-between items-center w-full px-4 py-3 rounded-lg hover:bg-green-600 transition"
                    onclick="toggleDropdown('eventsDropdown')">
                    📅 <span class="ml-3">Event/Schedules</span> ▾
                </button>
                <div id="eventsDropdown" class="{{ $eventsActive ? '' : 'hidden' }} ml-4 mt-1 space-y-1">
                    <a href="{{ route('secretary.events.index') }}"
                        class="flex items-center px-4 py-2 rounded-lg transition {{ request()->routeIs('secretary.events.index') ? 'bg-green-800 font-semibold shadow-md' : 'hover:bg-green-600' }}">
                        <span class="ml-2">Event</span></a>
                    <a href="{{ route('secretary.calendar') }}"
                        class="flex items-center px-4 py-2 rounded-lg transition {{ request()->routeIs('secretary.calendar') ? 'bg-green-800 font-semibold shadow-md' : 'hover:bg-green-600' }}">
                        <span class="ml-2">View Calendar</span></a>

                </div>
            </div>

            <!-- Finance Dropdown -->
            @php $financeActive = request()->routeIs('secretary.finance.*'); @endphp
            <div>
                <button type="button"
                    class="flex justify-between items-center w-full px-4 py-3 rounded-lg hover:bg-green-600 transition"
                    onclick="toggleDropdown('financeDropdown')">
                    💰 <span class="ml-3">Finance</span> ▾
                </button>
                <div id="financeDropdown" class="{{ $financeActive ? '' : 'hidden' }} ml-4 mt-1 space-y-1">
                    <a href="#"
                        class="flex items-center px-4 py-2 rounded-lg transition {{ request()->routeIs('secretary.finance.offerings.*') ? 'bg-green-800 font-semibold shadow-md' : 'hover:bg-green-600' }}">🕊
                        <span class="ml-2">Offerings</span></a>
                </div>
            </div>

            <!-- Communication -->
            <a href="#"
                class="flex items-center px-4 py-3 rounded-lg transition {{ request()->routeIs('secretary.communication.*') ? 'bg-green-800 font-semibold shadow-md' : 'hover:bg-green-600' }}">📢
                <span class="ml-3">Communication</span></a>

            <!-- Reports Dropdown -->
            @php $reportsActive = request()->routeIs('secretary.reports.*'); @endphp
            <div>
                <button type="button"
                    class="flex justify-between items-center w-full px-4 py-3 rounded-lg hover:bg-green-600 transition"
                    onclick="toggleDropdown('reportsDropdown')">
                    📊 <span class="ml-3">Reports</span> ▾
                </button>
                <div id="reportsDropdown" class="{{ $reportsActive ? '' : 'hidden' }} ml-4 mt-1 space-y-1">
                    <a href="#"
                        class="flex items-center px-4 py-2 rounded-lg transition {{ request()->routeIs('secretary.reports.monthly') ? 'bg-green-800 font-semibold shadow-md' : 'hover:bg-green-600' }}">📆
                        <span class="ml-2">Monthly</span></a>
                    <a href="#"
                        class="flex items-center px-4 py-2 rounded-lg transition {{ request()->routeIs('secretary.reports.annual') ? 'bg-green-800 font-semibold shadow-md' : 'hover:bg-green-600' }}">📅
                        <span class="ml-2">Annual</span></a>
                </div>
            </div>
        </nav>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}" class="mt-auto">
            @csrf
            <button type="submit"
                class="w-full flex items-center px-4 py-3 rounded-lg bg-red-600 hover:bg-red-500 transition font-semibold">🚪
                <span class="ml-3">Logout</span></button>
        </form>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 lg:ml-64 overflow-auto pt-20 lg:pt-6 relative z-10">
        @if (session('success'))
            <div id="alert-message" class="mb-4 p-4 rounded-lg bg-green-500 text-white shadow-md">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div id="alert-message" class="mb-4 p-4 rounded-lg bg-red-500 text-white shadow-md">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <script>
        const toggleBtn = document.getElementById("menu-toggle");
        const sidebar = document.getElementById("sidebar");
        toggleBtn?.addEventListener("click", () => sidebar.classList.toggle("-translate-x-full"));

        function toggleDropdown(id) {
            document.getElementById(id).classList.toggle("hidden");
        }

        const alertBox = document.getElementById("alert-message");
        if (alertBox) {
            setTimeout(() => {
                alertBox.classList.add("opacity-0", "transition", "duration-500");
                setTimeout(() => alertBox.remove(), 500);
            }, 3000);
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>

</body>

</html>
