<div id="calendaryo"></div>
<script>
    $(document).ready(function() {
        var events = [];
        var calendarEl = document.getElementById('calendaryo');

        calendar = new FullCalendar.Calendar(calendarEl, {
            // aspectRatio: 3.2,
            // width: 1000,
            theme: "bootstrap",
            height: "auto",
            plugins: ['interaction', 'dayGrid'],
            // plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth'
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
                // alert('selected ' + info.startStr + ' to ' + info.endStr);
                // alert('clicked ' + info.dateStr);
                dateStart = info.startStr;
                $("#inputDate1_cal").val(dateStart);
                // console.log('start:', dateStart);
                str = info.endStr;
                endDate = new Date(str);
                endDate.setDate(endDate.getDate() - 1);
                dateEnd = endDate.toISOString().split("T")[0];
                // console.log('end:', dateEnd);
                // dateEnd = (parseInt(str.substring(0, 4), 10)) + "-" +
                //   pad(parseInt(str.substring(6), 10)) + "-" +
                //   pad(parseInt(str.substring(8, 10), 10) - 1);
                // alert(dateEnd);
                $("#inputDate2_cal").val(dateEnd);
                // $("#event").html(info.dateStr);

                hrs = date_diff_indays_cal(dateStart, dateEnd);
                $("#inputHrs_cal").val(hrs);

                $(loadListToAdd_cal);
                $("#calendar_add_modl").modal({
                    // transition: "drop",
                    closable: false,
                    allowMultiple: true,
                    onApprove: function() {
                        // alert($("#inputDate1_cal").val());
                        // alert(addQueries_cal);
                        $(addTraining_cal());
                    },
                    onDeny: function() {
                        $(clear_cal);
                    }
                }).modal("show");
            },
            defaultDate: <?php echo json_encode(date('Y-m-d')); ?>, //'2019-06-12',
            navLinks: false,
            editable: false,
            allDay: true,
            displayEventTime: true,
            displayEventEnd: true,
            eventLimit: true, // allow "more" link when too many events
            events: {
                url: 'calendar_proc.php',
                method: 'POST',
                extraParams: {
                    getCalendarData: true
                },
                failure: function() {
                    alert('there was an error while fetching events!');
                },
                // color: 'yellow',   // a non-ajax option
                // textColor: 'black' // a non-ajax option
            },

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