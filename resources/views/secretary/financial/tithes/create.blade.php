@extends('layouts.secretary')

@section('content')
    <div class="p-6 bg-gray-900 min-h-screen text-white">
        <h1 class="text-2xl font-bold mb-6">Add Tithe</h1>
        <form action="{{ route('secretary.tithes.store') }}" method="POST"
            class="bg-gray-800 rounded-xl p-6 border border-white/10 shadow max-w-lg mx-auto">
            @csrf
            <div class="mb-4">
                <label class="block mb-2 font-semibold">Member</label>
                <select name="member_id" class="w-full rounded bg-gray-700 text-white p-2">
                    <option value="">-- Select Member --</option>
                    @foreach (App\Models\Member::all() as $member)
                        <option value="{{ $member->member_id }}">{{ $member->first_name }} {{ $member->last_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block mb-2 font-semibold">Amount</label>
                <input type="number" step="0.01" name="amount" class="w-full rounded bg-gray-700 text-white p-2"
                    required>
            </div>
            <div class="mb-4">
                <label class="block mb-2 font-semibold">Date</label>
                <input type="date" name="date" class="w-full rounded bg-gray-700 text-white p-2" required>
            </div>
            <div class="mb-4">
                <label class="block mb-2 font-semibold">Remarks</label>
                <input type="text" name="remarks" class="w-full rounded bg-gray-700 text-white p-2">
            </div>
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2.5 rounded-lg font-semibold">Save</button>
            <a href="{{ route('secretary.tithes.index') }}" class="ml-4 text-gray-300 hover:underline">Cancel</a>
        </form>
    </div>
@endsection
