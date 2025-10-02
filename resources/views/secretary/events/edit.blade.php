@extends('layouts.secretary')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">✏ Edit Event</h2>
        <a href="{{ route('secretary.events.index') }}"
            class="px-4 py-2 bg-gray-600 text-white rounded-lg shadow hover:bg-gray-500 transition">
            ⬅ Back to Events
        </a>
    </div>

    <div class="bg-white shadow rounded-xl p-6">
        <form action="{{ route('secretary.events.update', $event->event_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Event Title</label>
                    <input type="text" name="title" value="{{ old('title', $event->title) }}"
                        class="mt-1 w-full px-3 py-2 border rounded-lg focus:ring focus:ring-green-300 @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Date</label>
                    <input type="date" name="event_date" value="{{ old('event_date', $event->event_date) }}"
                        class="mt-1 w-full px-3 py-2 border rounded-lg focus:ring focus:ring-green-300 @error('event_date') border-red-500 @enderror">
                    @error('event_date')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Start Time -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Start Time</label>
                    <input type="time" name="start_time"
                        value="{{ old('start_time', $event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('H:i') : '') }}"
                        class="mt-1 w-full px-3 py-2 border rounded-lg focus:ring focus:ring-green-300 @error('start_time') border-red-500 @enderror">
                    @error('start_time')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- End Time -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700">End Time</label>
                    <input type="time" name="end_time"
                        value="{{ old('end_time', $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('H:i') : '') }}"
                        class="mt-1 w-full px-3 py-2 border rounded-lg focus:ring focus:ring-green-300 @error('end_time') border-red-500 @enderror">
                    @error('end_time')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <!-- Location -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700">Location</label>
                    <input type="text" name="location" value="{{ old('location', $event->location) }}"
                        class="mt-1 w-full px-3 py-2 border rounded-lg focus:ring focus:ring-green-300 @error('location') border-red-500 @enderror">
                    @error('location')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div class="mt-6">
                <label class="block text-sm font-semibold text-gray-700">Description</label>
                <textarea name="description" rows="4"
                    class="mt-1 w-full px-3 py-2 border rounded-lg focus:ring focus:ring-green-300 @error('description') border-red-500 @enderror">{{ old('description', $event->description) }}</textarea>
                @error('description')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <div class="mt-6">
                <button type="submit"
                    class="px-6 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-500 transition">
                    💾 Update Event
                </button>
            </div>
        </form>
    </div>
@endsection
