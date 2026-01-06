<table class="min-w-full divide-y divide-gray-600">
    <thead class="bg-gray-900/90">
        <tr>
            <th class="py-4 px-5 text-left text-base font-semibold text-gray-100">Title</th>
            <th class="py-4 px-5 text-left text-base font-semibold text-gray-100">Day</th>
            <th class="py-4 px-5 text-left text-base font-semibold text-gray-100">Time</th>
            <th class="py-4 px-5 text-left text-base font-semibold text-gray-100">Type</th>
            <th class="py-4 px-5 text-left text-base font-semibold text-gray-100">Status</th>
            <th class="py-4 px-5 text-right text-base font-semibold text-gray-100">Actions</th>
        </tr>
    </thead>

    <tbody class="divide-y divide-gray-700 bg-gray-800">
        @forelse ($masses as $mass)
            @php
                $today = \Carbon\Carbon::now()->format('l');
                $isToday = $mass->day_of_week === $today;
                $status = $isToday ? 'Ongoing' : 'Scheduled';
                $viewUrl = route('secretary.masses.show', $mass->mass_id);
            @endphp

            <tr class="hover:bg-gray-700/70 transition cursor-pointer" onclick="window.location='{{ $viewUrl }}'">
                <td class="py-4 px-5 text-base font-medium text-white">
                    {{ $mass->mass_title }}
                </td>

                <td class="py-4 px-5 text-base text-gray-200">
                    {{ $mass->day_of_week ?? \Carbon\Carbon::parse($mass->mass_date)->format('M d, Y') }}
                </td>

                <td class="py-4 px-5 text-base text-gray-200">
                    {{ \Carbon\Carbon::parse($mass->start_time)->format('h:i A') }} -
                    {{ \Carbon\Carbon::parse($mass->end_time)->format('h:i A') }}
                </td>

                <td class="py-4 px-5 text-base text-gray-200 capitalize">
                    {{ $mass->mass_type }}
                </td>

                <td class="py-4 px-5 text-base">
                    <span
                        class="px-3 py-1 rounded-full text-xs font-semibold
                    {{ $status === 'Ongoing' ? 'bg-green-600 text-white' : 'bg-blue-500 text-white' }}">
                        {{ $status }}
                    </span>
                </td>

                <td class="py-4 px-5 text-right flex justify-end gap-3">

                    <a href="{{ route('secretary.masses.edit', $mass->mass_id) }}" onclick="event.stopPropagation();">
                        <x-secondary-button class="bg-yellow-500 hover:bg-yellow-400 text-white">
                            Edit
                        </x-secondary-button>
                    </a>

                    <form action="{{ route('secretary.masses.destroy', $mass->mass_id) }}" method="POST"
                        onsubmit="event.stopPropagation(); return confirm('Are you sure you want to delete this mass schedule?');">
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
                    No mass schedules found.
                </td>
            </tr>
        @endforelse
    </tbody>

</table>


<div class="mt-6">
    {{ $masses->links() }}
</div>
