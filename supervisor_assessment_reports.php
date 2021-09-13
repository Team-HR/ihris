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

                <div id="depts_dropdown" class="ui search selection dropdown" style="margin-top: 10px;">
                    <input type="hidden" name="department">
                    <div class="default text">Select Department</div>
                    <i class="dropdown icon"></i>
                    <div class="menu">
                        <div class="item" data-value="0">ALL DEPARTMENTS</div>
                        <div v-for="dept in departments" :key="dept.department_id" class="item" :data-value="dept.department_id">{{dept.department}}</div>
                    </div>
                </div>

                <!-- <div id="snum_rows" class="ui basic segment" style="font-size: 24px;">
                <i class="icon info blue tiny circle"></i><span id="num_rows" style="font-size: 13px; color: grey; font-style: italic;">
                    <div class="ui active mini inline loader"></div> Loading...
                </span>
            </div> -->

                <!-- <div class="ui grid center aligned" style="margin-bottom: 100px;">
        <div class="eight wide column" height="">
          <canvas id="overall_chart"></canvas>
        </div>
        <div class="eight wide column" height="">
          <canvas id="gender_chart"></canvas>
        </div>
      </div>-->
                <ol type="I">
                    <div class="ui segment" v-for="(comp,i) in competencies" :key="i" style="margin-top: 20px;">

                        <h2 class="ui primary header block">
                            <li style="margin-left: 20px;">
                                {{comp.department}}
                            </li>
                        </h2>

                        <div class="ui segment" v-for="(office,off_ind) in comp.offices" :key="office.office_id">
                            <h4 class="ui primary header block">{{(off_ind+1)+".) "+ office.office}}</h4>

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
                                <button class="ui small primary button" style="margin-top: 10px;" @click="view_in_depth_report(sup.superior_id)">View In-Depth Report</button>
                            </div>

                        </div>
                    </div>
                </ol>

            </div>
        </div>
    </template>
</div>
<script>
    var supervisor_competency_report_app = new Vue({
        el: "#supervisor_competency_report_app",
        data() {
            return {
                department_id: null,
                departments: [],
                competencies: []
            }
        },
        methods: {
            async get_data() {
                await $.get("supervisor_assessment_reports_proc.php", {
                        get_data: true,
                        department_id: this.department_id
                    }, (data, textStatus, jqXHR) => {
                        this.competencies = JSON.parse(JSON.stringify(data))
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
            view_in_depth_report(superiors_record_id) {
                alert(superiors_record_id)
            }
        },
        mounted() {
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