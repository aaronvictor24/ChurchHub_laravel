<form action="{{ route('secretary.members.store') }}" method="POST" class="space-y-12 text-gray-200">
    @csrf

    <input type="hidden" name="church_id" value="{{ $churchId ?? '' }}">

    <div class="border-b border-white/10 pb-12">
        <h2 class="text-base font-semibold text-white">Personal Information</h2>
        <p class="mt-1 text-sm text-gray-400">Please fill out the member's details below.</p>

        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

            <div class="sm:col-span-3">
                <label class="block text-sm font-medium text-white">First Name</label>
                <input type="text" name="first_name" value="{{ old('first_name') }}" required
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white 
                    outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 
                    focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">
                @error('first_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-3">
                <label class="block text-sm font-medium text-white">Middle Name</label>
                <input type="text" name="middle_name" value="{{ old('middle_name') }}"
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white 
                    outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 
                    focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">
                @error('middle_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-3">
                <label class="block text-sm font-medium text-white">Last Name</label>
                <input type="text" name="last_name" value="{{ old('last_name') }}" required
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white 
                    outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 
                    focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">
                @error('last_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-3">
                <label class="block text-sm font-medium text-white">Suffix</label>
                <input type="text" name="suffix_name" value="{{ old('suffix_name') }}" placeholder="e.g. Jr, Sr, III"
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white 
                    outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 
                    focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">
                @error('suffix_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-3">
                <label class="block text-sm font-medium text-white">Birth Date</label>
                <input type="date" name="birth_date" value="{{ old('birth_date') }}" required
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white 
                    outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 
                    focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">
                @error('birth_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-3">
                <label class="block text-sm font-medium text-white">Gender</label>
                <select name="gender" required
                    class="mt-2 w-full appearance-none rounded-md bg-gray-800 py-1.5 pr-8 pl-3 text-base text-gray-white 
                    outline-1 -outline-offset-1 outline-white/10 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">
                    <option value="">-- Select Gender --</option>
                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
                @error('gender')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-3">
                <label class="block text-sm font-medium text-white">Contact Number</label>
                <input type="text" name="contact_number" value="{{ old('contact_number') }}" required
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white 
                    outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 
                    focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">
                @error('contact_number')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-3">
                <label class="block text-sm font-medium text-white">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white 
                    outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 
                    focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="col-span-full">
                <label class="block text-sm font-medium text-white">Address</label>
                <textarea name="address" rows="2" required
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white 
                    outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 
                    focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">{{ old('address') }}</textarea>
                @error('address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

        </div>
    </div>

    <div class="mt-6 flex items-center justify-end gap-x-6">
        <a href="{{ route('secretary.members.index') }}"
            class="text-sm font-semibold text-gray-400 hover:text-white">Cancel</a>
        <button type="submit"
            class="rounded-md bg-indigo-500 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
            Save
        </button>
    </div>
</form>
