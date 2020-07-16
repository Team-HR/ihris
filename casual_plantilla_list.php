<?php
$title = "Casual Plantilla Setup";
$id = $_GET["id"];
require_once "header.php";
?>

<div class="ui container segment" id="app">
    <div class="ui form">
        <div class="ui grid">
            <div class="two column row">
                <div class="column">
                    <div class="field">
                        <label>Search Employee to Add:</label>
                        <select id="employeeSelector" class="ui clearable search dropdown" v-model="employeeToAdd">
                            <option value="">e.g. Lastname</option>
                            <template>
                                <option v-for="emp in casualEmployeesNotInlist" :value="emp.employee_id">{{emp.employee_name}}</option>
                            </template>
                        </select>
                    </div>
                    <button @click="addEmployee" class="ui green mini button">Add</button>
                </div>
            </div>
        </div>


    </div>

    <table class="ui mini very compact celled structured table">
        <thead>
            <tr class="center aligned">
                <th rowspan="2"></th>
                <th colspan="4">Name of Appointee/s</th>
                <th rowspan="2">Position Title</th>
                <th rowspan="2">Pay Grade</th>
                <th rowspan="2">Daily Wage</th>
                <th colspan="2">Period of Employment</th>
                <th rowspan="2">Nature of Appointment</th>
            </tr>
            <tr class="center aligned">
                <th>Lastname</th>
                <th>Firstname</th>
                <th>ext</th>
                <th>Middlename</th>
                <th>From</th>
                <th>To</th>
            </tr>
        </thead>
        <tbody>
            <template>
                <tr v-if="data.length == 0">
                    <td colspan="11" class="center aligned"> -- No Employees --</td>
                </tr>
                <tr v-for="dat in data">
                    <td></td>
                    <td>{{ dat.lastName }}</td>
                    <td>{{ dat.firstName }}</td>
                    <td>{{dat.extName}}</td>
                    <td>{{ dat.middleName }}</td>
                    <td class="center aligned">{{dat.position}}</td>
                    <td class="center aligned"></td>
                    <td class="center aligned"></td>
                    <td class="center aligned"></td>
                    <td class="center aligned"></td>
                    <td class="center aligned"></td>
                </tr>
            </template>
        </tbody>
    </table>
    <!-- modal start -->
    <div class="ui mini modal" id="addNewModal">
        <div class="header">Add Casual Employee</div>
        <div class="content">

        </div>
        <div class="actions">
            <button class="ui green approve mini button">Save</button>
            <button class="ui red deny mini button">Cancel</button>
        </div>
    </div>
    <!-- modal end -->
</div>
<script>
    Date.prototype.toDateInputValue = (function() {
        var local = new Date(this);
        local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
        return local.toJSON().slice(0, 4);
    });
    new Vue({
        el: "#app",
        data: {
            employeeToAdd: "",
            casualEmployeesNotInlist: [],
            plantilla_id: 0,
            data: []
        },
        methods: {
            getData() {
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
                    }
                });
            },
            initAdd() {
                $("#addNewModal").modal("show")
            },

            addEmployee() {
                $.ajax({
                    type: "post",
                    url: "casual_plantilla.ajax.php",
                    data: {
                        addEmployee: true,
                        plantilla_id: this.plantilla_id,
                        employee_id: this.employeeToAdd
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

            $_GET(param) {
                var vars = {};
                window.location.href.replace(location.hash, '').replace(
                    /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
                    function(m, key, value) { // callback
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
        },
    });
</script>

<?php require_once "footer.php"; ?>