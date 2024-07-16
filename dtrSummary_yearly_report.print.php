<?php
require_once "vendor/autoload.php";
require_once "dtrSummary_yearly_report_config.php";
require_once "header.php";

$year = $_GET["year"];
$employee_ids = $_GET["ids"];
$employee_ids = explode(",", $employee_ids);
if (count($employee_ids) < 1 || !$year) return null;
$items = [];
foreach ($employee_ids as $employee_id) {
    $items[] = get_employee_dtr($mysqli, $employee_id, $year);
}

// $json_items = json_encode($items, JSON_PRETTY_PRINT);
// echo "<pre>$json_items</pre>";
// return false;
?>
<div id="dtrSummary_yearly_report_print">
    <template>
        <div class="ui basic segment">

            <div class="ui borderless menu">
                <div class="item">
                    <h2>PERSONNEL DTR REPORTS FOR THE YEAR {{year}}</h2>
                </div>
                <div class="right item">
                    <div class="ui right input">
                        <!-- temporary disable create pdf checklist of all applicants; work on changed data structure on arrays which now uses json -->
                        <!-- <a href="apc.php" target="_blank" class="ui icon mini green button" style="margin-right: 5px;"><i class="icon print"> </i>Print Checklists</a> -->
                        <button class="ui icon green button big" @click="print()" style="margin-right: 5px;"><i class="icon print"> </i> Print</button>
                        <div style="padding: 0px; margin: 0px; margin-right: 5px;">
                        </div>
                        <!-- <div class="ui icon fluid input" style="width: 300px;">
                            <input id="table_search" type="text" placeholder="Search...">
                            <i class="search icon"></i>
                        </div> -->
                    </div>
                </div>
            </div>

            <!-- <h2 class="ui header block">
                <div style="display: inline-block;">PERSONNEL DTR REPORTS FOR THE YEAR {{year}}</div>
                <div></div>
                 <button class="ui button right aligned">Print</button>
            </h2> -->
            <table class="ui compact small celled table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th></th>
                        <th v-for="(month, m) in months" :key="m">{{month}}</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <template>
                    <tr v-for="(item, index) in items" :key="index">
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

                            <!-- <i class="ui edit grey icon link noprint" @click="addEditRemarks(item.months[m].dtrsummary_remarks)"></i> -->

                        </td>
                        <td>
                            <i style="color:green;">
                                {{item.general_remarks ? item.general_remarks.remarks : '' }}
                            </i>
                            <!-- {{item.general_remarks}} -->
                            <!-- <button class="ui mini icon button basic noprint" @click="addEditRemarks(item.general_remarks)" style="white-space: nowrap;">
                                <i class="ui edit icon"></i> Remarks
                            </button> -->
                        </td>
                    </tr>

                </template>
            </table>

        </div>
    </template>

</div>
<script>
    new Vue({
        el: "#dtrSummary_yearly_report_print",
        data: {
            year: <?= $year ?>,
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
            items: <?= json_encode($items) ?>,
        },
        methods: {
            print() {
                window.print()
            },
        },
    });
</script>