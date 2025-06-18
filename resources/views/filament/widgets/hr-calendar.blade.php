<x-filament::widget>
    <x-filament::card class="p-0">
        <div id="calendar" class="w-full h-[700px]"></div>
    </x-filament::card>

    @push('styles')
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>
        <style>
            .fc-toolbar-title {
                font-size: 1.5rem;
                font-weight: 600;
            }
            .fc-event {
                font-size: 0.875rem;
            }
            .fi-section-content-ctn{
                width: 866px;
            }
            .fi-section{
                width: 867px;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const calendarEl = document.getElementById('calendar');

                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    height: 'auto',
                    contentHeight: 'auto',
                    expandRows: true,
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    events: @json($events),
                    eventColor: '#3b82f6',
                    nowIndicator: true,
                    navLinks: true,
                    selectable: false,
                    dayMaxEvents: true,
                });

                calendar.render();
            });
        </script>
    @endpush
</x-filament::widget>
