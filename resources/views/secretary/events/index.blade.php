@extends('layouts.secretary')

@section('content')
    <div class="p-3 bg-gray-900 min-h-screen text-white">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold">Events</h1>

            <a href="{{ route('secretary.events.create') }}">
                <x-primary-button
                    class="bg-blue-600 hover:bg-blue-500 text-white text-base font-semibold px-5 py-2.5 rounded-lg transition">
                    Add Event
                </x-primary-button>
            </a>
        </div>

        <div class="bg-gray-800 shadow rounded-xl p-10 border border-white/10">
            <x-table.event-table :events="$events" />
        </div>

    </div>
@endsection
