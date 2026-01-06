<section class="bg-gray-800 text-gray-100 p-8 rounded-xl shadow-md">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-2xl font-bold text-white">Members</h2>

        <a href="{{ route('secretary.members.create') }}">
            <x-primary-button
                class="bg-blue-600 hover:bg-blue-500 text-white text-base font-semibold px-5 py-2.5 rounded-lg transition">
                Add New Member
            </x-primary-button>
        </a>
    </div>

    <div class="overflow-x-auto rounded-lg border border-gray-700">
        <table class="min-w-full divide-y divide-gray-600">
            <thead class="bg-gray-900/90">
                <tr>
                    <th class="py-4 px-5 text-left text-base font-semibold text-gray-100">Name</th>
                    <th class="py-4 px-5 text-left text-base font-semibold text-gray-100">Gender</th>
                    <th class="py-4 px-5 text-left text-base font-semibold text-gray-100">Age</th>
                    <th class="py-4 px-5 text-left text-base font-semibold text-gray-100">Email</th>
                    <th class="py-4 px-5 text-left text-base font-semibold text-gray-100">Contact</th>
                    <th class="py-4 px-5 text-left text-base font-semibold text-gray-100">Address</th>
                    <th class="py-4 px-5 text-left text-base font-semibold text-gray-100">Church</th>
                    <th class="py-4 px-5 text-right text-base font-semibold text-gray-100">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-700 bg-gray-800">
                @forelse ($members as $member)
                    <tr class="hover:bg-gray-700/70 transition">
                        <td class="py-4 px-5 text-base font-medium text-white">
                            {{ $member->first_name }}
                            @if (!empty($member->middle_name))
                                {{ strtoupper(substr($member->middle_name, 0, 1)) }}.
                            @endif
                            {{ $member->last_name }}
                            @if (!empty($member->suffix_name))
                                {{ $member->suffix_name }}
                            @endif
                        </td>
                        <td class="py-4 px-5 text-base text-gray-200">{{ $member->gender }}</td>
                        <td class="py-4 px-5 text-base text-gray-200">{{ $member->age ?? '—' }}</td>
                        <td class="py-4 px-5 text-base text-gray-200">{{ $member->email ?? '—' }}</td>
                        <td class="py-4 px-5 text-base text-gray-200">{{ $member->contact_number ?? '—' }}</td>
                        <td class="py-4 px-5 text-base text-gray-200">{{ $member->address ?? '—' }}</td>
                        <td class="py-4 px-5 text-base text-gray-200">{{ $member->church->name ?? '—' }}</td>

                        <td class="py-4 px-5 text-right flex justify-end gap-3">
                            <a href="{{ route('secretary.members.edit', $member->member_id) }}">
                                <x-secondary-button class="bg-yellow-500 hover:bg-yellow-400 text-white">
                                    Edit
                                </x-secondary-button>
                            </a>

                            <form action="{{ route('secretary.members.destroy', $member->member_id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this member?');">
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
                        <td colspan="9" class="text-center text-gray-400 py-5 text-lg">
                            No members found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
