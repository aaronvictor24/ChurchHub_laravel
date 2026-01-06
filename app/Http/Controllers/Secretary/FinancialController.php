<?php

namespace App\Http\Controllers\Secretary;

use App\Http\Controllers\Controller;
use App\Models\MassOffering;
use App\Models\Tithe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FinancialController extends Controller
{
    public function exportFinanceExcel(Request $request)
    {
        $churchId = Auth::user()->church_id;
        $from = $request->input('from') ? Carbon::parse($request->input('from'))->startOfMonth() : Carbon::now()->subMonths(11)->startOfMonth();
        $to = $request->input('to') ? Carbon::parse($request->input('to'))->endOfMonth() : Carbon::now()->endOfMonth();

        $tithes = Tithe::where('church_id', $churchId)
            ->whereBetween('date', [$from->toDateString(), $to->toDateString()])
            ->get();
        $offerings = MassOffering::whereHas('mass', function ($q) use ($churchId) {
            $q->where('church_id', $churchId);
        })
            ->whereBetween('created_at', [$from->toDateTimeString(), $to->toDateTimeString()])
            ->get();

        // Use Laravel Excel to export
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\FinanceReportExport($tithes, $offerings, $from, $to), 'finance_report.xlsx');
    }

    public function exportFinancePDF(Request $request)
    {
        $churchId = Auth::user()->church_id;
        $from = $request->input('from') ? Carbon::parse($request->input('from'))->startOfMonth() : Carbon::now()->subMonths(11)->startOfMonth();
        $to = $request->input('to') ? Carbon::parse($request->input('to'))->endOfMonth() : Carbon::now()->endOfMonth();

        $tithes = Tithe::where('church_id', $churchId)
            ->whereBetween('date', [$from->toDateString(), $to->toDateString()])
            ->get();
        $offerings = MassOffering::whereHas('mass', function ($q) use ($churchId) {
            $q->where('church_id', $churchId);
        })
            ->whereBetween('created_at', [$from->toDateTimeString(), $to->toDateTimeString()])
            ->get();

        $pdf = \PDF::loadView('secretary.reports.pdf', compact('tithes', 'offerings', 'from', 'to'));
        return $pdf->download('finance_report.pdf');
    }
    // Removed duplicate method definition
    public function reports(Request $request)
    {
        $churchId = Auth::user()->church_id;

        // Default to current week (Monday to Sunday)
        if ($request->input('from') && $request->input('to')) {
            $from = Carbon::parse($request->input('from'))->startOfDay();
            $to = Carbon::parse($request->input('to'))->endOfDay();
        } else {
            $from = Carbon::now()->startOfWeek(Carbon::MONDAY);
            $to = Carbon::now()->endOfWeek(Carbon::SUNDAY);
        }

        $totalTithes = Tithe::where('church_id', $churchId)
            ->whereBetween('date', [$from->toDateString(), $to->toDateString()])
            ->sum('amount');

        $totalOfferings = MassOffering::whereHas('mass', function ($q) use ($churchId) {
            $q->where('church_id', $churchId);
        })
            ->whereBetween('created_at', [$from->toDateTimeString(), $to->toDateTimeString()])
            ->sum('amount');

        $totalExpenses = \App\Models\Expense::where('church_id', $churchId)
            ->whereBetween('expense_date', [$from->toDateString(), $to->toDateString()])
            ->sum('amount');

        $netTotal = $totalTithes + $totalOfferings - $totalExpenses;

        // Weekly chart data (Monday to Sunday)
        $weeklyLabels = [];
        $weeklyTitheData = [];
        $weeklyOfferingData = [];
        $weekStart = $from->copy()->startOfWeek(Carbon::MONDAY);
        $weekEnd = $to->copy()->endOfWeek(Carbon::SUNDAY);
        $current = $weekStart->copy();
        while ($current->lte($weekEnd)) {
            $weekLabel = $current->format('M d') . ' - ' . $current->copy()->endOfWeek(Carbon::SUNDAY)->format('M d');
            $weeklyLabels[] = $weekLabel;
            $start = $current->copy()->startOfWeek(Carbon::MONDAY)->toDateString();
            $end = $current->copy()->endOfWeek(Carbon::SUNDAY)->toDateString();
            $tithesSum = Tithe::where('church_id', $churchId)
                ->whereBetween('date', [$start, $end])
                ->sum('amount');
            $offeringsSum = MassOffering::whereHas('mass', function ($q) use ($churchId) {
                $q->where('church_id', $churchId);
            })
                ->whereBetween('created_at', [$current->copy()->startOfWeek(Carbon::MONDAY)->toDateTimeString(), $current->copy()->endOfWeek(Carbon::SUNDAY)->toDateTimeString()])
                ->sum('amount');
            $weeklyTitheData[] = (float) $tithesSum;
            $weeklyOfferingData[] = (float) $offeringsSum;
            $current->addWeek();
        }

        // Monthly chart data (for interval switching)
        $labels = [];
        $titheData = [];
        $offeringData = [];
        $current = $from->copy()->startOfMonth();
        $endMonth = $to->copy()->endOfMonth();
        while ($current->lte($endMonth)) {
            $labels[] = $current->format('M Y');
            $start = $current->copy()->startOfMonth()->toDateString();
            $end = $current->copy()->endOfMonth()->toDateString();
            $tithesSum = Tithe::where('church_id', $churchId)
                ->whereBetween('date', [$start, $end])
                ->sum('amount');
            $offeringsSum = MassOffering::whereHas('mass', function ($q) use ($churchId) {
                $q->where('church_id', $churchId);
            })
                ->whereBetween('created_at', [$current->copy()->startOfMonth()->toDateTimeString(), $current->copy()->endOfMonth()->toDateTimeString()])
                ->sum('amount');
            $titheData[] = (float) $tithesSum;
            $offeringData[] = (float) $offeringsSum;
            $current->addMonth();
        }

        // Fetch masses and their offerings for the period
        $masses = \App\Models\Mass::where('church_id', $churchId)
            ->whereBetween('mass_date', [$from->toDateString(), $to->toDateString()])
            ->with(['offerings'])
            ->get();

        // Fetch tithes for the period
        $tithes = Tithe::where('church_id', $churchId)
            ->whereBetween('date', [$from->toDateString(), $to->toDateString()])
            ->get();

        // Fetch expenses for the period
        $expenses = \App\Models\Expense::where('church_id', $churchId)
            ->whereBetween('expense_date', [$from->toDateString(), $to->toDateString()])
            ->get();

        return view('secretary.reports.index', compact(
            'totalTithes',
            'totalOfferings',
            'totalExpenses',
            'netTotal',
            'labels',
            'titheData',
            'offeringData',
            'weeklyLabels',
            'weeklyTitheData',
            'weeklyOfferingData',
            'from',
            'to',
            'masses',
            'tithes',
            'expenses'
        ));
    }
    public function offerings()
    {
        $churchId = Auth::user()->church_id;

        $offerings = MassOffering::with(['mass'])
            ->whereHas('mass', function ($query) use ($churchId) {
                $query->where('church_id', $churchId);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('secretary.financial.offerings.index', compact('offerings'));
    }
}
