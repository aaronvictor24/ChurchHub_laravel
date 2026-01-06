<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventAttendance;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index()
    {
        $query = Event::query();

        // Filter events if user is a secretary
        if (Auth::user()->role->name !== 'admin') {
            $query->where('secretary_id', Auth::user()->secretary->secretary_id);
        }

        $events = $query->latest()->paginate(10);

        $now = Carbon::now();

        //  Updated to use start_date and end_date
        $totalEvents = $query->count();
        $upcomingEvents = (clone $query)
            ->whereDate('start_date', '>', $now)
            ->count();
        $ongoingEvents = (clone $query)
            ->whereDate('start_date', '<=', $now)
            ->whereDate('end_date', '>=', $now)
            ->count();
        $pastEvents = (clone $query)
            ->whereDate('end_date', '<', $now)
            ->count();

        return view('secretary.events.index', compact(
            'events',
            'totalEvents',
            'upcomingEvents',
            'ongoingEvents',
            'pastEvents'
        ));
    }

    public function create()
    {
        return view('secretary.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
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
            ->with('success', ' Event created successfully!');
    }

    public function show(Event $event)
    {
        $members = $event->church->members()->orderBy('last_name')->get();
        $attendances = $event->attendances()->pluck('attended', 'member_id')->toArray();

        $totalMembers = $members->count();

        $attendedCount = collect($attendances)->filter(fn($att) => $att)->count();
        $absentCount = $totalMembers - $attendedCount;

        return view('secretary.events.show', compact(
            'event',
            'members',
            'attendances',
            'totalMembers',
            'attendedCount',
            'absentCount'
        ));
    }

    public function edit(Event $event)
    {
        if (Auth::user()->role->name !== 'admin' && $event->secretary_id !== Auth::user()->secretary->secretary_id) {
            abort(403, 'Unauthorized');
        }

        return view('secretary.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        if (Auth::user()->role->name !== 'admin' && $event->secretary_id !== Auth::user()->secretary->secretary_id) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'start_time'  => 'nullable|date_format:H:i',
            'end_time'    => 'nullable|date_format:H:i',
            'location'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $event->update($validated);

        return redirect()->route('secretary.events.index')
            ->with('success', ' Event updated successfully!');
    }

    public function destroy(Event $event)
    {
        if (Auth::user()->role->name !== 'admin' && $event->secretary_id !== Auth::user()->secretary->secretary_id) {
            abort(403, 'Unauthorized');
        }

        $event->delete();

        return redirect()->route('secretary.events.index')
            ->with('success', ' Event deleted successfully.');
    }

    public function updateAttendance(Request $request, Event $event)
    {
        // 🟡 Updated logic: cannot take attendance for future events
        if (Carbon::parse($event->start_date)->isFuture()) {
            return redirect()->back()->with('error', '⚠ You cannot save attendance for an upcoming event.');
        }

        foreach ($event->church->members as $member) {
            $attended = isset($request->attended[$member->member_id]);
            EventAttendance::updateOrCreate(
                ['event_id' => $event->event_id, 'member_id' => $member->member_id],
                ['attended' => $attended]
            );
        }

        return redirect()->back()->with('success', ' Attendance updated successfully!');
    }
}
