<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-600">
        <thead class="bg-gray-900/90">
            <tr>
                <th class="py-4 px-5 text-left text-base font-semibold text-gray-100">Mass Title</th>
                <th class="py-4 px-5 text-left text-base font-semibold text-gray-100">Date</th>
                <th class="py-4 px-5 text-left text-base font-semibold text-gray-100">Amount</th>
                <th class="py-4 px-5 text-left text-base font-semibold text-gray-100">Remarks</th>
                <th class="py-4 px-5 text-left text-base font-semibold text-gray-100">Encoded By</th>
                <th class="py-4 px-5 text-left text-base font-semibold text-gray-100">Date Added</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-700 bg-gray-800">
            @forelse ($offerings as $offering)
                <tr class="hover:bg-gray-700/70 transition">
                    <td class="py-4 px-5 text-base font-medium text-white">{{ $offering->mass->mass_title }}</td>
                    <td class="py-4 px-5 text-base text-gray-200">
                        {{ \Carbon\Carbon::parse($offering->mass->mass_date)->format('F d, Y') }}</td>
                    <td class="py-4 px-5 text-base text-gray-200">₱{{ number_format($offering->amount, 2) }}</td>
                    <td class="py-4 px-5 text-base text-gray-200">{{ $offering->remarks ?? 'N/A' }}</td>
                    <td class="py-4 px-5 text-base text-gray-200">{{ $offering->encoder->name ?? 'N/A' }}</td>
                    <td class="py-4 px-5 text-base text-gray-200">{{ $offering->created_at->format('F d, Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-gray-400 py-5 text-lg">
                        No offerings recorded yet.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-6">
        {{ $offerings->links() }}
    </div>
</div>
