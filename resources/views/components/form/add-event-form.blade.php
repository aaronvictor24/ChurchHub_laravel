<form action="{{ $action }}" method="POST" class="space-y-12">
    @csrf

    {{-- Display warning message if there's a schedule conflict --}}
    @if ($errors->any() || session('warning'))
        <div class="p-4 bg-yellow-900 border border-yellow-700 rounded-lg text-yellow-300 font-semibold">
            @if (session('warning'))
                <div>{{ session('warning') }}</div>
            @endif
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="border-b border-white/10 pb-12">
        <h2 class="text-base font-semibold text-white">Event Details</h2>
        <p class="mt-1 text-sm text-gray-400">Please fill out all the event information below.</p>

        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-3">
                <label class="block text-sm font-medium text-white">Event Title</label>
                <input type="text" name="title" value="{{ old('title', $event->title ?? '') }}" required
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white
                    outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500
                    focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-3">
                <label class="block text-sm font-medium text-white">Start Date</label>
                <input type="date" name="start_date" value="{{ old('start_date', $event->start_date ?? '') }}"
                    required
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white
                    outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500
                    focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">
                @error('start_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-3">
                <label class="block text-sm font-medium text-white">End Date</label>
                <input type="date" name="end_date" value="{{ old('end_date', $event->end_date ?? '') }}" required
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white
                    outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500
                    focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">
                @error('end_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-3">
                <label class="block text-sm font-medium text-white">Start Time</label>
                <input type="time" name="start_time" value="{{ old('start_time', $event->start_time ?? '') }}"
                    required
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white
                    outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500
                    focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">
                @error('start_time')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-3">
                <label class="block text-sm font-medium text-white">End Time</label>
                <input type="time" name="end_time" value="{{ old('end_time', $event->end_time ?? '') }}" required
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white
                    outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500
                    focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">
                @error('end_time')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-3">
                <label class="block text-sm font-medium text-white">Location</label>
                <input type="text" name="location" value="{{ old('location', $event->location ?? '') }}" required
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white
                    outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500
                    focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">
                @error('location')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="col-span-full">
                <label class="block text-sm font-medium text-white">Description</label>
                <textarea name="description" rows="3" required
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white
                    outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500
                    focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">{{ old('description', $event->description ?? '') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <div class="mt-6 flex items-center justify-end gap-x-6">
        <a href="{{ route('secretary.events.index') }}">
            <x-secondary-button
                class="bg-gray-700 hover:bg-gray-600 text-gray-300 text-base font-semibold px-5 py-2.5 rounded-lg transition">
                Cancel
            </x-secondary-button>
        </a>
        <x-primary-button
            class="bg-indigo-600 hover:bg-indigo-500 text-white text-base font-semibold px-5 py-2.5 rounded-lg transition">
            Save Event
        </x-primary-button>
    </div>
</form>
