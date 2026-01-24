<?php

namespace App\Http\Controllers\Secretary;

use App\Http\Controllers\Controller;
use App\Models\Mass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MassController extends Controller
{
    public function index()
    {
        $churchId = Auth::user()->church_id;
        $today = Carbon::today();
        $todayName = $today->format('l');

        // Upcoming / active masses:
        // include non-recurring masses with mass_date >= today
        // OR recurring (regular) masses that occur on today's weekday
        $masses = Mass::where('church_id', $churchId)
            ->where(function ($q) use ($today) {
                $q->where(function ($q2) use ($today) {
                    $q2->where('is_recurring', false)
                        ->whereDate('mass_date', '>=', $today);
                })
                    // include all recurring masses for the church
                    ->orWhere('is_recurring', true);
            })
            ->orderBy('mass_date', 'asc')
            ->paginate(10);

        // History (done masses)
        $historyMasses = Mass::where('church_id', $churchId)
            ->whereDate('mass_date', '<', $today)
            ->orderBy('mass_date', 'desc')
            ->get();

        return view('secretary.masses.index', compact('masses', 'historyMasses'));
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
                ->withErrors(['start_time' => 'This time slot is already occupied by another mass.'])
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


    public function show($id)
    {
        $mass = Mass::with(['attendances.member', 'offerings.encoder'])->findOrFail($id);
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


    public function edit($id)
    {
        $mass = Mass::findOrFail($id);
        return view('secretary.masses.edit', compact('mass'));
    }

    public function update(Request $request, $id)
    {
        $mass = Mass::findOrFail($id);

        $request->validate([
            'mass_title' => 'nullable|string|max:255',
            'mass_type' => 'required|string',
            'mass_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'description' => 'nullable|string',
        ]);

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

    public function destroy($id)
    {
        $mass = Mass::findOrFail($id);
        $mass->delete();

        return redirect()->route('secretary.masses.index')->with('success', 'Mass deleted successfully.');
    }

    public function updateAttendance(Request $request, $massId)
    {
        $mass = Mass::findOrFail($massId);

        foreach ($mass->church->members as $member) {
            $attended = isset($request->attended[$member->member_id]);
            $mass->attendances()->updateOrCreate(
                ['member_id' => $member->member_id],
                ['attended' => $attended]
            );
        }

        return redirect()->back()->with('success', 'Attendance updated successfully!');
    }


    public function storeOffering(Request $request, $massId)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'remarks' => 'nullable|string|max:255',
        ]);

        $mass = Mass::findOrFail($massId);

        $offering = $mass->offerings()->create([
            'amount' => $request->amount,
            'remarks' => $request->remarks,
            'encoded_by' => Auth::id(),
        ]);



        return redirect()->back()->with('success', 'Offering added successfully.');
    }
}
