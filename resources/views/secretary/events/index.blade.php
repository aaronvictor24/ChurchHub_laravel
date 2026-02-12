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
            .bg-gray-800\/60,
            .text-white {
                background: white !important;
                color: black !important;
            }

            input,
            select,
            button,
            form,
            .sidebar-filters,
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

            .print-container {
                display: block !important;
                width: 100%;
                page-break-after: avoid;
            }

            /* Hide the main layout sidebar when printing */
            aside {
                display: none !important;
            }

            /* Allow main content to take full width */
            main {
                margin-left: 0 !important;
                padding-left: 20px !important;
                padding-right: 20px !important;
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

            tr:nth-child(even) {
                background-color: #f9fafb;
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
        }

        .print-header {
            display: none;
        }

        /* Fix dropdown visibility */
        select option {
            background-color: #1f2937;
            color: white;
        }

        select option:checked {
            background: linear-gradient(#4f46e5, #4f46e5);
            background-color: #4f46e5;
            color: white;
        }
    </style>
    <div class="flex items-start gap-6">
        <!-- Main Content -->
        <div class="flex-1">
            <!-- Print Header -->
            <div class="print-header">
                <div class="print-header-top">
                    <div class="print-logo">
                        @if (Auth::user() && Auth::user()->secretary && Auth::user()->secretary->church)
                            <img src="{{ asset('images/logo.png') }}" alt="Church Logo">
                        @endif
                    </div>
                    <div class="print-header-text">
                        <h2 class="print-title">Lord of the Nation</h2>
                        @if (Auth::user() && Auth::user()->secretary && Auth::user()->secretary->church)
                            <p class="print-subtitle">{{ Auth::user()->secretary->church->name }}</p>
                        @endif
                    </div>
                </div>
                <div class="print-meta">
                    <div class="print-meta-item">Date: <strong>{{ now()->format('F d, Y') }}</strong></div>
                    <div class="print-meta-item">Time: <strong>{{ now()->format('h:i A') }}</strong></div>
                </div>
            </div>

            <!-- Header -->
            <div class="mb-8 no-print">
                <h1 class="text-3xl font-bold text-white">Events</h1>
                <p class="text-gray-400 mt-1">Manage and view church events</p>
            </div>

            <!-- Search Bar -->
            <div class="mb-6 flex items-center gap-3 no-print">
                <form action="{{ route('secretary.events.index') }}" method="GET" class="flex-1 flex gap-3">
                    <input type="search" name="q" value="{{ request('q') }}" placeholder="Search events..."
                        class="flex-1 rounded-md bg-white/5 px-4 py-2.5 text-white placeholder-gray-400 outline-1 -outline-offset-1 outline-white/10 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500" />
                    <button type="submit"
                        class="rounded-md bg-indigo-600 hover:bg-indigo-500 px-6 py-2.5 text-white font-medium transition">Search</button>
                </form>
            </div>
            <x-table.event-table :events="$events" />

            <!-- Print-only table (rendered only when printing) -->
            <div class="print-container" style="display:none;">
                @if ($events->total() > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Date Range</th>
                                <th>Time</th>
                                <th>Location</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $event)
                                @php
                                    $startDate = \Carbon\Carbon::parse($event->start_date)->startOfDay();
                                    $endDate = \Carbon\Carbon::parse($event->end_date)->endOfDay();
                                    $now = \Carbon\Carbon::now();

                                    if ($now->lt($startDate)) {
                                        $status = 'Upcoming';
                                    } elseif ($now->between($startDate, $endDate)) {
                                        $status = 'Ongoing';
                                    } else {
                                        $status = 'Past';
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $event->title }}</td>
                                    <td>{{ $startDate->format('M d, Y') }} - {{ $endDate->format('M d, Y') }}</td>
                                    <td>
                                        {{ $event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('h:i A') : '—' }}
                                        -
                                        {{ $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('h:i A') : '—' }}
                                    </td>
                                    <td>{{ $event->location ?? '—' }}</td>
                                    <td>{{ $status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="print-no-data">No events found</div>
                @endif
            </div>

            <!-- Print Footer -->
            <div class="print-footer">
                <div class="print-footer-item">
                    Total Events: <strong>{{ $events->total() }}</strong>
                </div>
                <div class="print-footer-item center">
                    Printed on: {{ now()->format('M d, Y') }}
                </div>
                <div class="print-footer-item right">
                    Page <span class="page-number">1</span>
                </div>
            </div>
        </div>

        <!-- Actions & Filter Sidebar -->
        <div class="w-72 no-print">
            <!-- Action Buttons -->
            <div class="flex gap-3 mb-6">
                <button onclick="window.print()"
                    class="flex-1 rounded-md bg-gray-600 hover:bg-gray-500 px-6 py-2.5 text-white font-medium transition">Print</button>
                <a href="{{ route('secretary.events.create') }}"
                    class="flex-1 rounded-md bg-indigo-600 hover:bg-indigo-500 px-6 py-2.5 text-white font-medium transition text-center">Add
                    Event</a>
            </div>

            <!-- Filter Sidebar -->
            <aside class="sidebar-filters bg-gray-800/60 rounded-lg p-6 sticky top-4 h-fit">
                <h3 class="text-lg font-semibold text-white mb-5">Filters</h3>
                <form action="{{ route('secretary.events.index') }}" method="GET" class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-200 mb-2">Status</label>
                        <select name="status"
                            class="w-full rounded-md bg-white/5 px-3 py-2 text-white text-sm outline-1 -outline-offset-1 outline-white/10 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500">
                            <option value="">All</option>
                            <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Upcoming
                            </option>
                            <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                            <option value="past" {{ request('status') == 'past' ? 'selected' : '' }}>Past</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-200 mb-2">Date Range</label>
                        <div class="flex flex-col gap-2">
                            <input type="date" name="date_from" value="{{ request('date_from') }}"
                                class="w-full rounded-md bg-white/5 px-3 py-2 text-white text-sm placeholder-gray-500 outline-1 -outline-offset-1 outline-white/10 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500" />
                            <input type="date" name="date_to" value="{{ request('date_to') }}"
                                class="w-full rounded-md bg-white/5 px-3 py-2 text-white text-sm placeholder-gray-500 outline-1 -outline-offset-1 outline-white/10 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500" />
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-200 mb-2">Created</label>
                        <select name="sort_by"
                            class="w-full rounded-md bg-white/5 px-3 py-2 text-white text-sm outline-1 -outline-offset-1 outline-white/10 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500">
                            <option value="" {{ request('sort_by') == '' ? 'selected' : '' }}>All Time</option>
                            <option value="today" {{ request('sort_by') == 'today' ? 'selected' : '' }}>Today</option>
                            <option value="this_week" {{ request('sort_by') == 'this_week' ? 'selected' : '' }}>This Week
                            </option>
                            <option value="this_month" {{ request('sort_by') == 'this_month' ? 'selected' : '' }}>This
                                Month</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-200 mb-2">Order</label>
                        <select name="order"
                            class="w-full rounded-md bg-white/5 px-3 py-2 text-white text-sm outline-1 -outline-offset-1 outline-white/10 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500">
                            <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Descending</option>
                            <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-200 mb-2">Sort By</label>
                        <select name="sort_field"
                            class="w-full rounded-md bg-white/5 px-3 py-2 text-white text-sm outline-1 -outline-offset-1 outline-white/10 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500">
                            <option value="created_at" {{ request('sort_field') == 'created_at' ? 'selected' : '' }}>Date
                                Created</option>
                            <option value="start_date" {{ request('sort_field') == 'start_date' ? 'selected' : '' }}>Start
                                Date</option>
                            <option value="title" {{ request('sort_field') == 'title' ? 'selected' : '' }}>Title</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-200 mb-2">Per Page</label>
                        <select name="per_page"
                            class="w-full rounded-md bg-white/5 px-3 py-2 text-white text-sm outline-1 -outline-offset-1 outline-white/10 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500">
                            <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100</option>
                        </select>
                    </div>
                    <div class="flex gap-2 pt-2">
                        <button type="submit"
                            class="flex-1 rounded-md bg-indigo-600 hover:bg-indigo-500 px-4 py-2 text-white font-medium text-sm transition">Apply</button>
                        <a href="{{ route('secretary.events.index') }}"
                            class="flex-1 rounded-md border border-gray-600 hover:border-gray-500 px-4 py-2 text-gray-300 text-center font-medium text-sm transition">Reset</a>
                    </div>
                </form>
            </aside>
        </div>
    </div>
@endsection
