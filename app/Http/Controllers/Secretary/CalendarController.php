<?php

namespace App\Http\Controllers\Secretary;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Mass;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index()
    {
        $secretaryId = optional(Auth::user()->secretary)->secretary_id;
        $now = Carbon::now();

        // 🔹 Secretary’s own events
        $events = $secretaryId
            ? Event::where('secretary_id', $secretaryId)->get()
            : collect();

        $calendarEvents = [];

        foreach ($events as $event) {
            $endDate = Carbon::parse($event->end_date ?? $event->start_date);
            $isPast = $endDate->lt($now); // check if already done

            $calendarEvents[] = [
                'title' => $event->title . ($isPast ? ' (Done)' : ''),
                'start' => $event->start_date,
                'end'   => $event->end_date ?? $event->start_date,
                'url'   => route('secretary.events.show', $event->event_id),
                'backgroundColor' => $isPast ? '#6b7280' : '#2563eb', // gray if done, blue if upcoming
                'borderColor' => $isPast ? '#6b7280' : '#2563eb',
                'textColor' => '#fff',
                'opacity' => $isPast ? 0.6 : 1, // faded look for completed events
            ];
        }

        // 🔹 Build recurring definitions from stored masses to avoid duplicate calendar entries
        // We treat unique combinations of (church_id, day_of_week, start_time, end_time, mass_title) as one recurring definition
        // Group recurring definitions by day/time (ignore small title variations to avoid duplicate calendar entries)
        $recurringDefs = Mass::where('is_recurring', true)
            ->whereNotNull('day_of_week')
            ->select(
                'church_id',
                'day_of_week',
                'start_time',
                'end_time',
                DB::raw('MIN(mass_title) as mass_title'),
                DB::raw('MIN(mass_id) as repr_id')
            )
            ->groupBy('church_id', 'day_of_week', 'start_time', 'end_time')
            ->get();

        foreach ($recurringDefs as $def) {
            $startDate = Carbon::now()->startOfMonth();
            $endDate   = Carbon::now()->addMonths(2)->endOfMonth();
            $day       = ucfirst(strtolower($def->day_of_week));
            $current   = $startDate->copy()->next($day);

            while ($current->lte($endDate)) {
                $start = $current->copy()->setTimeFromTimeString($def->start_time);
                $end   = $current->copy()->setTimeFromTimeString($def->end_time);
                $isPast = $end->lt($now);

                $calendarEvents[] = [
                    'title' => ($def->mass_title ?: 'Regular Mass') . ($isPast ? ' (Done)' : ''),
                    'start' => $start->toDateTimeString(),
                    'end'   => $end->toDateTimeString(),
                    'url'   => route('secretary.masses.show', $def->repr_id),
                    'backgroundColor' => $isPast ? '#6b7280' : '#16a34a',
                    'borderColor' => $isPast ? '#6b7280' : '#16a34a',
                    'textColor' => '#fff',
                    'opacity' => $isPast ? 0.6 : 1,
                ];

                $current->addWeek();
            }
        }

        // 🔹 One-time masses (special types) - keep these as-is
        $oneTimeMasses = Mass::whereIn('mass_type', ['funeral', 'wedding', 'baptism'])->get();
        foreach ($oneTimeMasses as $mass) {
            $start = Carbon::parse($mass->mass_date . ' ' . $mass->start_time);
            $end   = Carbon::parse($mass->mass_date . ' ' . $mass->end_time);
            $isPast = $end->lt($now);

            $calendarEvents[] = [
                'title' => ($mass->mass_title ?: ucfirst($mass->mass_type) . ' Mass') . ($isPast ? ' (Done)' : ''),
                'start' => $start->toDateTimeString(),
                'end'   => $end->toDateTimeString(),
                'url'   => route('secretary.masses.show', $mass->mass_id),
                'backgroundColor' => $isPast ? '#6b7280' : '#f59e0b',
                'borderColor' => $isPast ? '#6b7280' : '#f59e0b',
                'textColor' => '#fff',
                'opacity' => $isPast ? 0.6 : 1,
            ];
        }


        return view('secretary.events.calendar', compact('calendarEvents'));
    }
}
