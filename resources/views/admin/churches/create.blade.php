@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">➕ Add New Church</h2>
    </div>

    <!-- Form Card -->
    <div class="bg-white shadow rounded-xl p-6 max-w-4xl mx-auto">
        <form action="{{ route('admin.churches.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Church Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Church Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" name="address" id="address" value="{{ old('address') }}" required
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Assigned Pastor (span 2 columns) -->
                <div class="md:col-span-2">
                    <label for="pastor_id" class="block text-sm font-medium text-gray-700">Assigned Pastor</label>
                    <select name="pastor_id" id="pastor_id"
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Select Pastor --</option>
                        @foreach ($pastors as $pastor)
                            <option value="{{ $pastor->id }}" {{ old('pastor_id') == $pastor->id ? 'selected' : '' }}>
                                {{ $pastor->first_name }} {{ $pastor->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-4 mt-4">
                <a href="{{ route('admin.churches.index') }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded-lg shadow hover:bg-gray-600 transition">Cancel</a>
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-500 transition">Save
                    Church</button>
            </div>
        </form>
    </div>
@endsection
