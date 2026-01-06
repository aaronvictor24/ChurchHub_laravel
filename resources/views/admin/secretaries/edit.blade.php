@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-100">Edit Secretary</h2>
    </div>

    <div class="bg-gray-800 text-gray-100 shadow-xl rounded-xl p-8 max-w-4xl mx-auto border border-gray-700">
        <form action="{{ route('admin.secretaries.update', $secretary) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="first_name" :value="__('First Name')" />
                    <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $secretary->first_name)"
                        required autofocus autocomplete="off" />
                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="middle_name" :value="__('Middle Name')" />
                    <x-text-input id="middle_name" name="middle_name" type="text" class="mt-1 block w-full"
                        :value="old('middle_name', $secretary->middle_name)" autocomplete="off" />
                    <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="last_name" :value="__('Last Name')" />
                    <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name', $secretary->last_name)"
                        required autocomplete="off" />
                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="suffix_name" :value="__('Suffix Name')" />
                    <x-text-input id="suffix_name" name="suffix_name" type="text" class="mt-1 block w-full"
                        :value="old('suffix_name', $secretary->suffix_name)" autocomplete="off" />
                    <x-input-error :messages="$errors->get('suffix_name')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $secretary->email)"
                        required autocomplete="off" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="contact_number" :value="__('Contact Number')" />
                    <x-text-input id="contact_number" name="contact_number" type="text" class="mt-1 block w-full"
                        :value="old('contact_number', $secretary->contact_number)" required autocomplete="off" />
                    <x-input-error :messages="$errors->get('contact_number')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="birth_date" :value="__('Date of Birth')" />
                    <x-text-input id="birth_date" name="birth_date" type="date" class="mt-1 block w-full"
                        :value="old('birth_date', $secretary->birth_date)" required />
                    <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="gender" :value="__('Gender')" />
                    <select id="gender" name="gender"
                        class="mt-1 block w-full rounded-lg bg-gray-900 text-white border-gray-700 px-3 py-2 focus:border-indigo-500 focus:ring focus:ring-indigo-500/50 focus:outline-none">
                        <option value="Male" {{ old('gender', $secretary->gender) == 'Male' ? 'selected' : '' }}>Male
                        </option>
                        <option value="Female" {{ old('gender', $secretary->gender) == 'Female' ? 'selected' : '' }}>Female
                        </option>
                        <option value="Other" {{ old('gender', $secretary->gender) == 'Other' ? 'selected' : '' }}>Other
                        </option>
                    </select>
                    <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                </div>
                <div class="md:col-span-2">
                    <x-input-label for="address" :value="__('Address')" />
                    <textarea id="address" name="address" rows="2"
                        class="mt-1 block w-full rounded-lg bg-gray-900 text-white border-gray-700 px-3 py-2 focus:border-indigo-500 focus:ring focus:ring-indigo-500/50 focus:outline-none"
                        required>{{ old('address', $secretary->address) }}</textarea>
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>
                <div class="md:col-span-2">
                    <x-input-label for="church_id" :value="__('Assigned Church')" />
                    <select id="church_id" name="church_id"
                        class="mt-1 block w-full rounded-lg bg-gray-900 text-white border-gray-700 px-3 py-2 focus:border-indigo-500 focus:ring focus:ring-indigo-500/50 focus:outline-none">
                        <option value="">-- Select Church --</option>
                        @foreach ($churches as $church)
                            <option value="{{ $church->church_id }}"
                                {{ old('church_id', $secretary->church_id) == $church->church_id ? 'selected' : '' }}>
                                {{ $church->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('church_id')" class="mt-2" />
                </div>
                <div class="md:col-span-2">
                    <x-input-label for="password" :value="__('Password (Leave blank to keep current)')" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full"
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
            </div>
            <div class="flex justify-end gap-4 mt-6">
                <a href="{{ route('admin.secretaries.index') }}">
                    <x-secondary-button>Cancel</x-secondary-button>
                </a>

                <x-primary-button>Update Secretary</x-primary-button>
            </div>
        </form>
    </div>
@endsection
