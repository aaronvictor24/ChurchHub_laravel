@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">👩‍💼 Secretaries</h2>

        <a href="{{ route('admin.secretaries.create') }}"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-500 transition">
            ➕ Add New Secretary
        </a>
    </div>

    <div class="bg-white shadow rounded-xl p-6 overflow-x-auto">
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-100 text-left text-sm font-semibold text-gray-700">
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Gender</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Age</th>
                    <th class="px-4 py-3">Contact</th>
                    <th class="px-4 py-3">Address</th>
                    <th class="px-4 py-3">Church</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-600">
                @forelse ($secretaries as $s)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">
                            {{ $s->display_name }}
                        </td>

                        <td class="px-4 py-2">{{ $s->gender }}</td>
                        <td class="px-4 py-2">{{ $s->email }}</td>
                        <td class="px-4 py-2">{{ $s->age }}</td>
                        <td class="px-4 py-2">{{ $s->contact_number }}</td>
                        <td class="px-4 py-2">{{ $s->address }}</td>
                        <td class="px-4 py-2">{{ $s->church->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2 flex justify-center gap-2">
                            <a href="{{ route('admin.secretaries.show', $s->secretary_id) }}"
                                class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition">
                                👥 Members
                            </a>

                            <a href="{{ route('admin.secretaries.edit', $s->secretary_id) }}"
                                class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                                ✏ Edit
                            </a>

                            <form action="{{ route('admin.secretaries.destroy', $s->secretary_id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this secretary?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-500 transition">
                                    🗑 Delete
                                </button>
                            </form>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-gray-500 py-4">
                            No secretaries found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
