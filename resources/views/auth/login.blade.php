<x-guest-layout>

    <div class="mb-4">
        <a href="{{ url('/') }}"
            class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 
                  hover:text-blue-800 hover:underline transition">
            ← Back
        </a>
    </div>

    <!-- Logo Section -->
    <div class="flex justify-center mb-6">
        <img src="{{ asset('images/logo.png') }}" alt="ChurchHub Logo"
            class="h-20 w-20 rounded-full object-cover shadow-lg border-4 border-blue-500">
    </div>

    <!-- Title -->
    <h2 class="text-2xl font-extrabold text-center text-blue-600 dark:text-blue-400 mb-6">
        Login to ChurchHub
    </h2>

    <!-- Show Login Errors -->
    @if ($errors->any())
        <div class="mb-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                <strong class="font-bold">Whoops!</strong>
                <span class="block">Invalid email or password.</span>
            </div>
        </div>
    @endif

    <!-- Form -->
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition" />
            @error('email')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Password</label>
            <input id="password" type="password" name="password" required
                class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition" />
            @error('password')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                <input id="remember_me" type="checkbox" name="remember"
                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-2 focus:ring-blue-500">
                <span class="ml-2">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                    class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                    Forgot password?
                </a>
            @endif
        </div>

        <!-- Button -->
        <div>
            <button type="submit"
                class="w-full py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg shadow-lg hover:from-blue-700 hover:to-indigo-700 transition">
                Log in
            </button>
        </div>
    </form>
</x-guest-layout>
