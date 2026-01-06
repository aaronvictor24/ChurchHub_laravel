@extends('layouts.secretary')

@section('content')
    <div class="p-6 min-h-screen bg-gray-900 text-white">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold">Add New Mass</h2>
        </div>

        <div class="bg-gray-800 text-gray-200 shadow rounded-xl p-10 border border-white/10">
            <x-form.add-mass-form :action="route('secretary.masses.store')" />
        </div>
    </div>
@endsection
