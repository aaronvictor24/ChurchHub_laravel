@extends('layouts.secretary')

@section('content')
    <style>
        @media print {
            @page {
                size: A4 portrait;
                margin: 20mm;
            }

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
            .no-print {
                display: none !important;
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

            /* Hide on-screen layout blocks when printing to avoid duplicate content */
            .grid,
            .lg\:grid-cols-3,
            .lg\:col-span-2,
            .bg-gray-800,
            .no-print {
                display: none !important;
            }

            /* Ensure print-only blocks are visible when printing */
            .print-only {
                display: block !important;
            }

            .attendance-table {
                display: table !important;
            }

            .attendance-table th,
            .attendance-table td {
                display: table-cell !important;
                border: 1px solid #000 !important;
            }

            .print-mass-info {
                background: white !important;
                border-collapse: collapse;
                margin-bottom: 20px;
                font-size: 11px;
            }

            .print-mass-info td {
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

            .print-mass-details {
                margin: 20px 0;
                font-size: 11px;
            }

            .print-mass-details-row {
                display: flex;
                margin-bottom: 8px;
            }

            .print-mass-details-label {
                width: 120px;
                font-weight: bold;
                text-align: left;
            }

            .print-mass-details-value {
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
                    <h2 class="print-title">Mass Attendance Report</h2>
                    @if (Auth::user() && Auth::user()->secretary && Auth::user()->secretary->church)
                        <p class="print-subtitle">{{ Auth::user()->secretary->church->name }}</p>
                    @endif
                </div>
            </div>
            <div class="print-meta">
                <div class="print-meta-item">Mass:
                    <strong>{{ $mass->mass_title ?? ucfirst($mass->mass_type) . ' Mass' }}</strong>
                </div>
                <div class="print-meta-item">Date: <strong>{{ now()->format('F d, Y') }}</strong></div>
                <div class="print-meta-item">Time: <strong>{{ now()->format('h:i A') }}</strong></div>
            </div>
        </div>

        <!-- Print Mass Information Section -->
        <div class="print-only" style="display: none;">
            <div class="print-mass-details">
                <div class="print-mass-details-row">
                    <div class="print-mass-details-label">Title</div>
                    <div class="print-mass-details-value">{{ $mass->mass_title ?? 'N/A' }}</div>
                </div>
                <div class="print-mass-details-row">
                    <div class="print-mass-details-label">Type</div>
                    <div class="print-mass-details-value">{{ ucfirst($mass->mass_type) }}</div>
                </div>
                <div class="print-mass-details-row">
                    <div class="print-mass-details-label">Date</div>
                    <div class="print-mass-details-value">{{ \Carbon\Carbon::parse($mass->mass_date)->format('F d, Y') }}
                    </div>
                </div>
                <div class="print-mass-details-row">
                    <div class="print-mass-details-label">Start Time</div>
                    <div class="print-mass-details-value">{{ $mass->start_time }}</div>
                </div>
                <div class="print-mass-details-row">
                    <div class="print-mass-details-label">End Time</div>
                    <div class="print-mass-details-value">{{ $mass->end_time }}</div>
                </div>
                <div class="print-mass-details-row">
                    <div class="print-mass-details-label">Description</div>
                    <div class="print-mass-details-value">{{ $mass->description ?? 'N/A' }}</div>
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
                    <strong>Total Members:</strong> {{ $totalMembers }}<br>
                    <strong>Attended:</strong> {{ $attendedCount }}<br>
                    <strong>Absent:</strong> {{ $absentCount }}
                </div>
                <div class="print-footer-item center">
                    {{ $mass->mass_title ?? ucfirst($mass->mass_type) . ' Mass' }}
                </div>
                <div class="print-footer-item right">
                    Printed: {{ now()->format('F d, Y') }}
                </div>
            </div>
            <!-- Print Offerings -->
            <div style="margin-top:20px;">
                <h3 style="font-size:14px; font-weight:bold; margin: 12px 0;">Offerings</h3>
                @if ($mass->offerings->count() > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>Amount</th>
                                <th>Remarks</th>
                                <th>Encoded By</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mass->offerings as $offering)
                                <tr>
                                    <td>₱{{ number_format($offering->amount, 2) }}</td>
                                    <td>{{ $offering->remarks }}</td>
                                    <td>{{ $offering->encoder->name ?? 'N/A' }}</td>
                                    <td>{{ $offering->created_at->format('F j, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div style="margin-top:10px; font-size:11px;">
                        <strong>Total Offering: ₱{{ number_format($totalOffering, 2) }}</strong>
                    </div>
                @else
                    <p style="font-size:11px;">No offerings recorded for this mass.</p>
                @endif
            </div>
        </div>

        <div class="flex justify-between items-center mb-8 no-print">
            <h2 class="text-3xl font-bold text-gray-100">Mass Details</h2>
            <div class="flex gap-3">
                <a href="{{ route('secretary.masses.print', $mass) }}" target="_blank" rel="noopener noreferrer"
                    class="rounded-md bg-gray-600 hover:bg-gray-500 px-6 py-2.5 text-white font-medium transition">Print</a>
                <a href="{{ route('secretary.masses.index') }}">
                    <x-secondary-button>
                        Back
                    </x-secondary-button>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Panel - Mass Details -->
            <div class="lg:col-span-2 bg-gray-800 border border-gray-700 rounded-xl shadow-lg p-8">
                <h3 class="text-2xl font-semibold text-green-400 mb-6">Mass Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-6 text-gray-200">
                    <!-- Title -->
                    <div>
                        <p class="text-sm text-gray-400 uppercase font-medium">Title</p>
                        <p class="text-lg font-semibold">{{ $mass->mass_title ?? 'N/A' }}</p>
                    </div>

                    <!-- Type -->
                    <div>
                        <p class="text-sm text-gray-400 uppercase font-medium">Type</p>
                        <p class="text-lg font-semibold">{{ ucfirst($mass->mass_type) }}</p>
                    </div>

                    <!-- Date -->
                    <div>
                        <p class="text-sm text-gray-400 uppercase font-medium">Date</p>
                        <p class="text-lg font-semibold">
                            {{ \Carbon\Carbon::parse($mass->mass_date)->format('F d, Y') }}
                        </p>
                    </div>

                    <!-- Start Time -->
                    <div>
                        <p class="text-sm text-gray-400 uppercase font-medium">Start Time</p>
                        <p class="text-lg font-semibold">{{ $mass->start_time }}</p>
                    </div>

                    <!-- End Time -->
                    <div>
                        <p class="text-sm text-gray-400 uppercase font-medium">End Time</p>
                        <p class="text-lg font-semibold">{{ $mass->end_time }}</p>
                    </div>

                    <!-- Day of Week -->
                    <div>
                        <p class="text-sm text-gray-400 uppercase font-medium">Day of Week</p>
                        <p class="text-lg font-semibold">{{ $mass->day_of_week ?? 'N/A' }}</p>
                    </div>

                    <!-- Description (Full Width) -->
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-400 uppercase font-medium">Description</p>
                        <p class="text-base text-gray-300 leading-relaxed">
                            {{ $mass->description ?? 'No description available.' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Panel - Attendance Tracking -->
            <div class="bg-gray-800 border border-gray-700 rounded-xl shadow-lg p-8">
                <h3 class="text-2xl font-semibold text-green-400 mb-6">Attendance Tracking</h3>

                @php
                    $massDT = \Carbon\Carbon::parse($mass->mass_date . ' ' . ($mass->start_time ?? '00:00:00'));
                @endphp

                @if (!$massDT->isFuture())
                    <form id="attendanceForm" action="{{ route('secretary.masses.updateAttendance', $mass) }}"
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
                                                    value="1"
                                                    class="member-checkbox h-5 w-5 text-green-500 bg-gray-900 border-gray-600 rounded focus:ring-2 focus:ring-green-500"
                                                    @checked(isset($attendances[$member->member_id]) && $attendances[$member->member_id])>
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
                        ⚠ Attendance tracking is disabled for this upcoming mass.
                    </div>
                @endif

                <div class="mt-4 text-gray-400 text-sm">
                    <p>Total Members: {{ $totalMembers }}</p>
                    <p>Attended: {{ $attendedCount }}</p>
                    <p>Absent: {{ $absentCount }}</p>
                </div>
            </div>
        </div>

        {{-- Mass Offerings Section --}}
        <div class="bg-gray-800 text-gray-200 shadow rounded p-6 no-print mt-6">
            <h3 class="text-xl font-semibold mb-4">Offerings</h3>

            <form action="{{ route('secretary.masses.storeOffering', $mass) }}" method="POST"
                class="mb-4 flex space-x-4">
                @csrf
                <input type="number" name="amount" placeholder="Amount"
                    class="border border-gray-600 rounded px-3 py-2 w-32 bg-gray-700 text-gray-200" step="0.01"
                    min="0">
                <input type="text" name="remarks" placeholder="Remarks"
                    class="border border-gray-600 rounded px-3 py-2 flex-1 bg-gray-700 text-gray-200">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Add
                    Offering</button>
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-700 text-gray-200">
                        <tr>
                            <th class="px-4 py-2">Amount</th>
                            <th class="px-4 py-2">Remarks</th>
                            <th class="px-4 py-2">Encoded By</th>
                            <th class="px-4 py-2">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-600">
                        @foreach ($mass->offerings as $offering)
                            <tr>
                                <td class="px-4 py-2">₱{{ number_format($offering->amount, 2) }}</td>
                                <td class="px-4 py-2">{{ $offering->remarks }}</td>
                                <td class="px-4 py-2">{{ $offering->encoder->name ?? 'N/A' }}</td>
                                <td class="px-4 py-2">{{ $offering->created_at->format('F j, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <p class="mt-4 font-medium">Total Offering: ₱{{ number_format($totalOffering, 2) }}</p>
        </div>
    </div>

    <script>
        function toggleSelectAll(checkbox) {
            const memberCheckboxes = document.querySelectorAll('.member-checkbox');
            memberCheckboxes.forEach(cb => {
                cb.checked = checkbox.checked;
            });
        }

        function handlePrint(massDate) {
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            const massDateObj = new Date(massDate);
            massDateObj.setHours(0, 0, 0, 0);

            // If mass is upcoming (date is in the future)
            if (massDateObj > today) {
                const confirmed = confirm('This mass is upcoming. Do you want to print?');
                if (confirmed) {
                    window.print();
                }
            } else {
                // Mass is today or past, print directly
                window.print();
            }
        }
    </script>
@endsection
