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
                        <h2 class="print-title">Services Management Report</h2>
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
                <h1 class="text-3xl font-bold text-white">Services</h1>
                <p class="text-gray-400 mt-1">Manage and view church services</p>
            </div>

            <!-- Search Bar -->
            <div class="mb-6 flex items-center gap-3 no-print">
                <form action="{{ route('secretary.masses.index') }}" method="GET" class="flex-1 flex gap-3">
                    <input type="search" name="q" value="{{ request('q') }}" placeholder="Search services..."
                        class="flex-1 rounded-md bg-white/5 px-4 py-2.5 text-white placeholder-gray-400 outline-1 -outline-offset-1 outline-white/10 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500" />
                    <button type="submit"
                        class="rounded-md bg-indigo-600 hover:bg-indigo-500 px-6 py-2.5 text-white font-medium transition">Search</button>
                </form>
            </div>

            <x-table.mass-table :masses="$masses" />

            <!-- Print-only table (rendered only when printing) -->
            <div class="print-container" style="display:none;">
                @if ($masses->total() > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Recurring</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($masses as $mass)
                                <tr>
                                    <td>{{ $mass->mass_title ?? ucfirst($mass->mass_type) }}</td>
                                    <td>{{ ucfirst($mass->mass_type) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($mass->mass_date)->format('M d, Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($mass->start_time)->format('h:i A') }} -
                                        {{ \Carbon\Carbon::parse($mass->end_time)->format('h:i A') }}</td>
                                    <td>{{ $mass->is_recurring ? 'Yes' : 'No' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="print-no-data">No services found</div>
                @endif
            </div>

            <!-- Print Footer -->
            <div class="print-footer">
                <div class="print-footer-item">
                    Total Services: <strong>{{ $totalMasses }}</strong>
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
                <a href="{{ route('secretary.masses.create') }}"
                    class="flex-1 rounded-md bg-indigo-600 hover:bg-indigo-500 px-6 py-2.5 text-white font-medium transition text-center">Add
                    Service</a>
            </div>

            <!-- Filter Sidebar -->
            <aside class="sidebar-filters bg-gray-800/60 rounded-lg p-6 sticky top-4 h-fit">
                <h3 class="text-lg font-semibold text-white mb-5">Filters</h3>
                <form action="{{ route('secretary.masses.index') }}" method="GET" class="space-y-5">
                    <!-- Type Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-200 mb-2">Service Type</label>
                        <select name="type"
                            class="w-full rounded-md bg-white/5 px-3 py-2 text-white text-sm outline-1 -outline-offset-1 outline-white/10 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500">
                            <option value="">All Types</option>
                            <option value="regular" {{ request('type') === 'regular' ? 'selected' : '' }}>Regular</option>
                            <option value="funeral" {{ request('type') === 'funeral' ? 'selected' : '' }}>Funeral</option>
                            <option value="wedding" {{ request('type') === 'wedding' ? 'selected' : '' }}>Wedding</option>
                            <option value="baptism" {{ request('type') === 'baptism' ? 'selected' : '' }}>Baptism</option>
                        </select>
                    </div>

                    <!-- Recurring Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-200 mb-2">Recurring Status</label>
                        <select name="recurring"
                            class="w-full rounded-md bg-white/5 px-3 py-2 text-white text-sm outline-1 -outline-offset-1 outline-white/10 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500">
                            <option value="">All</option>
                            <option value="yes" {{ request('recurring') === 'yes' ? 'selected' : '' }}>Recurring
                            </option>
                            <option value="no" {{ request('recurring') === 'no' ? 'selected' : '' }}>One-Time</option>
                        </select>
                    </div>

                    <!-- Sort By -->
                    <div>
                        <label class="block text-sm font-medium text-gray-200 mb-2">Sort By</label>
                        <select name="sort_by"
                            class="w-full rounded-md bg-white/5 px-3 py-2 text-white text-sm outline-1 -outline-offset-1 outline-white/10 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500">
                            <option value="created_at"
                                {{ request('sort_by', 'created_at') === 'created_at' ? 'selected' : '' }}>Date Added
                            </option>
                            <option value="mass_title" {{ request('sort_by') === 'mass_title' ? 'selected' : '' }}>Title
                            </option>
                            <option value="start_time" {{ request('sort_by') === 'start_time' ? 'selected' : '' }}>Start
                                Time</option>
                        </select>
                    </div>

                    <!-- Order -->
                    <div>
                        <label class="block text-sm font-medium text-gray-200 mb-3">Order</label>
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="order" value="desc"
                                    {{ request('order', 'desc') === 'desc' ? 'checked' : '' }}
                                    class="w-4 h-4 accent-indigo-500" />
                                <span class="text-sm text-gray-300">Newest Added</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="order" value="asc"
                                    {{ request('order') === 'asc' ? 'checked' : '' }} class="w-4 h-4 accent-indigo-500" />
                                <span class="text-sm text-gray-300">Oldest Added</span>
                            </label>
                        </div>
                    </div>

                    <!-- Apply & Reset Buttons -->
                    <div class="flex gap-2 pt-2">
                        <button type="submit"
                            class="flex-1 rounded-md bg-indigo-600 hover:bg-indigo-500 px-4 py-2 text-white font-medium text-sm transition">Apply</button>
                        <a href="{{ route('secretary.masses.index') }}"
                            class="flex-1 rounded-md border border-gray-600 hover:border-gray-500 px-4 py-2 text-gray-300 text-center font-medium text-sm transition">Reset</a>
                    </div>

                    <!-- Summary Stats -->
                    <div class="pt-5 border-t border-gray-600">
                        <h4 class="text-sm font-semibold text-gray-200 mb-3">Summary</h4>
                        <div class="space-y-2 text-sm text-gray-300">
                            <p>Total Services: <strong class="text-white">{{ $totalMasses }}</strong></p>
                            <p>Recurring: <strong class="text-white">{{ $recurringMasses }}</strong></p>
                            <p>One-Time: <strong class="text-white">{{ $oneTimeMasses }}</strong></p>
                        </div>
                    </div>
                </form>
            </aside>
        </div>
    </div>
@endsection
