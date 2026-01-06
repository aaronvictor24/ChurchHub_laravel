@extends('layouts.secretary')

@section('content')
    <div class="p-3 bg-gray-900 min-h-screen text-white">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold">Church Offerings</h1>

        </div>

        <div class="bg-gray-800 shadow rounded-xl p-10 border border-white/10">
            <x-table.offering-table :offerings="$offerings" />
        </div>
    </div>
@endsection
