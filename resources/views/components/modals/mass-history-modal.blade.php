<div x-show="showHistory" x-transition @keydown.escape.window="showHistory = false"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/60">
    <div @click.away="showHistory = false"
        class="bg-gray-900 rounded-xl shadow-xl w-full max-w-4xl p-6 border border-white/10">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold">Mass History</h2>

            <button @click="showHistory = false" class="text-gray-400 hover:text-white text-2xl leading-none">
                &times;
            </button>
        </div>

        {{-- Table --}}
        <table class="min-w-full divide-y divide-gray-600">
            <thead class="bg-gray-800">
                <tr>
                    <th class="px-4 py-3 text-left">Title</th>
                    <th class="px-4 py-3 text-left">Date</th>
                    <th class="px-4 py-3 text-left">Time</th>
                    <th class="px-4 py-3 text-left">Type</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-700">
                @forelse ($masses as $mass)
                    <tr class="hover:bg-gray-700 cursor-pointer"
                        onclick="window.location='{{ route('secretary.masses.show', $mass->mass_id) }}'">
                        <td class="px-4 py-3">{{ $mass->mass_title }}</td>
                        <td class="px-4 py-3">
                            {{ \Carbon\Carbon::parse($mass->mass_date)->format('M d, Y') }}
                        </td>
                        <td class="px-4 py-3">
                            {{ \Carbon\Carbon::parse($mass->start_time)->format('h:i A') }}
                        </td>
                        <td class="px-4 py-3 capitalize">{{ $mass->mass_type }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-6 text-gray-400">
                            No past masses found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
