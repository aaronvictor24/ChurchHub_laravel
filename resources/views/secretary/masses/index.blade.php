@extends('layouts.secretary')

@section('content')
    <div x-data="{ showHistory: false }" class="p-3 bg-gray-900 min-h-screen text-white">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold">Mass Service</h1>

            <div class="flex gap-3">
                <x-secondary-button @click="showHistory = true"
                    class="bg-gray-700 hover:bg-gray-600 text-gray-200 px-5 py-2.5 rounded-lg">
                    History
                </x-secondary-button>

                <a href="{{ route('secretary.masses.create') }}">
                    <x-primary-button class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2.5 rounded-lg">
                        Add
                    </x-primary-button>
                </a>
            </div>
        </div>


        <div class="bg-gray-800 shadow rounded-xl p-10 border border-white/10">
            <x-table.mass-table :masses="$masses" />
        </div>

        <x-modals.mass-history-modal :masses="$historyMasses" />
    </div>
@endsection
