<div class="bg-gray-800 shadow-xl rounded-xl p-6 border border-gray-700">
    <div id="calendar" class="rounded-md overflow-hidden w-full" style="min-height:600px; max-height:80vh;"></div>
</div>

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
            themeSystem: 'standard',
            nowIndicator: true, // 🔹 shows current date/time indicator
            eventTimeFormat: { // 🔹 clean display of time
                hour: '2-digit',
                minute: '2-digit',
                meridiem: 'short'
            },
            events: @json($calendarEvents ?? []),

            // 🔹 Opens event detail page when clicked
            eventClick: function(info) {
                info.jsEvent.preventDefault();
                if (info.event.url) window.location.href = info.event.url;
            },

            // 🔹 Tooltip hover
            eventMouseEnter: function(info) {
                info.el.setAttribute('title', info.event.title);
            },

            // 🔹 Style adjustments for readability
            eventDidMount: function(info) {
                info.el.style.backgroundColor = info.event.backgroundColor ||
                'rgba(99,102,241,0.2)';
                info.el.style.color = info.event.textColor || '#E5E7EB';
                info.el.style.borderColor = info.event.borderColor || '#6366F1';
                info.el.style.fontWeight = '600';
                info.el.style.borderRadius = '8px';
            }
        });

        calendar.render();
    });
</script>
