<?php
$title = "DTR Yearly Report";
require_once "header.php";
?>
<style>


</style>

<div id="dtrYearlyReportApp">
    <template>
        <div class="ui fluid container" style="padding: 5px;">

            <div class="ui borderless blue inverted mini menu">
                <div class="left item" style="margin-right: 0px !important;">
                    <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
                        <i class="icon chevron left"></i> Back
                    </button>
                </div>
                <div class="item">
                    <h3><i class="sun icon"></i> Search for Sunshine Awardee Employee</h3>
                </div>

                <div class="right item">
                    <!-- <a href="print_employee_list.php" class="ui button " style="margin-right: 10px;">Print</a>
                <button onclick="addModalFunc()" class="green ui icon fluid button" style="margin-right: 10px;" title="Add Personnel">
                    <i class="icon user plus"></i> Add
                </button>
                <div class="ui icon input">
                    <input id="employee_search" type="text" placeholder="Search...">
                    <i class="search icon"></i>
                </div> -->
                </div>
            </div>

            <div class="ui segment">
                <form class="ui form" @submit.prevent="generateReport()">
                    <div class="fields">
                        <div class="field">
                            <label>Select Year:</label>
                            <input type="number" placeholder="Enter Year" v-model="year" required style="width: 150px;">
                            <!-- <input type="submit" value="Generate" class="ui button blue"> -->
                        </div>
                        <div class="field">
                            <label>Select Employment Status:</label>
                            <select name="employmentStatusDropdown" id="employmentStatusDropdown" v-model="employmentStatus">
                                <option value="" disabled>Select employment status</option>
                                <option value="ALL">All</option>
                                <option value="PERMANENT">Permanent</option>
                                <option value="CASUAL">Casual</option>
                            </select>
                        </div>
                        <div class="field">
                            <br>
                            <input type="submit" value="Generate" class="ui button blue" style="margin-top: 4px;">
                        </div>
                    </div>
                </form>
                <div class="ui divider"></div>
                <!-- content start -->
                <h2 class="ui header block">{{employmentStatus}} PERSONNEL DTR REPORTS FOR THE YEAR {{year}}</h2>
                <table class="ui compact small celled table" style="font-size: 11px;">
                    <thead>
                        <tr>
                            <th>
                                <!-- <div class="ui checkbox selectAllcheckbox">
                                    <input type="checkbox" name="selectAll" id="selectAll">
                                    <label for="selectAll"> Select_all</label>
                                </div> -->
                                Print
                            </th>
                            <th></th>
                            <th>Name</th>
                            <th></th>
                            <th v-for="(month, m) in months" :key="m">{{month}}</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>

                    <template>
                        <tr v-if="isLoading">
                            <td colspan="16" style="text-align: center;font-size: 24px;">
                                Loading data... Please wait...
                            </td>
                        </tr>
                        <tr v-else v-for="(item, index) in items" :key="index" :style="isSelected(index)">
                            <td class="center aligned">
                                <div class="ui checkbox">
                                    <input type="checkbox" name="selectForPrint" id="selectForPrint" v-model="printSelections" :value="index">
                                    <label for="selectForPrint"> </label>
                                </div>
                            </td>
                            <td>{{index+1}}</td>
                            <td>{{item.name}}</td>
                            <td>{{item.employment_status[0]}}</td>
                            <td v-for="(month, m) in 12" :key="m">

                                <!-- item.remarks[{{month}}] -->
                                <!-- {{'2023_'+item.id}}.general_remarks.m{{(m+1)}} -->
                                <template v-if="item.months[m] != ''">
                                    Tardy(n): <span v-if="item.months[m].totalTardy != '0' || item.months[m].totalTardy != 0" style="color: red;">{{item.months[m].totalTardy}}</span>
                                    <span v-else><i style="color: grey;">none</i></span>
                                    <br>
                                    UT:
                                    <span v-if="item.months[m].totalMinsUndertime != '0' || item.months[m].totalMinsUndertime != 0" style="color: red;">{{item.months[m].totalMinsUndertime}} mins</span>
                                    <span v-else><i style="color: grey;">none</i></span>
                                    <br>
                                    Absences:
                                    <br>
                                    <span v-if="item.months[m].remarks != ''" style="color: red;">{{item.months[m].remarks}}</span>
                                    <span v-else><i style="color: grey;">none</i></span>
                                </template>
                                <template v-else>
                                    <div>
                                        No <br>record <br>found
                                    </div>
                                </template>

                                <!-- <button class="ui mini icon button basic" @click="addEditRemarks(`${year}_${item.id}`,'m'+(m+1))" style="white-space: nowrap;">
                                        <i class="ui edit icon"></i>
                                    </button> -->
                                <br>
                                <!-- {{item.months[m].dtrsummary_remarks}} -->
                                Remarks: <i style="color:green;">{{item.months[m].dtrsummary_remarks ? item.months[m].dtrsummary_remarks.remarks : ''}}</i>
                                <i class="ui edit grey icon link" @click="addEditRemarks(item.months[m].dtrsummary_remarks)"></i>

                            </td>
                            <td>
                                <i style="color:green;">
                                    {{item.general_remarks ? item.general_remarks.remarks : '' }}
                                </i>
                                <!-- {{item.general_remarks}} -->
                                <button class="ui mini icon button basic" @click="addEditRemarks(item.general_remarks)" style="white-space: nowrap;">
                                    <i class="ui edit icon"></i> Remarks
                                </button>

                            </td>
                        </tr>

                    </template>
                </table>

                <!-- content end -->

            </div>
        </div>


        <div id="addEditRemarksModal" class="ui modal tiny">
            <div class="header">Remarks</div>
            <div class="content">
                <div class="ui form">
                    <div class="field ui fluid input">
                        <textarea v-model="editRemarks.remarks" name="remarksInput" id="remarksInput" rows="10" style="width: 100%;" placeholder="Enter comments here"></textarea>
                    </div>
                </div>
            </div>
            <div class="actions">
                <div class="ui approve small button primary"><i class="ui save icon"></i>Save</div>
                <div class="ui cancel small button">Cancel</div>
            </div>
        </div>


    </template>


    <a :href="`dtrSummary_yearly_report.print.php?year=${year}&ids=${printSelectionsEmployeeIds}`" target="_blank" class="printBtn ui big button green" :class="printSelections.length > 0 ? '':'disabled'" @click="printSelected()"><i class="ui print icon"></i>{{printSelectedNum}} Print Selected</a>
    <!-- printSelections -->



