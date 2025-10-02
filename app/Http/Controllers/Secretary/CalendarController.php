<?php

namespace App\Http\Controllers\Secretary;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index()
    {
        $secretaryId = optional(Auth::user()->secretary)->secretary_id;

        $events = $secretaryId
            ? Event::where('secretary_id', $secretaryId)->get()
            : collect();

        $calendarEvents = $events->map(function ($event) {
            return [
                'title' => $event->title,
                'start' => $event->event_date,
                'url'   => route('secretary.events.show', $event->event_id)
            ];
        });

        return view('secretary.events.calendar', compact('calendarEvents'));
    }
}
