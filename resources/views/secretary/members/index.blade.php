@extends('layouts.secretary')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Members</h1>
        <a href="{{ route('secretary.members.create') }}"
            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-500">
            + Add Member
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full border-collapse">
            <thead class="bg-green-100">
                <tr>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Gender</th>
                    <th class="px-4 py-2 text-left">Birth Date</th>
                    <th class="px-4 py-2 text-left">Age</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">Contact</th>
                    <th class="px-4 py-2 text-left">Address</th> {{-- ✅ Added --}}
                    <th class="px-4 py-2 text-left">Church</th>
                    <th class="px-4 py-2 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($members as $member)
                    <tr class="border-t">
                        <td class="px-4 py-2">
                            {{ $member->first_name }}
                            @if (!empty($member->middle_name))
                                {{ strtoupper(substr($member->middle_name, 0, 1)) }}.
                            @endif
                            {{ $member->last_name }}
                            @if (!empty($member->suffix_name))
                                {{ $member->suffix_name }}
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $member->gender }}</td>
                        <td class="px-4 py-2">
                            @if ($member->birth_date)
                                {{ \Carbon\Carbon::parse($member->birth_date)->format('M d, Y') }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $member->age ?? '—' }}</td>
                        <td class="px-4 py-2">{{ $member->email ?? '—' }}</td>
                        <td class="px-4 py-2">{{ $member->contact_number ?? '—' }}</td>
                        <td class="px-4 py-2">{{ $member->address ?? '—' }}</td> {{-- ✅ Display address --}}
                        <td class="px-4 py-2">{{ $member->church->name ?? '—' }}</td>
                        <td class="px-4 py-2 text-right space-x-2">
                            <a href="{{ route('secretary.members.edit', $member->member_id) }}"
                                class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('secretary.members.destroy', $member->member_id) }}" method="POST"
                                class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline"
                                    onclick="return confirm('Are you sure you want to delete this member?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-4 py-2 text-center text-gray-500">
                            No members found.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>
@endsection
