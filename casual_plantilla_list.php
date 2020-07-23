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
        <h3><i class="briefcase icon"></i>Casual Plantilla</h3>
    </div>
    <div class="right item">
        <div class="ui right input">
            <button class="ui icon mini green button" onclick="addModalFunc()" style="margin-right: 5px;" title="Add New Department"><i class="icon print"></i> Print</button>
        </div>
    </div>
</div>

<div class="ui container segment" id="app">
    <template>
        <div class="ui form">
            <div class="ui stackable grid">
                <div class="column">
                    <div class="fields">
                        <div class="eight wide field">
                            <label>Search Employee to Add:</label>
                            <select id="employeeSelector" class="ui clearable search fluid dropdown" v-model="employeeToAdd">
                                <option value="">e.g. Lastname</option>
                                <option v-for="emp in casualEmployeesNotInlist" :value="emp.employee_id">{{emp.employee_name}}</option>
                            </select>
                        </div>
                        <div class="field">
                            <label>Pay Grade:</label>
                            <input type="text" placeholder="01-1" v-model="pay_grade">
                        </div>
                        <div class="field">
                            <label>Daily Wage:</label>
                            <input type="number" placeholder="498.00" v-model="daily_wage">
                        </div>
                        <div class="field">
                            <label>From:</label>
                            <input type="date" v-model="from_date">
                        </div>
                        <div class="field">
                            <label>To:</label>
                            <input type="date" v-model="to_date">
                        </div>
                    </div>
                    <button @click="addEmployee" class="ui green mini button">Add</button>
                </div>
            </div>
        </div>

        <table class="ui mini very compact celled structured table">
            <thead>
                <tr class="center aligned">
                    <th rowspan="2">
                        <!-- <input type="checkbox"> -->
                    </th>
                    <th colspan="4">Name of Appointee/s</th>
                    <th rowspan="2">Position Title</th>
                    <th rowspan="2">Pay Grade</th>
                    <th rowspan="2">Daily Wage</th>
                    <th colspan="2">Period of Employment</th>
                    <th rowspan="2">Nature of Appointment</th>
                    <th rowspan="2"></th>
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
                    <td colspan="11" class="center aligned"> -- No Employees --</td>
                </tr>
                <tr v-for="dat in data">
                    <td class="center aligned">
                        <i class="icon link edit" @click="edit(dat)"></i>
                    </td>
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
                    <td class="center aligned"><i class="icon times link"></i></td>
                </tr>
            </tbody>
        </table>
        <!-- modal start -->
        <div class="ui mini modal" id="editModal">
            <div class="header">Edit</div>
            <div class="content">
                <div class="ui form">
                    <div class="field">
                        <label>Search Employee to Add:</label>
                        <input style="border: 0px; border-bottom: 1px solid lightgrey; border-radius: 0px;" readonly type="text" v-model="editData.employee_name">
                    </div>
                    <div class="field">
                        <label>Pay Grade:</label>
                        <input type="text" placeholder="01-1" v-model="editData.pay_grade">
                    </div>
                    <div class="field">
                        <label>Daily Wage:</label>
                        <input type="number" placeholder="498.00" v-model="editData.daily_wage">
                    </div>
                    <div class="field">
                        <label>From:</label>
                        <input type="date" v-model="editData.from_date">
                    </div>
                    <div class="field">
                        <label>To:</label>
                        <input type="date" v-model="editData.to_date">
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