@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-100">
            Secretary: {{ $secretary->first_name }} {{ $secretary->last_name }}
        </h2>

        <a href="{{ route('admin.secretaries.index') }}"
            class="bg-gray-700 text-gray-100 px-4 py-2 rounded-xl shadow hover:bg-gray-600 transition">
            ← Back to Secretaries
        </a>
    </div>

    <p class="text-gray-400 mb-4"> Church:
        <span class="font-semibold text-gray-200">{{ $secretary->church->name ?? 'N/A' }}</span>
    </p>

    <div class="bg-gray-800 text-gray-100 shadow-xl rounded-2xl p-6 border border-gray-700">
        <h3 class="text-xl font-semibold mb-5 flex items-center gap-2">
            Members of this Church
        </h3>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-700 rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-gray-700 text-left text-sm uppercase tracking-wider text-gray-300">
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
                <tbody class="text-sm text-gray-300">
                    @forelse ($members as $m)
                        <tr class="border-b border-gray-700 hover:bg-gray-700/50 transition">
                            <td class="px-4 py-2">{{ $m->first_name }} {{ $m->last_name }}</td>
                            <td class="px-4 py-2">{{ $m->gender ?? '—' }}</td>
                            <td class="px-4 py-2">
                                {{ $m->birth_date ? \Carbon\Carbon::parse($m->birth_date)->format('M d, Y') : '—' }}
                            </td>
                            <td class="px-4 py-2">{{ $m->email ?? '—' }}</td>
                            <td class="px-4 py-2">{{ $m->age ?? '—' }}</td>
                            <td class="px-4 py-2">{{ $m->contact_number ?? '—' }}</td>
                            <td class="px-4 py-2">{{ $m->address ?? '—' }}</td>
                            <td class="px-4 py-2">
                                {{ $m->created_at ? $m->created_at->format('M d, Y') : '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-gray-500 py-6">
                                No members found for this church.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
