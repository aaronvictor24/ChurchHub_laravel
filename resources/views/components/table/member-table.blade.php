<section class="bg-gray-800 text-gray-100 rounded-xl shadow-md no-print">

    <div class="overflow-y-auto max-h-[600px] rounded-lg border border-gray-700">
        <table class="min-w-full divide-y divide-gray-600">
            <thead class="bg-gray-900/90 sticky top-0">
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

                        <td class="py-4 px-5 text-right">
                            <div class="flex gap-2 justify-end">
                                <a href="{{ route('secretary.members.edit', $member->member_id) }}"
                                    class="inline-block px-3 py-1.5 text-sm bg-blue-600 hover:bg-blue-500 text-white rounded-md transition">
                                    Edit
                                </a>
                                <form action="{{ route('secretary.members.destroy', $member->member_id) }}"
                                    method="POST" class="inline-block"
                                    onsubmit="return confirm('Are you sure you want to delete this member?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1.5 text-sm bg-red-600 hover:bg-red-500 text-white rounded-md transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-gray-400 py-5 text-lg">
                            No members found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Info & Links -->
    <div class="mt-6 flex items-center justify-between px-8 pb-8">
        <div class="text-sm text-gray-400">
            @if ($members->total() > 0)
                Showing <span class="font-semibold">{{ $members->firstItem() }}</span> - <span
                    class="font-semibold">{{ $members->lastItem() }}</span> of <span
                    class="font-semibold">{{ $members->total() }}</span> members
            @else
                No members to display
            @endif
        </div>
        <div class="flex gap-1">
            {{ $members->links() }}
        </div>
</section>
