<?php
$title = "Casual Plantilla Setup";
$id = $_GET["id"];
require_once "header.php";
?>

<div class="ui container borderless blue inverted mini menu">
    <div class="left item" style="margin-right: 0px !important;">
        <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
            <i class="icon chevron left"></i> Back
        </button>
    </div>
    <div class="item">
        <h3><i class="briefcase icon"></i>Casual Plantilla Editor</h3>
    </div>
    <div class="right item">
        <div class="ui right input">
            <button class="ui icon mini green button" onclick="addModalFunc()" style="margin-right: 5px;"
                title="Add New Department"><i class="icon print"></i> Print</button>
        </div>
    </div>
</div>
<div class="ui container segment" id="app">
    <template>
        <form class="ui form" @submit.prevent="add_employee" id="add_employee_form">
            <div class="ui stackable grid">
                <div class="column">
                    <div class="fields">
                        <div class="eight wide field">
                            <label>Employee:</label>
                            <select id="employeeSelector" class="ui clearable search fluid dropdown"
                                v-model="employeeToAdd" @keyup.enter="add_employee">
                                <option value="">e.g. Lastname</option>
                                <option v-for="emp in casualEmployeesNotInlist" :value="emp.employee_id">
                                    {{emp.employee_name}}</option>
                            </select>
                        </div>
                        <div class="field">
                            <label>Pay Grade:</label>
                            <input id="pay_grade" type="text" placeholder="e.g. 01-1" v-model="pay_grade">
                        </div>
                        <div class="field">
                            <label>Daily Wage:</label>
                            <input id="daily_wage" type="number" step="0.01" placeholder="e.g. 498.00"
                                v-model="daily_wage">
                        </div>
                        <div class="field">
                            <label>From:</label>
                            <input id="from_date" type="date" v-model="from_date">
                        </div>
                        <div class="field">
                            <label>To:</label>
                            <input id="to_date" type="date" v-model="to_date">
                        </div>
                    </div>
                    <button type="submit" class="ui green mini button">Add</button>
                </div>
            </div>
        </form>
        <table class="ui mini very compact celled structured table">
            <thead>
                <tr class="center aligned">
                    <th rowspan="2">No</th>
                    <th rowspan="2"></th>
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
                <tr v-if="data.length == 0">
                    <td colspan="13" class="center aligned"> -- No Listed Casual Employees --</td>
                </tr>
                <tr v-for="(dat,index)  in data">
                    <td class="center aligned">{{index + 1}}</td>
                    <td class="center aligned"><i class="icon link edit" @click="edit_func(index)"></i></td>
                    <td class="center aligned"><i class="icon times link" @click="delete_data(index)"></i></td>
                    <td>{{ dat.lastName }}</td>
                    <td>{{ dat.firstName }}</td>
                    <td>{{ dat.extName }}</td>
                    <td>{{ dat.middleName }}</td>
                    <td class="center aligned">{{dat.position}}</td>
                    <td class="center aligned">{{dat.pay_grade}}</td>
                    <td class="center aligned">{{dat.daily_wage}}</td>
                    <td class="center aligned">{{dat.from_date}}</td>
                    <td class="center aligned">{{dat.to_date}}</td>
                    <td class="center aligned">{{dat.nature}}</td>
                </tr>
            </tbody>
        </table>
        <!-- modal start -->
        <div class="ui mini modal" id="editModal">
            <div class="header">{{edit_data.employee_name}}</div>
            <div class="content">
                <div class="ui form">
                    <div class="field">
                        <label>Pay Grade:</label>
                        <input type="text" placeholder="01-1" v-model="edit_data.pay_grade">
                    </div>
                    <div class="field">
                        <label>Daily Wage:</label>
                        <input type="number" placeholder="498.00" v-model="edit_data.daily_wage">
                    </div>
                    <div class="field">
                        <label>From:</label>
                        <input type="date" v-model="edit_data.from_date">
                    </div>
                    <div class="field">
                        <label>To:</label>
                        <input type="date" v-model="edit_data.to_date">
                    </div>
                </div>
            </div>
            <div class="actions">
                <button class="ui green approve mini button">Save</button>
                <button class="ui red deny mini button">Cancel</button>
            </div>
        </div>
        <!-- modal end -->
    </template>
</div>

<script src="casual_plantilla_list.js"></script>

<?php require_once "footer.php"; ?>