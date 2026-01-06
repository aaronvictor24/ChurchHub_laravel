<?php

namespace App\Http\Controllers\Secretary;

use App\Http\Controllers\Controller;
use App\Models\Tithe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TithesController extends Controller
{
    public function index()
    {
        $churchId = Auth::user()->church_id;
        $tithes = Tithe::where('church_id', $churchId)
            ->orderBy('date', 'desc')
            ->paginate(10);
        $totalTithes = $tithes->sum('amount');
        return view('secretary.financial.tithes.index', compact('tithes', 'totalTithes'));
    }

    public function create()
    {
        return view('secretary.financial.tithes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'nullable|exists:members,member_id',
            'mass_id' => 'nullable|exists:tbl_masses,mass_id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'remarks' => 'nullable|string',
        ]);
        $churchId = Auth::user()->church_id;
        $encoderId = Auth::id();
        Tithe::create([
            'church_id' => $churchId,
            'member_id' => $request->member_id,
            'mass_id' => $request->mass_id,
            'amount' => $request->amount,
            'date' => $request->date,
            'remarks' => $request->remarks,
            'encoder_id' => $encoderId,
        ]);
        return redirect()->route('secretary.tithes.index')->with('success', 'Tithe recorded successfully.');
    }

    public function show($id)
    {
        $tithe = Tithe::with(['member', 'mass', 'encoder'])->findOrFail($id);
        return view('secretary.financial.tithes.show', compact('tithe'));
    }

    public function edit($id)
    {
        $tithe = Tithe::findOrFail($id);
        return view('secretary.financial.tithes.edit', compact('tithe'));
    }

    public function update(Request $request, $id)
    {
        $tithe = Tithe::findOrFail($id);
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'remarks' => 'nullable|string',
        ]);
        $tithe->update($request->only(['amount', 'date', 'remarks']));
        return redirect()->route('secretary.tithes.index')->with('success', 'Tithe updated successfully.');
    }

    public function destroy($id)
    {
        Tithe::destroy($id);
        return redirect()->route('secretary.tithes.index')->with('success', 'Tithe deleted.');
    }
}
