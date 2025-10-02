@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">👤 Pastors</h2>

        <!-- Add New Pastor Button -->
        <a href="{{ route('admin.pastors.create') }}"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-500 transition">
            ➕ Add New Pastor
        </a>
    </div>

    <!-- Table Card -->
    <div class="bg-white shadow rounded-xl p-6 overflow-x-auto">
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-100 text-left text-sm font-semibold text-gray-700">
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Age</th>
                    <th class="px-4 py-3">Contact</th>
                    <th class="px-4 py-3">Address</th>
                    <th class="px-4 py-3">Date of Birth</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-600">
                @forelse ($pastors as $pastor)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">
                            {{ $pastor->first_name }} {{ $pastor->last_name }}
                        </td>
                        <td class="px-4 py-2">{{ $pastor->email }}</td>
                        <td class="px-4 py-2">{{ $pastor->age }}</td>
                        <td class="px-4 py-2">{{ $pastor->contact_number }}</td>
                        <td class="px-4 py-2">{{ $pastor->address }}</td>
                        <td class="px-4 py-2">{{ $pastor->date_of_birth }}</td>
                        <td class="px-4 py-2 flex justify-center gap-2">
                            <!-- Edit -->
                            <a href="{{ route('admin.pastors.edit', $pastor->id) }}"
                                class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                                ✏ Edit
                            </a>
                            <!-- Delete -->
                            <form action="{{ route('admin.pastors.destroy', $pastor->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this pastor?');">
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
                        <td colspan="7" class="text-center text-gray-500 py-4">
                            No pastors found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
