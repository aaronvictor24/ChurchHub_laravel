<section class="bg-gray-800 text-gray-100 rounded-xl shadow-md no-print">

    <div class="overflow-y-auto max-h-[600px] rounded-lg border border-gray-700">
        <table class="min-w-full divide-y divide-gray-600">
            <thead class="bg-gray-900/90 sticky top-0">
                <tr>
                    <th class="py-4 px-5 text-left text-base font-semibold text-gray-100">Title</th>
                    <th class="py-4 px-5 text-left text-base font-semibold text-gray-100">Date Range</th>
                    <th class="py-4 px-5 text-left text-base font-semibold text-gray-100">Time</th>
                    <th class="py-4 px-5 text-left text-base font-semibold text-gray-100">Location</th>
                    <th class="py-4 px-5 text-left text-base font-semibold text-gray-100">Status</th>
                    <th class="py-4 px-5 text-right text-base font-semibold text-gray-100">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-700 bg-gray-800">
                @forelse ($events as $event)
                    @php
                        $startDate = \Carbon\Carbon::parse($event->start_date)->startOfDay();
                        $endDate = \Carbon\Carbon::parse($event->end_date)->endOfDay();
                        $now = \Carbon\Carbon::now();

                        if ($now->lt($startDate)) {
                            $status = 'Upcoming';
                        } elseif ($now->between($startDate, $endDate)) {
                            $status = 'Ongoing';
                        } else {
                            $status = 'Past';
                        }
                    @endphp

                    <tr class="hover:bg-gray-700/70 transition cursor-pointer"
                        onclick="if(!event.target.closest('.dropdown-menu') && !event.target.closest('button[onclick*=toggleMenu]')) window.location='{{ route('secretary.events.show', $event->event_id) }}'">

                        <td class="py-4 px-5 text-base font-medium text-white">
                            {{ $event->title }}
                        </td>

                        <td class="py-4 px-5 text-base text-gray-200">
                            {{ $startDate->format('M d, Y') }} - {{ $endDate->format('M d, Y') }}
                        </td>

                        <td class="py-4 px-5 text-base text-gray-200">
                            {{ $event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('h:i A') : '—' }}
                            -
                            {{ $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('h:i A') : '—' }}
                        </td>

                        <td class="py-4 px-5 text-base text-gray-200">
                            {{ $event->location ?? '—' }}
                        </td>

                        <td class="py-4 px-5 text-base">
                            <span
                                class="px-3 py-1 rounded-full text-xs font-semibold
                                {{ $status === 'Upcoming' ? 'bg-yellow-500 text-white' : '' }}
                                {{ $status === 'Ongoing' ? 'bg-green-600 text-white' : '' }}
                                {{ $status === 'Past' ? 'bg-gray-500 text-white' : '' }}">
                                {{ $status }}
                            </span>
                        </td>

                        <!-- ACTION BUTTONS -->
                        <td class="py-4 px-5 text-right">
                            <div class="relative inline-block">
                                <button type="button" onclick="toggleMenu(this)"
                                    class="p-2 text-gray-400 hover:text-white hover:bg-gray-700 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 16 16">
                                        <circle cx="8" cy="2.5" r="1.5"></circle>
                                        <circle cx="8" cy="8" r="1.5"></circle>
                                        <circle cx="8" cy="13.5" r="1.5"></circle>
                                    </svg>
                                </button>
                                <div
                                    class="dropdown-menu hidden absolute right-0 mt-2 w-40 bg-gray-700 rounded-lg shadow-xl z-10 border border-gray-600 overflow-hidden">
                                    <a href="{{ route('secretary.events.edit', $event->event_id) }}"
                                        class="block px-4 py-2.5 text-sm text-blue-400 hover:bg-gray-600 hover:text-blue-300 transition font-medium text-center">
                                        Edit
                                    </a>
                                    <form action="{{ route('secretary.events.destroy', $event->event_id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this event?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-full px-4 py-2.5 text-sm text-red-400 hover:bg-gray-600 hover:text-red-300 transition font-medium border-0 bg-transparent text-center">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-400 py-5 text-lg">
                            No events found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Info & Links -->
    <div class="mt-6 flex items-center justify-between px-8 pb-8">
        <div class="text-sm text-gray-400">
            @if ($events->total() > 0)
                Showing <span class="font-semibold">{{ $events->firstItem() }}</span> - <span
                    class="font-semibold">{{ $events->lastItem() }}</span> of <span
                    class="font-semibold">{{ $events->total() }}</span> events
            @else
                No events to display
            @endif
        </div>
        <div class="flex gap-1">
            {{ $events->links() }}
        </div>
    </div>
</section>

<script>
    function toggleMenu(button) {
        const menu = button.nextElementSibling;
        const isHidden = menu.classList.contains('hidden');

        // Close all other menus
        document.querySelectorAll('.dropdown-menu').forEach(m => {
            if (m !== menu) {
                m.classList.add('hidden');
            }
        });

        // Toggle current menu
        if (isHidden) {
            menu.classList.remove('hidden');
        } else {
            menu.classList.add('hidden');
        }
    }

    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
        const isButton = event.target.closest('button[onclick*="toggleMenu"]');
        const isMenu = event.target.closest('.dropdown-menu');

        if (!isButton && !isMenu) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.add('hidden');
            });
        }
    });
</script>
