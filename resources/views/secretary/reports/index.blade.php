@extends('layouts.secretary')

@section('content')
    <div class="p-8 bg-gray-900 min-h-screen text-white">
        <h1 class="text-3xl font-bold mb-8 text-center">Church Finance Report</h1>

        <form method="GET" action="{{ route('secretary.reports.finance') }}"
            class="flex flex-wrap gap-4 mb-8 items-end justify-center">
            <div>
                <button type="button" onclick="document.getElementById('exportModal').classList.remove('hidden')"
                    class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded">Print</button>
            </div>
            <div>
                <label class="text-sm text-gray-300">From</label>
                <input type="date" name="from" value="{{ isset($from) ? $from->toDateString() : '' }}"
                    class="block mt-1 bg-gray-800 text-white rounded p-2">
            </div>
            <div>
                <label class="text-sm text-gray-300">To</label>
                <input type="date" name="to" value="{{ isset($to) ? $to->toDateString() : '' }}"
                    class="block mt-1 bg-gray-800 text-white rounded p-2">
            </div>
            <div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
            </div>
            <div>
                <a href="{{ route('secretary.reports.finance') }}" class="text-gray-300 hover:underline">Reset</a>
            </div>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <div class="bg-gray-800 rounded-xl p-6 border border-white/10 shadow flex flex-col items-center">
                <div class="text-lg font-semibold mb-2">Total Tithes</div>
                <div class="text-2xl font-bold text-green-400">₱{{ number_format($totalTithes, 2) }}</div>
            </div>
            <div class="bg-gray-800 rounded-xl p-6 border border-white/10 shadow flex flex-col items-center">
                <div class="text-lg font-semibold mb-2">Total Offerings</div>
                <div class="text-2xl font-bold text-blue-400">₱{{ number_format($totalOfferings, 2) }}</div>
            </div>
            <div class="bg-gray-800 rounded-xl p-6 border border-white/10 shadow flex flex-col items-center">
                <div class="text-lg font-semibold mb-2">Total Expenses</div>
                <div class="text-2xl font-bold text-red-400">₱{{ number_format($totalExpenses, 2) }}</div>
            </div>
            <div class="bg-gray-800 rounded-xl p-6 border border-white/10 shadow flex flex-col items-center">
                <div class="text-lg font-semibold mb-2">Net Total</div>
                <div class="text-2xl font-bold text-yellow-400">₱{{ number_format($netTotal, 2) }}</div>
            </div>
        </div>

        <div class="flex items-center gap-4 mb-6">
            <label for="chart-interval" class="text-gray-300">Chart Interval:</label>
            <select id="chart-interval" class="bg-gray-800 text-white rounded p-2" onchange="updateFinanceChart()">
                <option value="weekly" selected>Weekly</option>
                <option value="monthly">Monthly</option>
            </select>
        </div>
        <div class="bg-gray-800 rounded-xl p-6 border border-white/10 shadow text-gray-400 mb-10">
            <canvas id="financeChart" height="120"></canvas>
        </div>

        <div id="exportModal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 hidden">
            @include('components.modals.finance-print-preview')
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Example: You should provide weekly and monthly data from the controller for dynamic switching
            const weeklyLabels = {!! json_encode($weeklyLabels ?? ($labels ?? [])) !!};
            const weeklyTithes = {!! json_encode($weeklyTitheData ?? ($titheData ?? [])) !!};
            const weeklyOfferings = {!! json_encode($weeklyOfferingData ?? ($offeringData ?? [])) !!};
            const monthlyLabels = {!! json_encode($labels ?? []) !!};
            const monthlyTithes = {!! json_encode($titheData ?? []) !!};
            const monthlyOfferings = {!! json_encode($offeringData ?? []) !!};

            let financeChart;

            function updateFinanceChart() {
                const interval = document.getElementById('chart-interval').value;
                let labels, tithes, offerings;
                if (interval === 'weekly') {
                    labels = weeklyLabels;
                    tithes = weeklyTithes;
                    offerings = weeklyOfferings;
                } else {
                    labels = monthlyLabels;
                    tithes = monthlyTithes;
                    offerings = monthlyOfferings;
                }
                if (financeChart) financeChart.destroy();
                const ctx = document.getElementById('financeChart').getContext('2d');
                financeChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                                label: 'Tithes',
                                data: tithes,
                                backgroundColor: 'rgba(34,197,94,0.6)'
                            },
                            {
                                label: 'Offerings',
                                data: offerings,
                                backgroundColor: 'rgba(59,130,246,0.6)'
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
            }
            document.addEventListener('DOMContentLoaded', updateFinanceChart);
        </script>
    @endsection
