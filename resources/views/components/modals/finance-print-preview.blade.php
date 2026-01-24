<div class="bg-white rounded-lg p-6 w-full max-w-xl shadow-lg relative print:!block text-black my-8 overflow-y-auto max-h-[90vh]"
    style="min-width:340px;max-width:600px;">
    <button onclick="document.getElementById('exportModal').classList.add('hidden')"
        class="absolute top-3 right-3 text-gray-400 hover:text-black text-2xl">&times;</button>
    <div class="border border-gray-300 p-4 bg-white rounded-lg shadow-lg">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-4 border-b pb-2">
            <div>
                <h2 class="text-xl font-bold text-black">Church Finance Report</h2>
                <div class="text-gray-700 mt-1 text-sm">Church: <span class="font-semibold">
                        @if (isset($secretary) && $secretary && $secretary->church && $secretary->church->name)
                            {{ $secretary->church->name }}
                        @elseif(isset($church) && $church && $church->name)
                            {{ $church->name }}
                        @else
                            N/A
                        @endif
                    </span></div>
            </div>
            <div class="text-right mt-2 sm:mt-0">
                <div class="text-gray-700 text-xs">Period:</div>
                <div class="font-semibold text-black text-sm">
                    @if (isset($from) && isset($to) && $from && $to)
                        {{ $from->copy()->startOfWeek(1)->format('F d, Y') }} -
                        {{ $to->copy()->endOfWeek(0)->format('F d, Y') }}
                    @else
                        N/A
                    @endif
                </div>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-2 mb-4">
            <div class="bg-gray-100 rounded p-2">
                <div class="text-xs text-gray-500">Total Tithes</div>
                <div class="text-base text-green-700 font-bold">₱{{ number_format($totalTithes, 2) }}</div>
            </div>
            <div class="bg-gray-100 rounded p-2">
                <div class="text-xs text-gray-500">Total Offerings</div>
                <div class="text-base text-blue-700 font-bold">₱{{ number_format($totalOfferings, 2) }}</div>
            </div>
            <div class="bg-gray-100 rounded p-2">
                <div class="text-xs text-gray-500">Total Expenses</div>
                <div class="text-base text-red-700 font-bold">₱{{ number_format($totalExpenses, 2) }}</div>
            </div>
            <div class="bg-gray-100 rounded p-2">
                <div class="text-xs text-gray-500">Net Total</div>
                <div class="text-base text-yellow-700 font-bold">₱{{ number_format($netTotal, 2) }}</div>
            </div>
        </div>
        <h3 class="text-base font-semibold text-black mb-2 mt-4">Masses & Offerings</h3>
        <table class="w-full mb-3 border border-gray-300 text-xs">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-1 border">Mass Title</th>
                    <th class="p-1 border">Date</th>
                    <th class="p-1 border">Offerings</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($masses as $mass)
                    <tr class="hover:bg-gray-50">
                        <td class="p-1 border">{{ $mass->mass_title }}</td>
                        <td class="p-1 border">{{ $mass->mass_date }}</td>
                        <td class="p-1 border">₱{{ number_format($mass->offerings->sum('amount'), 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-1 text-center text-gray-400">No masses found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <h3 class="text-base font-semibold text-black mb-2 mt-4">Tithes</h3>
        <table class="w-full mb-3 border border-gray-300 text-xs">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-1 border">Amount</th>
                    <th class="p-1 border">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tithes as $tithe)
                    <tr class="hover:bg-gray-50">
                        <td class="p-1 border">₱{{ number_format($tithe->amount, 2) }}</td>
                        <td class="p-1 border">{{ $tithe->date }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="p-1 text-center text-gray-400">No tithes found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <h3 class="text-base font-semibold text-black mb-2 mt-4">Expenses</h3>
        <table class="w-full mb-3 border border-gray-300 text-xs">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-1 border">Amount</th>
                    <th class="p-1 border">Date</th>
                    <th class="p-1 border">Description</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($expenses as $expense)
                    <tr class="hover:bg-gray-50">
                        <td class="p-1 border">₱{{ number_format($expense->amount, 2) }}</td>
                        <td class="p-1 border">{{ $expense->expense_date }}</td>
                        <td class="p-1 border">{{ $expense->description }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-1 text-center text-gray-400">No expenses found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="flex justify-between items-end mt-6">
            <div class="text-gray-700 text-xs">
                <div class="mb-1">Prepared by:</div>
                <div class="font-semibold text-black">{{ auth()->user()->name }}</div>
                <div class="text-xs text-gray-500">Secretary</div>
            </div>
            <div class="text-gray-700 text-right text-xs">
                <div class="mb-1">Date Generated:</div>
                <div class="font-semibold text-black">{{ now()->format('F d, Y') }}</div>
            </div>
        </div>
    </div>
    <div class="flex gap-4 mt-4 justify-end">
        <button onclick="window.print()"
            class="bg-indigo-600 hover:bg-indigo-500 text-white px-3 py-1 rounded text-sm">Print</button>
        <a href="{{ route('secretary.reports.finance.export.pdf', request()->query()) }}"
            class="bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded text-sm">Export PDF</a>
    </div>
</div>
