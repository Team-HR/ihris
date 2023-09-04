var CalendarVue = new Vue({
    el: "#calendar-vue",
    data() {
        return {
            event_form: null,
            events: [],
            calendar: null,
            employees_id: new URLSearchParams(window.location.search).get("employees_id"),
            event: {
                id: null,
                title: "",
                description: "",
                start_date: "",
                end_date: "",
                allDay: false,
                start_time: "08:00",
                end_time: "17:00",
                privacy: "onlyme"
            },
            event_detail: {},
            create_event_modal: null
        }
    },
    methods: {
        async fetch_events() {
            await $.get("dashboard_calendar_proc.php", {
                fetch_events: true,
                employees_id: this.employees_id
            }, (data, textStatus, jqXHR) => {
                // console.log('events:', data)
                this.events = JSON.parse(JSON.stringify(data))
                if (!this.calendar) return null
                this.calendar.getEventSources().forEach(element => {
                    element.remove()
                });
                this.calendar.addEventSource(this.events)
            },
                "json"
            );
        },
        init_event_modal() {
            $("#create-event-modal").modal({
                closable: false,
                onHidden() {
                    CalendarVue.reset_create_event_form()
                },
                onApprove($element) {
                    return false
                }
            }).modal("show");
        },

        async submit_create_event() {
            await $.post("dashboard_calendar_proc.php", {
                submit_create_event: true,
                employees_id: this.employees_id,
                event: this.event
            }, (data, textStatus, jqXHR) => {
                // console.log('submitted:', data);
                // console.log('submit:', this.event)
                this.fetch_events()
                $("#create-event-modal").modal("hide")
            },
                "json"
            );
        },

        format_date(date) {
            var date = new Date(date)
            return moment(date).format('dddd, LL').toUpperCase();
        },

        async get_event_details(id) {
            let result;
            try {
                result = await $.get("dashboard_calendar_proc.php", {
                    get_event_details: true,
                    id: id
                }, (data, textStatus, jqXHR) => {
                    return  JSON.parse(JSON.stringify(data))
                },
                    "json"
                );
                return result;
            } catch (error) { console.log(error) }

        },

        reset_create_event_form() {
            this.event = {
                id: null,
                title: "",
                description: "",
                start_date: "",
                end_date: "",
                allDay: false,
                start_time: "08:00",
                end_time: "17:00",
                privacy: "onlyme"
            }
        },
        init_calendar() { }
    },
    mounted() {
        // console.log(this.calendar)
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
                allDay = info.allDay
                start_date = info.startStr
                end_date = info.endStr
                start_time = this.event.start_time
                end_time = this.event.end_time

                if (allDay) {
                    end_date = new Date(end_date)
                    end_date.setDate(end_date.getDate() - 1)
                    end_date = end_date.toISOString().split("T")[0]
                } else {
                    startStr = start_date.split("+")[0]
                    endStr = end_date.split("+")[0]
                    startStr = startStr.split("T")
                    endStr = endStr.split("T")
                    start_date = startStr[0]
                    end_date = endStr[0]
                    start_time = startStr[1]
                    end_time = endStr[1]
                }

                this.event.allDay = allDay
                this.event.start_date = start_date
                this.event.end_date = end_date
                this.event.start_time = start_time
                this.event.end_time = end_time

                this.init_event_modal()
                // console.log(this.event);
            },
            navLinks: false,
            editable: false,
            // allDay: true,
            displayEventTime: true,
            displayEventend_date: true,
            eventLimit: true, // allow "more" link when too many events
            // events: this.events,
            eventClick: (info) => {
                info.jsEvent.preventDefault();
                var id = info.event.id;

                this.get_event_details(id).then(res=>{
                    this.event_detail = res
                    $("#event_details_modal").modal("show");
                })

                // if (info.event.url) {
                //     // window.open(info.event.url+"&start="+info.event.start.toISOString(),"_blank");
                //     // window.open(info.event.url+"&start="+info.event.start.toISOString(),"_blank");
                //     window.location.replace(info.event.url + "&start=" + info.event.start.toISOString());
                //     // alert(info.event.start.toISOString());
                // }
            }
        });
        this.calendar.render();

    }
});