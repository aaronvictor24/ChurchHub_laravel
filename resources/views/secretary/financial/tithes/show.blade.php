@extends('layouts.secretary')

@section('content')
    <div class="p-6 bg-gray-900 min-h-screen text-white">
        <h1 class="text-2xl font-bold mb-6">Tithe Details</h1>
        <div class="bg-gray-800 rounded-xl p-6 border border-white/10 shadow max-w-lg mx-auto">
            <div class="mb-4">
                <span class="font-semibold">Member:</span>
                {{ $tithe->member->first_name ?? 'N/A' }} {{ $tithe->member->last_name ?? '' }}
            </div>
            <div class="mb-4">
                <span class="font-semibold">Amount:</span>
                ₱{{ number_format($tithe->amount, 2) }}
            </div>
            <div class="mb-4">
                <span class="font-semibold">Date:</span>
                {{ \Carbon\Carbon::parse($tithe->date)->format('M d, Y') }}
            </div>
            <div class="mb-4">
                <span class="font-semibold">Remarks:</span>
                {{ $tithe->remarks ?? '—' }}
            </div>
            <div class="mb-4">
                <span class="font-semibold">Encoder:</span>
                {{ $tithe->encoder->name ?? 'N/A' }}
            </div>
            <a href="{{ route('secretary.tithes.edit', $tithe->tithe_id) }}"
                class="text-yellow-400 hover:underline">Edit</a>
            <a href="{{ route('secretary.tithes.index') }}" class="ml-4 text-gray-300 hover:underline">Back</a>
        </div>
    </div>
@endsection
