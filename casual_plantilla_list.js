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
        pay_grade: "01-1",
        daily_wage: "498.00",
        from_date: "",
        to_date: "",
        casualEmployeesNotInlist: [],
        plantilla_id: 0,
        editData: {
            employee_name: "test",
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
                    // console.log(response);
                },
                async: false
            });
        },
        initAdd() {
            $("#addNewModal").modal("show")
        },
        addEmployee() {
            var data = {
                employee_id: this.employeeToAdd,
                pay_grade: this.pay_grade,
                daily_wage: this.daily_wage,
                from_date: this.from_date,
                to_date: this.to_date,
                nature: this.plantillaInfo.nature
            }
            // console.log(data);
            $.ajax({
                type: "post",
                url: "casual_plantilla.ajax.php",
                data: {
                    addEmployee: true,
                    plantilla_id: this.plantilla_id,
                    data: data
                },
                dataType: "json",
                success: (response) => {
                    console.log(response);
                    if (response > 0) {
                        delete this.casualEmployeesNotInlist["id_" + this.employeeToAdd]
                        $("#employeeSelector").dropdown("clear")
                        this.getData()
                    }
                },
                async: false
            });
        },

        getCasualEmployeesNotInlist() {
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
        edit(dat){
            this.editData = dat
            console.log(this.editData)
            // console.log(dat)
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
        }


    },
    mounted() {
        this.plantilla_id = this.$_GET("id")
        this.getCasualEmployeesNotInlist()
        this.getData()
        $("#employeeSelector").dropdown({
            fullTextSearch: true,
            clearable: true
        })
        this.from_date = this.plantillaInfo.period[0]
        this.to_date = this.plantillaInfo.period[1]
        $("#editModal").modal();
    },

});
