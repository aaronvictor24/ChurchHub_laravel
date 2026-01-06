@extends('layouts.secretary')

@section('content')
    <div class="p-8 bg-gray-900 min-h-screen text-white">
        <h2 class="text-2xl font-bold mb-8"> Edit Event</h2>

        <div class="bg-gray-800 text-gray-200 shadow rounded-xl p-10 border border-white/10 max-w-5xl mx-auto">
            <x-form.edit-event-form :event="$event" />
        </div>

    </div>
@endsection
