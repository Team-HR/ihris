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
                    <h3><i class="users icon"></i> DTR Yearly Report</h3>
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
                <table class="ui compact small celled table">
                    <tr>
                        <!-- <th>ID</th> -->
                        <th>Name</th>
                        <th>Status</th>
                        <th v-for="(month, m) in months" :key="m">{{month}}</th>
                    </tr>

                    <template>
                        <tr v-if="isLoading">
                            <td colspan="14" style="text-align: center;font-size: 24px;">
                                Loading data... Please wait...
                            </td>
                        </tr>
                        <tr v-else v-for="(item, index) in items" :key="index">
                            <!-- <td>{{item.id}}</td> -->
                            <td>{{item.name}}</td>
                            <td>{{item.employment_status}}</td>
                            <td v-for="(month, m) in 12" :key="m">
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
                            </td>
                        </tr>

                    </template>
                </table>

                <!-- content end -->

            </div>
        </div>
    </template>
</div>
<script>
    new Vue({
        el: "#dtrYearlyReportApp",
        data: {
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
            items: []
        },
        methods: {
            generateReport() {
                this.isLoading = true;
                $.post("dtrSummary_yearly_report_config.php", {
                        generateReport: true,
                        year: this.year,
                        employmentStatus: this.employmentStatus,
                    }, (data, textStatus, jqXHR) => {
                        this.items = data;
                        console.log(this.items);
                        this.isLoading = false
                    },
                    "json"
                );
            }
        },
        mounted() {
            this.generateReport()
            $("#employmentStatusDropdown").dropdown()
        },
    });
</script>
<?php
require_once "footer.php";
?>