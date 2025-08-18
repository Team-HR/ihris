var appointment_app = new Vue({
    el: "#appointment-app",
    data() {
        return {
            employee_id: new URLSearchParams(window.location.search).get("employees_id"),
            appointments: [],
            oathOfOffice: {
                appointment_id: null,
                address: null,
                govId_type: null,
                govId_no: null,
                govId_issued_date: null,
                sworn_date: null,
                sworn_in: null,
                appointing_authority: null
            }
        }
    },
    methods: {
        get_data() {
            $.post("appointments/config.php", {
                get_data: true,
                employee_id: this.employee_id
            },
                (data, textStatus, jqXHR) => {
                    this.appointments = Object.assign([], data)
                },
                "json"
            );
        },

        editAppointmentModal() {
            $("#appointment-editor-modal").modal({
                closable: false
            }).modal("show");
        },

        editOathOfOfficeModal(appointment) {
            // console.log(appointment);
            //initialize this.oathOfOffice
            this.oathOfOffice.appointment_id = appointment.appointment_id
            this.oathOfOffice.address = appointment.address
            this.oathOfOffice.govId_type = appointment.govId_type
            this.oathOfOffice.govId_no = appointment.govId_no
            this.oathOfOffice.govId_issued_date = appointment.govId_issued_date
            this.oathOfOffice.sworn_date = appointment.sworn_date
            this.oathOfOffice.sworn_in = appointment.sworn_in
            this.oathOfOffice.appointing_authority = appointment.appointing_authority
            // console.log(this.oathOfOffice);
            $("#aoo-editor-modal").modal({
                closable: false
            }).modal("show");
        },

        saveOathOfOffice(print = null) {
            // save this,oathOfOffice
            $.post("appointments/config.php", {
                saveOathOfOffice: true,
                oathOfOffice: this.oathOfOffice
            },
                (data, textStatus, jqXHR) => {
                    this.get_data()
                    if (print) {
                        window.open('forms/oath_of_office.CS_form32_revision_2017.pdf.php?appointment_id=' + this.oathOfOffice.appointment_id, '_blank');
                    }
                }
            );

        },

        editAssumptionModal() {
            // console.log("test");
            $("#assumption-editor-modal").modal({
                closable: false
            }).modal("show");
        },

    },
    created() {
        // this.employee_id = new URLSearchParams(window.location.search).get("employees_id")
        // this.get_data()
    },
    mounted() {
        this.get_data()
    },
})