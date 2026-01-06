@extends('layouts.secretary')

@section('content')
    <div class="p-6 bg-gray-900 min-h-screen text-white">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold">Tithes</h1>
            <a href="{{ route('secretary.tithes.create') }}">
                <x-primary-button class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2.5 rounded-lg">
                    Add Tithe
                </x-primary-button>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-gray-800 rounded-xl p-6 border border-white/10 shadow">
                <h2 class="text-lg font-semibold mb-2">Total Tithes</h2>
                <div class="text-3xl font-bold text-green-400">₱{{ number_format($totalTithes, 2) }}</div>
            </div>
        </div>

        <div class="bg-gray-800 shadow rounded-xl p-6 border border-white/10">
            <x-table.tithe-table :tithes="$tithes" />
        </div>
    </div>
@endsection
