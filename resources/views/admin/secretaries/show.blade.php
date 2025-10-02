@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            👩‍💼 Secretary: {{ $secretary->first_name }} {{ $secretary->last_name }}
        </h2>

        <a href="{{ route('admin.secretaries.index') }}"
            class="bg-gray-100 text-gray-800 px-4 py-2 rounded-lg shadow hover:bg-gray-200 transition">
            ← Back to Secretaries
        </a>
    </div>

    <p class="text-gray-600 mb-4">📍 Church: {{ $secretary->church->name ?? 'N/A' }}</p>

    <div class="bg-white shadow rounded-xl p-6">
        <h3 class="text-lg font-semibold mb-4">📋 Members of this Church</h3>

        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-100 text-left text-sm font-semibold text-gray-700">
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Gender</th>
                    <th class="px-4 py-3">Birth Date</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Age</th>
                    <th class="px-4 py-3">Contact</th>
                    <th class="px-4 py-3">Address</th>
                    <th class="px-4 py-3">Added At</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-600">
                @forelse ($members as $m)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $m->first_name }} {{ $m->last_name }}</td>
                        <td class="px-4 py-2">{{ $m->gender ?? '—' }}</td>
                        <td class="px-4 py-2">
                            {{ $m->birth_date ? \Carbon\Carbon::parse($m->birth_date)->format('M d, Y') : '—' }}</td>
                        <td class="px-4 py-2">{{ $m->email ?? '—' }}</td>
                        <td class="px-4 py-2">{{ $m->age ?? '—' }}</td>
                        <td class="px-4 py-2">{{ $m->contact_number ?? '—' }}</td>
                        <td class="px-4 py-2">{{ $m->address ?? '—' }}</td>
                        <td class="px-4 py-2">{{ $m->created_at ? $m->created_at->format('M d, Y ') : '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-gray-500 py-4">No members found for this church.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
