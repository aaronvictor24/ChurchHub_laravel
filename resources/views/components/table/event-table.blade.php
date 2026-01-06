<table class="min-w-full divide-y divide-gray-600">
    <thead class="bg-gray-900/90">
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

            <tr onclick="window.location='{{ route('secretary.events.show', $event->event_id) }}'"
                class="hover:bg-gray-700/70 transition cursor-pointer">

                <td class="py-4 px-5 text-base font-medium text-white">
                    {{ $event->title }}
                </td>

                <td class="py-4 px-5 text-base text-gray-200">
                    {{ $startDate->format('M d, Y') }} - {{ $endDate->format('M d, Y') }}
                </td>

                <td class="py-4 px-5 text-base text-gray-200">
                    {{ $event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('h:i A') : '' }}
                    -
                    {{ $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('h:i A') : '' }}
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

                <!-- ACTION BUTTONS (STOP ROW CLICK) -->
                <td class="py-4 px-5 text-right flex justify-end gap-3">

                    <a href="{{ route('secretary.events.edit', $event->event_id) }}" onclick="event.stopPropagation()">
                        <x-secondary-button class="bg-yellow-500 hover:bg-yellow-400 text-white">
                            Edit
                        </x-secondary-button>
                    </a>

                    <form action="{{ route('secretary.events.destroy', $event->event_id) }}" method="POST"
                        onsubmit="event.stopPropagation(); return confirm('Are you sure you want to delete this event?');">
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
                <td colspan="6" class="text-center text-gray-400 py-5 text-lg">
                    No events found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-6">
    {{ $events->links() }}
</div>
