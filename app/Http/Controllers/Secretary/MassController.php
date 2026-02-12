<?php

namespace App\Http\Controllers\Secretary;

use App\Http\Controllers\Controller;
use App\Models\Mass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class MassController extends Controller
{
    public function index(Request $request)
    {
        $churchId = Auth::user()->church_id;
        $query = Mass::where('church_id', $churchId);

        // Search functionality
        if ($request->has('q') && !empty($request->q)) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('mass_title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by mass type
        if ($request->has('type') && !empty($request->type)) {
            $query->where('mass_type', $request->type);
        }

        // Filter by recurring status
        if ($request->has('recurring') && !empty($request->recurring)) {
            $isRecurring = $request->recurring === 'yes' ? true : false;
            $query->where('is_recurring', $isRecurring);
        }

        // Sorting and ordering
        $sortField = $request->get('sort_by', 'created_at');
        $order = $request->get('order', 'desc');

        if (in_array($sortField, ['created_at', 'start_time', 'mass_title'])) {
            $query->orderBy($sortField, $order);
        } else {
            $query->latest();
        }

        // Fixed pagination at 15 items per page
        $masses = $query->paginate(15);
        $masses->appends($request->query());

        // Calculate totals for summary
        $totalQuery = Mass::where('church_id', $churchId);
        $totalMasses = $totalQuery->count();
        $recurringMasses = (clone $totalQuery)->where('is_recurring', true)->count();
        $oneTimeMasses = (clone $totalQuery)->where('is_recurring', false)->count();

        return view('secretary.masses.index', compact(
            'masses',
            'totalMasses',
            'recurringMasses',
            'oneTimeMasses'
        ));
    }

    public function create()
    {
        return view('secretary.masses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'mass_title' => 'nullable|string|max:255',
            'mass_type' => 'required|string',
            'mass_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'description' => 'nullable|string',
        ]);

        $churchId = Auth::user()->church_id;
        $startTime = $request->start_time;
        $endTime = $request->end_time;
        $massType = $request->mass_type;

        $query = Mass::where('church_id', $churchId)
            ->where(function ($q) use ($startTime, $endTime) {
                $q->where('start_time', '<', $endTime)
                    ->where('end_time', '>', $startTime);
            });

        if ($massType === 'regular') {
            $dayOfWeek = Carbon::parse($request->mass_date)->format('l');

            $query->where('is_recurring', true)
                ->where('day_of_week', $dayOfWeek);
        } else {
            $query->where('is_recurring', false)
                ->whereDate('mass_date', $request->mass_date);
        }

        if ($query->exists()) {
            return back()
                ->withErrors(['start_time' => '⚠ This time slot is already occupied by another mass.'])
                ->withInput();
        }

        $dayOfWeek = Carbon::parse($request->mass_date)->format('l');

        Mass::create([
            'church_id' => $churchId,
            'mass_title' => $request->mass_title,
            'mass_type' => $massType,
            'mass_date' => $request->mass_date,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'day_of_week' => $dayOfWeek,
            'is_recurring' => $massType === 'regular',
            'description' => $request->description,
        ]);

        return redirect()->route('secretary.masses.index')
            ->with('success', 'Mass added successfully.');
    }


    public function show(Mass $mass)
    {
        $mass->load(['attendances.member', 'offerings.encoder']);
        $members = $mass->church->members()->orderBy('last_name')->get();

        $attendances = $mass->attendances->pluck('attended', 'member_id')->toArray();
        $totalMembers = $members->count();
        $attendedCount = collect($attendances)->filter(fn($a) => $a)->count();
        $absentCount = $totalMembers - $attendedCount;

        $totalOffering = $mass->offerings->sum('amount');

        return view('secretary.masses.show', compact(
            'mass',
            'members',
            'attendances',
            'totalMembers',
            'attendedCount',
            'absentCount',
            'totalOffering'
        ));
    }


    public function edit(Mass $mass)
    {
        return view('secretary.masses.edit', compact('mass'));
    }

    public function update(Request $request, Mass $mass)
    {
        $request->validate([
            'mass_title' => 'nullable|string|max:255',
            'mass_type' => 'required|string',
            'mass_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'description' => 'nullable|string',
        ]);

        // Check for schedule conflicts (exclude current mass)
        $churchId = Auth::user()->church_id;
        $startTime = $request->start_time;
        $endTime = $request->end_time;
        $massType = $request->mass_type;

        $query = Mass::where('church_id', $churchId)
            ->where('mass_id', '!=', $mass->mass_id)
            ->where(function ($q) use ($startTime, $endTime) {
                $q->where('start_time', '<', $endTime)
                    ->where('end_time', '>', $startTime);
            });

        if ($massType === 'regular') {
            $dayOfWeek = Carbon::parse($request->mass_date)->format('l');
            $query->where('is_recurring', true)
                ->where('day_of_week', $dayOfWeek);
        } else {
            $query->where('is_recurring', false)
                ->whereDate('mass_date', $request->mass_date);
        }

        if ($query->exists()) {
            return back()
                ->withErrors(['start_time' => '⚠ This time slot is already occupied by another mass.'])
                ->withInput();
        }

        // Update computed day_of_week
        $dayOfWeek = Carbon::parse($request->mass_date)->format('l');

        $mass->update([
            'mass_title' => $request->mass_title,
            'mass_type' => $request->mass_type,
            'mass_date' => $request->mass_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'day_of_week' => $dayOfWeek,
            'is_recurring' => $request->mass_type === 'regular',
            'description' => $request->description,
        ]);

        return redirect()->route('secretary.masses.index')->with('success', 'Mass updated successfully.');
    }

    public function destroy(Mass $mass)
    {
        $mass->delete();

        return redirect()->route('secretary.masses.index')->with('success', 'Mass deleted successfully.');
    }

    public function updateAttendance(Request $request, Mass $mass)
    {
        // Prevent attendance update for future masses
        $massDT = Carbon::parse($mass->mass_date . ' ' . ($mass->start_time ?? '00:00:00'));
        if ($massDT->isFuture()) {
            return redirect()->back()->with('error', '⚠ You cannot save attendance for a future mass.');
        }

        try {
            // Get all members from the church (use relationship query to satisfy static analyzers)
            $members = $mass->church->members()->get();

            foreach ($members as $member) {
                $attended = isset($request->attended[$member->member_id]) ? 1 : 0;

                // Use updateOrCreate to insert or update attendance record
                // include mass_id to ensure uniqueness and correct association
                $mass->attendances()->updateOrCreate(
                    ['mass_id' => $mass->mass_id, 'member_id' => $member->member_id],
                    ['attended' => $attended]
                );
            }

            return redirect()
                ->route('secretary.masses.show', $mass)
                ->with('success', 'Attendance updated successfully!');
        } catch (\Exception $e) {
            Log::error('Attendance update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error updating attendance. Please try again.');
        }
    }

    public function storeOffering(Request $request, Mass $mass)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'remarks' => 'nullable|string|max:255',
        ]);

        $offering = $mass->offerings()->create([
            'amount' => $request->amount,
            'remarks' => $request->remarks,
            'encoded_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Offering added successfully.');
    }

    public function print(Mass $mass)
    {
        $mass->load(['attendances.member', 'offerings.encoder']);
        $members = $mass->church->members()->orderBy('last_name')->get();

        $attendances = $mass->attendances->pluck('attended', 'member_id')->toArray();
        $totalMembers = $members->count();
        $attendedCount = collect($attendances)->filter(fn($a) => $a)->count();
        $absentCount = $totalMembers - $attendedCount;

        $totalOffering = $mass->offerings->sum('amount');

        return view('secretary.masses.print', compact(
            'mass',
            'members',
            'attendances',
            'totalMembers',
            'attendedCount',
            'absentCount',
            'totalOffering'
        ));
    }
}
