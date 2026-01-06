@extends('layouts.admin')

@section('content')
    <section class="bg-gray-800 text-gray-100 p-8 rounded-xl shadow-md">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold text-white"> Churches</h2>

            </div>
            <a href="{{ route('admin.churches.create') }}"
                class="bg-blue-600 hover:bg-blue-500 text-white text-base font-semibold px-5 py-2.5 rounded-lg transition">
                Add New Church
            </a>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto rounded-lg border border-gray-700">
            <table class="min-w-full divide-y divide-gray-600">
                <thead class="bg-gray-900/90">
                    <tr>
                        <th scope="col" class="py-4 px-5 text-left text-base font-semibold text-gray-100">Church Name</th>
                        <th scope="col" class="py-4 px-5 text-left text-base font-semibold text-gray-100">Address</th>
                        <th scope="col" class="py-4 px-5 text-left text-base font-semibold text-gray-100">Assigned Pastor
                        </th>
                        <th scope="col" class="py-4 px-5 text-left text-base font-semibold text-gray-100">Created At</th>
                        <th scope="col" class="py-4 px-5 text-right text-base font-semibold text-gray-100">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-700 bg-gray-800">
                    @forelse ($churches as $church)
                        <tr class="hover:bg-gray-700/70 transition">
                            <td class="py-4 px-5 text-base font-medium text-white">{{ $church->name }}</td>
                            <td class="py-4 px-5 text-base text-gray-200">{{ $church->address }}</td>
                            <td class="py-4 px-5 text-base text-gray-200">
                                {{ $church->pastor ? $church->pastor->first_name . ' ' . $church->pastor->last_name : '—' }}
                            </td>
                            <td class="py-4 px-5 text-base text-gray-300">{{ $church->created_at->format('M d, Y') }}</td>
                            <td class="py-4 px-5 text-right flex justify-end gap-3">
                                <!-- Edit -->
                                <a href="{{ route('admin.churches.edit', $church->church_id) }}"
                                    class="text-yellow-400 hover:text-yellow-300 text-base font-semibold transition">
                                    <x-secondary-button>
                                        Edit
                                    </x-secondary-button>
                                </a>
                                <!-- Delete -->
                                <form action="{{ route('admin.churches.destroy', $church->church_id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this church?');">
                                    @csrf
                                    @method('DELETE')
                                    <x-danger-button type="submit">
                                        Delete
                                    </x-danger-button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-400 py-5 text-lg">
                                No churches found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
