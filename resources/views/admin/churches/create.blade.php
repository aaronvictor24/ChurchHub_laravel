@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-100"> Add New Church</h2>
    </div>

    <div class="bg-gray-800 text-gray-100 shadow rounded-xl p-8 max-w-4xl mx-auto border border-gray-700">
        <form action="{{ route('admin.churches.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Church Name -->
                <div>
                    <x-input-label for="name" :value="__('Church Name')" />
                    <x-text-input id="name" name="name" type="text" :value="old('name')" required
                        class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Address -->
                <div>
                    <x-input-label for="address" :value="__('Address')" />
                    <x-text-input id="address" name="address" type="text" :value="old('address')" required
                        class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>

                <!-- Assigned Pastor (span 2 cols) -->
                <div class="md:col-span-2">
                    <x-input-label for="pastor_id" :value="__('Assigned Pastor')" />
                    <select id="pastor_id" name="pastor_id"
                        class="mt-1 block w-full rounded-lg bg-gray-900 text-white border-gray-700 px-3 py-2">
                        <option value="">-- Select Pastor --</option>
                        @foreach ($pastors as $pastor)
                            <option value="{{ $pastor->id }}" {{ old('pastor_id') == $pastor->id ? 'selected' : '' }}>
                                {{ $pastor->first_name }} {{ $pastor->last_name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('pastor_id')" class="mt-2" />
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-6">
                <a href="{{ route('admin.churches.index') }}"
                    class="px-4 py-2 bg-gray-600 text-white rounded-lg shadow hover:bg-gray-500 transition">Cancel</a>
                <x-primary-button>Save Church</x-primary-button>
            </div>
        </form>
    </div>
@endsection
