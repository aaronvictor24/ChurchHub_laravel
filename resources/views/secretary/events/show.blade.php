@extends('layouts.secretary')

@section('content')
    <div class="px-6 py-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-100">Event Details</h2>
            <a href="{{ route('secretary.events.index') }}">
                <x-secondary-button>
                    Back
                </x-secondary-button>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Panel - Event Details -->
            <div class="lg:col-span-2 bg-gray-800 border border-gray-700 rounded-xl shadow-lg p-8">
                <h3 class="text-2xl font-semibold text-green-400 mb-6">Event Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-6 text-gray-200">
                    <!-- Title -->
                    <div>
                        <p class="text-sm text-gray-400 uppercase font-medium">Title</p>
                        <p class="text-lg font-semibold">{{ $event->title }}</p>
                    </div>

                    <!-- Location -->
                    <div>
                        <p class="text-sm text-gray-400 uppercase font-medium">Location</p>
                        <p class="text-lg font-semibold">{{ $event->location ?? 'N/A' }}</p>
                    </div>

                    <!-- Start Date -->
                    <div>
                        <p class="text-sm text-gray-400 uppercase font-medium">Start Date</p>
                        <p class="text-lg font-semibold">
                            {{ \Carbon\Carbon::parse($event->start_date)->format('F d, Y') }}
                        </p>
                    </div>

                    <!-- End Date -->
                    <div>
                        <p class="text-sm text-gray-400 uppercase font-medium">End Date</p>
                        <p class="text-lg font-semibold">
                            {{ \Carbon\Carbon::parse($event->end_date)->format('F d, Y') }}
                        </p>
                    </div>

                    <!-- Time -->
                    <div>
                        <p class="text-sm text-gray-400 uppercase font-medium">Time</p>
                        <p class="text-lg font-semibold">
                            @if ($event->start_time && $event->end_time)
                                {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} –
                                {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
                            @elseif ($event->start_time)
                                {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}
                            @else
                                N/A
                            @endif
                        </p>
                    </div>

                    <!-- Created By -->
                    <div>
                        <p class="text-sm text-gray-400 uppercase font-medium">Created By</p>
                        <p class="text-lg font-semibold">{{ $event->secretary->first_name ?? 'N/A' }}</p>
                    </div>

                    <!-- Description (Full Width) -->
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-400 uppercase font-medium">Description</p>
                        <p class="text-base text-gray-300 leading-relaxed">
                            {{ $event->description ?? 'No description available.' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Panel - Attendance Tracking -->
            <div class="bg-gray-800 border border-gray-700 rounded-xl shadow-lg p-8">
                <h3 class="text-2xl font-semibold text-green-400 mb-6">Attendance Tracking</h3>

                @php
                    $today = \Carbon\Carbon::today();
                    $start = \Carbon\Carbon::parse($event->start_date);
                    $end = \Carbon\Carbon::parse($event->end_date);
                @endphp

                @if ($today->between($start, $end) || $end->isPast())
                    <form id="attendanceForm" action="{{ route('secretary.events.attendance.update', $event->event_id) }}"
                        method="POST">
                        @csrf
                        <div class="overflow-x-auto max-h-[420px] scrollbar-thin scrollbar-thumb-gray-600">
                            <table class="min-w-full divide-y divide-gray-700 text-gray-200">
                                <thead class="bg-gray-900 text-gray-400 uppercase text-sm sticky top-0">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-medium">#</th>
                                        <th class="px-4 py-3 text-left font-medium">Member Name</th>
                                        <th class="px-4 py-3 text-center font-medium">Attended</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-700">
                                    @foreach ($members as $index => $member)
                                        <tr class="hover:bg-gray-700/40 transition">
                                            <td class="px-4 py-3">{{ $index + 1 }}</td>
                                            <td class="px-4 py-3">{{ $member->first_name }} {{ $member->last_name }}</td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="checkbox" name="attended[{{ $member->member_id }}]"
                                                    class="h-5 w-5 text-green-500 bg-gray-900 border-gray-600 rounded focus:ring-2 focus:ring-green-500"
                                                    {{ isset($attendances[$member->member_id]) && $attendances[$member->member_id] ? 'checked' : '' }}>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="flex justify-end mt-6">
                            <x-primary-button type="submit">
                                Save Attendance
                            </x-primary-button>
                        </div>
                    </form>
                @else
                    <div
                        class="p-4 bg-yellow-900 border border-yellow-700 rounded-lg text-yellow-300 font-semibold text-center">
                        ⚠ Attendance tracking is disabled for this upcoming event.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
