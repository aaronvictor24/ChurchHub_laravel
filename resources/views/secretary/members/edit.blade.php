@extends('layouts.secretary')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Edit Member</h1>

    <div class="bg-white shadow rounded-xl p-6 max-w-3xl mx-auto">
        <form action="{{ route('secretary.members.update', $member->member_id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4">

                <!-- Church -->
                <!-- Church (auto from secretary's assigned church) -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Church</label>
                    <input type="text" value="{{ $member->church->name }}" disabled
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 bg-gray-100 text-gray-700">
                    <input type="hidden" name="church_id" value="{{ $member->church_id }}">
                </div>


                <!-- First Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $member->first_name) }}" required
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm px-3 py-2
                               focus:ring-green-500 focus:border-green-500">
                    @error('first_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Middle Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Middle Name</label>
                    <input type="text" name="middle_name" value="{{ old('middle_name', $member->middle_name) }}"
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm px-3 py-2
                               focus:ring-green-500 focus:border-green-500">
                    @error('middle_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Last Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $member->last_name) }}" required
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm px-3 py-2
                               focus:ring-green-500 focus:border-green-500">
                    @error('last_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Suffix -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Suffix</label>
                    <input type="text" name="suffix_name" value="{{ old('suffix_name', $member->suffix_name) }}"
                        placeholder="e.g. Jr, Sr, III"
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm px-3 py-2
                               focus:ring-green-500 focus:border-green-500">
                    @error('suffix_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Birth Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Birth Date</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date', $member->birth_date) }}" required
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm px-3 py-2
                               focus:ring-green-500 focus:border-green-500">
                    @error('birth_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gender -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Gender</label>
                    <select name="gender" required
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm px-3 py-2
                               focus:ring-green-500 focus:border-green-500">
                        <option value="">-- Select Gender --</option>
                        <option value="Male" {{ old('gender', $member->gender) == 'Male' ? 'selected' : '' }}>Male
                        </option>
                        <option value="Female" {{ old('gender', $member->gender) == 'Female' ? 'selected' : '' }}>Female
                        </option>
                    </select>
                    @error('gender')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contact Number -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Contact Number</label>
                    <input type="text" name="contact_number"
                        value="{{ old('contact_number', $member->contact_number) }}" required
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm px-3 py-2
                               focus:ring-green-500 focus:border-green-500">
                    @error('contact_number')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $member->email) }}" required
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm px-3 py-2
                               focus:ring-green-500 focus:border-green-500">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Address</label>
                    <textarea name="address" rows="2" required
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm px-3 py-2
                               focus:ring-green-500 focus:border-green-500">{{ old('address', $member->address) }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-4">
                <a href="{{ route('secretary.members.index') }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded-lg shadow
                           hover:bg-gray-600 transition">Cancel</a>
                <button type="submit"
                    class="px-6 py-2 bg-green-600 text-white font-semibold rounded-lg shadow
                           hover:bg-green-500 transition">
                    Update
                </button>
            </div>
        </form>
    </div>
@endsection
