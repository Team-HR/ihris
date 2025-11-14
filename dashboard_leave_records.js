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

        async changeColor(dtrSummary_id, currentStatus) {

            let confirmation
            if (currentStatus) {
                confirmation = confirm("Revert DTR as NOT posted?")
            } else {
                confirmation = confirm("Mark DTR as posted?")
            }

            if (confirmation) {

                if (currentStatus) {
                    this._changeColor(dtrSummary_id, '')
                    this.get_leave_records()
                } else {
                    // alert('Work In Progres...' + ' ' + dtrSummary_id + '-current:' + currentStatus)
                    this._changeColor(dtrSummary_id, '#ead74da8')
                    this.get_leave_records()
                }
            }
        },

        _changeColor(id, color) {
            var fd = new FormData();
            fd.append("color", color);
            fd.append("changeColor", id);
            var xml = new XMLHttpRequest();
            xml.open("POST", "umbra/dtrManagement/config_summary.php", false);
            xml.send(fd);
        },

    },
    mounted() {
        this.get_leave_records()
    }

});