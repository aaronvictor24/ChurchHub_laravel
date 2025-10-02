@extends('layouts.secretary')

@section('content')
    <div class="space-y-4 container mx-auto">

        <!-- Legend -->
        <div class="flex flex-wrap space-x-4 mb-4 text-sm">
            <div class="flex items-center space-x-2">
                <span class="w-4 h-4 bg-yellow-400 rounded-sm"></span>
                <span class="text-gray-700">Upcoming</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="w-4 h-4 bg-green-600 rounded-sm"></span>
                <span class="text-gray-700">Ongoing</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="w-4 h-4 bg-gray-500 rounded-sm"></span>
                <span class="text-gray-700">Past</span>
            </div>
        </div>

        <!-- Calendar Card -->
        <div class="bg-white shadow rounded-lg p-4">
            <h2 class="text-xl font-bold mb-4">📅 Event Calendar</h2>
            <div id="calendar" class="rounded-md border overflow-auto w-full" style="min-height:600px; max-height:80vh;">
            </div>
        </div>
    </div>

    <!-- FullCalendar Script -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: '80vh',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: @json($calendarEvents ?? []),
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    if (info.event.url) window.location.href = info.event.url;
                },
                eventMouseEnter: function(info) {
                    info.el.setAttribute('title', info.event.title);
                }
            });

            calendar.render();
        });
    </script>
@endsection
