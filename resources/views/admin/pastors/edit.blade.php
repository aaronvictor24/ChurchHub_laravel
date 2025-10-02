@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">✏️ Edit Pastor</h2>
    </div>

    <div class="bg-white shadow rounded-xl p-6 max-w-3xl mx-auto">
        <form action="{{ route('admin.pastors.update', $pastor->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <!-- First Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $pastor->first_name) }}" required
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">

                </div>

                <!-- Middle Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Middle Name</label>
                    <input type="text" name="middle_name" value="{{ old('middle_name', $pastor->middle_name) }}"
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">

                </div>

                <!-- Last Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $pastor->last_name) }}" required
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">

                </div>

                <!-- Suffix -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Suffix Name</label>
                    <input type="text" name="suffix_name" value="{{ old('suffix_name', $pastor->suffix_name) }}"
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">

                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $pastor->email) }}" required
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">

                </div>

                <!-- Contact -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Contact Number</label>
                    <input type="text" name="contact_number" value="{{ old('contact_number', $pastor->contact_number) }}"
                        required
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">

                </div>

                <!-- Birthdate -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $pastor->date_of_birth) }}"
                        required
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">

                </div>

                <!-- Gender -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Gender</label>
                    <select name="gender" required
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="Male" {{ old('gender', $pastor->gender) == 'Male' ? 'selected' : '' }}>Male
                        </option>
                        <option value="Female" {{ old('gender', $pastor->gender) == 'Female' ? 'selected' : '' }}>Female
                        </option>
                        <option value="Other" {{ old('gender', $pastor->gender) == 'Other' ? 'selected' : '' }}>Other
                        </option>
                    </select>

                </div>

                <!-- Address -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Address</label>
                    <textarea name="address" rows="2" required
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">{{ old('address', $pastor->address) }}</textarea>

                </div>
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('admin.pastors.index') }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded-lg shadow hover:bg-gray-600 transition">Cancel</a>
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-500 transition">
                    Update Pastor
                </button>
            </div>
        </form>
    </div>
@endsection
