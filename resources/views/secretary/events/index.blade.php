@extends('layouts.secretary')

@section('content')
    <!-- Event Stats Cards -->
    <div class="mb-6">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Events -->
            <div class="bg-blue-600 text-white p-6 rounded-lg shadow">
                <h5 class="text-sm font-medium">Total Events</h5>
                <p class="text-2xl font-bold mt-2">{{ $totalEvents }}</p>
            </div>

            <!-- Upcoming -->
            <div class="bg-green-600 text-white p-6 rounded-lg shadow">
                <h5 class="text-sm font-medium">Upcoming</h5>
                <p class="text-2xl font-bold mt-2">{{ $upcomingEvents }}</p>
            </div>

            <!-- Ongoing -->
            <div class="bg-yellow-400 text-gray-800 p-6 rounded-lg shadow">
                <h5 class="text-sm font-medium">Ongoing</h5>
                <p class="text-2xl font-bold mt-2">{{ $ongoingEvents }}</p>
            </div>

            <!-- Past -->
            <div class="bg-red-600 text-white p-6 rounded-lg shadow">
                <h5 class="text-sm font-medium">Past</h5>
                <p class="text-2xl font-bold mt-2">{{ $pastEvents }}</p>
            </div>
        </div>
    </div>


    <!-- Add Event Button -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold mb-6">Events</h1>
        <a href="{{ route('secretary.events.create') }}"
            class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-500 transition">
            + Add Event
        </a>
    </div>


    <!-- Event Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full border-collapse">
            <thead class="bg-green-600 text-white">
                <tr>
                    <th class="px-4 py-2 text-left">Title</th>
                    <th class="px-4 py-2 text-left">Date</th>
                    <th class="px-4 py-2 text-left">Time</th>
                    <th class="px-4 py-2 text-left">Location</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($events as $event)
                    @php
                        $eventDate = \Carbon\Carbon::parse($event->event_date);
                        $status = $eventDate->isFuture()
                            ? 'Pending'
                            : ($eventDate->isToday()
                                ? 'Ongoing'
                                : 'Completed');
                    @endphp

                    <tr class="border-b hover:bg-gray-50 {{ $eventDate->isToday() ? 'bg-green-50' : '' }}">
                        <td class="px-4 py-2">{{ $event->title }}</td>
                        <td class="px-4 py-2">{{ $eventDate->format('M d, Y') }}</td>
                        <td class="px-4 py-2">
                            {{ $event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('h:i A') : '' }}
                            -
                            {{ $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('h:i A') : '' }}
                        </td>
                        <td class="px-4 py-2">{{ $event->location }}</td>
                        <td class="px-4 py-2">
                            <span
                                class="px-2 py-1 rounded text-white text-xs
                                {{ $status === 'Pending' ? 'bg-yellow-500' : ($status === 'Ongoing' ? 'bg-green-600' : 'bg-gray-500') }}">
                                {{ $status }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            <div class="flex space-x-1">
                                <!-- View Details -->
                                <a href="{{ route('secretary.events.show', $event->event_id) }}"
                                    class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-500 text-xs">View</a>

                                <!-- Edit -->
                                <a href="{{ route('secretary.events.edit', $event->event_id) }}"
                                    class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-400 text-xs">Edit</a>

                                <!-- Delete -->
                                <form action="{{ route('secretary.events.destroy', $event->event_id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this event?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-500 text-xs">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-center text-gray-500">No events found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $events->links() }}
    </div>
@endsection
