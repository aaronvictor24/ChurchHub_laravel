<?php

namespace App\Http\Controllers\Secretary;

use App\Http\Controllers\Controller;
use App\Models\Tithe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TithesController extends Controller
{
    public function index(Request $request)
    {
        $churchId = Auth::user()->church_id;
        $query = Tithe::where('church_id', $churchId);

        // Search by member, pledger, or remarks
        if (request('q')) {
            $qTerm = request('q');
            $query->where(function ($q) use ($qTerm) {
                $q->where('remarks', 'like', "%{$qTerm}%")
                    ->orWhere('pledger_name', 'like', "%{$qTerm}%")
                    ->orWhereHas('member', function ($mq) use ($qTerm) {
                        $mq->where('first_name', 'like', "%{$qTerm}%")
                            ->orWhere('last_name', 'like', "%{$qTerm}%");
                    });
            });
        }

        // Filter by type (member vs pledge)
        if (request('type')) {
            if (request('type') === 'pledge') {
                $query->where('is_pledge', true);
            } elseif (request('type') === 'member') {
                $query->where('is_pledge', false);
            }
        }

        // Date range filter
        if (request('from') && request('to')) {
            try {
                $from = Carbon::parse(request('from'))->startOfDay()->toDateString();
                $to = Carbon::parse(request('to'))->endOfDay()->toDateString();
                $query->whereBetween('date', [$from, $to]);
            } catch (\Exception $e) {
                // ignore invalid dates
            }
        }

        // Sorting
        $sortBy = request('sort_by', 'date');
        $order = request('order', 'desc') === 'asc' ? 'asc' : 'desc';

        if ($sortBy === 'amount') {
            $query->orderBy('amount', $order);
        } elseif ($sortBy === 'encoder') {
            $query->orderByRaw("(select name from users where users.id = tbl_tithes.encoder_id) {$order}");
        } else {
            $query->orderBy('date', $order);
        }

        $tithes = $query->with(['member', 'encoder'])->paginate(10)->withQueryString();
        $totalAmount = $query->sum('amount');

        return view('secretary.financial.tithes.index', compact('tithes', 'totalAmount'));
    }

    public function create()
    {
        return view('secretary.financial.tithes.create');
    }

    public function store(Request $request)
    {
        $isPledge = $request->has('is_pledge') && $request->is_pledge == 1;

        $request->validate([
            'member_id' => $isPledge ? 'nullable' : 'required|exists:members,member_id',
            'pledger_name' => $isPledge ? 'required|string|max:255' : 'nullable',
            'mass_id' => 'nullable|exists:tbl_masses,mass_id',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'remarks' => 'nullable|string',
        ]);

        $churchId = Auth::user()->church_id;
        $encoderId = Auth::id();

        Tithe::create([
            'church_id' => $churchId,
            'member_id' => $isPledge ? null : $request->member_id,
            'is_pledge' => $isPledge,
            'pledger_name' => $isPledge ? $request->pledger_name : null,
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
        $isPledge = $request->has('is_pledge') && $request->is_pledge == 1;

        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'remarks' => 'nullable|string',
            'pledger_name' => $isPledge ? 'required|string|max:255' : 'nullable',
            'member_id' => $isPledge ? 'nullable' : 'required|exists:members,member_id',
        ]);

        $tithe->update([
            'member_id' => $isPledge ? null : $request->member_id,
            'is_pledge' => $isPledge,
            'pledger_name' => $isPledge ? $request->pledger_name : null,
            'amount' => $request->amount,
            'date' => $request->date,
            'remarks' => $request->remarks,
        ]);

        return redirect()->route('secretary.tithes.index')->with('success', 'Tithe updated successfully.');
    }

    public function destroy($id)
    {
        Tithe::destroy($id);
        return redirect()->route('secretary.tithes.index')->with('success', 'Tithe deleted.');
    }
}