</div>
<style>
    .printBtn {
        position: fixed;
        bottom: 50px;
        right: 50px;
    }
</style>
<script>
    new Vue({
        el: "#dtrYearlyReportApp",
        data: {
            printSelections: [],
            printSelectionsEmployeeIds: [],
            isLoading: null,
            year: 2023, //curr year - 1
            employmentStatus: "ALL",
            months: [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December"
            ],
            items: [],
            editRemarks: {
                identifier: null,
                column_name: null,
                remarks: null
            }
        },
        watch: {
            printSelections(newValue, oldValue) {
                // console.log(newValue);
                // printSelectionsEmployeeIds
                this.printSelectionsEmployeeIds = [];
                newValue.forEach(index => {
                    // console.log(index);
                    this.printSelectionsEmployeeIds.push(this.items[index].id)
                });
                // this.printSelectionsEmployeeIds = JSON.stringify(this.printSelectionsEmployeeIds)
                console.log(this.printSelectionsEmployeeIds);
            },
        },
        computed: {
            printSelectedNum() {
                if (this.printSelections.length > 0) {
                    return `(${this.printSelections.length})`;
                }

            }
        },
        methods: {
            isSelected(index) {
                if (this.printSelections.includes(index)) {
                    return "background-color: #1a80001c;"
                }
            },

            generateReport() {
                this.isLoading = true;
                $.post("dtrSummary_yearly_report_config.php", {
                        generateReport: true,
                        year: this.year,
                        employmentStatus: this.employmentStatus,
                    }, (data, textStatus, jqXHR) => {
                        this.items = data;
                        // console.log(this.items);
                        this.isLoading = false
                    },
                    "json"
                );
            },
            addEditRemarks(dtrsummary_remarks) {
                // console.log(dtrsummary_remarks);
                // return false;
                this.editRemarks.identifier = dtrsummary_remarks.identifier
                this.editRemarks.column_name = dtrsummary_remarks.column_name
                this.editRemarks.remarks = dtrsummary_remarks.remarks
                $("#addEditRemarksModal").modal("show");
            },
            submitRemarks() {
                $.post("dtrSummary_yearly_report_config.php", {
                        submitRemarks: true,
                        payload: this.editRemarks
                    }, (data, textStatus, jqXHR) => {
                        // console.log(data);
                        this.generateReport()
                    },
                    "json"
                );
            },

            printSelected() {
                if (this.printSelections.length > 0) {
                    var printData = [];
                    this.printSelections.sort()
                    this.printSelections.forEach(element => {
                        printData.push(this.items[element])
                    });
                    console.log(this.printSelections);
                    console.log(printData); //item selected for printing

                    // $.get("dtrSummary_yearly_report.print.php", {
                    //     ids: this.printSelections
                    // })

                    // $.post("dtrSummary_yearly_report_config.php", {
                    //         print: true,
                    //         printData: printData
                    //     }, (data, textStatus, jqXHR) => {
                    //         console.log('print: ', data);
                    //     },
                    //     "json"
                    // );
                } else console.log("Nothing selected");
            }

        },
        mounted() {
            $(".ui.checkbox").checkbox();
            $(".selectAllcheckbox").checkbox({

            });


            this.generateReport()
            $("#employmentStatusDropdown").dropdown()
            $("#addEditRemarksModal").modal({
                closable: false,
                onApprove: () => {
                    this.submitRemarks()
                }
            })
        },
    });
</script>
<?php
require_once "footer.php";
?>