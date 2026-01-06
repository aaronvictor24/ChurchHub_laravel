<form action="{{ route('secretary.events.update', $event->event_id) }}" method="POST" class="space-y-12">
    @csrf
    @method('PUT')

    <div class="border-b border-white/10 pb-12">
        <h2 class="text-base font-semibold text-white">Event Information</h2>
        <p class="mt-1 text-sm text-gray-400">Update the event details below.</p>

        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

            <!-- Title -->
            <div class="sm:col-span-3">
                <label class="block text-sm font-medium text-white">Event Title</label>
                <input type="text" name="title" value="{{ old('title', $event->title) }}" required
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white
                    outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500
                    focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Start Date -->
            <div class="sm:col-span-3">
                <label class="block text-sm font-medium text-white">Start Date</label>
                <input type="date" name="start_date" value="{{ old('start_date', $event->start_date) }}" required
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white
                    outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500
                    focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">
                @error('start_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- End Date -->
            <div class="sm:col-span-3">
                <label class="block text-sm font-medium text-white">End Date</label>
                <input type="date" name="end_date" value="{{ old('end_date', $event->end_date) }}" required
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white
                    outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500
                    focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">
                @error('end_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Start Time -->
            <div class="sm:col-span-3">
                <label class="block text-sm font-medium text-white">Start Time</label>
                <input type="time" name="start_time"
                    value="{{ old('start_time', $event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('H:i') : '') }}"
                    required
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white
                    outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500
                    focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">
                @error('start_time')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- End Time -->
            <div class="sm:col-span-3">
                <label class="block text-sm font-medium text-white">End Time</label>
                <input type="time" name="end_time"
                    value="{{ old('end_time', $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('H:i') : '') }}"
                    required
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white
                    outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500
                    focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">
                @error('end_time')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Location -->
            <div class="sm:col-span-full">
                <label class="block text-sm font-medium text-white">Location</label>
                <input type="text" name="location" value="{{ old('location', $event->location) }}" required
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white
                    outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500
                    focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">
                @error('location')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="sm:col-span-full">
                <label class="block text-sm font-medium text-white">Description</label>
                <textarea name="description" rows="3" required
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white
                    outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500
                    focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">{{ old('description', $event->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <div class="mt-6 flex items-center justify-end gap-x-6">
        <a href="{{ route('secretary.events.index') }}">
            <x-secondary-button type="button" class="bg-gray-700 hover:bg-gray-600">
                Cancel
            </x-secondary-button>
        </a>
        <x-primary-button type="submit">
            Update Event
        </x-primary-button>
    </div>
</form>
