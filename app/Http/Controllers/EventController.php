<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventAttendance;
use App\Models\Member; // if not already imported

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of events.
     */
    public function index()
    {
        $query = Event::query();

        // Filter events for secretary only (if not admin)
        if (Auth::user()->role->name !== 'admin') {
            $query->where('secretary_id', Auth::user()->secretary->secretary_id);
        }

        $events = $query->latest()->paginate(10);

        // Event stats
        $now = \Carbon\Carbon::now();
        $totalEvents = $query->count();
        $upcomingEvents = (clone $query)->whereDate('event_date', '>', $now)->count();
        $ongoingEvents = (clone $query)->whereDate('event_date', $now->toDateString())->count();
        $pastEvents = (clone $query)->whereDate('event_date', '<', $now->toDateString())->count();

        return view('secretary.events.index', compact(
            'events',
            'totalEvents',
            'upcomingEvents',
            'ongoingEvents',
            'pastEvents'
        ));
    }



    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        return view('secretary.events.create');
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'event_date'  => 'required|date',
            'start_time'  => 'nullable|date_format:H:i',
            'end_time'    => 'nullable|date_format:H:i',
            'location'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $secretary = Auth::user()->secretary;

        $validated['secretary_id'] = $secretary->secretary_id;
        $validated['church_id'] = $secretary->church_id;

        Event::create($validated);

        return redirect()->route('secretary.events.index')
            ->with('success', 'Event created successfully!');
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        $members = $event->church->members()->orderBy('last_name')->get();
        $attendances = $event->attendances()->pluck('attended', 'member_id')->toArray();

        $totalMembers = $members->count();

        if (count($attendances) === 0) {
            // No attendance saved yet → keep attended/absent = 0
            $attendedCount = 0;
            $absentCount = 0;
        } else {
            $attendedCount = collect($attendances)->filter(fn($att) => $att)->count();
            $absentCount   = $totalMembers - $attendedCount;
        }

        return view('secretary.events.show', compact(
            'event',
            'members',
            'attendances',
            'totalMembers',
            'attendedCount',
            'absentCount'
        ));
    }




    /**
     * Show the form for editing the specified event.
     */
    public function edit(Event $event)
    {
        if (Auth::user()->role->name !== 'admin' && $event->secretary_id !== Auth::user()->secretary->secretary_id) {
            abort(403, 'Unauthorized');
        }

        return view('secretary.events.edit', compact('event'));
    }

    /**
     * Update the specified event in storage.
     */
    public function update(Request $request, Event $event)
    {
        if (Auth::user()->role->name !== 'admin' && $event->secretary_id !== Auth::user()->secretary->secretary_id) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'event_date'  => 'required|date',
            'start_time'  => 'nullable|date_format:H:i',
            'end_time'    => 'nullable|date_format:H:i',
            'location'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $event->update($validated);

        return redirect()->route('secretary.events.index')
            ->with('success', 'Event updated successfully!');
    }

    /**
     * Remove the specified event from storage.
     */
    public function destroy(Event $event)
    {
        if (Auth::user()->role->name !== 'admin' && $event->secretary_id !== Auth::user()->secretary->secretary_id) {
            abort(403, 'Unauthorized');
        }

        $event->delete();

        return redirect()->route('secretary.events.index')
            ->with('success', 'Event deleted successfully.');
    }

    public function updateAttendance(Request $request, Event $event)
    {
        // Prevent saving attendance for future events
        if (\Carbon\Carbon::parse($event->event_date)->isFuture()) {
            return redirect()->back()->with('error', '⚠ You cannot save attendance for a pending/upcoming event.');
        }

        foreach ($event->church->members as $member) {
            $attended = isset($request->attended[$member->member_id]) ? true : false;
            \App\Models\EventAttendance::updateOrCreate(
                ['event_id' => $event->event_id, 'member_id' => $member->member_id],
                ['attended' => $attended]
            );
        }

        return redirect()->back()->with('success', '✅ Attendance updated!');
    }
}
