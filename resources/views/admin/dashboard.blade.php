@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">🏠 Admin Dashboard</h2>
    </div>


    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <a href="{{ route('admin.churches.index') }}"
            class="bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow rounded-xl p-6 hover:shadow-lg transition flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold">Churches</h3>
                <p class="text-sm opacity-90">Manage branches</p>
            </div>
        </a>


        <a href="{{ route('admin.pastors.index') }}"
            class="bg-gradient-to-r from-purple-500 to-purple-600 text-white shadow rounded-xl p-6 hover:shadow-lg transition flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold">Pastors</h3>
                <p class="text-sm opacity-90">View & manage</p>
            </div>
        </a>


        <a href="{{ route('admin.secretaries.index') }}"
            class="bg-gradient-to-r from-pink-500 to-pink-600 text-white shadow rounded-xl p-6 hover:shadow-lg transition flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold">Secretaries</h3>
                <p class="text-sm opacity-90">Manage staff</p>
            </div>
        </a>


        <div
            class="bg-gradient-to-r from-green-500 to-green-600 text-white shadow rounded-xl p-6 hover:shadow-lg transition flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold">Members</h3>
                <p class="text-sm opacity-90">Total registered</p>
                <p class="mt-2 text-2xl font-bold">{{ $totalMembers }}</p>
            </div>
        </div>
    </div>


    <div class="mt-10 bg-white shadow rounded-xl p-6">
        <h3 class="text-lg font-semibold mb-4">Recent Notifications</h3>
        <ul class="divide-y">
            @forelse(auth()->user()->notifications as $notification)
                <li
                    class="py-3 flex justify-between items-center
                   {{ is_null($notification->read_at) ? 'bg-green-50 border-l-4 border-green-400 shadow-sm' : 'bg-gray-50' }} 
                   rounded-lg px-4 mb-2 hover:shadow-md transition">
                    <div class="flex flex-col space-y-1">
                        <span class="text-gray-800">
                            {!! $notification->data['message'] !!}
                        </span>
                        <span class="text-sm text-gray-500">
                            Added by: {{ $notification->data['secretary'] ?? 'Unknown Secretary' }}
                        </span>

                    </div>

                    <div class="flex items-center space-x-2">
                        @if (isset($notification->data['member_id']))
                            <a href="{{ route('admin.notifications.viewMember', $notification->id) }}"
                                class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition text-sm">
                                View Member
                            </a>
                        @endif

                        @if (is_null($notification->read_at))
                            <form action="{{ route('admin.notifications.read', $notification->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-green-600 hover:text-green-800 text-sm font-semibold">
                                    Mark as read
                                </button>
                            </form>
                        @endif
                        <form action="{{ route('admin.notifications.destroy', $notification->id) }}" method="POST"
                            class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('Are you sure you want to delete this notification?');"
                                class="dark:bg-red-300 text-red-500 hover:bg-red-200 hover:text-red-700 ml-2 px-2 py-1 rounded transition"
                                title="Delete">
                                🗑️
                            </button>


                        </form>
                    </div>
                </li>
            @empty
                <li class="py-2 text-gray-500 text-center">No new notifications.</li>
            @endforelse
        </ul>
    </div>
@endsection
