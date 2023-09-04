Date.prototype.toDateInputValue = (function () {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0, 4);
});
new Vue({
    el: "#app",
    data: {
        plantillaInfo: [],
        employeeToAdd: "",
        pay_grade: "",
        daily_wage: "",
        from_date: "",
        to_date: "",
        casualEmployeesNotInlist: [],
        plantilla_id: 0,
        edit_data: {
            employee_name: "",
            pay_grade: "",
            daily_wage: "",
            from_date: "",
            to_date: ""
        },
        data: []
    },
    methods: {
        getData() {
            $.ajax({
                type: "post",
                url: "casual_plantilla.ajax.php",
                data: {
                    getPlantillaInfo: true,
                    plantilla_id: this.plantilla_id
                },
                dataType: "json",
                success: (response) => {
                    this.plantillaInfo = response
                },
                async: false
            });
            $.ajax({
                type: "post",
                url: "casual_plantilla.ajax.php",
                data: {
                    getEmployees: true,
                    plantilla_id: this.plantilla_id
                },
                dataType: "json",
                success: (response) => {
                    this.data = response
                },
                async: false
            });
            this.getCasualEmployeesNotInlist()
        },
        initAdd() {
            $("#addNewModal").modal("show")
        },
        delete_data(index) {
            $.ajax({
                type: "post",
                url: "./casual_plantilla.ajax.php",
                data: {
                    delete_data: true,
                    id: this.data[index].id
                },
                dataType: "json",
                success: (response) => {
                    this.data.splice(index, 1)
                    this.getCasualEmployeesNotInlist()
                }
            });
            // this.data.splice(index,1)
        },
        reset_form() {
            this.employee_name = ""
            this.pay_grade = ""
            this.daily_wage = ""
            this.from_date = ""
            this.to_date = ""
        },
        add_employee() {
            var data = {
                employee_id: this.employeeToAdd,
                pay_grade: this.pay_grade,
                daily_wage: this.daily_wage,
                from_date: this.from_date,
                to_date: this.to_date,
                nature: this.plantillaInfo.nature
            }
            $.ajax({
                type: "post",
                url: "casual_plantilla.ajax.php",
                data: {
                    add_employee: true,
                    plantilla_id: this.plantilla_id,
                    data: data
                },
                dataType: "json",
                success: (response) => {
                    if (response > 0) {
                        delete this.casualEmployeesNotInlist["id_" + this.employeeToAdd]
                        this.getData()
                    }
                },
                async: false
            });
        },

        getCasualEmployeesNotInlist() {
            $("#employeeSelector").dropdown("clear")
            $.ajax({
                type: "post",
                url: "casual_plantilla.ajax.php",
                data: {
                    getCasualEmployeesNotInlist: true,
                    plantilla_id: this.plantilla_id
                },
                dataType: "json",
                success: (response) => {
                    this.casualEmployeesNotInlist = response
                },
                async: false
            });
        },
        edit_func(index) {
            this.edit_data = this.data[index]
            $("#editModal").modal({
                onApprove: () => {
                    $.ajax({
                        type: "post",
                        url: "./casual_plantilla.ajax.php",
                        data: {
                            edit_data: true,
                            data: this.edit_data
                        },
                        dataType: "json",
                        success: (response) => {
                            console.log(response);
                        }
                    });
                }
            });
            $("#editModal").modal("show");
        },
        $_GET(param) {
            var vars = {};
            window.location.href.replace(location.hash, '').replace(
                /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
                function (m, key, value) { // callback
                    vars[key] = value !== undefined ? value : '';
                }
            );

            if (param) {
                return vars[param] ? vars[param] : null;
            }
            return vars;
        },

    },
    mounted() {
        $('#add_employee_form').form({
            keyboardShortcuts: false,
            fields: {
                // employeeSelector     : 'empty',
                pay_grade: 'empty',
                daily_wage: 'empty',
                from_date: 'empty',
                to_date: 'empty',
            }
        });
        $("#employeeSelector").dropdown({
            fullTextSearch: true,
            clearable: true
        })
        this.plantilla_id = this.$_GET("id")
        this.getData()
        this.from_date = this.plantillaInfo.period[0]
        this.to_date = this.plantillaInfo.period[1]
        $("#editModal").modal();

    },



});
