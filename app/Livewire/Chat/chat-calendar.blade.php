<div>
    <div class="position-absolute" wire:loading wire:target="message">
        <div class="loader-overlay">
            <div class="loader">
                <div></div>
            </div>
        </div>
    </div>
    <div class="container-fluid my-1" id='chartScreen'>
        <div class="wrapper-canvas bg-white" style="height: 93vh">
            {{-- chat side bar --}}
            <livewire:chat.chat-side-bar />
            <div class="row m-0 p-0 col-11 pt-3" style="overflow: auto; height: 90vh">
                <div id='calendar'></div>
            </div>
        </div>
    </div>
</div>

<script>

      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            themeSystem: 'bootstrap5',
            height: 480,
            initialView: 'dayGridWeek',
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek,dayGridDay'
            }
        });
        calendar.render();
      });
</script>
