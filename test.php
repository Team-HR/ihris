<?php
$title = "Competency Comparative Report";
require "header.php";

?>

<style type="text/css">
    table {
        margin-top: 100px !important;
        border-collapse: collapse;
        /* border-collapse: separate;
        border-spacing: 0 1em; */
    }

    /* .datatr:hover {
        background-color: #cbffc0;
    } */

    td {
        /* border: 1px solid #5ea3ff; */
        text-align: center;
    }

    th.rotate {
        height: 150px;
        white-space: nowrap;
    }

    th.rotate>div {
        transform:
            translate(18px, 51px) rotate(315deg);
        width: 30px;

    }

    th.rotate>div>span {
        border-bottom: 1px solid #5ea3ff;
        padding: 5px 10px;
    }

    /* .reportTb tr:nth-child(even) {
        background-color: #edf3fb;
    } */
</style>

<div id="comparativeComp">
    <div class="ui segment container" style="min-height: 500px; min-width: 1500px; padding-bottom: 100px;">

        <!-- department selector start -->
        <label for="department_selector">Filter by department:</label>
        <select class="ui search dropdown" id="department_selector" v-model="department_id" @change="filter_by_department()">
            <option value="">Select a department</option>
            <option v-for="department in departments" :key="department.department_id" :value="department.department_id">{{department.department}}</option>
        </select>
        <!-- department selector end -->

        <button class="ui primary button" style="margin-left: 25px;" @click="view_in_depth_dept()">View In-Depth Report</button>

        <div :hidden="done_loading">
            <div class="ui active inverted dimmer" style="height: 300px;">
                <div class="ui text big loader">Loading</div>
            </div>
            <div v-for="i in 2" :key="i" class="ui segment" style="width: 1000px; margin: auto; margin-top: 50px;">
                <div class="ui placeholder">
                    <div class="paragraph">
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                    </div>
                    <div class="paragraph">
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                    </div>
                </div>
            </div>
        </div>

        <div :hidden="!done_loading" v-for="(item, i) in data" :key="i" style="margin-top: 25px;">
            <h3 class="ui header blue block">{{ item.department }}</h3>
            <div v-for="office in item.offices" :key="office.id" style="margin-top: 25px;">
                <h4 class="ui green header">{{ office.office }}</h4>
                <div v-for="sup in office.supervisors" :key="sup.superior_id">
                    <h5 style="margin-left: 25px;">SUPERVISOR: {{ sup.full_name }}</h5>
                    <!-- chart start -->
                    <!-- <div style="width: 300px;">
                        <canvas :id="`chart${sup.superior_id}`" width="400" height="400"></canvas>
                    </div> -->
                    <!-- chart end -->
                    <table class="reportTb" style="margin: auto;">
                        <thead>
                            <tr>
                                <th style="text-align: left; font-size:small;">
                                    Legends: <br>
                                    <i class="icon circle blue"></i> - Supervisor Assessment <br>
                                    <i class="icon circle green"></i> - Self Assessment
                                </th>
                                <th style="vertical-align: bottom;"></th>
                                <th class="rotate">
                                    <div><span>Adaptability</span></div>
                                </th>
                                <th class="rotate">
                                    <div><span>Continous Learning</span></div>
                                </th>
                                <th class="rotate">
                                    <div><span>Communication</span></div>
                                </th>
                                <th class="rotate">
                                    <div><span>Organizational Awareness</span></div>
                                </th>
                                <th class="rotate">
                                    <div><span>Creative Thinking</span></div>
                                </th>
                                <th class="rotate">
                                    <div><span>Networking/Relationship Building</span></div>
                                </th>
                                <th class="rotate">
                                    <div><span>Conflict Management</span></div>
                                </th>
                                <th class="rotate">
                                    <div><span>Stewardship of Resources</span></div>
                                </th>
                                <th class="rotate">
                                    <div><span>Risk Management</span></div>
                                </th>
                                <th class="rotate">
                                    <div><span>Stress Management</span></div>
                                </th>
                                <th class="rotate">
                                    <div><span>Influence</span></div>
                                </th>
                                <th class="rotate">
                                    <div><span>Initiative</span></div>
                                </th>
                                <th class="rotate">
                                    <div><span>Team Leadership</span></div>
                                </th>
                                <th class="rotate">
                                    <div><span>Change Leadership</span></div>
                                </th>
                                <th class="rotate">
                                    <div><span>Client Focus</span></div>
                                </th>
                                <th class="rotate">
                                    <div><span>Partnering</span></div>
                                </th>
                                <th class="rotate">
                                    <div><span>Developing Others</span></div>
                                </th>
                                <th class="rotate">
                                    <div><span>Planning and Organizing</span></div>
                                </th>
                                <th class="rotate">
                                    <div><span>Decision Making</span></div>
                                </th>
                                <th class="rotate">
                                    <div><span>Analytical Thinking</span></div>
                                </th>
                                <th class="rotate">
                                    <div><span>Results Orientation</span></div>
                                </th>
                                <th class="rotate">
                                    <div><span>Teamwork</span></div>
                                </th>
                                <th class="rotate">
                                    <div><span>Values and Ethics</span></div>
                                </th>
                                <th class="rotate">
                                    <div><span>Visioning and Strategic Direction</span></div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(sub, s) in sup.subordinates" :key="s">
                                <tr>
                                    <td colspan="26" style="padding: 10px; background-color: lightgrey;"></td>
                                </tr>
                                <tr class="datatr" style="border-top: solid blue 3px; margin-top: 5px;">
                                    <td rowspan="3" style="text-align: left;">{{sub.full_name}}</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #5ea3ff;"><i class="icon circle blue"></i></td>
                                    <template v-if="sub.competency_scores != 0">
                                        <td v-for="(score, score_ind) in sub.competency_scores" :key="score_ind" :style='set_color(score)' style="border: 1px solid #5ea3ff;">
                                            {{score}}
                                        </td>
                                    </template>
                                    <template v-else>
                                        <td colspan="24" style="border: 1px solid #5ea3ff; background-color: #0061c540;">No supervisor assessment</td>
                                    </template>

                                </tr>
                                <tr class="datatr" style="border-bottom: solid blue 3px;">
                                    <td style="border: 1px solid #5ea3ff;">
                                        <i class="icon circle green"></i>
                                    </td>
                                    <template v-if="sub.competency_scores_self_assessed.length != 0">
                                        <td v-for="(score, score_ind) in sub.competency_scores_self_assessed" :key="score_ind" :style='set_color_self_assessed(score)' style="border: 1px solid #5ea3ff;">
                                            {{score}}
                                        </td>
                                    </template>
                                    <template v-else>
                                        <td colspan="24" style="border: 1px solid #5ea3ff; background-color: #27ff0038;">No self assessment</td>
                                    </template>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                    <!-- <button class="ui primary button" style="margin-top: 30px; margin-left: 200px;" @click="view_in_depth(sup)">View In-Depth Report</button> -->
                </div>
            </div>
        </div>
    </div>
    <!-- in depth by dept modal start -->
    <div class="ui fullscreen modal" id="in_depth_by_dept_modal">
        <div class="header">
            <!--  -->
            <!-- DEPARTMENT NAME -->
        </div>
        <div class="content">
            <label>Select Competency: </label>
            <select class="ui dropdown" @change="update_chart_in_depth_dept()">
                <option v-for="(competency, c) in competencies" :key="c" :value="competency.name">{{ competency.name }}</option>
            </select>
            <select class="ui dropdown">
                <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
            </select>


            <div class="ui basic segment">
                <div style="width: 1000px;">
                    <canvas id="chart_in_depth_dept" width="1000" height="1000"></canvas>
                </div>
            </div>


            <div class="actions">
                <div class="ui deny button">
                    Close
                </div>
            </div>
        </div>
        <!-- in depth by dept modal end -->
        <!-- in depth per sup modal start -->
        <div class="ui fullscreen modal" id="in_depth_modal">
            <div class="header">
                SUPERVISOR: {{in_depth_modal.sup.full_name}}
            </div>
            <div class="content">
                <label>Select Competency: </label>
                <select id="comps_dropdown" class="ui dropdown">
                    <option v-for="(competency, c) in competencies" :key="c" :value="competency.name">{{ competency.name }}</option>
                </select>


                <div class="ui basic segment">
                    UNDER DEVELOPMENT <br>
                </div>

            </div>
            <div class="actions">
                <div class="ui deny button">
                    Close
                </div>
            </div>
        </div>
        <!-- in depth per sup modal end -->
    </div>
    <script>
        new Vue({
            el: "#comparativeComp",
            data() {
                return {
                    departments: [],
                    department_id: 12, //default 0
                    done_loading: false,
                    data: [],
                    charts: [],
                    in_depth_modal: {
                        sup: {}
                    },
                    competencies: [],
                    chart_in_depth_dept: {},
                    years: [
                        2022,
                        2021,
                        2020,
                        2019
                    ]
                }
            },
            methods: {
                view_in_depth_dept() {
                    console.log(this.department_id);

                    $("#in_depth_by_dept_modal .ui.dropdown").dropdown({
                        showOnFocus: false
                    })
                    $("#in_depth_by_dept_modal").modal({
                        onVisible: () => {
                            this.create_chart_in_depth_dept()
                        },
                        onHidden: () => {
                            $("#in_depth_by_dept_modal .ui.dropdown").dropdown("restore defaults");
                        }
                    }).modal("show")
                },
                create_chart_in_depth_dept() {

                    var config = {
                        type: 'horizontalBar',
                        data: {
                            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                            datasets: [{
                                    label: 'Supervisor Assessments 2019',
                                    data: [3, 2, 3, 5, 4, 1],
                                },
                                {
                                    label: 'Supervisor Assessmentz 2020',
                                    data: [5, 4, 3, 5, 2, 3],
                                },
                                {
                                    label: 'Self Assessmentz 2019',
                                    data: [2, 1, 3, 3, 4, 4],
                                },
                                {
                                    label: 'Self Assessmentz 2020',
                                    data: [3, 2, 3, 1, 5, 4],
                                }
                            ]
                        },
                        options: {
                            scales: {
                                xAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    }

                    var ctx = document.getElementById('chart_in_depth_dept').getContext('2d');
                    this.chart_in_depth_dept = new Chart(ctx, config);

                },
                update_chart_in_depth_dept() {
                    this.destroy_chart_in_depth_dept()
                    this.create_chart_in_depth_dept()
                },
                destroy_chart_in_depth_dept() {
                    this.chart_in_depth_dept.destroy()
                },






                get_in_depth_dept_data() {
                    $.get("test_proc.php", {
                            get_in_depth_dept_data: true,
                            competency: "",
                            department_id: 0,
                        }, (data, textStatus, jqXHR) => {
                            console.log('get_in_depth_dept_data:', data);
                        },
                        "json"
                    );
                },
                view_in_depth(sup) {
                    this.in_depth_modal.sup = sup
                    $("#comps_dropdown").dropdown();
                    $("#in_depth_modal").modal({
                        autofocus: false,
                        forceSelection: false,
                        onHidden: () => {
                            $("#comps_dropdown").dropdown("restore defaults");
                        }
                    }).modal("show");
                },
                get_competencies() {
                    $.get("supervisor_assessment_reports_proc.php", {
                            get_competency_dictionary: true
                        }, (data, textStatus, jqXHR) => {
                            this.competencies = JSON.parse(JSON.stringify(data))
                        },
                        "json"
                    );
                },
                get_data() {
                    $.post("test_proc.php", {
                            get_data: true,
                            department_id: this.department_id
                        }, (data, textStatus, jqXHR) => {
                            console.log('get_data:', data);
                            this.data = data;
                            this.set_loading_done()
                        },
                        "json"
                    );

                    // // ############################## for testing start
                    // setTimeout(() => {
                    //     this.set_loading_done()
                    // }, 1000);
                    // // ############################### for testing end
                },
                filter_by_department() {
                    this.get_data()
                    this.set_loading()
                },
                set_loading() {
                    this.done_loading = false
                },
                set_color(score) {
                    if (score == 3) return "background-color: #88baecd1; color: white;"
                    else if (score == 4) return "background-color: #016dd8c4; color: white;"
                    else if (score == 5) return "background-color: #016dd8; color: white;"
                },
                set_color_self_assessed(score) {
                    if (score == 3) return "background-color: #1ca703b0; color: white;"
                    else if (score == 4) return "background-color: #1ca703; color: white;"
                    else if (score == 5) return "background-color: #0e5c00; color: white;"
                },

                get_departments() {
                    $.get("test_proc.php", {
                            get_departments: true
                        }, (data, textStatus, jqXHR) => {
                            // console.log(data);
                            this.departments = data;
                        },
                        "json"
                    );
                },

                set_loading_done() {
                    this.$nextTick(() => {
                        // var ctx = document.getElementById('chart24').getContext('2d');
                        // var myChart = new Chart(ctx, this.chart_config());
                        this.done_loading = true;
                    })
                },

                chart_config() {
                    var config = {
                        type: 'bar',
                        data: {
                            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                            datasets: [{
                                    label: 'Supervisor Assessment',
                                    data: [12, 19, 3, 5, 2, 3],
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(255, 99, 132, 0.2)',
                                    ],
                                    borderWidth: 1
                                },
                                {
                                    label: 'Self Assessment',
                                    data: [12, 19, 3, 5, 2, 3],
                                    backgroundColor: [
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                    ],
                                    borderWidth: 1
                                }
                            ]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    }
                    return config;
                }
            },
            mounted() {

                $("#department_selector").dropdown();
                this.get_departments()
                this.get_data()
                this.get_competencies()
                // this.done_loading = false;
                // setTimeout(() => {
                //     this.set_loading_done()
                // }, 1000);
            },
            created() {


            }
        })
    </script>

    <?php
    require "footer.php";
    ?>