@extends('layouts.secretary')

@section('content')
    <div class="max-w-6xl mx-auto p-6 space-y-6">

        {{-- Mass Details --}}
        <div class="bg-gray-800 text-gray-200 shadow rounded p-6">
            <h2 class="text-2xl font-semibold mb-4">{{ $mass->mass_title ?? 'Mass Details' }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <p><span class="font-medium">Type:</span> {{ ucfirst($mass->mass_type) }}</p>
                <p><span class="font-medium">Date:</span> {{ \Carbon\Carbon::parse($mass->mass_date)->format('F j, Y') }}</p>
                <p><span class="font-medium">Start Time:</span> {{ $mass->start_time }}</p>
                <p><span class="font-medium">End Time:</span> {{ $mass->end_time }}</p>
                <p><span class="font-medium">Day of Week:</span> {{ $mass->day_of_week ?? 'N/A' }}</p>
                <p><span class="font-medium">Recurring:</span> {{ $mass->is_recurring ? 'Yes' : 'No' }}</p>
            </div>
            <p class="mt-4"><span class="font-medium">Description:</span> {{ $mass->description ?? 'N/A' }}</p>
        </div>

        {{-- Attendance Section --}}
        <div class="bg-gray-800 text-gray-200 shadow rounded p-6">
            <h3 class="text-xl font-semibold mb-4">Attendance</h3>
            <form action="{{ route('secretary.masses.updateAttendance', $mass->mass_id) }}" method="POST">
                @csrf
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-gray-700 text-gray-200">
                            <tr>
                                <th class="px-4 py-2 text-left">Member</th>
                                <th class="px-4 py-2 text-left">Attended</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-600">
                            @foreach ($members as $member)
                                <tr>
                                    <td class="px-4 py-2">{{ $member->first_name }} {{ $member->last_name }}</td>
                                    <td class="px-4 py-2">
                                        <input type="checkbox" name="attended[{{ $member->member_id }}]"
                                            {{ isset($attendances[$member->member_id]) && $attendances[$member->member_id] ? 'checked' : '' }}>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <button type="submit" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Update
                    Attendance</button>
            </form>

            <div class="mt-4 text-gray-400 text-sm">
                <p>Total Members: {{ $totalMembers }}</p>
                <p>Attended: {{ $attendedCount }}</p>
                <p>Absent: {{ $absentCount }}</p>
            </div>
        </div>

        {{-- Mass Offerings Section --}}
        <div class="bg-gray-800 text-gray-200 shadow rounded p-6">
            <h3 class="text-xl font-semibold mb-4">Offerings</h3>

            <form action="{{ route('secretary.masses.storeOffering', $mass->mass_id) }}" method="POST"
                class="mb-4 flex space-x-4">
                @csrf
                <input type="number" name="amount" placeholder="Amount"
                    class="border border-gray-600 rounded px-3 py-2 w-32 bg-gray-700 text-gray-200" step="0.01"
                    min="0">
                <input type="text" name="remarks" placeholder="Remarks"
                    class="border border-gray-600 rounded px-3 py-2 flex-1 bg-gray-700 text-gray-200">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Add
                    Offering</button>
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-700 text-gray-200">
                        <tr>
                            <th class="px-4 py-2">Amount</th>
                            <th class="px-4 py-2">Remarks</th>
                            <th class="px-4 py-2">Encoded By</th>
                            <th class="px-4 py-2">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-600">
                        @foreach ($mass->offerings as $offering)
                            <tr>
                                <td class="px-4 py-2">₱{{ number_format($offering->amount, 2) }}</td>
                                <td class="px-4 py-2">{{ $offering->remarks }}</td>
                                <td class="px-4 py-2">{{ $offering->encoder->name ?? 'N/A' }}</td>
                                <td class="px-4 py-2">{{ $offering->created_at->format('F j, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <p class="mt-4 font-medium">Total Offering: ₱{{ number_format($totalOffering, 2) }}</p>
        </div>

    </div>
@endsection
