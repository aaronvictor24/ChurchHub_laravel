@extends('layouts.secretary')

@section('content')
    <div class="space-y-6 container mx-auto p-6 text-gray-100 bg-gray-900 min-h-screen">

        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-white"> Event Calendar</h1>
        </div>

        <x-secretary.calendar :calendarEvents="$calendarEvents" />
    </div>
@endsection
