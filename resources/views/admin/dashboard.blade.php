@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-100"> Welcome Back Admin</h2>
    </div>

    <section class="bg-gray-800 text-gray-100 p-6 rounded-xl shadow-md mb-10">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold">Pinned Modules</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('admin.churches.index') }}"
                class="flex items-center justify-between bg-gray-900 rounded-lg p-4 border border-gray-700 hover:bg-gray-700 transition">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-blue-600 text-white font-bold">
                        CH
                    </div>
                    <div>
                        <p class="font-semibold text-white">Churches</p>
                        <p class="text-sm text-gray-400">Manage branches</p>
                    </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5 text-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm6 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm6 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                </svg>
            </a>

            <a href="{{ route('admin.pastors.index') }}"
                class="flex items-center justify-between bg-gray-900 rounded-lg p-4 border border-gray-700 hover:bg-gray-700 transition">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-purple-600 text-white font-bold">
                        PS
                    </div>
                    <div>
                        <p class="font-semibold text-white">Pastors</p>
                        <p class="text-sm text-gray-400">View & manage</p>
                    </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5 text-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm6 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm6 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                </svg>
            </a>

            <a href="{{ route('admin.secretaries.index') }}"
                class="flex items-center justify-between bg-gray-900 rounded-lg p-4 border border-gray-700 hover:bg-gray-700 transition">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-pink-600 text-white font-bold">
                        SC
                    </div>
                    <div>
                        <p class="font-semibold text-white">Secretaries</p>
                        <p class="text-sm text-gray-400">Manage staff</p>
                    </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5 text-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm6 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm6 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                </svg>
            </a>

            <div class="flex items-center justify-between bg-gray-900 rounded-lg p-4 border border-gray-700">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-green-600 text-white font-bold">
                        MB
                    </div>
                    <div>
                        <p class="font-semibold text-white">Members</p>
                        <p class="text-sm text-gray-400">Total Registered</p>
                        <p class="mt-2 text-2xl font-bold text-green-400">{{ $totalMembers }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-gray-800 text-gray-100 p-6 rounded-xl shadow-md">
        <h3 class="text-lg font-semibold mb-4">Recent Notifications</h3>
        <ul class="divide-y divide-gray-700">
            @forelse(auth()->user()->notifications as $notification)
                <li
                    class="py-3 flex justify-between items-center
                    {{ is_null($notification->read_at) ? 'bg-green-950/30 border-l-4 border-green-400 shadow-sm' : 'bg-gray-900' }} 
                    rounded-lg px-4 mb-2 hover:shadow-md transition">
                    <div class="flex flex-col space-y-1">
                        <span class="text-gray-100">{!! $notification->data['message'] !!}</span>
                        <span class="text-sm text-gray-400">Added by:
                            {{ $notification->data['secretary'] ?? 'Unknown Secretary' }}</span>
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
                                <button type="submit" class="text-green-400 hover:text-green-300 text-sm font-semibold">
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
                                class="text-red-400 hover:text-red-300 px-2 py-1 rounded transition" title="Delete">
                                delete
                            </button>
                        </form>
                    </div>
                </li>
            @empty
                <li class="py-2 text-gray-500 text-center">No new notifications.</li>
            @endforelse
        </ul>
    </section>
@endsection
