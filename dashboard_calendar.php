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
                        <input type="date" v-model="event.start">
                    </div>
                    <div class="field">
                        <label>End Date</label>
                        <input type="date" v-model="event.end">
                    </div>
                </div>

                <div class="field">
                    <div class="ui checkbox checked">
                        <input type="checkbox" name="allday" :checked="event.allDay?true:false" tabindex="0" class="hidden" v-model="event.allDay">
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
                            <input value="onlyme" :checked="event.privacy=='onlyme'?true:false" v-model="event.privacy" type="radio" name="privacy" class="hidden">
                            <label>Only me</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input value="mydepartment" :checked="event.privacy=='mydepartment'?true:false" v-model="event.privacy" type="radio" name="privacy" class="hidden">
                            <label>My Department</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input value="everyone" :checked="event.privacy=='everyone'?true:false" v-model="event.privacy" type="radio" name="privacy" class="hidden">
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
                employees_id: new URLSearchParams(window.location.search).get("employees_id"),
                event: {
                    groupId: 0,
                    title: "",
                    description: "",
                    start: "",
                    end: "",
                    allDay: true,
                    startTime: "08:00",
                    endTime: "17:00",
                    privacy: "onlyme"
                },
                create_event_modal: null
            }
        },
        methods: {
            fetch_events() {
                if (!this.calendar) return false
                this.calendar.getEventSources().forEach(element => {
                    element.remove()
                });
                // this.events.push({
                //     groupId: 0,
                //     title: "TEST",
                //     description: "",
                //     start: "2021-09-01T08:00:00",
                //     end: "2021-09-02T17:00:00",
                //     allDay: false,
                //     startTime: "",
                //     endTime: "",
                //     privacy: ""
                // })
                // $.post("dashboard_calendar_proc", {
                //     fetch_events: true,
                //     employees_id: this.employees_id
                // }, (data, textStatus, jqXHR) => {
                //         console.log(data);
                //         this.calendar.addEventSource(this.events)      
                //     },
                //     "json"
                // );
                this.calendar.addEventSource(this.events)      
                    
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
                this.events.push(this.event)
                this.fetch_events()
                $("#create-event-modal").modal("hide")
            },
            // cancel_create_event() {
            //     $("#create-event-modal").modal("hide")
            // },
            reset_create_event_form() {
                this.event = {
                    groupId: 0,
                    title: "",
                    description: "",
                    start: "",
                    end: "",
                    allDay: true,
                    startTime: "08:00",
                    endTime: "17:00",
                    privacy: "onlyme"
                }
            },
            init_calendar() {}
        },
        mounted() {
            this.fetch_events()
            // this.init_calendar()
            // var events = this.events.length > 0 ? this.events : [];
            this.calendar = new FullCalendar.Calendar(document.getElementById('calendaryo'), {
                // aspectRatio: 3.2,
                // width: 1000,
                // nextDayThreshold: '09:00:00',
                height: "auto",
                plugins: ['interaction', 'dayGrid', 'timeGrid', 'list'],
                // plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    // right: 'next',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },

                eventLimit: true, // for all non-TimeGrid views
                views: {
                    dayGrid: {
                        eventLimit: 2 // adjust to 6 only for timeGridWeek/timeGridDay
                    },
                },
                selectable: true,
                select: (info) => {
                    // start = info.startStr;
                    end = new Date(info.endStr);
                    end.setDate(end.getDate() - 1);
                    dateEnd = end.toISOString().split("T")[0];
                    // console.log(start + " to " + dateEnd);
                    // this.event.title = ""
                    this.event.start = info.startStr
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
    });
</script>