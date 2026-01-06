@extends('layouts.secretary')

@section('content')
    <div class="p-8 bg-gray-900 min-h-screen text-white">
        <h1 class="text-2xl font-bold mb-5">Edit Member</h1>

        <div class="bg-gray-800 shadow rounded-xl p-10 border border-white/10">
            <x-secretary.edit-member-form :member="$member" />
        </div>
    </div>
@endsection
