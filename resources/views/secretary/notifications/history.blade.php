@extends('layouts.secretary')

@section('title', 'Notification History')

@section('content')
    <div class="container mx-auto py-6">
        <h2 class="text-2xl font-bold mb-4">Notification History</h2>
        <div class="bg-white shadow rounded p-4">
            <table class="min-w-full table-auto">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Message</th>
                        <th class="px-4 py-2">Type</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notifications as $notification)
                        <tr>
                            <td class="border px-4 py-2">{{ $notification->data['message'] ?? 'N/A' }}</td>
                            <td class="border px-4 py-2">{{ $notification->type ?? 'General' }}</td>
                            <td class="border px-4 py-2">
                                @if ($notification->read_at)
                                    <span class="text-green-600">Delivered</span>
                                @else
                                    <span class="text-yellow-600">Pending</span>
                                @endif
                            </td>
                            <td class="border px-4 py-2">{{ $notification->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">No notifications found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
@endsection
