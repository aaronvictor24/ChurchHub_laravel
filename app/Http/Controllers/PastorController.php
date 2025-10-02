<?php

namespace App\Http\Controllers;

use App\Models\Pastor;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PastorController extends Controller
{
    /**
     * Display a listing of pastors.
     */
    public function index()
    {
        $pastors = Pastor::where('is_deleted', 0)
            ->orderBy('id', 'desc') // ✅ newest first
            ->get();

        return view('admin.pastors.index', compact('pastors'));
    }


    /**
     * Show the form for creating a new pastor.
     */
    public function create()
    {
        return view('admin.pastors.create');
    }

    /**
     * Store a newly created pastor.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'     => 'required|string|max:55',
            'middle_name'    => 'nullable|string|max:55',
            'last_name'      => 'required|string|max:55',
            'suffix_name'    => 'nullable|string|max:55',
            'date_of_birth'  => 'required|date',
            'gender'         => 'required|string|max:10',
            'address'        => 'required|string|max:255',
            'contact_number' => 'required|digits:11|unique:tbl_pastors,contact_number',
            'email'          => 'required|email|unique:tbl_pastors,email',
        ], [
            'contact_number.digits' => 'The contact number must be exactly 11 digits.',
            'contact_number.unique' => 'This contact number is already registered.',
            'email.unique'          => 'This email is already registered.',
        ]);

        $validated['age'] = Carbon::parse($validated['date_of_birth'])->age;

        Pastor::create($validated);

        return redirect()->route('admin.pastors.index')->with('success', 'Pastor added successfully!');
    }

    /**
     * Show the form for editing a pastor.
     */
    public function edit(Pastor $pastor)
    {
        return view('admin.pastors.edit', compact('pastor'));
    }

    /**
     * Update the specified pastor.
     */
    public function update(Request $request, Pastor $pastor)
    {
        $request->validate([
            'first_name'     => 'required|string|max:55',
            'middle_name'    => 'nullable|string|max:55',
            'last_name'      => 'required|string|max:55',
            'suffix_name'    => 'nullable|string|max:55',
            'email'          => 'required|email|max:100|unique:tbl_pastors,email,' . $pastor->id,
            'contact_number' => 'required|digits:11|unique:tbl_pastors,contact_number,' . $pastor->id,
            'date_of_birth'  => 'required|date',
            'address'        => 'required|string|max:255',
        ], [
            'contact_number.digits' => 'The contact number must be exactly 11 digits.',
            'contact_number.unique' => 'This contact number is already registered.',
            'email.unique'          => 'This email is already registered.',
        ]);

        $age = Carbon::parse($request->date_of_birth)->age;

        $pastor->update([
            'first_name'     => $request->first_name,
            'middle_name'    => $request->middle_name,
            'last_name'      => $request->last_name,
            'suffix_name'    => $request->suffix_name,
            'email'          => $request->email,
            'contact_number' => $request->contact_number,
            'date_of_birth'  => $request->date_of_birth,
            'address'        => $request->address,
            'age'            => $age,
        ]);

        return redirect()->route('admin.pastors.index')->with('success', 'Pastor updated successfully.');
    }

    /**
     * Soft delete the specified pastor.
     */
    public function destroy(Pastor $pastor)
    {
        $pastor->update(['is_deleted' => 1]);

        return redirect()->route('admin.pastors.index')->with('success', 'Pastor deleted successfully!');
    }
}
