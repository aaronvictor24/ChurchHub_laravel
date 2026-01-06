@extends('layouts.secretary')

@section('content')
    <div class="p-6 bg-gray-900 min-h-screen text-white">
        <h1 class="text-2xl font-bold mb-6">Finance Reports</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-gray-800 rounded-xl p-6 border border-white/10 shadow">
                <h2 class="text-lg font-semibold mb-2">Total Tithes</h2>
                <div class="text-3xl font-bold text-green-400">₱{{ number_format($totalTithes, 2) }}</div>
            </div>
            <div class="bg-gray-800 rounded-xl p-6 border border-white/10 shadow">
                <h2 class="text-lg font-semibold mb-2">Total Offerings</h2>
                <div class="text-3xl font-bold text-blue-400">₱{{ number_format($totalOfferings, 2) }}</div>
            </div>
        </div>
        <div class="bg-gray-800 rounded-xl p-6 border border-white/10 shadow text-gray-400">
            <p>Charts and export options coming soon...</p>
        </div>
    </div>
@endsection
