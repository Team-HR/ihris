var appointment_app = new Vue({
    el: "#appointment-app",
    data() {
        return {
            employee_id: new URLSearchParams(window.location.search).get("employees_id"),
            appointments: []
        }
    },
    methods: {
        get_data() {
            // console.log('get_appointments');
            $.post("appointments/config.php", {
                get_data: true,
                employee_id: this.employee_id
            },
                (data, textStatus, jqXHR) => {
                    this.appointments = Object.assign([],data)
                    // console.log('appointments:', data);
                },
                "json"
            );
        }
    },
    created() {
        // this.employee_id = new URLSearchParams(window.location.search).get("employees_id")
        // this.get_data()
    },
    mounted() {
        this.get_data()
    },
})