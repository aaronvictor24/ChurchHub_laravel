<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChurchHub - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900 min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-blue-600 text-white flex flex-col min-h-screen p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold">ChurchHub</h1>
        </div>

        <nav class="flex-1 space-y-2">
            <a href="{{ url('/admin') }}"
                class="block px-3 py-2 rounded transition {{ request()->is('admin') ? 'bg-blue-700' : 'hover:bg-blue-500' }}">
                Dashboard
            </a>

            <a href="{{ route('churches.index') }}"
                class="block px-3 py-2 rounded transition {{ request()->is('churches*') ? 'bg-blue-700' : 'hover:bg-blue-500' }}">
                Churches
            </a>

            <a href="{{ route('pastors.index') }}"
                class="block px-3 py-2 rounded transition {{ request()->is('pastors*') ? 'bg-blue-700' : 'hover:bg-blue-500' }}">
                Pastors
            </a>

            <a href="{{ route('secretaries.index') }}"
                class="block px-3 py-2 rounded transition {{ request()->is('secretaries*') ? 'bg-blue-700' : 'hover:bg-blue-500' }}">
                Secretaries
            </a>
        </nav>

        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}" class="mt-auto">
            @csrf
            <button type="submit" class="w-full text-left px-3 py-2 rounded bg-red-600 hover:bg-red-500 transition">
                Logout
            </button>
        </form>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 overflow-auto">

        {{-- 🔔 Global Alerts Section --}}
        @if (session('success'))
            <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 rounded bg-red-100 text-red-800 border border-red-300">
                ❌ {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-4 rounded bg-red-100 text-red-800 border border-red-300">
                <strong>⚠ Please fix the following:</strong>
                <ul class="list-disc pl-5 mt-2 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{-- 🔔 End Global Alerts Section --}}

        @yield('content')
    </main>

</body>

</html>
