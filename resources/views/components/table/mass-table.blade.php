<section class="bg-gray-800 text-gray-100 rounded-xl shadow-md no-print">

    <div class="overflow-y-auto max-h-[600px] rounded-lg border border-gray-700">
        <table class="min-w-full divide-y divide-gray-600">
            <thead class="bg-gray-900/90 sticky top-0">
                <tr>
                    <th class="py-4 px-5 text-left text-base font-semibold text-gray-100">Title</th>
                    <th class="py-4 px-5 text-left text-base font-semibold text-gray-100">Type</th>
                    <th class="py-4 px-5 text-left text-base font-semibold text-gray-100">Date</th>
                    <th class="py-4 px-5 text-left text-base font-semibold text-gray-100">Time</th>
                    <th class="py-4 px-5 text-right text-base font-semibold text-gray-100">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-700 bg-gray-800">
                @forelse ($masses as $mass)
                    <tr class="hover:bg-gray-700/70 transition cursor-pointer"
                        onclick="if(!event.target.closest('a') && !event.target.closest('button') && !event.target.closest('form')) window.location='{{ route('secretary.masses.show', $mass->mass_id) }}'">
                        <td class="py-4 px-5 text-base font-medium text-white">
                            {{ $mass->mass_title ?? ucfirst($mass->mass_type) }}
                            @if ($mass->is_recurring)
                                <span
                                    class="ml-2 inline-block px-2 py-0.5 rounded text-xs bg-amber-600 text-white">Recurring</span>
                            @endif
                        </td>
                        <td class="py-4 px-5 text-base text-gray-200 capitalize">{{ $mass->mass_type }}</td>
                        <td class="py-4 px-5 text-base text-gray-200">
                            {{ \Carbon\Carbon::parse($mass->mass_date)->format('M d, Y') }}
                        </td>
                        <td class="py-4 px-5 text-base text-gray-200">
                            {{ \Carbon\Carbon::parse($mass->start_time)->format('h:i A') }} -
                            {{ \Carbon\Carbon::parse($mass->end_time)->format('h:i A') }}
                        </td>

                        <td class="py-4 px-5 text-right">
                            <div class="flex gap-2 justify-end">
                                <a href="{{ route('secretary.masses.edit', $mass->mass_id) }}"
                                    class="inline-block px-3 py-1.5 text-sm bg-blue-600 hover:bg-blue-500 text-white rounded-md transition">
                                    Edit
                                </a>
                                <form action="{{ route('secretary.masses.destroy', $mass->mass_id) }}" method="POST"
                                    class="inline-block"
                                    onsubmit="return confirm('Are you sure you want to delete this service?');">
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
                        <td colspan="5" class="text-center text-gray-400 py-5 text-lg">
                            No services found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Info & Links -->
    <div class="mt-6 flex items-center justify-between px-8 pb-8">
        <div class="text-sm text-gray-400">
            @if ($masses->total() > 0)
                Showing <span class="font-semibold">{{ $masses->firstItem() }}</span> - <span
                    class="font-semibold">{{ $masses->lastItem() }}</span> of <span
                    class="font-semibold">{{ $masses->total() }}</span> services
            @else
                No services to display
            @endif
        </div>
        <div class="flex gap-1">
            {{ $masses->links() }}
        </div>
</section>
