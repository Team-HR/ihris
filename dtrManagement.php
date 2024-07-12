<?php
$title = "Leave Ledger";

require_once "header.php";
?>


<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/fomantic-ui@2.9.3/dist/semantic.min.css">
<script src="https://cdn.jsdelivr.net/npm/fomantic-ui@2.9.3/dist/semantic.min.js"></script>


<div class="ui segment" id="leaveLedger" style="width: 700px; margin: auto">
    <template>

        <form @submit.prevent="" style="width: 500px; margin: auto; margin-bottom: 5px; margin-top: 20px;">
            <div class="field">
                <label><b>Employee:</b></label>
                <select class="ui search clearable dropdown fluid" id="employeeDropdown" v-model="selectedEmployee">
                    <option value="">Select Employee</option>
                    <option v-for="emp, e in employees" :key="e" :value="emp.employees_id">
                        {{ emp.fullName }}
                    </option>
                </select>
            </div>


            <div class="field" style="margin-top: 15px;">
                <label><b>Month-Year:</b></label>
                <br>
                <div class="ui input" :class="selectedEmployee ? '' : 'disabled'">
                    <input type="month" v-model="monthYear">
                </div>
            </div>



            <button type="button" :class="dtrIsSubmitted ? 'green' : 'grey'" class="ui right labeled icon green button" style="margin-bottom: 10px;margin-top: 10px;" @click="dtrSubmitted()" :disabled="isLoading || !selectedEmployee || !monthYear">
                DTR Submitted
                <i :class="dtrIsSubmitted ? 'check' : 'question'" class="icon"></i>
            </button>



        </form>



        <!-- <li v-for="(item, index) in rows" :key="index">
      {{index+1}} || {{item}}
    </li> -->
        <!-- {{ monthYear }} -->
        <!-- <div class="ui active dimmer" style="height: 200px; ">
      <div class="ui indeterminate text loader">Preparing Files</div>
    </div> -->





        <table v-if="!isLoading && (selectedEmployee && monthYear)" class="ui table mini head stuck compact celled structured" style="width: _500px; margin: auto; ">

            <thead>
                <tr class="center aligned">
                    <th rowspan="2">Day</th>
                    <th colspan="2">Am</th>
                    <th colspan="2">Pm</th>
                    <th rowspan="2">Tardiness (mins)</th>
                    <th rowspan="2">Undertime (mins)</th>
                    <th rowspan="2">Remarks</th>
                    <th rowspan="2">Actions</th>
                </tr>
                <tr class="center aligned">
                    <th>In</th>
                    <th>Out</th>
                    <th>In</th>
                    <th>Out</th>
                </tr>
            </thead>
            <!-- #eeff123b -->
            <template v-for="item, index in rows">
                <tr :key="index" :style="{backgroundColor: (item.day == 'SUN' || item.day == 'SAT' ?'#eeff123b':'')}">
                    <td width="55" v-if="item.day != 'SAT' && item.day != 'SUN'">{{index+1}}</td>
                    <td width="55" v-else>{{item.day}}</td>

                    <template v-if="item.attendDate">
                        <td width="85" :style="{color: (item.tardyAm?'red':''), backgroundColor: (!item.amIn && item.day != 'SAT' && item.day != 'SUN'?'#bcbcbc57':'')}">
                            {{item.amIn ? item.amIn : ''}}
                        </td>
                        <td width="85" :style="{color: (item.undertimeAm?'red':''), backgroundColor: (!item.amOut && item.day != 'SAT' && item.day != 'SUN' ?'#bcbcbc57':'')}">
                            {{item.amOut ? item.amOut : ''}}
                        </td>
                        <td width="85" :style="{color: (item.tardyPm?'red':''), backgroundColor: (!item.pmIn && item.day != 'SAT' && item.day != 'SUN' ?'#bcbcbc57':'')}">
                            {{item.pmIn ? item.pmIn : ''}}
                        </td>
                        <td width="85" :style="{color: (item.undertimePm?'red':''), backgroundColor: (!item.pmOut && item.day != 'SAT' && item.day != 'SUN' ?'#bcbcbc57':'')}">
                            {{item.pmOut ? item.pmOut : ''}}
                        </td>
                        <td class="center aligned" style="color: red; font-weight: bold;">{{item.isConfirmed ? item.tardies ? item.tardies : '' :''}}</td>
                        <td class="center aligned" style="color: red; font-weight: bold;">{{item.isConfirmed ? item.undertimes ? item.undertimes : '' : ''}}</td>
                        <td><b style="color: red;">{{item.other}}</b></td>
                        <td><button class="ui button mini basic" @click="confirm(item)">Actions</button></td>
                    </template>
                    <template v-else>
                        <td colspan="8">
                            {{item}}
                        </td>
                    </template>


                </tr>
            </template>
        </table>

        <h1 class="ui header block" v-else-if="isLoading && (selectedEmployee && monthYear)">Loading...</h1>

        <div style="position: fixed; top: 54px; right: 194px; width:200px;" class="ui segment">
            Total tardiness: <span style="color:red;">{{(summary.totalTardy ? summary.totalTardy + " mins":"---")}}</span> <br />
            No. of times tardy: <span style="color:red;">{{(summary.timesTardy?summary.timesTardy:"---")}}</span> <br />
            Total undertime: <span style="color:red;">{{(summary.totalUndertime ? summary.totalUndertime+ " mins":"---")}}</span> <br />
        </div>



        <div class="ui modal actions mini">
            <div class="header">
                DTR Management Form
            </div>
            <div class=" content">

                <form class="ui form" id="actionsForm" @submit.prevent="">
                    Tardiness
                    <hr>
                    <div class="two column fields">
                        <div class="field">
                            <label for="">AM</label>
                            <input type="number" name="tardyAm" v-model="selectedRow.tardyAm" placeholder="---">
                        </div>
                        <div class="field">
                            <label for="">PM</label>
                            <input type="number" name="tardyPm" v-model="selectedRow.tardyPm" placeholder="---">
                        </div>
                    </div>
                    Undertime
                    <hr>
                    <div class="two column fields">
                        <div class="field">
                            <label for="">AM</label>
                            <input type="number" name="undertimeAm" v-model="selectedRow.undertimeAm" placeholder="---">
                        </div>
                        <div class="field">
                            <label for="">PM</label>
                            <input type="number" name="undertimePm" v-model="selectedRow.undertimePm" placeholder="---">
                        </div>
                    </div>
                    Others
                    <hr>
                    <div class="field">
                        <!-- <label for="">Others:</label> -->
                        <input type="text" name="other" v-model="selectedRow.other" placeholder="Enter remarks here...">
                    </div>
                </form>
            </div>
            <div class="actions">
                <button class="ui black deny button">
                    Cancel
                </button>
                <button class="ui positive right labeled icon button" type="submit" form="actionsForm">
                    Confirm
                    <i class="checkmark icon"></i>
                </button>
            </div>
        </div>



    </template>
