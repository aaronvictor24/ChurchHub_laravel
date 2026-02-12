@extends('layouts.secretary')

@section('content')
    <style>
        @media print {
            * { margin: 0; padding: 0; }
            .no-print { display: none !important; }
            body { background: white; color: black; font-family: Arial, sans-serif; line-height: 1.6; }
            .bg-gray-800, .bg-gray-800\/60, .text-white { background: white !important; color: black !important; }
            input, select, button, form, .sidebar-filters, .no-print { display: none !important; }
            .print-header { display: block !important; text-align: center; border-bottom: 2px solid #000; padding-bottom: 20px; margin-bottom: 30px; }
            .print-header-top { display:flex; justify-content:center; align-items:center; gap:20px; margin-bottom:15px; }
            .print-logo { width:70px; height:70px; display:flex; align-items:center; }
            .print-logo img { width:100%; height:100%; object-fit:contain; }
            .print-header-text { text-align:center; }
            .print-title { font-size:22px; font-weight:bold; margin:5px 0; letter-spacing:0.5px; }
            .print-subtitle { font-size:13px; margin:3px 0; color:#333; }
            .print-meta { font-size:11px; color:#555; margin-top:8px; }
            .print-meta-item { display:inline-block; margin-right:30px; }
            .print-container { display:block !important; width:100%; page-break-after:avoid; }
            aside { display:none !important; }
            main { margin-left:0 !important; padding-left:20px !important; padding-right:20px !important; }
            table { width:100%; border-collapse:collapse; margin-bottom:20px; font-size:11px; }
            th { background-color:#f3f4f6; border:1px solid #000; padding:10px 8px; text-align:left; font-weight:bold; font-size:12px; }
            td { border:1px solid #ccc; padding:8px; }
            tr:nth-child(even) { background-color:#f9fafb; }
            .print-footer { margin-top:30px; border-top:1px solid #000; padding-top:15px; font-size:11px; display:flex; justify-content:space-between; }
            .print-footer-item { flex:1; }
            .print-footer-item.center { text-align:center; }
            .print-footer-item.right { text-align:right; }
        }
        .print-header { display:none; }
    </style>

    <div class="p-6 bg-gray-900 min-h-screen text-white">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Expenses</h1>
            <div class="flex gap-2">
                <a href="{{ route('secretary.expenses.create') }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">+ Add Expense</a>
                <button onclick="window.print()"
                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded no-print">Print</button>
            </div>
        </div>

        <div class="flex gap-6">
            <main class="flex-1">
                <!-- Print Header -->
                <div class="print-header">
                    <div class="print-header-top">
                        <div class="print-logo">
                            @if (Auth::user() && Auth::user()->secretary && Auth::user()->secretary->church)
                                <img src="{{ asset('images/logo.png') }}" alt="Church Logo">
                            @endif
                        </div>
                        <div class="print-header-text">
                            <h2 class="print-title">Expenses Report</h2>
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
                <form method="GET" class="mb-4 no-print">
                    <div class="flex gap-2">
                        <input type="search" name="q" value="{{ request('q') }}" placeholder="Search expenses..."
                            class="flex-1 rounded px-3 py-3 bg-gray-800 text-white placeholder-gray-400">
                        <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">Search</button>
                    </div>
                </form>

                <div class="bg-gray-800 shadow rounded-xl p-4 no-print">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left">
                            <thead>
                                <tr class="text-sm text-gray-300">
                                    <th class="p-3">Date</th>
                                    <th class="p-3">Amount</th>
                                    <th class="p-3">Purpose</th>
                                    <th class="p-3">Requested</th>
                                    <th class="p-3">Released To</th>
                                    <th class="p-3">Details</th>
                                    <th class="p-3 no-print">Recorded By</th>
                                    <th class="p-3 no-print">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @forelse($expenses as $expense)
                                    <tr class="border-t border-gray-700">
                                        <td class="p-3 align-top">{{ $expense->expense_date }}</td>
                                        <td class="p-3 align-top">₱{{ number_format($expense->amount, 2) }}</td>
                                        <td class="p-3 align-top">{{ $expense->purpose ?? '—' }}</td>
                                        <td class="p-3 align-top">{{ $expense->requested_by ?? '—' }}</td>
                                        <td class="p-3 align-top">{{ $expense->released_to ?? '—' }}</td>
                                        <td class="p-3 align-top">{{ $expense->description ?? 'n/a' }}</td>
                                        <td class="p-3 align-top no-print">{{ $expense->creator->name ?? 'N/A' }}</td>
                                        <td class="p-3 align-top no-print">
                                            <a href="{{ route('secretary.expenses.edit', $expense->id) }}"
                                                class="text-yellow-400 mr-3">Edit</a>
                                            <form action="{{ route('secretary.expenses.destroy', $expense->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="return confirm('Delete expense?')"
                                                    class="text-red-400">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="p-6 text-center text-gray-400">No expenses recorded.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">{{ $expenses->links() }}</div>
                </div>

                <!-- Print-only table -->
                <div class="print-container" style="display:none;">
                    @if ($expenses->total() > 0)
                        <table>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Purpose</th>
                                    <th>Requested</th>
                                    <th>Released To</th>
                                    <th>Details</th>
                                    <th>Recorded By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($expenses as $expense)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($expense->expense_date)->format('M d, Y') }}</td>
                                        <td>₱{{ number_format($expense->amount, 2) }}</td>
                                        <td>{{ $expense->purpose ?? '—' }}</td>
                                        <td>{{ $expense->requested_by ?? '—' }}</td>
                                        <td>{{ $expense->released_to ?? '—' }}</td>
                                        <td>{{ $expense->description ?? '—' }}</td>
                                        <td>{{ $expense->creator->name ?? 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="print-no-data">No expenses found</div>
                    @endif
                </div>

                <!-- Print Footer -->
                <div class="print-footer">
                    <div class="print-footer-item">
                        Total Records: <strong>{{ $expenses->total() }}</strong>
                    </div>
                    <div class="print-footer-item center">
                        Total Amount: <strong>₱{{ number_format($totalAmount ?? 0, 2) }}</strong>
                    </div>
                    <div class="print-footer-item right">
                        Printed on: {{ now()->format('M d, Y') }}
                    </div>
                </div>
            </main>

            <aside class="w-80 no-print">
                <div class="bg-gray-800 rounded-xl p-4 shadow">
                    <h3 class="font-semibold mb-3">Filters</h3>
                    <form method="GET">
                        <div class="mb-3">
                            <label class="block text-sm text-gray-400 mb-1">Purpose</label>
                            <select name="purpose" class="w-full rounded px-3 py-2 bg-gray-900 text-white">
                                <option value="">All</option>
                                @foreach ($purposes as $p)
                                    <option value="{{ $p }}" {{ request('purpose') == $p ? 'selected' : '' }}>
                                        {{ $p }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="block text-sm text-gray-400 mb-1">Date Range</label>
                            <div class="flex gap-2">
                                <input type="date" name="from" value="{{ request('from') }}"
                                    class="rounded px-3 py-2 bg-gray-900 text-white w-1/2">
                                <input type="date" name="to" value="{{ request('to') }}"
                                    class="rounded px-3 py-2 bg-gray-900 text-white w-1/2">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="block text-sm text-gray-400 mb-1">Sort By</label>
                            <select name="sort" class="w-full rounded px-3 py-2 bg-gray-900 text-white">
                                <option value="date" {{ request('sort') == 'date' ? 'selected' : '' }}>Date</option>
                                <option value="amount" {{ request('sort') == 'amount' ? 'selected' : '' }}>Amount</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm text-gray-400 mb-1">Order</label>
                            <div class="flex items-center gap-3">
                                <label class="text-sm"><input type="radio" name="order" value="asc"
                                        {{ request('order') == 'asc' ? 'checked' : '' }}> Ascending</label>
                                <label class="text-sm"><input type="radio" name="order" value="desc"
                                        {{ request('order') == 'desc' || !request('order') ? 'checked' : '' }}>
                                    Descending</label>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit"
                                class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded">Apply</button>
                            <a href="{{ route('secretary.expenses.index') }}"
                                class="flex-1 bg-gray-700 hover:bg-gray-600 text-white px-3 py-2 rounded text-center">Reset</a>
                        </div>
                    </form>
                </div>
            </aside>
        </div>
    </div>
@endsection
