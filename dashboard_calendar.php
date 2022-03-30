<div id="calendar-vue">
    <div id="calendaryo"></div>
    <div id="create-event-modal" class="ui mini modal">
        <div class="ui basic segment">
            <form id="event_form" @submit.prevent="submit_create_event" class="ui form">
                <div class="field">
                    <label>Event Title</label>
                    <input class="ui input" type="text" v-model="event.title" placeholder="Title of the event" required>
                </div>
                <div class="field">
                    <label>Description</label>
                    <input class="ui input" type="text" v-model="event.description" placeholder="Enter the description here...">
                </div>
                <div class="two fields">
                    <div class="field">
                        <label>Start Date</label>
                        <input type="date" v-model="event.start_date">
                    </div>
                    <div class="field">
                        <label>End Date</label>
                        <input type="date" v-model="event.end_date">
                    </div>
                </div>

                <div class="field">
                    <div class="ui checkbox checked">
                        <input type="checkbox" name="allday" value="true" :checked="event.allDay?true:false" tabindex="0" class="hidden" v-model="event.allDay">
                        <label>All Day</label>
                    </div>
                </div>
                <div class="two fields" v-if="!event.allDay">
                    <div class="field">
                        <label>Start Time</label>
                        <input type="time" v-model="event.start_time">
                    </div>
                    <div class="field">
                        <label>End Time</label>
                        <input type="time" v-model="event.end_time">
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
            <button form="event_form" type="submit" class="ui small approve primary button">Submit</button>
            <button form="event_form" type="button" class="ui small deny button">Cancel</button>
        </div>
    </div>
    <div class="ui mini modal" id="event_details_modal">
        <div class="header">
            <h3>{{event_detail.title}}</h3>
        </div>
        <div class="content">
            <table class="ui mini very compact celled structured table">
                <tr>
                    <td>
                        <b>Start:</b>
                    </td>
                    <td>
                        {{format_date(event_detail.start_date)}}
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>End:</b>
                    </td>
                    <td>
                        {{format_date(event_detail.end_date)}}
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Time:</b>
                    </td>
                    <td>
                        {{event_detail.allDay?'TBA':'TBA'}}
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>From:</b>
                    </td>
                    <td>
                        {{event_detail.name}}
                    </td>
                </tr>
                <tr>
                    <td>
                        
                    </td>
                    <td>
                        {{event_detail.department}}
                    </td>
                </tr>
            </table>

        </div>
        <div class="actions">
            <button class="ui small button deny">Close</button>
        </div>
    </div>
</div>
<script src="dashboard_calendar.js"></script>