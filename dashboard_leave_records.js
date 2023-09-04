var auth_user_app = new Vue({
    el: "#dashboard_leave_records",
    data() {
        return {
            leave_records: [],
            employees_id: new URLSearchParams(window.location.search).get("employees_id"),
        }
    },
    methods: {
        async get_leave_records() {
            await $.get("dashboard_leave_records.php", {
                get_leave_records: true,
                employees_id: this.employees_id,
            }, (data, textStatus, jqXHR) => {
                this.leave_records = JSON.parse(JSON.stringify(data))
            },
                "json"
            );
        },
    },
    mounted() {
        this.get_leave_records()
    }

});