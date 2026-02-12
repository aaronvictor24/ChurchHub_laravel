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
            nowIndicator: true,
            eventTimeFormat: {
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

            // 🔹 Style adjustments for readability and to ensure colors persist to print
            eventDidMount: function(info) {
                // Prefer explicit color properties from event data, fallback to defaults
                const bg = info.event.backgroundColor || info.event.extendedProps.color ||
                    '#16a34a';
                const border = info.event.borderColor || info.event.extendedProps.borderColor ||
                    '#15803d';
                const text = info.event.textColor || info.event.extendedProps.textColor ||
                    '#ffffff';

                // Apply inline styles so they are preserved in print
                info.el.style.backgroundColor = bg;
                info.el.style.color = text;
                info.el.style.borderColor = border;
                info.el.style.fontWeight = '600';
                info.el.style.borderRadius = '8px';
                info.el.style.padding = '2px 6px';

                // Add a print-friendly class as well
                info.el.classList.add('fc-print-event');
            }
        });

        calendar.render();

        // Keep track of previous view/height so we can restore after printing
        let prevView = calendar.view.type;
        let prevHeight = calendar.getOption('height');

        function beforePrint() {
            try {
                prevView = calendar.view.type;
                prevHeight = calendar.getOption('height');
                // Force month view and auto height for printing
                calendar.changeView('dayGridMonth');
                calendar.setOption('height', 'auto');
                // ensure events are fully rendered for print
                calendar.render();
                document.documentElement.classList.add('printing-calendar');
            } catch (e) {
                console.warn('Before print handling failed', e);
            }
        }

        function afterPrint() {
            try {
                // Restore previous view/height
                if (prevView) calendar.changeView(prevView);
                if (prevHeight) calendar.setOption('height', prevHeight);
                calendar.render();
                document.documentElement.classList.remove('printing-calendar');
            } catch (e) {
                console.warn('After print handling failed', e);
            }
        }

        // Add print listeners for most browsers
        if (window.matchMedia) {
            const mediaQueryList = window.matchMedia('print');
            mediaQueryList.addEventListener ? mediaQueryList.addEventListener('change', (mql) => {
                if (mql.matches) beforePrint();
                else afterPrint();
            }) : mediaQueryList.addListener((mql) => {
                if (mql.matches) beforePrint();
                else afterPrint();
            });
        }

        window.addEventListener('beforeprint', beforePrint);
        window.addEventListener('afterprint', afterPrint);
    });
</script>
