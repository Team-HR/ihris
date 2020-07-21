
var sr_app = new Vue({
    el: "#app_sr",
    data() {
        return {
            record_types: ['Appointment', 'Build-Up', 'Death', 'End of Casual Emp.', 'End of Term', 'Resignation', 'Retirement', 'Salary Adjustment', 'Step Increment'],
            statuses: ['Appointed', 'Add-in', 'Casual', 'Co-terminous', 'Contractual/Job Order', 'Elective', 'Permanent', 'Provisionary', 'Substitute', 'Temporary'],
            salaries: [],
            positions: [],
            place_of_assignments: [],
            records: [],
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
                    this.records = response
                    console.log(response);
                },
                async: false
            });
            this.get_positions()
            this.get_salaries()
            this.get_place_of_assignments()
        },
        get_salaries() {
            $.ajax({
                type: "post",
                url: "umbra/service_record/config.php",
                data: {
                    get_salaries: true
                },
                dataType: "json",
                success: (response) => {
                    this.salaries = response
                },
                async: false
            });
        },
        get_place_of_assignments() {
            $.ajax({
                type: "GET",
                url: "umbra/service_record/config.php",
                data: {
                    get_place_of_assignments: true
                },
                dataType: "json",
                success: (response) => {
                    this.place_of_assignments = response
                },
                async: false
            });
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
        clear_form() {
            $('.ui .dropdown').dropdown("clear")
            this.type = ""
            this.designation = ""
            this.status = ""
            this.rate = ""
            this.is_per_session = ""
            this.rate_on_schedule = ""
            this.date_from = ""
            this.date_to = ""
            this.place_of_assignment = ""
            this.branch = ""
            this.remarks = ""
            this.memo = ""
        },
        init_add() {
            $("#addSR").modal("show")
        },
        init_edit(index) {
            console.log("edit:", this.records[index]);
        },
        init_remove(index) {
            // console.log("remove:", index);
            // this.records.splice(index,1)
            // // delete this.records[key]
            
            $("#delete_modal").modal({
                onApprove:()=>{
                    this.records.splice(index,1)
                },
                duration: 0
            });
            $("#delete_modal").modal("show");
        },
        submit_form() {
            var data = {
                employee_id: this.employee_id,
                sr_type: this.type,
                sr_designation: this.designation,
                sr_status: this.status,
                sr_salary_rate: this.rate,
                sr_rate_on_schedule: this.rate_on_schedule,
                sr_is_per_session: this.is_per_session,
                sr_date_from: this.date_from,
                sr_date_to: this.date_to,
                sr_place_of_assignment: this.place_of_assignment,
                sr_branch: this.branch,
                sr_remarks: this.remarks,
                sr_memo: this.memo
            }

            console.log(data);
            $.ajax({
                type: "post",
                url: "umbra/service_record/config.php",
                data: {
                    submit_form: true,
                    sr_id: null,
                    data: data
                },
                dataType: "json",
                success: (response) => {
                    $("#addSR").modal("hide")
                    this.clear_form()
                    this.init_load()
                },
                async: false
            });
        },
        format_date(date) {
            var _date = moment(date).format("MMM DD,YYYY");
            return _date;
        }
    },
    mounted() {
        var queryString = window.location.search;
        var urlParams = new URLSearchParams(queryString);
        var employee_id = urlParams.get('employees_id')
        this.employee_id = employee_id;
        this.init_load()

        $("#addSR").modal({
            closable: false,
            duration: 0
        });

        $("#type_el").dropdown({
            showOnFocus: false,
            allowTab: false,
            onShow() {
                $("#designation_el").dropdown("hide others");
                // console.log("dropped!");
            }
        });

        $("#designation_el").dropdown({
            clearable: true,
            allowAdditions: true,
            forceSelection: true,
            allowTab: false,
            showOnFocus: false,
            hideAdditions: false
        });

        $("#status_el").dropdown({
            showOnFocus: false,
            allowTab: false,
        });
        $("#is_per_session_el").dropdown({
            showOnFocus: false,
            allowTab: false,
        });
        $("#rate_on_schedule_el").dropdown({
            clearable: true,
            keepOnScreen: false,
            showOnFocus: false,
            allowTab: false,
            fullTextSearch: "exact",
            allowAdditions: true
        });

        $("#place_of_assignment_el").dropdown({
            clearable: true,
            allowAdditions: true,
            allowTab: false,
            showOnFocus: false,
        });

        $("#branch_el").dropdown({
            showOnFocus: false,
            allowTab: false,
        });


        // this.init_add()

    },
})