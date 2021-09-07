<div id="calendar-vue">
    <div id="calendaryo"></div>
    <div id="create-event-modal" class="ui mini modal">
        <div class="ui basic segment">
            <form @submit.prevent="submit_create_event" class="ui form">
                <div class="field">
                    <label>Event Title</label>
                    <input class="ui input" type="text" v-model="event.title" placeholder="Title of the event">
                </div>
                <div class="field">
                    <label>Description</label>
                    <input class="ui input" type="text" v-model="event.description" placeholder="Enter the description here...">
                </div>
                <div class="two fields">
                    <div class="field">
                        <label>Start Date</label>
                        <input type="date" v-model="event.startDate">
                    </div>
                    <div class="field">
                        <label>End Date</label>
                        <input type="date" v-model="event.endDate">
                    </div>
                </div>

                <div class="field">
                    <div class="ui checkbox checked">
                        <input type="checkbox" name="allday" checked="" tabindex="0" class="hidden" v-model="event.allDay">
                        <label>All Day</label>
                    </div>
                </div>
                <div class="two fields">
                    <div class="field">
                        <label>Start Time</label>
                        <input type="time" v-model="event.startTime">
                    </div>
                    <div class="field">
                        <label>End Time</label>
                        <input type="time" v-model="event.endTime">
                    </div>
                </div>
                <div class="grouped fields">
                    <label for="fruit">Privacy (Who can view this event?):</label>
                    <div class="field">
                        <div class="ui radio checkbox checked">
                            <input type="radio" name="fruit2" checked="" tabindex="0" class="hidden">
                            <label>Only me</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input type="radio" name="fruit2" tabindex="0" class="hidden">
                            <label>My Department</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input type="radio" name="fruit2" tabindex="0" class="hidden">
                            <label>Everyone</label>
                        </div>
                    </div>
                </div>


            </form>
        </div>
        <div class="actions">
            <button class="ui small approve primary button">Submit</button>
            <button class="ui small deny button">Cancel</button>
        </div>
    </div>
</div>
<script>
    var CalendarVue = new Vue({
        el: "#calendar-vue",
        data() {
            return {
                events: [],
                calendar: null,
                event: {
                    title: "",
                    description: "",
                    startDate: "",
                    endDate: "",
                    allDay: true,
                    startTime: "",
                    endTime: "",
                },
                create_event_modal: null
            }
        },
        methods: {
            init_events() {
                // console.log("testing!");
                // const sample_events = [{
                //     "groupId": 1,
                //     "title": "Testing",
                //     "start": "2021-09-03",
                //     "end": "2021-09-05",
                //     "color": "red",
                //     "url": "test.php"
                // }]
                // this.events = JSON.parse(JSON.stringify(sample_events))
            },

            init_event_modal() {
                $("#create-event-modal").modal({
                    closable: false,
                    onHidden() {
                        CalendarVue.reset_create_event_form()
                    },
                    onApprove($element) {
                        CalendarVue.submit_create_event()
                    }
                }).modal("show");
            },
            submit_create_event() {
                // console.log('submit create event: ', this.event);
                $("#create-event-modal").modal("hide")
            },
            // cancel_create_event() {
            //     $("#create-event-modal").modal("hide")
            // },
            reset_create_event_form() {
                this.event = {
                    title: "",
                    start: "",
                    end: "",
                }
            },
            init_calendar() {
                // var events = this.events.length > 0 ? this.events : [];
                this.calendar = new FullCalendar.Calendar(document.getElementById('calendaryo'), {
                    // aspectRatio: 3.2,
                    // width: 1000,
                    height: "auto",
                    plugins: ['interaction', 'dayGrid', 'timeGrid', 'list'],
                    // plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
                    header: {
                        left: 'prev today next',
                        center: 'title',
                        // right: 'next',
                        right: 'dayGridMonth, timeGridWeek, timeGridDay, listMonth'
                    },

                    eventLimit: true, // for all non-TimeGrid views
                    views: {
                        dayGrid: {
                            eventLimit: 2 // adjust to 6 only for timeGridWeek/timeGridDay
                        },
                    },

                    selectable: true,
                    select: (info) => {
                        start = info.startStr;
                        end = new Date(info.endStr);
                        end.setDate(end.getDate() - 1);
                        dateEnd = end.toISOString().split("T")[0];
                        console.log(start + " to " + dateEnd);
                        this.event.title = ""
                        this.event.start = start
                        this.event.end = dateEnd
                        // console.log(info.endStr);
                        // this.create_modal = true
                        this.init_event_modal()
                    },
                    navLinks: false,
                    editable: false,
                    allDay: true,
                    displayEventTime: true,
                    displayEventEnd: true,
                    eventLimit: true, // allow "more" link when too many events
                    events: this.events,
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
                this.calendar.render();
            }
        },
        mounted() {
            this.init_events()
            this.init_calendar()
        }
    });
</script>