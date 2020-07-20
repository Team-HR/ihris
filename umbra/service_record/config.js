
var sr = new Vue({
    el: "#app_sr",
    data: {
        srtype_array: ['Appointment', 'Build-Up', 'Death', 'End of Casual Emp.', 'End of Term', 'Resignation', 'Retirement', 'Salary Adjustment', 'Step Increment'],
        status_array: ['Appointed', 'Add-in', 'Casual', 'Co-terminous', 'Contractual/Job Order', 'Elective', 'Permanent', 'Provisionary', 'Substitute', 'Temporary'],
        salary_array: [],
        sr_data: [],
        sr_form: "",
        designation_form: "",
        status_form: "",
        from_form: "",
        to_form: "",
        assign_form: "",
        branch_form: "",
        remarks_form: "",
        memo_form: "",
        salaryPerSchedule: 0,
        session_form: "",
        salaryAnnual: "",
        srEditId: '',
        positions: [],
        is_per_session: false
    },
    methods: {
        openAddSr: function () {
            $('#addSR').modal('show');
            sr.sr_form = ""
            sr.designation_form = ""
            sr.status_form = ""
            sr.salary_form = ""
            sr.from_form = ""
            sr.to_form = ""
            sr.assign_form = ""
            sr.branch_form = ""
            sr.remarks_form = ""
            sr.memo_form = ""
            sr.salaryPerSchedule = 0;
            sr.session_form = ""
            sr.salaryAnnual = "";
            sr.srEditId = "";
        },
        editor: function (i) {
            dat = sr.sr_data[i]
            $('#sr_form').dropdown('set selected', dat.sr_type);
            sr.designation_form = dat.sr_designation;
            $('#status_form').dropdown('set selected', dat.status);
            sr.from_form = dat.sr_from;
            sr.to_form = dat.sr_to;
            sr.assign_form = dat.sr_place_of_assignment;
            $('#branch_form').dropdown('set selected', dat.sr_branch);
            sr.remarks_form = dat.remarks;
            sr.memo_form = dat.sr_memo;
            $('#session_form').dropdown('set selected', dat.is_per_session);
            sr.salaryAnnual = dat.sr_salary_rate;
            sr.srEditId = dat.id;
            $('#addSR').modal('show');
        },
        get_designation: function () {
            var fd = new FormData();
            fd.append('getSalary', true);
            var xml = new XMLHttpRequest();
            xml.onload = function () {
                sr.salary_array = JSON.parse(this.responseText);
            };
            xml.open('POST', 'umbra/service_record/config.php', false);
            xml.send(fd);
        },
        save_form_data: function (dataId) {
            var salary = 0;
            var session = 0;
            if (sr.salaryPerSchedule != 0 && sr.salaryPerSchedule != "") {
                salary = sr.salaryPerSchedule * 12;
            } else {
                salary = sr.salaryAnnual;
                session = sr.session_form;
            }

            // $str = " srEditI: " + sr.srEditI +
            //     " sr_form: " + sr.sr_form +
            //     " designation_form: " + sr.designation_form +
            //     " status_form: " + sr.status_form +
            //     " from_form: " + sr.from_form +
            //     " to_form: " + sr.to_form +
            //     " assign_form: " + sr.assign_form +
            //     " branch_form: " + sr.branch_form +
            //     " remarks_form: " + sr.remarks_form +
            //     " memo_form: " + sr.memo_form;
            // console.log($str);

            var fd = new FormData();
            fd.append('save_form', dataId);
            fd.append('editData', sr.srEditId)
            fd.append('sr_form', sr.sr_form);
            fd.append('designation_form', sr.designation_form);
            fd.append('status_form', sr.status_form);
            fd.append('salary_form', salary);
            fd.append('session_form', session);
            fd.append('from_form', sr.from_form);
            fd.append('to_form', sr.to_form);
            fd.append('assign_form', sr.assign_form);
            fd.append('branch_form', sr.branch_form);
            fd.append('remark_form', sr.remarks_form);
            fd.append('memo_form', sr.memo_form);
            var xml = new XMLHttpRequest();
            xml.onload = function () {
                var res = JSON.parse(xml.responseText);
                $('body').toast({ class: res.status, message: res.msg });
                $('#addSR').modal('hide');
                sr.sr_data = res.dat;
            }
            xml.open('POST', 'umbra/service_record/config.php', true);
            xml.send(fd);
        },
        get_srData: function () {
            var employee = document.getElementById('srTable').attributes['data-id'].value;
            var fd = new FormData();
            fd.append('get_srData', employee);
            var xml = new XMLHttpRequest();
            xml.onload = function () {
                sr.sr_data = JSON.parse(xml.responseText)
            }
            xml.open('POST', 'umbra/service_record/config.php', true);
            xml.send(fd);
        },
        formatNumber: function (num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
        },
        removeSr: function (dataId) {
            con = confirm('Are you sure?\nCANNOT BE UNDONE');
            if (con) {
                var fd = new FormData();
                fd.append('remove', dataId);
                var xml = new XMLHttpRequest();
                xml.onload = function () {
                    sr.get_srData();
                }
                xml.open('POST', 'umbra/service_record/config.php', true);
                xml.send(fd);
            }
        },
        getPositions() {
            $.ajax({
                type: "post",
                url: "umbra/service_record/config.php",
                data: {
                    getPositions: true
                },
                dataType: "json",
                success: (response) => {
                    this.positions = response
                },
                async: false
            });
        }
    },
    watch: {
        session_form: function(val,oldVal){
            if(val == ""|| val == 0){
                this.is_per_session = false
                this.salaryPerSchedule = "0"
            } else {
                this.is_per_session = true
                this.salaryAnnual = ""
            }
        }
    },
     mounted() {
        // $('#sr_form').dropdown({
        //     showOnFocus: false,
        // });
        // $('#status_form').dropdown({
        //     showOnFocus: false,
        // });
        // $('#designation_dropdown').dropdown({
        //     showOnFocus: false,
        //     fullTextSearch: "exact",
        //     clearable: true
        // });

        $('#place_of_assignment_dropdown').dropdown({
            showOnFocus: false,
            fullTextSearch: "exact",
            clearable: true
        });
        
        $('#sr_form').dropdown("set selected", "Build-Up");
        var isReady = setInterval(() => {
            if (document.readyState == "complete") {
                sr.get_designation();
                sr.get_srData();
                this.openAddSr()
                this.getPositions()
                clearInterval(isReady);

            }
        }, 500);
    }
})


