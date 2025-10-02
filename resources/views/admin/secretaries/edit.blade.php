@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">✏️ Edit Secretary</h2>
    </div>



    <div class="bg-white shadow rounded-xl p-6 max-w-3xl mx-auto">
        <form action="{{ route('admin.secretaries.update', $secretary) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $secretary->first_name) }}" required
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('first_name')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Middle Name</label>
                    <input type="text" name="middle_name" value="{{ old('middle_name', $secretary->middle_name) }}"
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('middle_name')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $secretary->last_name) }}" required
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('last_name')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Suffix Name</label>
                    <input type="text" name="suffix_name" value="{{ old('suffix_name', $secretary->suffix_name) }}"
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('suffix_name')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $secretary->email) }}" required
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('email')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Contact Number</label>
                    <input type="text" name="contact_number"
                        value="{{ old('contact_number', $secretary->contact_number) }}" required
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('contact_number')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date', $secretary->birth_date) }}"
                        required
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('birth_date')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Gender</label>
                    <select name="gender" required
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="Male" {{ old('gender', $secretary->gender) == 'Male' ? 'selected' : '' }}>Male
                        </option>
                        <option value="Female" {{ old('gender', $secretary->gender) == 'Female' ? 'selected' : '' }}>Female
                        </option>
                        <option value="Other" {{ old('gender', $secretary->gender) == 'Other' ? 'selected' : '' }}>Other
                        </option>
                    </select>
                    @error('gender')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Address</label>
                    <textarea name="address" rows="2" required
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">{{ old('address', $secretary->address) }}</textarea>
                    @error('address')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Church</label>
                    <select name="church_id" required
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                        @foreach ($churches as $church)
                            <option value="{{ $church->church_id }}"
                                {{ old('church_id', $secretary->church_id) == $church->church_id ? 'selected' : '' }}>
                                {{ $church->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('church_id')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Password (leave blank to keep current)</label>
                    <input type="password" name="password"
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('password')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('admin.secretaries.index') }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded-lg shadow hover:bg-gray-600 transition">Cancel</a>
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-500 transition">
                    Update Secretary
                </button>
            </div>
        </form>
    </div>
@endsection
