<?php

namespace App\Http\Controllers\Secretary;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ExpensesController extends Controller
{
    public function index(Request $request)
    {
        $churchId = Auth::user()->church_id;
        $query = Expense::where('church_id', $churchId)->orderBy('expense_date', 'desc');

        if ($q = $request->input('q')) {
            $query->where('description', 'like', "%{$q}%");
        }

        if ($request->input('from') && $request->input('to')) {
            try {
                $from = Carbon::parse($request->input('from'))->startOfDay()->toDateString();
                $to = Carbon::parse($request->input('to'))->endOfDay()->toDateString();
                $query->whereBetween('expense_date', [$from, $to]);
            } catch (\Exception $e) {
                // ignore
            }
        }

            // compute total amount for filtered results (before pagination)
            $totalAmount = (clone $query)->sum('amount');

            $expenses = $query->with('creator')->paginate(10)->withQueryString();

        // derive purposes list from existing descriptions as a fallback
        $purposes = Expense::where('church_id', $churchId)
            ->whereNotNull('purpose')
            ->distinct()
            ->orderBy('purpose')
            ->pluck('purpose');

        // provide sensible defaults if DB has none
        $defaultPurposes = [
            'Transportation',
            'Fuel/Gas',
            'Events Equipment',
            'Food/Catering',
            'Travel Allowance',
            'Office Supplies',
            'Utilities',
            'Maintenance & Repairs',
            'Venue Rent',
            'Honoraria',
            'Printing & Stationery',
            'Communication',
            'Training/Workshops',
            'Donations/Charity',
            'Miscellaneous',
            'Other'
        ];

        $purposes = $purposes->merge($defaultPurposes)->unique()->values();

            return view('secretary.financial.expenses.index', compact('expenses', 'purposes', 'totalAmount'));
    }

    public function create()
    {
        $churchId = Auth::user()->church_id;
        $purposes = Expense::where('church_id', $churchId)
            ->whereNotNull('purpose')
            ->distinct()
            ->pluck('purpose');

        $defaultPurposes = [
            'Transportation',
            'Fuel/Gas',
            'Events Equipment',
            'Food/Catering',
            'Travel Allowance',
            'Office Supplies',
            'Utilities',
            'Maintenance & Repairs',
            'Venue Rent',
            'Honoraria',
            'Printing & Stationery',
            'Communication',
            'Training/Workshops',
            'Donations/Charity',
            'Miscellaneous',
            'Other'
        ];

        $purposes = $purposes->merge($defaultPurposes)->unique()->values();

        return view('secretary.financial.expenses.create', compact('purposes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'expense_date' => 'required|date',
            'description' => 'nullable|string',
            'purpose' => 'nullable|string',
            'requested_by' => 'nullable|string',
            'released_to' => 'nullable|string',
        ]);

        $data = $request->only(['amount', 'expense_date', 'description', 'purpose', 'requested_by', 'released_to']);
        $data['church_id'] = Auth::user()->church_id;
        $data['created_by'] = Auth::id();

        Expense::create($data);

        return redirect()->route('secretary.expenses.index')->with('success', 'Expense recorded.');
    }

    public function edit($id)
    {
        $expense = Expense::findOrFail($id);

        $churchId = Auth::user()->church_id;
        $purposes = Expense::where('church_id', $churchId)
            ->whereNotNull('purpose')
            ->distinct()
            ->pluck('purpose');

        $defaultPurposes = [
            'Transportation',
            'Fuel/Gas',
            'Events Equipment',
            'Food/Catering',
            'Travel Allowance',
            'Office Supplies',
            'Utilities',
            'Maintenance & Repairs',
            'Venue Rent',
            'Honoraria',
            'Printing & Stationery',
            'Communication',
            'Training/Workshops',
            'Donations/Charity',
            'Miscellaneous',
            'Other'
        ];

        $purposes = $purposes->merge($defaultPurposes)->unique()->values();

        return view('secretary.financial.expenses.edit', compact('expense', 'purposes'));
    }

    public function update(Request $request, $id)
    {
        $expense = Expense::findOrFail($id);


        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'expense_date' => 'required|date',
            'description' => 'nullable|string',
            'purpose' => 'nullable|string',
            'requested_by' => 'nullable|string',
            'released_to' => 'nullable|string',
        ]);

        $expense->update($request->only(['amount', 'expense_date', 'description', 'purpose', 'requested_by', 'released_to']));

        return redirect()->route('secretary.expenses.index')->with('success', 'Expense updated.');
    }

    public function destroy($id)
    {
        Expense::destroy($id);
        return redirect()->route('secretary.expenses.index')->with('success', 'Expense deleted.');
    }
}
