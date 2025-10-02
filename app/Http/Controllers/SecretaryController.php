<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Church;
use App\Models\Member;
use App\Models\Secretary;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SecretaryController extends Controller
{
    public function index()
    {
        $secretaries = Secretary::orderBy('secretary_id', 'desc')->get(); // ✅ newest first
        return view('admin.secretaries.index', compact('secretaries'));
    }


    public function create()
    {
        $churches = Church::all();
        return view('admin.secretaries.create', compact('churches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'     => 'required|string|max:55',
            'middle_name'    => 'nullable|string|max:55',
            'last_name'      => 'required|string|max:55',
            'suffix_name'    => 'nullable|string|max:55',
            'email'          => 'required|email|unique:tbl_secretaries,email|unique:users,email',
            'contact_number' => 'required|digits:11|unique:tbl_secretaries,contact_number',
            'church_id'      => 'required|exists:tbl_churches,church_id',
            'birth_date'     => 'required|date',
            'gender'         => 'required|string',
            'address'        => 'required|string|max:255',
            'password'       => 'required|string|min:8',
        ]);

        $age = Carbon::parse($request->birth_date)->age;

        // Create secretary in tbl_secretaries
        $secretary = Secretary::create([
            'first_name'     => $request->first_name,
            'middle_name'    => $request->middle_name,
            'last_name'      => $request->last_name,
            'suffix_name'    => $request->suffix_name,
            'email'          => $request->email,
            'contact_number' => $request->contact_number,
            'church_id'      => $request->church_id,
            'birth_date'     => $request->birth_date,
            'gender'         => $request->gender,
            'address'        => $request->address,
            'age'            => $age,
            'password'       => bcrypt($request->password),
        ]);

        // Also create login account in users table
        User::create([
            'name'     => $request->first_name . ' ' . $request->last_name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role_id'  => 2, // e.g. 2 = Secretary role in your roles table
            'church_id' => $request->church_id,
        ]);

        return redirect()->route('admin.secretaries.index')->with('success', 'Secretary created successfully!');
    }

    public function edit(Secretary $secretary)
    {
        $churches = Church::all();
        return view('admin.secretaries.edit', compact('secretary', 'churches'));
    }

    public function show($id)
    {
        $secretary = Secretary::with('church')->findOrFail($id);

        // Get members added by this secretary in descending order
        $members = $secretary->members()->orderBy('created_at', 'desc')->get();

        return view('admin.secretaries.show', compact('secretary', 'members'));
    }






    public function update(Request $request, Secretary $secretary)
    {
        $request->validate([
            'first_name'     => 'required|string|max:55',
            'middle_name'    => 'nullable|string|max:55',
            'last_name'      => 'required|string|max:55',
            'suffix_name'    => 'nullable|string|max:55',
            'email' => 'required|email|unique:tbl_secretaries,email,' . $secretary->secretary_id . ',secretary_id',
            'contact_number' => 'required|digits:11|unique:tbl_secretaries,contact_number,' . $secretary->secretary_id . ',secretary_id',
            'church_id'      => 'required|exists:tbl_churches,church_id',
            'birth_date'     => 'required|date',
            'gender'         => 'required|string',
            'address'        => 'required|string|max:255',
            'password'       => 'nullable|string|min:8',
        ]);

        $age = Carbon::parse($request->birth_date)->age;

        $updateData = [
            'first_name'     => $request->first_name,
            'middle_name'    => $request->middle_name,
            'last_name'      => $request->last_name,
            'suffix_name'    => $request->suffix_name,
            'email'          => $request->email,
            'contact_number' => $request->contact_number,
            'church_id'      => $request->church_id,
            'birth_date'     => $request->birth_date,
            'gender'         => $request->gender,
            'address'        => $request->address,
            'age'            => $age,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($request->password);
        }

        $secretary->update($updateData);

        return redirect()->route('admin.secretaries.index')->with('success', 'Secretary updated successfully!');
    }

    public function destroy(Secretary $secretary)
    {
        $secretary->delete();
        return redirect()->route('admin.secretaries.index')->with('success', 'Secretary deleted successfully.');
    }
}
