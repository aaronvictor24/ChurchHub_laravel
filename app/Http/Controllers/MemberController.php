<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Church;
use App\Models\User;
use App\Notifications\NewMemberAdded;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function index()
    {
        $query = Member::with('church');

        if (Auth::user()->role->name !== 'admin') {
            $query->where('secretary_id', Auth::user()->secretary->secretary_id);
        }

        $members = $query->orderBy('member_id', 'desc')->get();

        return view('secretary.members.index', compact('members'));
    }

    public function create()
    {
        $secretary = Auth::user()->secretary;

        $churchId = $secretary ? $secretary->church_id : null;

        return view('secretary.members.create', compact('churchId'));
    }

    public function store(Request $request)
    {
        $secretary = Auth::user();

        $validated = $request->validate([
            'first_name'      => 'required|string|max:255',
            'middle_name'     => 'nullable|string|max:255',
            'last_name'       => 'required|string|max:255',
            'suffix_name'     => 'nullable|string|max:50',
            'birth_date'      => 'required|date',
            'gender'          => 'required|string|in:Male,Female,',
            'contact_number'  => ['required', 'regex:/^\d{11}$/', 'unique:members,contact_number'],
            'email'           => 'required|email|max:255|unique:members,email',
            'address'         => 'required|string|max:500',
        ], [
            'contact_number.regex' => 'The contact number must be exactly 11 digits.',
        ]);



        $secretary = Auth::user()->secretary; // get the secretary model

        $validated['secretary_id'] = $secretary->secretary_id; // use secretary_id
        $validated['church_id'] = $secretary->church_id;



        // Compute age
        $validated['age'] = Carbon::parse($validated['birth_date'])->age;

        $member = Member::create($validated);

        // Notify admins
        $admins = User::whereHas('role', fn($q) => $q->where('name', 'admin'))->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewMemberAdded($member));
        }

        return redirect()->route('secretary.members.index')
            ->with('success', 'Member created successfully!');
    }

    public function show($member_id)
    {
        $member = Member::with(['church', 'secretary'])
            ->where('member_id', $member_id)
            ->firstOrFail();

        return view('admin.members.show', compact('member'));
    }



    public function edit(Member $member)
    {
        if (Auth::user()->role->name === 'admin') {
            $churches = Church::all();
            return view('secretary.members.edit', compact('member', 'churches'));
        } else {
            $church = Auth::user()->church; // assuming User belongsTo Church
            return view('secretary.members.edit', compact('member', 'church'));
        }
    }


    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'first_name'      => 'required|string|max:255',
            'middle_name'     => 'nullable|string|max:255',
            'last_name'       => 'required|string|max:255',
            'suffix_name'     => 'nullable|string|max:50',
            'birth_date'      => 'required|date',
            'gender'          => 'required|string|in:Male,Female',
            'contact_number'  => [
                'required',
                'regex:/^\d{11}$/',
                'unique:members,contact_number,' . $member->member_id . ',member_id'
            ],
            'email'           => 'required|email|max:255|unique:members,email,' . $member->member_id . ',member_id',
            'address'         => 'required|string|max:500',
        ], [
            'contact_number.regex' => 'The contact number must be exactly 11 digits.',
        ]);

        if (Auth::user()->role->name === 'admin') {
            $validated['church_id'] = $request->church_id; // Admin can change
        } else {
            $validated['church_id'] = Auth::user()->secretary->church_id; // Secretary cannot change
        }

        $member->update($validated);

        return redirect()->route('secretary.members.index')
            ->with('success', 'Member updated successfully!');
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('secretary.members.index')
            ->with('success', 'Member deleted successfully!');
    }
}
