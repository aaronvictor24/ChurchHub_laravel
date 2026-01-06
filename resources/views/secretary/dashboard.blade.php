@extends('layouts.secretary')

@section('content')
    <div class="text-5xl font-semibold tracking-tight text-white sm:text-7xl">
        <span class="block">{{ $secretary->church->name ?? 'N/A' }}</span>
        <span class="block text-2xl text-gray-400 mb-10">
        </span>
    </div>

    {{-- Dashboard Widgets --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gray-800 border border-gray-700 shadow-lg rounded-xl p-6 flex flex-col items-center">
            <div class="text-3xl font-bold text-green-400 mb-2">{{ $totalMembers }}</div>
            <div class="text-lg text-gray-300">Members</div>
        </div>
        <div class="bg-gray-800 border border-gray-700 shadow-lg rounded-xl p-6 flex flex-col items-center">
            <div class="text-3xl font-bold text-blue-400 mb-2">{{ $upcomingEvents->count() }}</div>
            <div class="text-lg text-gray-300">Upcoming Events</div>
        </div>
        <div class="bg-gray-800 border border-gray-700 shadow-lg rounded-xl p-6 flex flex-col items-center">
            <div class="text-3xl font-bold text-yellow-400 mb-2">₱{{ number_format($recentOfferings + $recentTithes, 2) }}
            </div>
            <div class="text-lg text-gray-300">Offerings & Tithes (30d)</div>
        </div>
        <div class="bg-gray-800 border border-gray-700 shadow-lg rounded-xl p-6 flex flex-col items-center">
            <div class="flex flex-col space-y-2 w-full">
                <a href="{{ route('secretary.members.index') }}"
                    class="block text-sm text-gray-200 hover:text-green-400">View Members</a>
                <a href="{{ route('secretary.events.index') }}" class="block text-sm text-gray-200 hover:text-blue-400">View
                    Events</a>
                <a href="{{ route('secretary.masses.index') }}"
                    class="block text-sm text-gray-200 hover:text-yellow-400">View Masses</a>
                <a href="{{ route('secretary.reports.finance') }}"
                    class="block text-sm text-gray-200 hover:text-indigo-400">Finance Reports</a>
            </div>
        </div>
    </div>

    {{-- Upcoming Events List --}}
    @if ($upcomingEvents->count())
        <div class="bg-gray-800 border border-gray-700 shadow-lg rounded-xl p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-100 mb-4">Upcoming Events</h3>
            <ul class="divide-y divide-gray-700">
                @foreach ($upcomingEvents as $event)
                    <li class="py-2 flex justify-between items-center">
                        <span class="text-gray-200">{{ $event->title }}</span>
                        <span class="text-gray-400 text-sm">{{ $event->formatted_start_date ?? $event->start_date }}</span>
                        <a href="{{ route('secretary.events.show', $event->event_id) }}"
                            class="ml-4 text-green-400 hover:underline text-sm">Details</a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Grid: 2/3 left (info), 1/3 right (modules) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <section class="lg:col-span-3 bg-gray-800 border border-gray-700 shadow-lg rounded-xl p-8 mb-8">
            <h3 class="text-lg font-semibold text-gray-100 mb-6">Attendance Analytics (Last 12 Months)</h3>
            <canvas id="attendanceChart" height="100"></canvas>
        </section>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const labels = {!! json_encode($labels ?? []) !!};
            const memberAttendance = {!! json_encode($memberAttendance ?? []) !!};
            const eventAttendance = {!! json_encode($eventAttendance ?? []) !!};
            const massAttendance = {!! json_encode($massAttendance ?? []) !!};

            const ctx = document.getElementById('attendanceChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Member Attendance',
                            data: memberAttendance,
                            borderColor: 'rgba(34,197,94,1)',
                            backgroundColor: 'rgba(34,197,94,0.2)',
                            fill: true
                        },
                        {
                            label: 'Event Attendance',
                            data: eventAttendance,
                            borderColor: 'rgba(59,130,246,1)',
                            backgroundColor: 'rgba(59,130,246,0.2)',
                            fill: true
                        },
                        {
                            label: 'Mass Attendance',
                            data: massAttendance,
                            borderColor: 'rgba(234,179,8,1)',
                            backgroundColor: 'rgba(234,179,8,0.2)',
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    stacked: false
                }
            });
        </script>

        {{-- Secretary Information --}}
        <section class="lg:col-span-2 bg-gray-800 border border-gray-700 shadow-lg rounded-xl p-8">
            <h3 class="text-lg font-semibold text-gray-100 mb-6">Secretary Information</h3>

            <div class="overflow-hidden rounded-lg border border-gray-700">
                <table class="w-full text-left text-lg text-gray-300">
                    <tbody>
                        <tr class="border-b border-gray-700">
                            <th class="p-4 font-medium w-1/3 text-gray-400">Full Name</th>
                            <td class="p-4 font-semibold text-gray-100">{{ auth()->user()->name ?? 'N/A' }}</td>
                        </tr>
                        <tr class="border-b border-gray-700">
                            <th class="p-4 font-medium text-gray-400">Email</th>
                            <td class="p-4 font-semibold text-gray-100">{{ auth()->user()->email ?? 'N/A' }}</td>
                        </tr>
                        <tr class="border-b border-gray-700">
                            <th class="p-4 font-medium text-gray-400">Assigned Church</th>
                            <td class="p-4 font-semibold text-gray-100">{{ $secretary->church->name ?? 'N/A' }}</td>
                        </tr>
                        <tr class="border-b border-gray-700">
                            <th class="p-4 font-medium text-gray-400">Position</th>
                            <td class="p-4 font-semibold text-gray-100">Secretary</td>
                        </tr>
                        <tr class="border-b border-gray-700">
                            <th class="p-4 font-medium text-gray-400">Date Assigned</th>
                            <td class="p-4 font-semibold text-gray-100">
                                {{ $secretary->created_at ? $secretary->created_at->format('F d, Y') : 'N/A' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="p-4 font-medium text-gray-400">Status</th>
                            <td class="p-4 font-semibold text-green-400">Active</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        {{-- Modules & Activity --}}
        <section class="bg-gray-800 border border-gray-700 shadow-lg rounded-xl p-8">
            <h3 class="text-2xl font-semibold text-gray-100 mb-6">Modules & Activity</h3>

            <div class="space-y-6">
                <div>
                    <p class="text-lg text-gray-400 uppercase tracking-wider">Available Modules</p>
                    <ul class="mt-2 list-disc list-inside text-gray-200 text-lg space-y-1">
                        <li>Member Management</li>
                        <li>Event Scheduling</li>
                        <li>Mass Records</li>
                        <li>Reports & Notifications</li>
                    </ul>
                </div>

                <div>
                    <p class="text-sm text-gray-400 uppercase tracking-wider">Recent Activity</p>
                    <div class="mt-3 bg-gray-900 border border-gray-700 rounded-lg p-4 max-h-56 overflow-y-auto">
                        @forelse($recentActivities as $activity)
                            <div class="border-b border-gray-700 last:border-0 py-2">
                                <p class="text-gray-200 text-sm">{{ $activity->description }}</p>
                                <p class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</p>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">No recent activity.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection
