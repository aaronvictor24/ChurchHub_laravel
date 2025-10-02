<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium">First Name</label>
        <input type="text" name="first_name" value="{{ old('first_name', $member->first_name ?? '') }}"
            class="w-full border rounded px-3 py-2">
    </div>

    <div>
        <label class="block text-sm font-medium">Middle Name</label>
        <input type="text" name="middle_name" value="{{ old('middle_name', $member->middle_name ?? '') }}"
            class="w-full border rounded px-3 py-2">
    </div>

    <div>
        <label class="block text-sm font-medium">Last Name</label>
        <input type="text" name="last_name" value="{{ old('last_name', $member->last_name ?? '') }}"
            class="w-full border rounded px-3 py-2">
    </div>

    <div>
        <label class="block text-sm font-medium">Suffix</label>
        <input type="text" name="suffix_name" value="{{ old('suffix_name', $member->suffix_name ?? '') }}"
            class="w-full border rounded px-3 py-2" placeholder="e.g. Jr, Sr, III">
    </div>

    <div>
        <label class="block text-sm font-medium">Email</label>
        <input type="email" name="email" value="{{ old('email', $member->email ?? '') }}"
            class="w-full border rounded px-3 py-2">
    </div>

    <div>
        <label class="block text-sm font-medium">Contact Number</label>
        <input type="text" name="contact_number" value="{{ old('contact_number', $member->contact_number ?? '') }}"
            class="w-full border rounded px-3 py-2">
    </div>

    <div>
        <label class="block text-sm font-medium">Gender</label>
        <select name="gender" class="w-full border rounded px-3 py-2">
            <option value="">-- Select --</option>
            <option value="Male" {{ old('gender', $member->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
            <option value="Female" {{ old('gender', $member->gender ?? '') == 'Female' ? 'selected' : '' }}>Female
            </option>
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium">Date of Birth</label>
        <input type="date" name="birth_date" value="{{ old('birth_date', $member->birth_date ?? '') }}"
            class="w-full border rounded px-3 py-2">
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium">Address</label>
        <textarea name="address" class="w-full border rounded px-3 py-2">{{ old('address', $member->address ?? '') }}</textarea>
    </div>
</div>
