@extends('layouts.admin')

@section('content')
    <section class="bg-gray-800 text-gray-100 p-8 rounded-xl shadow-md">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold text-white"> Pastors</h2>
            </div>
            <a href="{{ route('admin.pastors.create') }}"
                class="bg-blue-600 hover:bg-blue-500 text-white text-base font-semibold px-5 py-2.5 rounded-lg transition">
                Add New Pastor
            </a>
        </div>

        <div class="overflow-x-auto rounded-lg border border-gray-700">
            <table class="min-w-full divide-y divide-gray-600">
                <thead class="bg-gray-900/90">
                    <tr>
                        <th scope="col" class="py-4 px-5 text-left text-base font-semibold text-gray-100">Name</th>
                        <th scope="col" class="py-4 px-5 text-left text-base font-semibold text-gray-100">Email</th>
                        <th scope="col" class="py-4 px-5 text-left text-base font-semibold text-gray-100">Age</th>
                        <th scope="col" class="py-4 px-5 text-left text-base font-semibold text-gray-100">Contact</th>
                        <th scope="col" class="py-4 px-5 text-left text-base font-semibold text-gray-100">Address</th>
                        <th scope="col" class="py-4 px-5 text-left text-base font-semibold text-gray-100">Date of Birth
                        </th>
                        <th scope="col" class="py-4 px-5 text-right text-base font-semibold text-gray-100">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-700 bg-gray-800">
                    @forelse ($pastors as $pastor)
                        <tr class="hover:bg-gray-700/70 transition">
                            <td class="py-4 px-5 text-base font-medium text-white">
                                {{ $pastor->first_name }} {{ $pastor->last_name }}
                            </td>
                            <td class="py-4 px-5 text-base text-gray-200">{{ $pastor->email }}</td>
                            <td class="py-4 px-5 text-base text-gray-200">{{ $pastor->age }}</td>
                            <td class="py-4 px-5 text-base text-gray-200">{{ $pastor->contact_number }}</td>
                            <td class="py-4 px-5 text-base text-gray-200">{{ $pastor->address }}</td>
                            <td class="py-4 px-5 text-base text-gray-300">{{ $pastor->date_of_birth }}</td>
                            <td class="py-4 px-5 text-right flex justify-end gap-3">
                                <!-- Edit -->
                                <a href="{{ route('admin.pastors.edit', $pastor->id) }}"
                                    class="text-yellow-400 hover:text-yellow-300 text-base font-semibold transition">
                                    <x-secondary-button>Edit</x-secondary-button>
                                </a>

                                <!-- Delete -->
                                <form action="{{ route('admin.pastors.destroy', $pastor->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this pastor?');">
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
                            <td colspan="7" class="text-center text-gray-400 py-5 text-lg">
                                No pastors found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
