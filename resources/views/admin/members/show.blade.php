@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">👤 Member Profile</h2>
        <a href="{{ route('admin.dashboard') }}"
            class="bg-gray-100 text-gray-800 px-4 py-2 rounded-lg shadow hover:bg-gray-200 transition">
            ← Back to Dashboard
        </a>
    </div>

    <!-- Member Profile Card -->
    <div class="bg-white shadow-lg rounded-2xl p-8">
        <div class="flex items-center space-x-6 mb-6">
            <!-- Avatar Circle -->
            <div
                class="w-20 h-20 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-3xl font-bold">
                {{ strtoupper(substr($member->first_name, 0, 1)) }}
            </div>
            <div>
                <h3 class="text-2xl font-semibold text-gray-900">
                    {{ $member->first_name }} {{ $member->last_name }}
                </h3>
                <p class="text-gray-600 text-sm">Member of {{ $member->church->name ?? '—' }}</p>
            </div>
        </div>

        <!-- Info Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-gray-700">
            <div>
                <p class="text-sm text-gray-500">📌 Gender</p>
                <p class="font-medium">{{ $member->gender }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">🎂 Birth Date</p>
                <p class="font-medium">{{ \Carbon\Carbon::parse($member->birth_date)->format('M d, Y') }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">⏳ Age</p>
                <p class="font-medium">{{ $member->age }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">📧 Email</p>
                <p class="font-medium">{{ $member->email ?? '—' }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">📱 Contact</p>
                <p class="font-medium">{{ $member->contact_number ?? '—' }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">🏠 Address</p>
                <p class="font-medium">{{ $member->address ?? '—' }}</p>
            </div>

            <div class="sm:col-span-2">
                <p class="text-sm text-gray-500">✍ Added by Secretary</p>
                <p class="font-medium">{{ $member->secretary->full_name ?? '—' }}</p>

            </div>
        </div>
    </div>
@endsection
