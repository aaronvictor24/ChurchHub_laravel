@extends('layouts.admin')

@section('content')
    <div class="bg-gray-800 border border-white/10 rounded-xl p-8 shadow-xl">
        <!-- Header -->
        <div class="px-4 sm:px-0">
            <h3 class="text-2xl font-semibold text-white">Member Information</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-400">Details and contact information.</p>
        </div>

        <!-- Details Section -->
        <div class="mt-6 border-t border-white/10">
            <dl class="divide-y divide-white/10">
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-2xl font-medium text-gray-100">Full Name</dt>
                    <dd class="mt-1 text-lg text-gray-300 sm:col-span-2 sm:mt-0">
                        {{ $member->first_name }} {{ $member->last_name }}
                    </dd>
                </div>

                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-2xl font-medium text-gray-100">Gender</dt>
                    <dd class="mt-1 text-lg text-gray-300 sm:col-span-2 sm:mt-0">
                        {{ $member->gender }}
                    </dd>
                </div>

                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-2xl font-medium text-gray-100">Birth Date</dt>
                    <dd class="mt-1 text-lg text-gray-300 sm:col-span-2 sm:mt-0">
                        {{ \Carbon\Carbon::parse($member->birth_date)->format('M d, Y') }}
                    </dd>
                </div>

                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-2xl font-medium text-gray-100">Age</dt>
                    <dd class="mt-1 text-lg text-gray-300 sm:col-span-2 sm:mt-0">
                        {{ $member->age }}
                    </dd>
                </div>

                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-2xl font-medium text-gray-100">Email</dt>
                    <dd class="mt-1 text-lg text-gray-300 sm:col-span-2 sm:mt-0">
                        {{ $member->email ?? '—' }}
                    </dd>
                </div>

                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-2xl font-medium text-gray-100">Contact Number</dt>
                    <dd class="mt-1 text-lg text-gray-300 sm:col-span-2 sm:mt-0">
                        {{ $member->contact_number ?? '—' }}
                    </dd>
                </div>

                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-2xl font-medium text-gray-100">Address</dt>
                    <dd class="mt-1 text-lg text-gray-300 sm:col-span-2 sm:mt-0">
                        {{ $member->address ?? '—' }}
                    </dd>
                </div>

                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-2xl font-medium text-gray-100">Church</dt>
                    <dd class="mt-1 text-lg text-gray-300 sm:col-span-2 sm:mt-0">
                        {{ $member->church->name ?? '—' }}
                    </dd>
                </div>

                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-2xl font-medium text-gray-100">Added By</dt>
                    <dd class="mt-1 text-lg text-gray-300 sm:col-span-2 sm:mt-0">
                        {{ $member->secretary->full_name ?? '—' }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>
@endsection
