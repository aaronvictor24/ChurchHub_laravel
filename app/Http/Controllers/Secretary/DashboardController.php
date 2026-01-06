<?php

namespace App\Http\Controllers\Secretary;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Secretary;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $secretary = Auth::user()->secretary;
        $churchId = $secretary->church_id;

        // Total members for secretary's church
        $totalMembers = \App\Models\Member::where('church_id', $churchId)->count();

        // Upcoming events (next 7 days)
        $upcomingEvents = \App\Models\Event::where('church_id', $churchId)
            ->whereDate('start_date', '>=', now())
            ->whereDate('start_date', '<=', now()->addDays(7))
            ->orderBy('start_date')
            ->take(5)
            ->get();

        // Recent offerings/tithes (last 30 days)
        $recentOfferings = \App\Models\MassOffering::whereHas('mass', function ($q) use ($churchId) {
            $q->where('church_id', $churchId);
        })
            ->where('created_at', '>=', now()->subDays(30))
            ->sum('amount');
        $recentTithes = \App\Models\Tithe::where('church_id', $churchId)
            ->where('date', '>=', now()->subDays(30)->toDateString())
            ->sum('amount');

        $events = \App\Models\Event::where('secretary_id', $secretary->secretary_id)->get();
        $calendarEvents = $events->map(function ($event) {
            return [
                'title' => $event->title,
                'start' => $event->event_date,
                'url'   => route('secretary.events.show', $event->event_id),
            ];
        });

        $recentActivities = [];

        // Attendance analytics (last 12 months)
        $labels = [];
        $memberAttendance = [];
        $eventAttendance = [];
        $massAttendance = [];
        $from = now()->subMonths(11)->startOfMonth();
        $to = now()->endOfMonth();
        $current = $from->copy();
        while ($current->lte($to)) {
            $labels[] = $current->format('M Y');
            $start = $current->copy()->startOfMonth()->toDateString();
            $end = $current->copy()->endOfMonth()->toDateString();

            $memberAttendance[] = \App\Models\EventAttendance::whereHas('event', function ($q) use ($churchId) {
                $q->where('church_id', $churchId);
            })
                ->where('attended', 1)
                ->whereBetween('created_at', [$start, $end])
                ->count();

            $eventAttendance[] = \App\Models\EventAttendance::whereHas('event', function ($q) use ($churchId) {
                $q->where('church_id', $churchId);
            })
                ->whereBetween('created_at', [$start, $end])
                ->count();

            $massAttendance[] = \App\Models\MassAttendance::whereHas('mass', function ($q) use ($churchId) {
                $q->where('church_id', $churchId);
            })
                ->where('attended', 1)
                ->whereBetween('created_at', [$start, $end])
                ->count();

            $current->addMonth();
        }

        return view('secretary.dashboard', compact(
            'calendarEvents',
            'secretary',
            'recentActivities',
            'labels',
            'memberAttendance',
            'eventAttendance',
            'massAttendance',
            'totalMembers',
            'upcomingEvents',
            'recentOfferings',
            'recentTithes'
        ));
    }
}
