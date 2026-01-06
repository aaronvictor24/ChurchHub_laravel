<x-guest-layout>

    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <img src="{{ asset('images/logo.png') }}" alt="ChurchHub Logo" class="mx-auto h-12 w-auto rounded-full" />
        <h2 class="mt-10 text-center text-2xl font-bold tracking-tight text-white">
            Sign in to your account
        </h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-100">Email address</label>
                <div class="mt-2">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="block w-full rounded-md bg-white/5 px-3 py-2 text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm" />
                </div>
                <x-input-error :messages="$errors->get('loginError')" />
            </div>

            <!-- Password -->
            <div>
                <div class="flex items-center justify-between">
                    <label for="password" class="block text-sm font-medium text-gray-100">Password</label>

                </div>
                <div class="mt-2">
                    <input id="password" type="password" name="password" required
                        class="block w-full rounded-md bg-white/5 px-3 py-2 text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm" />
                </div>
                <x-input-error :messages="$errors->get('loginError')" />
            </div>

            <!-- Submit -->
            <div>
                <button type="submit"
                    class="flex w-full justify-center rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                    Sign in
                </button>
            </div>
        </form>

        <p class="mt-10 text-center text-sm text-gray-400">
            Not a member?
            <a href="#" class="font-semibold text-indigo-400 hover:text-indigo-300">Contact your administrator</a>
        </p>
    </div>
</x-guest-layout>
