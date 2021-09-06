<div id="calendaryo"></div>
<div id="newEvent" class="ui mini modal"></div>
<script>
    // $(document).ready(function() {
    const events = [{
        "groupId": 1,
        "title": "Testing",
        "start": "2021-09-03",
        "end": "2021-09-05",
        "color": "red",
        "url": "test.php"
    }];


    $(document).ready(function() {
        calendario(events);
    });

    function calendario(events) {
        var events = events.length > 0 ? events : [];
        var calendar = new FullCalendar.Calendar(document.getElementById('calendaryo'), {
            // aspectRatio: 3.2,
            // width: 1000,
            height: "auto",
            plugins: ['interaction', 'dayGrid', 'timeGrid', 'list'],
            // plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
            header: {
                left: 'prev, today',
                center: 'title',
                right: 'next',
                // right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },

            eventLimit: true, // for all non-TimeGrid views
            views: {
                dayGrid: {
                    eventLimit: 2 // adjust to 6 only for timeGridWeek/timeGridDay
                },
            },

            selectable: true,
            select: function(info) {
                start = info.startStr;
                end = new Date(info.endStr);
                end.setDate(end.getDate() - 1);
                dateEnd = end.toISOString().split("T")[0];
                console.log(start + " to " + dateEnd);
                // console.log(info.endStr);
            },
            navLinks: false,
            editable: false,
            allDay: true,
            displayEventTime: true,
            displayEventEnd: true,
            eventLimit: true, // allow "more" link when too many events
            events: events,
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
    }
</script>