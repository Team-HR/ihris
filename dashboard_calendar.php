<div id="calendaryo"></div>
<script>
    $(document).ready(function() {
        var events = [];
        var calendarEl = document.getElementById('calendaryo');

        calendar = new FullCalendar.Calendar(calendarEl, {
            // aspectRatio: 3.2,
            // width: 1000,
            height: "auto",
            plugins: ['interaction', 'dayGrid'],
            // plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
            header: {
                left: 'prev,next today',
                center: 'title',
                right: ''
                // right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },

            eventLimit: true, // for all non-TimeGrid views
            views: {
                dayGrid: {
                    eventLimit: 2 // adjust to 6 only for timeGridWeek/timeGridDay
                }
            },

            selectable: true,
            select: function(info) {
                dateStart = info.startStr;
                endDate = new Date(info.endStr);
                endDate.setDate(endDate.getDate() - 1);
                dateEnd = endDate.toISOString().split("T")[0];
                console.log(dateStart + " to " + dateEnd);
            },
            navLinks: false,
            editable: false,
            allDay: true,
            displayEventTime: true,
            displayEventEnd: true,
            eventLimit: true, // allow "more" link when too many events
            events: [
                {
                    "groupId": 1,
                    "title": "Testing",
                    "start": "2021-09-03",
                    "end": "2021-09-03",
                    "color": "red",
                    "url": "test.php"
                },
                {
                    "groupId": 2,
                    "title": "Birthday",
                    "start": "2021-09-06",
                    "end": "2021-09-12",
                    "color": "red",
                    "url": "test.php"
                },
            ],
            // {
            //     url: 'calendar_proc.php',
            //     method: 'POST',
            //     extraParams: {
            //         getCalendarData: true
            //     },
            //     failure: function() {
            //         alert('there was an error while fetching events!');
            //     },
            // },

            eventClick: function(info) {
                info.jsEvent.preventDefault();

                if (info.event.url) {
                    // window.open(info.event.url+"&start="+info.event.start.toISOString(),"_blank");
                    // window.open(info.event.url+"&start="+info.event.start.toISOString(),"_blank");
                    window.location.replace(info.event.url + "&start=" + info.event.start.toISOString());
                    // alert(info.event.start.toISOString());
                }
            }
        });

        calendar.render();
    });
</script>