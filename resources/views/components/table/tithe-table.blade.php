<table class="min-w-full divide-y divide-gray-600">
    <thead class="bg-gray-700">
        <tr>
            <th class="px-4 py-3 text-left">Member</th>
            <th class="px-4 py-3 text-left">Amount</th>
            <th class="px-4 py-3 text-left">Date</th>
            <th class="px-4 py-3 text-left">Remarks</th>
            <th class="px-4 py-3 text-left">Encoder</th>
            <th class="px-4 py-3 text-left">Actions</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-700">
        @forelse ($tithes as $tithe)
            <tr class="hover:bg-gray-700">
                <td class="px-4 py-3">{{ $tithe->member->first_name ?? 'N/A' }} {{ $tithe->member->last_name ?? '' }}
                </td>
                <td class="px-4 py-3">₱{{ number_format($tithe->amount, 2) }}</td>
                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($tithe->date)->format('M d, Y') }}</td>
                <td class="px-4 py-3">{{ $tithe->remarks ?? '—' }}</td>
                <td class="px-4 py-3">{{ $tithe->encoder->name ?? 'N/A' }}</td>
                <td class="px-4 py-3">
                    <a href="{{ route('secretary.tithes.show', $tithe->tithe_id) }}"
                        class="text-blue-400 hover:underline">View</a>
                    <a href="{{ route('secretary.tithes.edit', $tithe->tithe_id) }}"
                        class="ml-2 text-yellow-400 hover:underline">Edit</a>
                    <form action="{{ route('secretary.tithes.destroy', $tithe->tithe_id) }}" method="POST"
                        class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="ml-2 text-red-400 hover:underline"
                            onclick="return confirm('Delete this tithe?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center py-6 text-gray-400">No tithes recorded yet.</td>
            </tr>
        @endforelse
    </tbody>
</table>
<div class="mt-6">{{ $tithes->links() }}</div>
