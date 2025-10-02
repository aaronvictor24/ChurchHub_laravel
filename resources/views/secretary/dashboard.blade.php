@extends('layouts.secretary')

@section('content')
    <div class="space-y-6">

        <!-- Welcome Header -->
        <div class="bg-white rounded-lg shadow p-6 flex items-center space-x-6">
            <img src="{{ asset('images/logo.png') }}" alt="ChurchHub Logo" class="w-20 h-20 object-contain">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Welcome to ChurchHub Portal</h1>
                <p class="text-gray-600 mt-1 text-lg">Hello, {{ Auth::user()->name }}!</p>
                <p class="text-gray-500 mt-1">Quick overview of your modules and activities</p>
            </div>
        </div>

        <!-- Module Overview Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Memberships Card -->
            <a href="{{ route('secretary.members.index') }}"
                class="bg-green-100 hover:bg-green-200 transition rounded-lg shadow p-6 flex flex-col items-start">
                <div class="flex items-center space-x-3">
                    <div class="bg-green-600 text-white p-3 rounded-full">
                        👥
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Members</h2>
                </div>
                <p class="mt-4 text-gray-700">
                    Total Members: <span
                        class="font-semibold">{{ \App\Models\Member::where('secretary_id', Auth::user()->secretary->secretary_id)->count() }}</span>
                </p>
            </a>

            <!-- Events Card -->
            <a href="{{ route('secretary.events.index') }}"
                class="bg-blue-100 hover:bg-blue-200 transition rounded-lg shadow p-6 flex flex-col items-start">
                <div class="flex items-center space-x-3">
                    <div class="bg-blue-600 text-white p-3 rounded-full">
                        📅
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Events</h2>
                </div>
                <p class="mt-4 text-gray-700">
                    Upcoming Events: <span
                        class="font-semibold">{{ \App\Models\Event::where('secretary_id', Auth::user()->secretary->secretary_id)->where('event_date', '>=', now())->count() }}</span>
                </p>
            </a>

            <!-- Finance Card -->
            <a href="#"
                class="bg-yellow-100 hover:bg-yellow-200 transition rounded-lg shadow p-6 flex flex-col items-start">
                <div class="flex items-center space-x-3">
                    <div class="bg-yellow-600 text-white p-3 rounded-full">
                        💰
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Finance</h2>
                </div>
                <p class="mt-4 text-gray-700">
                    Module Coming Soon
                </p>
            </a>


            <!-- Communication Card -->
            <a href="#"
                class="bg-purple-100 hover:bg-purple-200 transition rounded-lg shadow p-6 flex flex-col items-start">
                <div class="flex items-center space-x-3">
                    <div class="bg-purple-600 text-white p-3 rounded-full">
                        📢
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Communication</h2>
                </div>
                <p class="mt-4 text-gray-700">
                    Coming Soon
                </p>
            </a>

            <!-- Reports Card -->
            <a href="#"
                class="bg-gray-100 hover:bg-gray-200 transition rounded-lg shadow p-6 flex flex-col items-start">
                <div class="flex items-center space-x-3">
                    <div class="bg-gray-600 text-white p-3 rounded-full">
                        📊
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Reports</h2>
                </div>
                <p class="mt-4 text-gray-700">
                    Generate Monthly & Annual Reports
                </p>
            </a>
        </div>

    </div>
@endsection
