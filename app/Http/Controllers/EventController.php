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
    public function index(Request $request)
    {
        $query = Event::query();

        // Filter events if user is a secretary
        if (Auth::user()->role->name !== 'admin') {
            $query->where('secretary_id', Auth::user()->secretary->secretary_id);
        }

        // Search functionality
        if ($request->has('q') && !empty($request->q)) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Status filter
        $now = Carbon::now();
        if ($request->has('status') && !empty($request->status)) {
            if ($request->status === 'upcoming') {
                $query->whereDate('start_date', '>', $now);
            } elseif ($request->status === 'ongoing') {
                $query->whereDate('start_date', '<=', $now)
                    ->whereDate('end_date', '>=', $now);
            } elseif ($request->status === 'past') {
                $query->whereDate('end_date', '<', $now);
            }
        }

        // Date range filter
        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->whereDate('start_date', '>=', $request->date_from);
        }
        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->whereDate('end_date', '<=', $request->date_to);
        }

        // Added date range filter
        if ($request->has('sort_by') && !empty($request->sort_by)) {
            if ($request->sort_by === 'today') {
                $query->whereDate('created_at', Carbon::today());
            } elseif ($request->sort_by === 'this_week') {
                $query->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ]);
            } elseif ($request->sort_by === 'this_month') {
                $query->whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year);
            }
        }

        // Sorting
        $sortField = $request->get('sort_field', 'created_at');
        $order = $request->get('order', 'desc');

        if (in_array($sortField, ['created_at', 'start_date', 'title'])) {
            $query->orderBy($sortField, $order);
        } else {
            $query->latest();
        }

        // Per page
        $perPage = $request->get('per_page', 10);
        if (in_array($perPage, [10, 25, 50, 100])) {
            $events = $query->paginate($perPage);
        } else {
            $events = $query->paginate(10);
        }

        // Preserve query parameters in pagination links
        $events->appends($request->query());

        // Calculate totals for the original secretary query
        $totalQuery = Event::query();
        if (Auth::user()->role->name !== 'admin') {
            $totalQuery->where('secretary_id', Auth::user()->secretary->secretary_id);
        }

        // Use precise datetimes (include times when available) to compute statuses
        $allEvents = $totalQuery->get();
        $totalEvents = $allEvents->count();
        $upcomingEvents = $allEvents->filter(function ($e) use ($now) {
            $start = Carbon::parse($e->start_date . ' ' . ($e->start_time ?? '00:00:00'));
            return $start->gt($now);
        })->count();
        $ongoingEvents = $allEvents->filter(function ($e) use ($now) {
            $start = Carbon::parse($e->start_date . ' ' . ($e->start_time ?? '00:00:00'));
            $end = Carbon::parse($e->end_date . ' ' . ($e->end_time ?? '23:59:59'));
            return $start->lte($now) && $end->gte($now);
        })->count();
        $pastEvents = $allEvents->filter(function ($e) use ($now) {
            $end = Carbon::parse($e->end_date . ' ' . ($e->end_time ?? '23:59:59'));
            return $end->lt($now);
        })->count();

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

        // Build new event start/end datetimes (use whole-day fallback when times are missing)
        $newStart = Carbon::parse($validated['start_date'] . ' ' . ($validated['start_time'] ?? '00:00:00'));
        $newEnd = Carbon::parse($validated['end_date'] . ' ' . ($validated['end_time'] ?? '23:59:59'));

        // First narrow by date overlap candidates then check time overlap precisely
        $candidates = Event::where('secretary_id', $secretary->secretary_id)
            ->whereDate('start_date', '<=', $validated['end_date'])
            ->whereDate('end_date', '>=', $validated['start_date'])
            ->get();

        $hasConflict = $candidates->contains(function ($ev) use ($newStart, $newEnd) {
            $evStart = Carbon::parse($ev->start_date . ' ' . ($ev->start_time ?? '00:00:00'));
            $evEnd = Carbon::parse($ev->end_date . ' ' . ($ev->end_time ?? '23:59:59'));

            // Overlap exists when start <= other_end AND end >= other_start
            return $newStart->lte($evEnd) && $newEnd->gte($evStart);
        });

        if ($hasConflict) {
            return redirect()->back()->with('warning', '⚠ Warning: This event schedule is occupied. Please check the calendar for conflicts.')
                ->withInput();
        }

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

        // Check for schedule conflicts (exclude current event)
        $newStart = Carbon::parse($validated['start_date'] . ' ' . ($validated['start_time'] ?? '00:00:00'));
        $newEnd = Carbon::parse($validated['end_date'] . ' ' . ($validated['end_time'] ?? '23:59:59'));

        $candidates = Event::where('secretary_id', $event->secretary_id)
            ->where('event_id', '!=', $event->event_id)
            ->whereDate('start_date', '<=', $validated['end_date'])
            ->whereDate('end_date', '>=', $validated['start_date'])
            ->get();

        $hasConflict = $candidates->contains(function ($ev) use ($newStart, $newEnd) {
            $evStart = Carbon::parse($ev->start_date . ' ' . ($ev->start_time ?? '00:00:00'));
            $evEnd = Carbon::parse($ev->end_date . ' ' . ($ev->end_time ?? '23:59:59'));
            return $newStart->lte($evEnd) && $newEnd->gte($evStart);
        });

        if ($hasConflict) {
            return redirect()->back()->with('warning', '⚠ Warning: This event schedule is occupied. Please check the calendar for conflicts.')
                ->withInput();
        }

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
        // 🟡 Updated logic: cannot take attendance for future events — consider start datetime if available
        $eventStartDT = Carbon::parse($event->start_date . ' ' . ($event->start_time ?? '00:00:00'));
        if ($eventStartDT->isFuture()) {
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
