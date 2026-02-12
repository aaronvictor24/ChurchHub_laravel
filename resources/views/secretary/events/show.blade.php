@extends('layouts.secretary')

@section('content')
    <style>
        @media print {
            * {
                margin: 0;
                padding: 0;
            }

            .no-print {
                display: none !important;
            }

            body {
                background: white;
                color: black;
                font-family: Arial, sans-serif;
                line-height: 1.6;
            }

            .bg-gray-800,
            .bg-gray-900,
            .text-white,
            input,
            select,
            button,
            form {
                background: white !important;
                color: black !important;
                display: block !important;
            }

            input,
            select,
            button,
            .no-print,
            .grid,
            .lg\:col-span-2 {
                display: none !important;
            }

            .attendance-section {
                display: block !important;
            }

            .print-header {
                display: block !important;
                text-align: center;
                border-bottom: 2px solid #000;
                padding-bottom: 20px;
                margin-bottom: 30px;
            }

            .print-header-top {
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 20px;
                margin-bottom: 15px;
            }

            .print-logo {
                width: 70px;
                height: 70px;
                display: flex;
                align-items: center;
            }

            .print-logo img {
                width: 100%;
                height: 100%;
                object-fit: contain;
            }

            .print-header-text {
                text-align: center;
            }

            .print-title {
                font-size: 22px;
                font-weight: bold;
                margin: 5px 0;
                letter-spacing: 0.5px;
            }

            .print-subtitle {
                font-size: 13px;
                margin: 3px 0;
                color: #333;
            }

            .print-meta {
                font-size: 11px;
                color: #555;
                margin-top: 8px;
            }

            .print-meta-item {
                display: inline-block;
                margin-right: 30px;
            }

            /* Ensure print-only blocks are visible when printing */
            .print-only {
                display: block !important;
            }

            .print-event-info {
                background: white !important;
                border-collapse: collapse;
                margin-bottom: 20px;
                font-size: 11px;
            }

            .print-event-info td {
                border: 1px solid #ccc;
                padding: 8px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
                font-size: 11px;
            }

            th {
                background-color: #f3f4f6;
                border: 1px solid #000;
                padding: 10px 8px;
                text-align: left;
                font-weight: bold;
                font-size: 12px;
            }

            td {
                border: 1px solid #ccc;
                padding: 8px;
            }

            .print-footer {
                margin-top: 30px;
                border-top: 1px solid #000;
                padding-top: 15px;
                font-size: 11px;
                display: flex;
                justify-content: space-between;
            }

            .print-footer-item {
                flex: 1;
            }

            .print-footer-item.center {
                text-align: center;
            }

            .print-footer-item.right {
                text-align: right;
            }

            .print-event-details {
                margin: 20px 0;
                font-size: 11px;
            }

            .print-event-details-row {
                display: flex;
                margin-bottom: 8px;
            }

            .print-event-details-label {
                width: 120px;
                font-weight: bold;
                text-align: left;
            }

            .print-event-details-value {
                flex: 1;
                padding-left: 20px;
            }

            .attendance-table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
                font-size: 11px;
            }

            .attendance-table th {
                background-color: #f3f4f6;
                border: 1px solid #000;
                padding: 10px 8px;
                text-align: left;
                font-weight: bold;
                font-size: 12px;
            }

            .attendance-table td {
                border: 1px solid #ccc;
                padding: 10px 8px;
                text-align: left;
            }

            .attendance-table .attendance-check {
                text-align: center;
                font-weight: bold;
                font-size: 12px;
            }

            .attendance-section {
                display: none;
            }

            .attendance-section.print-section {
                display: block;
            }

            @media print {
                .attendance-section {
                    display: block !important;
                }

                .attendance-table {
                    display: table !important;
                    width: 100% !important;
                }

                .attendance-table th,
                .attendance-table td {
                    display: table-cell !important;
                    border: 1px solid #000 !important;
                }
            }
        }

        .print-header {
            display: none;
        }
    </style>
    <div class="px-6 py-8">
        <!-- Print Header -->
        <div class="print-header">
            <div class="print-header-top">
                <div class="print-logo">
                    @if (Auth::user() && Auth::user()->secretary && Auth::user()->secretary->church)
                        <img src="{{ asset('images/logo.png') }}" alt="Church Logo">
                    @endif
                </div>
                <div class="print-header-text">
                    <h2 class="print-title">Event Attendance Report</h2>
                    @if (Auth::user() && Auth::user()->secretary && Auth::user()->secretary->church)
                        <p class="print-subtitle">{{ Auth::user()->secretary->church->name }}</p>
                    @endif
                </div>
            </div>
            <div class="print-meta">
                <div class="print-meta-item">Event: <strong>{{ $event->title }}</strong></div>
                <div class="print-meta-item">Date: <strong>{{ now()->format('F d, Y') }}</strong></div>
                <div class="print-meta-item">Time: <strong>{{ now()->format('h:i A') }}</strong></div>
            </div>
        </div>

        <!-- Print Event Information Section -->
        <div class="print-only" style="display: none;">
            <div class="print-event-details">
                <div class="print-event-details-row">
                    <div class="print-event-details-label">Title</div>
                    <div class="print-event-details-value">{{ $event->title }}</div>
                </div>
                <div class="print-event-details-row">
                    <div class="print-event-details-label">Location</div>
                    <div class="print-event-details-value">{{ $event->location ?? 'N/A' }}</div>
                </div>
                <div class="print-event-details-row">
                    <div class="print-event-details-label">Start Date</div>
                    <div class="print-event-details-value">{{ \Carbon\Carbon::parse($event->start_date)->format('F d, Y') }}
                    </div>
                </div>
                <div class="print-event-details-row">
                    <div class="print-event-details-label">End Date</div>
                    <div class="print-event-details-value">{{ \Carbon\Carbon::parse($event->end_date)->format('F d, Y') }}
                    </div>
                </div>
                <div class="print-event-details-row">
                    <div class="print-event-details-label">Time</div>
                    <div class="print-event-details-value">
                        @if ($event->start_time && $event->end_time)
                            {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} –
                            {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
                        @elseif ($event->start_time)
                            {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}
                        @else
                            N/A
                        @endif
                    </div>
                </div>
                <div class="print-event-details-row">
                    <div class="print-event-details-label">Description</div>
                    <div class="print-event-details-value">{{ $event->description ?? 'No description available.' }}</div>
                </div>
            </div>

            <!-- Print Attendance Table -->
            <h3 style="font-size: 14px; font-weight: bold; margin: 20px 0; text-decoration: underline;">Attendance Record
            </h3>
            <table class="attendance-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Member Name</th>
                        <th class="attendance-check">Attended</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($members as $index => $member)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $member->first_name }} {{ $member->last_name }}</td>
                            <td class="attendance-check">
                                {{ isset($attendances[$member->member_id]) && $attendances[$member->member_id] ? '✓' : '' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Print Footer -->
            <div class="print-footer">
                <div class="print-footer-item">
                    <strong>Total Members:</strong> {{ count($members) }}
                </div>
                <div class="print-footer-item center">
                    Event: {{ $event->title }}
                </div>
                <div class="print-footer-item right">
                    Printed: {{ now()->format('F d, Y') }}
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center mb-8 no-print">
            <h2 class="text-3xl font-bold text-gray-100">Event Details</h2>
            <div class="flex gap-3">
                <button onclick="handlePrint('{{ $event->start_date }}')"
                    class="rounded-md bg-gray-600 hover:bg-gray-500 px-6 py-2.5 text-white font-medium transition">Print</button>
                <a href="{{ route('secretary.events.index') }}">
                    <x-secondary-button>
                        Back
                    </x-secondary-button>
                </a>
            </div>
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
                                        <th class="px-4 py-3 text-center font-medium">
                                            <div class="flex items-center justify-center gap-2">
                                                <input type="checkbox" id="selectAllCheckbox"
                                                    class="h-5 w-5 text-green-500 bg-gray-900 border-gray-600 rounded focus:ring-2 focus:ring-green-500 cursor-pointer"
                                                    onchange="toggleSelectAll(this)">
                                                <span class="text-xs">Attended</span>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-700">
                                    @foreach ($members as $index => $member)
                                        <tr class="hover:bg-gray-700/40 transition">
                                            <td class="px-4 py-3">{{ $index + 1 }}</td>
                                            <td class="px-4 py-3">{{ $member->first_name }} {{ $member->last_name }}</td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="checkbox" name="attended[{{ $member->member_id }}]"
                                                    class="member-checkbox h-5 w-5 text-green-500 bg-gray-900 border-gray-600 rounded focus:ring-2 focus:ring-green-500"
                                                    {{ isset($attendances[$member->member_id]) && $attendances[$member->member_id] ? 'checked' : '' }}>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="flex justify-end mt-6 no-print">
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

    <script>
        function toggleSelectAll(checkbox) {
            const memberCheckboxes = document.querySelectorAll('.member-checkbox');
            memberCheckboxes.forEach(cb => {
                cb.checked = checkbox.checked;
            });
        }

        function handlePrint(eventStartDate) {
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            const startDate = new Date(eventStartDate);
            startDate.setHours(0, 0, 0, 0);

            // If event is upcoming (start date is in the future)
            if (startDate > today) {
                const confirmed = confirm('This event is upcoming. Do you want to print?');
                if (confirmed) {
                    window.print();
                }
            } else {
                // Event is ongoing or past, print directly
                window.print();
            }
        }
    </script>
@endsection
