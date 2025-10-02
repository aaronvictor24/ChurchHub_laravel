<?php

namespace App\Http\Controllers\Secretary;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Fetch events for this secretary only
        $events = Event::where('secretary_id', Auth::user()->secretary->secretary_id)->get();

        // Prepare for FullCalendar
        $calendarEvents = $events->map(function ($event) {
            return [
                'title' => $event->title,
                'start' => $event->event_date,
                'url'   => route('secretary.events.show', $event->event_id)
            ];
        });

        return view('secretary.dashboard', compact('calendarEvents'));
    }
}
