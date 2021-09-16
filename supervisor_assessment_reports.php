<?php $title = "Competency Report";
require_once "header.php";
require_once "_connect.db.php"; ?>
<script src="js/competencies_array.js"></script>

<style type="text/css">
    table {
        margin-top: 100px !important;
        border-collapse: collapse;
    }

    .datatr:hover {
        background-color: #cbffc0;
    }

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

    .reportTb tr:nth-child(even) {
        background-color: #edf3fb;
    }
</style>

<div class="ui container" style="width: 1300px; margin-bottom: 20px;">
    <div class="ui borderless blue inverted mini menu noprint">
        <div class="left item" style="margin-right: 0px !important;">
            <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
                <i class="icon chevron left"></i> Back
            </button>
        </div>
        <div class="item">
            <h3><i class="icon chart line"></i>Supervisor Competency Report</h3>
        </div>
        <div class="right item">
            <!-- <a href="personnelCompetenciesReport_gen_report.php" class="ui small green button"><i class="ui icon print"></i> Generate Report</a> -->
        </div>
    </div>
</div>

<div id="supervisor_competency_report_app" class="ui container" style="background-color: white; width: 1300px;">
    <template>
        <div class="ui segment">
            <!-- <div class="ui top attached tabular menu" id="tabs">
                <a class="item active" data-tab="report">Overall Survey Report</a>
                <a class="item" data-tab="reportindepth">In-Depth Survey Report</a>
            </div> -->
            <!-- <div class="ui bottom attached tab active" data-tab="report"> -->
            <div>
                <label> Select Department: </label>
                <div id="depts_dropdown" class="ui search selection dropdown" :class="is_loading?'disabled':''" style="margin-top: 10px;">
                    <input type="hidden" name="department">
                    <div class="default text">Select Department</div>
                    <i class="dropdown icon"></i>
                    <div class="menu">
                        <div class="item" data-value="0">ALL DEPARTMENTS</div>
                        <div v-for="dept in departments" :key="dept.department_id" class="item" :data-value="dept.department_id">{{dept.department}}</div>
                    </div>
                </div>


                <div class="ui segment" v-if="is_loading">
                    <div class="ui active inverted dimmer">
                        <div class="ui large text loader">Loading</div>
                    </div>
                    <p style="height: 500px;"></p>
                </div>


                <ol type="I">
                    <div class="ui basic segment" v-for="(comp,i) in competencies" :key="i" style="margin-top: 20px;">

                        <h2 class="ui primary header">
                            <li style="margin-left: 20px;">
                                {{comp.department}}
                            </li>
                        </h2>

                        <div class="ui basic segment" v-for="(office,off_ind) in comp.offices" :key="office.office_id">
                            <h4 class="ui primary header">{{(off_ind+1)+".) "+ office.office}}</h4>

                            <div class="ui basic segment" v-for="(sup,sup_ind) in office.supervisors" :key="sup.superior_id">
                                <h5 class="ui primary header">{{"SUPERVISOR: "+ sup.full_name}} <span style="color: white; font-size: 10px;">SUPERIOR_ID:{{sup.superior_id}}</span></h5>
                                <table class="reportTb">
                                    <thead>
                                        <tr>
                                            <th></th>
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
                                        <tr v-for="(sub, sub_ind) in sup.subordinates" :key="sup.superiors_record_id" class="datatr" :style="!sub.is_complete?'background-color:#cecece;':''">
                                            <td>{{sub_ind+1}}.)</td>
                                            <td style="text-align: left;">{{sub.full_name}}</td>
                                            <template v-if="sub.is_complete">
                                                <td v-for="(score, score_ind) in sub.competency_scores" :key="score_ind" :style='set_color(score)'>
                                                    {{score}}
                                                </td>
                                            </template>
                                            <template v-else>
                                                <td colspan="24">Not Assessed</td>
                                            </template>
                                        </tr>
                                    </tbody>
                                </table>
                                <button v-if="sup.num_completed" class="ui small primary button" style="margin-top: 10px;" @click="show_indepth_report(sup.superior_id)">View In-Depth Report</button>
                            </div>

                        </div>
                    </div>
                </ol>

            </div>
        </div>


        <!-- fullscreen modal start -->
        <div id="in_depth_modal" class="ui fullscreen modal">
            <!-- <div class="header">Header</div> -->
            <div class="ui basic segment scrolling content" style="min-height: 1000px;">
                <!-- competency dropdown start -->
                <label>Select Competency: </label>
                <div id="comps_dropdown" class="ui search selection dropdown" :class="is_loading?'disabled':''" style="margin-top: 10px;" tabindex="">
                    <input type="hidden" name="competency">
                    <div class="default text">Select Competency</div>
                    <i class="dropdown icon"></i>
                    <div class="menu">
                        <div v-for="(comp,k) in competency_dictionary" :key="k" class="item" :data-value="k">{{comp.name}}</div>
                    </div>
                </div>
                <!-- <button class="ui small deny button">Close</button> -->
                <!-- competency dropdown end -->
                <!-- competency definition card start  -->
                <div class="ui segment">
                    <h3 class="ui primary header">{{competency_dictionary_selected.name}}</h3>
                    <p>{{competency_dictionary_selected.description}}</p>
                </div>
                <!-- competency definition card end  -->
                <!-- chart start -->
                <!-- <div style="max-width: 800px;">
                <canvas id="competency_in_depth_chart"></canvas>
                </div> -->
                <div class="ui grid">
                    <div class="eight wide column"><canvas id="number_bar_chart"></canvas></div>
                    <div class="eight wide column"><canvas id="percent_doughnut_chart"></canvas></div>
                </div>
                <!-- chart end -->
                <!-- competency definition table start -->
                <table class="ui structured celled compact large table">
                    <thead>
                        <!-- <tr class="center aligned"> -->
                        <tr>
                            <th v-for="(lvl,l) in competency_dictionary_selected.levels" :key="l" style="font-size: 14px;">
                                Level {{l+1}}
                                <br>
                                <cite style="font-weight: normal;">{{lvl.proficiency}}</cite>
                                <br>
                                <p style="font-weight: normal;">{{in_depth_data_selected.bar[l]+" in "+in_depth_data_selected.total}} ({{in_depth_data_selected.pie[l]+"%"}}) personnel</p>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td v-for="(employees, emps) in in_depth_data_selected.personnel" :key="emps" style="vertical-align: top; font-size: 14px;">
                                <ol>
                                    <li v-for="(employee,e) in employees" :key="e">{{employee.full_name}}</li>
                                </ol>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- competency definition table end -->
            </div>
            <div class="actions">
                <button class="ui small deny button">Close</button>
            </div>
        </div>
        <!-- fullscreen modal end -->


    </template>
