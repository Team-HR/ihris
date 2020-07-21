new Vue({
    el: "#app_sr",
    data() {
        return {
            record_types: ['Appointment', 'Build-Up', 'Death', 'End of Casual Emp.', 'End of Term', 'Resignation', 'Retirement', 'Salary Adjustment', 'Step Increment'],
            statuses: ['Appointed', 'Add-in', 'Casual', 'Co-terminous', 'Contractual/Job Order', 'Elective', 'Permanent', 'Provisionary', 'Substitute', 'Temporary'],
            positions: [],
            type: "",
            designation: "",
            status: "",
            rate: "",
            is_per_session: "",
            rate_on_schedule: "",
            date_from: "",
            date_to: "",
            place_of_assignment: "",
            branch: "",
            remarks: "",
            memo: "",
            employee_id: 0
        }
    },
    methods: {
        init_load() {
            $.ajax({
                type: "GET",
                url: "umbra/service_record/config.php",
                data: {
                    init_load: true,
                    employee_id: this.employee_id
                },
                dataType: "json",
                success: (response) => {

                },
                async: false
            });

            this.get_positions()
        },
        get_positions() {
            $.ajax({
                type: "GET",
                url: "umbra/service_record/config.php",
                data: {
                    get_positions: true
                },
                dataType: "json",
                success: (response) => {
                    this.positions = response
                },
                async: false
            });
        },
        init_add() {
            $("#addSR").modal("show")
        },
        save() {

        }
    },
    mounted() {

        var queryString = window.location.search;
        var urlParams = new URLSearchParams(queryString);
        var employee_id = urlParams.get('employees_id')
        this.employee_id = employee_id;
        this.init_load();
        
        $("#addSR").modal({
            closable: false,
            duration: 0
        });

        $("#type").dropdown({
            clearable: true,
            keepOnScreen: false,
            showOnFocus: false,
            allowTab: false,
            fullTextSearch: "exact",
            // allowAdditions: true
        });
        $("#designation").dropdown({
            clearable: true,
            allowAdditions: true,
            forceSelection: false,
            hideAdditions: false,
            allowTab: false,
            showOnFocus: false,
        });
        $("#status_drp").dropdown({
            clearable: true,
            keepOnScreen: false,
            showOnFocus: false,
            allowTab: false,
            fullTextSearch: "exact",
        });
        $("#is_per_session").dropdown({
            clearable: true,
            keepOnScreen: false,
            showOnFocus: false,
            allowTab: false,
            fullTextSearch: "exact",
            // allowAdditions: true
        });
        $("#branch").dropdown({
            clearable: true,
            keepOnScreen: false,
            showOnFocus: false,
            allowTab: false,
            fullTextSearch: "exact",
            // allowAdditions: true
        });

        // $("#addSR").modal();
        this.init_add()
    },
})