</div>

<style>
    th {
        padding: 3px !important;
    }
</style>


<script>
    var leaveLedger = new Vue({
        el: "#leaveLedger",
        data: {
            dtrIsSubmitted: false,
            summary: {
                totalTardy: 0,
                timesTardy: 0,
                totalUndertime: 0,
            },
            isLoading: false,
            selectedEmployee: null,
            monthYear: null,
            employees: [],
            rows: [],
            selectedRow: {
                tardyAm: null,
                tardyPm: null,
                undertimeAm: null,
                undertimePm: null,
                other: null,
            }
        },
        watch: {
            selectedEmployee(newValue, oldValue) {
                this.isLoading = true
                if (newValue && this.monthYear) {
                    this.getRows()
                }
            },
            monthYear(newValue, oldValue) {
                this.isLoading = true
                this.getRows()
            }
        },

        methods: {
            confirm(item) {
                this.selectedRow = item
                this.selectedRow.tardyAm = this.selectedRow.tardyAm == 0 ? null : this.selectedRow.tardyAm;
                this.selectedRow.tardyPm = this.selectedRow.tardyPm == 0 ? null : this.selectedRow.tardyPm;
                this.selectedRow.undertimeAm = this.selectedRow.undertimeAm == 0 ? null : this.selectedRow.undertimeAm;
                this.selectedRow.undertimePm = this.selectedRow.undertimePm == 0 ? null : this.selectedRow.undertimePm;

                $('.ui.modal.actions').modal({
                    closable: false,
                    onApprove: () => {
                        this.saveActions()
                    }
                }).modal('show');

            },

            saveActions() {
                $.post("dtrManagement.config.php", {
                        saveActions: true,
                        employee_id: this.selectedEmployee,
                        selectedRow: this.selectedRow
                    },
                    (data, textStatus, jqXHR) => {
                        this.getRows().then(() => {
                            this.saveToDtrsummary()
                        })
                    },
                    "json"
                );
            },

            dtrSubmitted() {

                if (this.dtrIsSubmitted) {
                    if (confirm("Revert DTR not submitted?") == true) {
                        $.post("dtrManagement.config.php", {
                                dtrNotSubmitted: true,
                                period: this.monthYear,
                                emp_id: this.selectedEmployee
                            }, (data, textStatus, jqXHR) => {
                                this.dtrIsSubmitted = data;
                            },
                            "json"
                        );
                    }
                } else {
                    $.post("dtrManagement.config.php", {
                            dtrSubmitted: true,
                            period: this.monthYear,
                            emp_id: this.selectedEmployee
                        }, (data, textStatus, jqXHR) => {
                            this.dtrIsSubmitted = data;
                            this.saveToDtrsummary()
                        },
                        "json"
                    );
                }
            },

            async getRows() {
                await $.post("dtrManagement.config.php", {
                        getRows: true,
                        employee_id: this.selectedEmployee,
                        monthYear: this.monthYear,
                    }, (data, textStatus, jqXHR) => {
                        this.dtrIsSubmitted = data.submitted
                        this.rows = data.rows

                        this.summary.employee = data.employee
                        this.summary.period = data.period
                        this.summary.timesTardy = data.timesTardy
                        this.summary.totalTardy = data.totalTardy
                        this.summary.totalUndertime = data.totalUndertime
                        this.summary.halfDaysTardy = data.halfDaysTardy
                        this.summary.halfDaysUndertime = data.halfDaysUndertime
                        this.summary.allRemarks = data.allRemarks

                        this.isLoading = false
                        // console.log(this.summary);
                    },
                    "json"
                );
            },

            async saveToDtrsummary() {
                await $.post("dtrManagement.config.php", {
                        saveToDtrsummary: true,
                        data: this.summary,
                    }, (data, textStatus, jqXHR) => {
                        console.log("saveToDtrsummary: ", data);
                    },
                    "json"
                );
            },

            getEmployeesList() {
                $.post("dtrManagement.config.php", {
                        getEmployeesList: true,
                    }, (data, textStatus, jqXHR) => {
                        this.employees = data
                    },
                    "json"
                );
            }
        },
        mounted() {
            this.getEmployeesList()
            // this.getRows()

            $("#employeeDropdown").dropdown({
                fullTextSearch: true,
                duration: 50,
                forceSelection: false
            })

        },

    })
</script>

<?php
require_once "footer.php";
?>