<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

    <title>ChurchHub - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900 min-h-screen flex">

    <!-- Sidebar -->
    <!-- Sidebar -->
    <aside class="w-64 bg-blue-600 text-white flex flex-col fixed top-0 left-0 h-full p-6 shadow-lg">
        <div class="mb-6">
            <h1 class="text-2xl font-bold">ChurchHub</h1>
        </div>

        <nav class="flex-1 space-y-2 overflow-y-auto">
            <a href="{{ url('/admin') }}"
                class="block px-3 py-2 rounded transition {{ request()->is('admin') ? 'bg-blue-700' : 'hover:bg-blue-500' }}">
                Dashboard
            </a>

            <a href="{{ route('admin.churches.index') }}"
                class="block px-3 py-2 rounded transition {{ request()->is('churches*') ? 'bg-blue-700' : 'hover:bg-blue-500' }}">
                Churches
            </a>

            <a href="{{ route('admin.pastors.index') }}"
                class="block px-3 py-2 rounded transition {{ request()->is('pastors*') ? 'bg-blue-700' : 'hover:bg-blue-500' }}">
                Pastors
            </a>

            <a href="{{ route('admin.secretaries.index') }}"
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
    <!-- Main Content -->
    <main class="flex-1 p-6 ml-64 overflow-auto">
        {{-- Global alerts --}}
        @if (session('success'))
            <div id="alert-message"
                class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300 transition-opacity duration-500">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div id="alert-message"
                class="mb-4 p-4 rounded bg-red-100 text-red-800 border border-red-300 transition-opacity duration-500">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div id="alert-message"
                class="mb-4 p-4 rounded bg-red-100 text-red-800 border border-red-300 transition-opacity duration-500">
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
        // Select all alert messages (in case there are multiple)
        document.querySelectorAll("#alert-message").forEach(alertBox => {
            setTimeout(() => {
                alertBox.classList.add("opacity-0");
                setTimeout(() => alertBox.remove(), 500); // remove after fade out
            }, 3000); // wait 3s
        });
    </script>



</body>

</html>
