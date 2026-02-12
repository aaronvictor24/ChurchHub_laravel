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

            aside {
                display: none !important;
            }

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
                        <h2 class="print-title">Tithes Report</h2>
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
                <h1 class="text-3xl font-bold text-white">Tithes</h1>
                <p class="text-gray-400 mt-1">Manage and view church tithes</p>
            </div>

            <!-- Search Bar -->
            <div class="mb-6 flex items-center gap-3 no-print">
                <form action="{{ route('secretary.tithes.index') }}" method="GET" class="flex-1 flex gap-3">
                    <input type="search" name="q" value="{{ request('q') }}"
                        placeholder="Search tithes by member, pledger or remarks..."
                        class="flex-1 rounded-md bg-white/5 px-4 py-2.5 text-white placeholder-gray-400 outline-1 -outline-offset-1 outline-white/10 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500" />
                    <button type="submit"
                        class="rounded-md bg-indigo-600 hover:bg-indigo-500 px-6 py-2.5 text-white font-medium transition">Search</button>
                </form>
            </div>

            <div class="bg-gray-800 shadow rounded-xl p-6 border border-white/10 no-print">
                <x-table.tithe-table :tithes="$tithes" />
            </div>

            <!-- Print-only table -->
            <div class="print-container" style="display:none;">
                @if ($tithes->total() > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>Member / Pledger</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Remarks</th>
                                <th>Encoder</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tithes as $tithe)
                                <tr>
                                    <td>
                                        @if ($tithe->is_pledge)
                                            {{ $tithe->pledger_name ?? 'Unknown Pledger' }}
                                        @else
                                            {{ $tithe->member->first_name ?? 'N/A' }} {{ $tithe->member->last_name ?? '' }}
                                        @endif
                                    </td>
                                    <td>{{ $tithe->is_pledge ? 'Pledge' : 'Member' }}</td>
                                    <td>₱{{ number_format($tithe->amount, 2) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($tithe->date)->format('M d, Y') }}</td>
                                    <td>{{ $tithe->remarks ?? '—' }}</td>
                                    <td>{{ $tithe->encoder->name ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="print-no-data">No tithes found</div>
                @endif
            </div>

            <!-- Print Footer -->
            <div class="print-footer">
                <div class="print-footer-item">
                    Total Records: <strong>{{ $tithes->total() }}</strong>
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
                <a href="{{ route('secretary.tithes.create') }}"
                    class="flex-1 rounded-md bg-indigo-600 hover:bg-indigo-500 px-6 py-2.5 text-white font-medium transition text-center">Add
                    Tithe</a>
            </div>

            <!-- Filter Sidebar -->
            <aside class="sidebar-filters bg-gray-800/60 rounded-lg p-6 sticky top-4 h-fit">
                <h3 class="text-lg font-semibold text-white mb-5">Filters</h3>
                <form action="{{ route('secretary.tithes.index') }}" method="GET" class="space-y-5">
                    <!-- Tithe Type Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-200 mb-2">Type</label>
                        <select name="type"
                            class="w-full rounded-md bg-white/5 px-3 py-2 text-white text-sm outline-1 -outline-offset-1 outline-white/10 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500">
                            <option value="">All Types</option>
                            <option value="member" {{ request('type') === 'member' ? 'selected' : '' }}>Member</option>
                            <option value="pledge" {{ request('type') === 'pledge' ? 'selected' : '' }}>Pledge</option>
                        </select>
                    </div>

                    <!-- Date Range Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-200 mb-2">From</label>
                        <input type="date" name="from" value="{{ request('from') }}"
                            class="w-full rounded-md bg-white/5 px-3 py-2 text-white text-sm" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-200 mb-2">To</label>
                        <input type="date" name="to" value="{{ request('to') }}"
                            class="w-full rounded-md bg-white/5 px-3 py-2 text-white text-sm" />
                    </div>

                    <!-- Sort By -->
                    <div>
                        <label class="block text-sm font-medium text-gray-200 mb-2">Sort By</label>
                        <select name="sort_by"
                            class="w-full rounded-md bg-white/5 px-3 py-2 text-white text-sm outline-1 -outline-offset-1 outline-white/10 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500">
                            <option value="date" {{ request('sort_by', 'date') === 'date' ? 'selected' : '' }}>Date
                            </option>
                            <option value="amount" {{ request('sort_by') === 'amount' ? 'selected' : '' }}>Amount</option>
                            <option value="encoder" {{ request('sort_by') === 'encoder' ? 'selected' : '' }}>Encoder
                            </option>
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
                                <span class="text-sm text-gray-300">Newest</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="order" value="asc"
                                    {{ request('order') === 'asc' ? 'checked' : '' }} class="w-4 h-4 accent-indigo-500" />
                                <span class="text-sm text-gray-300">Oldest</span>
                            </label>
                        </div>
                    </div>

                    <!-- Apply & Reset Buttons -->
                    <div class="flex gap-2 pt-2">
                        <button type="submit"
                            class="flex-1 rounded-md bg-indigo-600 hover:bg-indigo-500 px-4 py-2 text-white font-medium text-sm transition">Apply</button>
                        <a href="{{ route('secretary.tithes.index') }}"
                            class="flex-1 rounded-md border border-gray-600 hover:border-gray-500 px-4 py-2 text-gray-300 text-center font-medium text-sm transition">Reset</a>
                    </div>

                    <!-- Summary Stats -->
                    <div class="pt-5 border-t border-gray-600">
                        <h4 class="text-sm font-semibold text-gray-200 mb-3">Summary</h4>
                        <div class="space-y-2 text-sm text-gray-300">
                            <p>Total Records: <strong class="text-white">{{ $tithes->total() }}</strong></p>
                            <p>Total Amount: <strong class="text-white">₱{{ number_format($totalAmount, 2) }}</strong></p>
                        </div>
                    </div>
                </form>
            </aside>
        </div>
    </div>
@endsection
