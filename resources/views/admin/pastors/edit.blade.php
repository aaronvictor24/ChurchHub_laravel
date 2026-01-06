@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-100"> Edit Pastor</h2>
    </div>

    <!-- Form Card -->
    <div class="bg-gray-800 text-gray-100 shadow-xl rounded-xl p-8 max-w-4xl mx-auto border border-gray-700">
        <form action="{{ route('admin.pastors.update', $pastor->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- First Name -->
                <div>
                    <x-input-label for="first_name" :value="__('First Name')" />
                    <x-text-input id="first_name" name="first_name" type="text" :value="old('first_name', $pastor->first_name)" required
                        class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                </div>

                <!-- Middle Name -->
                <div>
                    <x-input-label for="middle_name" :value="__('Middle Name')" />
                    <x-text-input id="middle_name" name="middle_name" type="text" :value="old('middle_name', $pastor->middle_name)"
                        class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
                </div>

                <!-- Last Name -->
                <div>
                    <x-input-label for="last_name" :value="__('Last Name')" />
                    <x-text-input id="last_name" name="last_name" type="text" :value="old('last_name', $pastor->last_name)" required
                        class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                </div>

                <!-- Suffix -->
                <div>
                    <x-input-label for="suffix_name" :value="__('Suffix')" />
                    <x-text-input id="suffix_name" name="suffix_name" type="text" :value="old('suffix_name', $pastor->suffix_name)"
                        class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('suffix_name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="email" :value="old('email', $pastor->email)" required
                        class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Contact -->
                <div>
                    <x-input-label for="contact_number" :value="__('Contact Number')" />
                    <x-text-input id="contact_number" name="contact_number" type="text" :value="old('contact_number', $pastor->contact_number)" required
                        class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('contact_number')" class="mt-2" />
                </div>

                <!-- Birth Date -->
                <div>
                    <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                    <x-text-input id="date_of_birth" name="date_of_birth" type="date" :value="old('date_of_birth', $pastor->date_of_birth)" required
                        class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                </div>

                <!-- Gender -->
                <div>
                    <x-input-label for="gender" :value="__('Gender')" />
                    <select id="gender" name="gender" required
                        class="mt-1 block w-full rounded-lg bg-gray-900 text-white border-gray-700 px-3 py-2 focus:border-indigo-500 focus:ring focus:ring-indigo-500/50 focus:outline-none">
                        <option value="">-- Select Gender --</option>
                        <option value="Male" {{ old('gender', $pastor->gender) == 'Male' ? 'selected' : '' }}>Male
                        </option>
                        <option value="Female" {{ old('gender', $pastor->gender) == 'Female' ? 'selected' : '' }}>Female
                        </option>
                        <option value="Other" {{ old('gender', $pastor->gender) == 'Other' ? 'selected' : '' }}>Other
                        </option>
                    </select>
                    <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                </div>

                <!-- Address -->
                <div class="md:col-span-2">
                    <x-input-label for="address" :value="__('Address')" />
                    <textarea id="address" name="address" rows="2" required
                        class="mt-1 block w-full rounded-lg bg-gray-900 text-white border-gray-700 px-3 py-2 focus:border-indigo-500 focus:ring focus:ring-indigo-500/50 focus:outline-none">{{ old('address', $pastor->address) }}</textarea>
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-4 mt-6">
                <a href="{{ route('admin.pastors.index') }}">
                    <x-secondary-button>Cancel</x-secondary-button>
                </a>

                <x-primary-button>Update Pastor</x-primary-button>
            </div>
        </form>
    </div>
@endsection
