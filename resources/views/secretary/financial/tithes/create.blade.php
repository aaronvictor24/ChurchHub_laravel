@extends('layouts.secretary')

@section('content')
    <div class="p-6 bg-gray-900 min-h-screen text-white">
        <h1 class="text-2xl font-bold mb-6">Add Tithe</h1>
        <form action="{{ route('secretary.tithes.store') }}" method="POST"
            class="bg-gray-800 rounded-xl p-6 border border-white/10 shadow max-w-lg mx-auto">
            @csrf

            <!-- This is a Pledge Checkbox -->
            <div class="mb-6 p-4 bg-blue-900/30 border border-blue-700 rounded-lg">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" id="isPledgeCheckbox" name="is_pledge" value="1"
                        class="w-5 h-5 rounded accent-blue-500" onchange="togglePledgeInput()">
                    <span class="text-sm font-semibold text-blue-200">This is a Pledge (Non-Member)</span>
                </label>
            </div>

            <!-- Member Dropdown (Hidden when pledge) -->
            <div class="mb-4" id="memberSection">
                <label class="block mb-2 font-semibold">Member</label>
                <select name="member_id" id="memberSelect" class="w-full rounded bg-gray-700 text-white p-2">
                    <option value="">-- Select Member --</option>
                    @foreach (App\Models\Member::all() as $member)
                        <option value="{{ $member->member_id }}">{{ $member->first_name }} {{ $member->last_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Pledger Name Text Input (Hidden by default) -->
            <div class="mb-4" id="pledgerSection" style="display:none;">
                <label class="block mb-2 font-semibold">Pledger Name</label>
                <input type="text" name="pledger_name" id="pledgerName"
                    class="w-full rounded bg-gray-700 text-white p-2 placeholder-gray-400"
                    placeholder="Enter pledger's full name">
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

    <script>
        function togglePledgeInput() {
            const isPledge = document.getElementById('isPledgeCheckbox').checked;
            const memberSection = document.getElementById('memberSection');
            const pledgerSection = document.getElementById('pledgerSection');
            const memberSelect = document.getElementById('memberSelect');
            const pledgerName = document.getElementById('pledgerName');

            if (isPledge) {
                memberSection.style.display = 'none';
                pledgerSection.style.display = 'block';
                memberSelect.value = '';
                memberSelect.removeAttribute('required');
                pledgerName.setAttribute('required', 'required');
            } else {
                memberSection.style.display = 'block';
                pledgerSection.style.display = 'none';
                pledgerName.value = '';
                pledgerName.removeAttribute('required');
                memberSelect.setAttribute('required', 'required');
            }
        }
    </script>
@endsection
