<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Church;
use App\Models\Pastor;
use Illuminate\Http\Request;

class ChurchController extends Controller
{
    public function index()
    {
        $churches = Church::orderBy('church_id', 'desc')->get();

        return view('admin.churches.index', compact('churches'));
    }

    public function create()
    {
        $pastors = Pastor::where('is_deleted', 0)->get();
        return view('admin.churches.create', compact('pastors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'address'   => 'required|string|max:255',
            'pastor_id' => 'nullable|exists:tbl_pastors,id',
        ]);

        Church::create($request->only(['name', 'address', 'pastor_id']));

        return redirect()->route('admin.churches.index')->with('success', 'Church created successfully!');
    }

    public function show(Church $church)
    {
        return view('admin.churches.show', compact('church'));
    }

    public function edit(Church $church)
    {
        $pastors = Pastor::where('is_deleted', 0)->get();
        return view('admin.churches.edit', compact('church', 'pastors'));
    }

    public function update(Request $request, Church $church)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $church->update($request->only(['name', 'address', 'pastor_id']));

        return redirect()->route('admin.churches.index')->with('success', 'Church updated successfully.');
    }

    public function destroy(Church $church)
    {
        $church->delete();
        return redirect()->route('admin.churches.index')->with('success', 'Church deleted successfully.');
    }
}
