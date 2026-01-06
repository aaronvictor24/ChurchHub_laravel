<form action="{{ $action }}" method="POST" class="space-y-12">
    @csrf
    @method('PUT')

    <div class="border-b border-white/10 pb-12">
        <h2 class="text-base font-semibold text-white">Mass Details</h2>
        <p class="mt-1 text-sm text-gray-400">Please fill out all the information below.</p>

        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

            {{-- Mass Title --}}
            <div class="sm:col-span-3">
                <label class="block text-sm font-medium text-white">Mass Title</label>
                <input type="text" name="mass_title" value="{{ old('mass_title', $mass->mass_title ?? '') }}"
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white
                       outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500
                       focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">
                @error('mass_title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-3">
                <label class="block text-sm font-medium text-white">Mass Type</label>
                <select name="mass_type" id="mass_type" required
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white
                    outline-1 -outline-offset-1 outline-white/10 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">
                    <option value="" class="text-gray-800">-- Select Type --</option>
                    <option value="regular"
                        {{ old('mass_type', $mass->mass_type ?? '') == 'regular' ? 'selected' : '' }}
                        class = "text-gray-800">Regular</option>
                    <option value="funeral"
                        {{ old('mass_type', $mass->mass_type ?? '') == 'funeral' ? 'selected' : '' }}
                        class = "text-gray-800">Funeral</option>
                    <option value="wedding"
                        {{ old('mass_type', $mass->mass_type ?? '') == 'wedding' ? 'selected' : '' }}
                        class = "text-gray-800">Wedding</option>
                    <option value="baptism"
                        {{ old('mass_type', $mass->mass_type ?? '') == 'baptism' ? 'selected' : '' }}
                        class = "text-gray-800">Baptism</option>
                </select>
                @error('mass_type')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Mass Date --}}
            <div class="sm:col-span-3">
                <label class="block text-sm font-medium text-white">Mass Date</label>
                <input type="date" name="mass_date" value="{{ old('mass_date', $mass->mass_date ?? '') }}" required
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white
                       outline-1 -outline-offset-1 outline-white/10 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">
                @error('mass_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Start Time --}}
            <div class="sm:col-span-3">
                <label class="block text-sm font-medium text-white">Start Time</label>
                <input type="time" name="start_time" value="{{ old('start_time', $mass->start_time ?? '') }}"
                    required
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white
                       outline-1 -outline-offset-1 outline-white/10 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">
                @error('start_time')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- End Time --}}
            <div class="sm:col-span-3">
                <label class="block text-sm font-medium text-white">End Time</label>
                <input type="time" name="end_time" value="{{ old('end_time', $mass->end_time ?? '') }}" required
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white
                       outline-1 -outline-offset-1 outline-white/10 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">
                @error('end_time')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div class="col-span-full">
                <label class="block text-sm font-medium text-white">Description</label>
                <textarea name="description" rows="3"
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white
                    outline-1 -outline-offset-1 outline-white/10 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">{{ old('description', $mass->description ?? '') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

        </div>
    </div>

    {{-- Buttons --}}
    <div class="mt-6 flex items-center justify-end gap-x-6">
        <a href="{{ route('secretary.masses.index') }}">
            <x-secondary-button class="bg-gray-700 hover:bg-gray-600 text-gray-300 px-5 py-2.5 rounded-lg transition">
                Cancel
            </x-secondary-button>
        </a>
        <x-primary-button class="bg-indigo-600 hover:bg-indigo-500 text-white px-5 py-2.5 rounded-lg transition">
            Save Mass
        </x-primary-button>
    </div>
</form>