</div>
<script>
    var supervisor_competency_report_app = new Vue({
        el: "#supervisor_competency_report_app",
        data() {
            return {
                department_id: null,
                departments: [],
                competencies: [],
                competency_dictionary: [],
                competency_dictionary_selected: {},
                is_loading: true,
                in_depth_data: [],
                in_depth_data_selected: {},
                bar_chart: null,
                doughnut_chart: null

            }
        },
        methods: {
            async show_indepth_report(superior_id) {
                // $("#comps_dropdown").dropdown("set value", "0")
                await this.get_in_depth_data(superior_id).then((res) => {
                    this.in_depth_data = JSON.parse(JSON.stringify(res))
                    $("#in_depth_modal").modal({
                        onHide: ($el) => {
                            this.bar_chart.destroy()
                            this.doughnut_chart.destroy()
                            this.competency_dictionary_selected = {}
                        }
                    }).modal("show")
                    $("#comps_dropdown").dropdown("set selected", 0)
                    this.set_in_depth_competency(0)
                })
            },

            async get_in_depth_data(superior_id) {
                let result
                try {
                    result = await $.get("supervisor_assessment_reports_proc.php", {
                            get_in_depth_data: true,
                            superior_id: superior_id
                        }, (data, textStatus, jqXHR) => {
                            result = data
                        },
                        "json"
                    );
                    return result
                } catch (error) {
                    console.log(error);
                }
            },

            async get_data() {
                this.is_loading = true
                await $.get("supervisor_assessment_reports_proc.php", {
                        get_data: true,
                        department_id: this.department_id
                    }, (data, textStatus, jqXHR) => {
                        this.competencies = JSON.parse(JSON.stringify(data))
                        this.is_loading = false
                    },
                    "json"
                );
            },
            async get_departments() {
                await $.get("supervisor_assessment_reports_proc.php", {
                        get_departments: true
                    }, (data, textStatus, jqXHR) => {
                        this.departments = JSON.parse(JSON.stringify(data))
                    },
                    "json"
                );
            },
            set_color(score) {
                if (score == 3) return "background-color: #88baecd1; color: white;"
                else if (score == 4) return "background-color: #016dd8c4; color: white;"
                else if (score == 5) return "background-color: #016dd8; color: white;"
            },
            async get_competency_dictionary() {
                await $.get("supervisor_assessment_reports_proc.php", {
                        get_competency_dictionary: true
                    }, (data, textStatus, jqXHR) => {
                        // console.log('competencies:',data);
                        this.competency_dictionary = JSON.parse(JSON.stringify(data))
                    },
                    "json"
                );
            },
            create_charts() {
                if (this.bar_chart && this.doughnut_chart) {
                    this.bar_chart.destroy()
                    this.doughnut_chart.destroy()
                }

                const bar_data = this.in_depth_data_selected.bar
                const pie_data = this.in_depth_data_selected.pie

                var config = {
                    type: 'bar',
                    data: {
                        labels: ["Level 1", "Level 2", "Level 3", "Level 4", "Level 5"],
                        datasets: [{
                            label: '# of personnel',
                            data: bar_data,
                            backgroundColor: [
                                "#acf0f2",
                                "#00d1fd",
                                "#00aaff",
                                "#0079ff",
                                "#2c1dff"
                            ],
                            fill: false,
                            borderWidth: 1,
                            lineTension: 0,
                        }]
                    },
                    options: {
                        tooltips: {
                            callbacks: {
                                // label: function(tooltipItem, data) {
                                //     var label = data.datasets[tooltipItem.datasetIndex].label || '';

                                //     if (label) {
                                //         label += 'Level ';
                                //     }
                                //     label += tooltipItem.yLabel;
                                //     return label;
                                // }
                            }
                        },
                        responsive: true,
                        title: {
                            display: true,
                            text: "Number of Personnel / Level"
                        },
                        legend: {
                            display: true,
                        },
                        scales: {
                            xAxes: [{
                                ticks: {
                                    // fontSize:14,
                                    // min: 0,
                                    // max: 25,
                                    // beginAtZero: true,
                                    // stepSize:1
                                    autoSkip: false,
                                }
                            }],
                            yAxes: [{
                                display: true,
                                ticks: {
                                    beginAtZero: true,
                                    stepSize: 1,
                                    autoSkip: false,
                                    // max: 5
                                }
                            }],
                        },
                        onClick: function(evt, items) {

                            //   var firstPoint = this.getElementAtEvent(evt)[0];
                            //   if (firstPoint) {
                            //     var label = this.data.labels[firstPoint._index];
                            //     var value = this.data.datasets[firstPoint._datasetIndex].data[firstPoint._index];
                            //     showCompInfo(label, value);
                            //   }

                        }

                    }
                };
                var config2 = {
                    type: 'pie',
                    data: {
                        labels: [
                            "Level 1",
                            "Level 2",
                            "Level 3",
                            "Level 4",
                            "Level 5",
                        ],
                        datasets: [{
                            label: 'Percentage',
                            data: pie_data,
                            backgroundColor: [
                                "#acf0f2",
                                "#00d1fd",
                                "#00aaff",
                                "#0079ff",
                                "#2c1dff",
                            ],
                            fill: true,
                            borderWidth: 2,
                        }]
                    },
                    options: {
                        // multiTooltipTemplate: "<%%=datasetLabel%%> : <%%= value %%>",
                        tooltips: {
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    var datasetIndex = tooltipItem.datasetIndex
                                    var dataIndex = tooltipItem.index
                                    var tooltip = ""
                                    var value = data.datasets[datasetIndex].data[dataIndex]
                                    var label = data.labels[dataIndex]
                                    tooltip += label + ": " + value + "%";
                                    return tooltip;
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: "Percentage of Personnels per Level"
                        },
                        legend: {
                            display: true,
                        },
                    }
                };

                var number_bar_chart = $("#number_bar_chart")
                var percent_doughnut_chart = $("#percent_doughnut_chart")

                this.bar_chart = new Chart(number_bar_chart, config)
                this.doughnut_chart = new Chart(percent_doughnut_chart, config2)
            },
            set_in_depth_competency(index) {
                this.competency_dictionary_selected = JSON.parse(JSON.stringify(this.competency_dictionary[index]))
                this.in_depth_data_selected = JSON.parse(JSON.stringify(this.in_depth_data[index]))
                this.create_charts()
            }
        },
        mounted() {
            this.get_competency_dictionary().then(() => {
                $("#comps_dropdown").dropdown({
                    autofocus: false,
                    fullTextSearch: true,
                    forceSelection: false,
                    onChange: (value, text, $choice) => {
                        this.set_in_depth_competency(value)
                    }
                })
            })
            this.get_data()
            this.get_departments().then(() => {
                $("#depts_dropdown").dropdown({
                    fullTextSearch: true,
                    forceSelection: false,
                    onChange: (value, text, $choice) => {
                        this.department_id = value
                        this.get_data()
                    }
                })
            })


        }
    });
</script>

<?php require_once "footer.php"; ?>