@extends('layouts.admin')

@section('content')
    <section class="bg-gray-800 text-gray-100 p-8 rounded-xl shadow-md">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold text-white"> Secretaries</h2>
            </div>

            <a href="{{ route('admin.secretaries.create') }}"
                class="bg-blue-600 hover:bg-blue-500 text-white text-base font-semibold px-5 py-2.5 rounded-lg transition">
                Add New Secretary
            </a>
        </div>

        <div class="overflow-x-auto rounded-lg border border-gray-700">
            <table class="min-w-full divide-y divide-gray-600">
                <thead class="bg-gray-900/90">
                    <tr>
                        <th scope="col" class="py-4 px-5 text-left text-base font-semibold text-gray-100">Name</th>
                        <th scope="col" class="py-4 px-5 text-left text-base font-semibold text-gray-100">Gender</th>
                        <th scope="col" class="py-4 px-5 text-left text-base font-semibold text-gray-100">Email</th>
                        <th scope="col" class="py-4 px-5 text-left text-base font-semibold text-gray-100">Age</th>
                        <th scope="col" class="py-4 px-5 text-left text-base font-semibold text-gray-100">Contact</th>
                        <th scope="col" class="py-4 px-5 text-left text-base font-semibold text-gray-100">Address</th>
                        <th scope="col" class="py-4 px-5 text-left text-base font-semibold text-gray-100">Church</th>
                        <th scope="col" class="py-4 px-5 text-right text-base font-semibold text-gray-100">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-700 bg-gray-800">
                    @forelse ($secretaries as $s)
                        <tr class="hover:bg-gray-700/70 transition">
                            <td class="py-4 px-5 text-base font-medium text-white">
                                {{ $s->display_name }}
                            </td>
                            <td class="py-4 px-5 text-base text-gray-200">{{ $s->gender }}</td>
                            <td class="py-4 px-5 text-base text-gray-200">{{ $s->email }}</td>
                            <td class="py-4 px-5 text-base text-gray-200">{{ $s->age }}</td>
                            <td class="py-4 px-5 text-base text-gray-200">{{ $s->contact_number }}</td>
                            <td class="py-4 px-5 text-base text-gray-200">{{ $s->address }}</td>
                            <td class="py-4 px-5 text-base text-gray-200">{{ $s->church->name ?? 'N/A' }}</td>

                            <td class="py-4 px-5 text-right flex justify-end gap-3">
                                <a href="{{ route('admin.secretaries.show', $s->secretary_id) }}">
                                    <x-secondary-button class="bg-green-600 hover:bg-green-500 text-black">
                                        Members
                                    </x-secondary-button>
                                </a>

                                <a href="{{ route('admin.secretaries.edit', $s->secretary_id) }}">
                                    <x-secondary-button class="bg-yellow-500 hover:bg-yellow-400 text-white">
                                        Edit
                                    </x-secondary-button>
                                </a>

                                <form action="{{ route('admin.secretaries.destroy', $s->secretary_id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this secretary?');">
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
                            <td colspan="8" class="text-center text-gray-400 py-5 text-lg">
                                No secretaries found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
