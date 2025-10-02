@extends('layouts.secretary')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">📅 Event Details</h2>
        <a href="{{ route('secretary.events.index') }}"
            class="px-4 py-2 bg-gray-600 text-white rounded-lg shadow hover:bg-gray-500 transition">
            ⬅ Back to Events
        </a>
    </div>

    <!-- Event Info -->
    <div class="bg-white shadow rounded-xl p-6 mb-6">
        <h3 class="text-2xl font-bold text-green-700 mb-4">{{ $event->title }}</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-500 font-semibold">📍 Location</p>
                <p class="text-lg text-gray-800">{{ $event->location }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-semibold">📅 Date</p>
                <p class="text-lg text-gray-800">{{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-semibold">⏰ Time</p>
                <p class="text-lg text-gray-800">
                    @if ($event->start_time && $event->end_time)
                        {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} -
                        {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
                    @elseif ($event->start_time)
                        {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}
                    @else
                        N/A
                    @endif
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-semibold">📝 Created By</p>
                <p class="text-lg text-gray-800">{{ $event->secretary->first_name ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="mt-6">
            <p class="text-sm text-gray-500 font-semibold">📝 Description</p>
            <p class="text-lg text-gray-800">{{ $event->description }}</p>
        </div>
    </div>

    <!-- Attendance Summary -->
    @if (\Carbon\Carbon::parse($event->event_date)->isPast() || \Carbon\Carbon::parse($event->event_date)->isToday())
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-green-100 shadow rounded-xl p-6 text-center">
                <p class="text-3xl font-bold text-green-700">{{ $attendedCount ?? 0 }}</p>
                <p class="text-sm text-gray-700 font-semibold">Attended</p>
            </div>
            <div class="bg-red-100 shadow rounded-xl p-6 text-center">
                <p class="text-3xl font-bold text-red-700">{{ $absentCount ?? 0 }}</p>
                <p class="text-sm text-gray-700 font-semibold">Absent</p>
            </div>
            <div class="bg-blue-100 shadow rounded-xl p-6 text-center">
                <p class="text-3xl font-bold text-blue-700">{{ $totalMembers ?? 0 }}</p>
                <p class="text-sm text-gray-700 font-semibold">Total Members</p>
            </div>
        </div>
    @else
        <div class="bg-yellow-100 shadow rounded-xl p-4 mb-6 text-center">
            <p class="text-lg font-semibold text-yellow-700">⚠ Attendance tracking will be available once this event starts.
            </p>
        </div>
    @endif

    <!-- Attendance Tracker -->
    <div class="bg-white shadow rounded-xl p-6">
        <h3 class="text-xl font-bold text-gray-700 mb-4">👥 Attendance</h3>

        @if (\Carbon\Carbon::parse($event->event_date)->isPast() || \Carbon\Carbon::parse($event->event_date)->isToday())
            <form id="attendanceForm" action="{{ route('secretary.events.attendance.update', $event->event_id) }}"
                method="POST">
                @csrf

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">#</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Member Name</th>
                                <th class="px-4 py-2 text-center text-sm font-medium text-gray-500">Attended</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($members as $index => $member)
                                <tr>
                                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2">{{ $member->first_name }} {{ $member->last_name }}</td>
                                    <td class="px-4 py-2 text-center">
                                        <input type="checkbox" name="attended[{{ $member->member_id }}]"
                                            class="h-5 w-5 text-green-600 rounded focus:ring-2 focus:ring-green-500"
                                            {{ isset($attendances[$member->member_id]) && $attendances[$member->member_id] ? 'checked' : '' }}>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-end mt-4">
                    <button type="submit"
                        class="px-6 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-500 transition">
                        💾 Save Attendance
                    </button>
                </div>
            </form>
        @else
            <div class="p-4 bg-yellow-100 rounded-lg text-yellow-700 font-semibold text-center">
                ⚠ Attendance tracking is disabled for this upcoming event.
            </div>
        @endif
    </div>
@endsection
