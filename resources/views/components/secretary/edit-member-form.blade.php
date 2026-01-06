<form action="{{ route('secretary.members.update', $member->member_id) }}" method="POST" class="space-y-12 text-gray-200">
    @csrf
    @method('PUT')

    <input type="hidden" name="church_id" value="{{ $member->church_id }}">

    <div class="border-b border-white/10 pb-12">
        <h2 class="text-base font-semibold text-white">Personal Information</h2>
        <p class="mt-1 text-sm text-gray-400">Update the member’s details below.</p>

        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

            <!-- Church -->
            <div class="col-span-full">
                <label class="block text-sm font-medium text-white">Church</label>
                <input type="text" value="{{ $member->church->name ?? 'N/A' }}" disabled
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-gray-400 
                    outline-1 -outline-offset-1 outline-white/10 sm:text-sm cursor-not-allowed">
            </div>

            <!-- First Name -->
            <div class="sm:col-span-3">
                <label class="block text-sm font-medium text-white">First Name</label>
                <input type="text" name="first_name" value="{{ old('first_name', $member->first_name) }}" required
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white 
                    outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 
                    focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">
                @error('first_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Middle Name -->
            <div class="sm:col-span-3">
                <label class="block text-sm font-medium text-white">Middle Name</label>
                <input type="text" name="middle_name" value="{{ old('middle_name', $member->middle_name) }}"
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white 
                    outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 
                    focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">
                @error('middle_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Last Name -->
            <div class="sm:col-span-3">
                <label class="block text-sm font-medium text-white">Last Name</label>
                <input type="text" name="last_name" value="{{ old('last_name', $member->last_name) }}" required
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white 
                    outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 
                    focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">
                @error('last_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Suffix -->
            <div class="sm:col-span-3">
                <label class="block text-sm font-medium text-white">Suffix</label>
                <input type="text" name="suffix_name" value="{{ old('suffix_name', $member->suffix_name) }}"
                    placeholder="e.g. Jr, Sr, III"
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white 
                    outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 
                    focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">
                @error('suffix_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Birth Date -->
            <div class="sm:col-span-3">
                <label class="block text-sm font-medium text-white">Birth Date</label>
                <input type="date" name="birth_date" value="{{ old('birth_date', $member->birth_date) }}" required
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white 
                    outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 
                    focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">
                @error('birth_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gender -->
            <div class="sm:col-span-3">
                <label class="block text-sm font-medium text-white">Gender</label>
                <select name="gender" required
                    class="mt-2 w-full appearance-none rounded-md bg-white/5 py-1.5 pr-8 pl-3 text-base text-white 
                    outline-1 -outline-offset-1 outline-white/10 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">
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
            <div class="sm:col-span-3">
                <label class="block text-sm font-medium text-white">Contact Number</label>
                <input type="text" name="contact_number"
                    value="{{ old('contact_number', $member->contact_number) }}" required
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white 
                    outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 
                    focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">
                @error('contact_number')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="sm:col-span-3">
                <label class="block text-sm font-medium text-white">Email</label>
                <input type="email" name="email" value="{{ old('email', $member->email) }}" required
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white 
                    outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 
                    focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Address -->
            <div class="col-span-full">
                <label class="block text-sm font-medium text-white">Address</label>
                <textarea name="address" rows="2" required
                    class="mt-2 block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white 
                    outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 
                    focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm">{{ old('address', $member->address) }}</textarea>
                @error('address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

        </div>
    </div>

    <div class="mt-6 flex items-center justify-end gap-x-6">
        <a href="{{ route('secretary.members.index') }}">
            <x-secondary-button type="button" class="bg-gray-700 hover:bg-gray-600">
                Cancel
            </x-secondary-button>
        </a>
        <x-primary-button type="submit">
            Save Changes
        </x-primary-button>
    </div>
</form>
