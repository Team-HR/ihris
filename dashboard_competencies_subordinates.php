<div id="subordinates-assessment-app">
    <!-- <button class="ui primary button">Setup Office</button> -->
    <!-- <label for="sort_year">Sort by Year:</label>
    <select name="year" id="sort_year" class="ui dropdown" v-model="year" @change="sort_by_year()">
        <option v-for="year in years" :key="year.id" :value="year.year" :selected="year.is_current">{{year.year}}</option>
    </select> -->

    <!-- <div class="ui basic segment">
        <canvas id="competency_self_assessment_chart" height="150"></canvas>
    </div> -->


    <!-- 
    <div class="ui middle aligned list">
        <div class="item" v-for="subordinate in subordinates" :key="subordinate.superior_records_id" @click="view_assessment(subordinate)">
            <div class="right floated content">
                <button class="ui mini primary button">View</button>
            </div>
            <div class="content">
                <div class="header">{{subordinate.full_name}}</div>
                {{format_position(subordinate.position,subordinate.functional)}}
            </div>
        </div>
    </div> 
    -->

    <label for="sort_year">Select Year:</label>
    <select name="year" id="sort_year" class="ui dropdown" v-model="year" @change="sort_by_year()">
        <option v-for="(year, y) in years" :key="year" :value="year.year" :selected="year.is_current">{{year.year}}</option>
    </select>

    <div :id="`${subordinate.employee_id}`" class="ui segment" v-for="(subordinate, s) in subordinates" :key="subordinate.superior_records_id">
        <strong>{{subordinate.full_name}}</strong> <br>
        <i>{{format_position(subordinate.position,subordinate.functional)}}</i> <br>
        <button v-if="!subordinate.is_sup_assessed" class="ui button primary pt-2" @click="assess_subordinate(subordinate)">Assess</button>
        <!-- <button v-else class="ui basic button primary pt-2" disabled>Assessed</button> -->
        <canvas :id="`competency_sup_assessment_chart${subordinate.superior_records_id}`" height="150"></canvas>
    </div>


    <!-- survey form start -->
    <div class="ui overlay fullscreen modal" id="subordinate_assessment_form_modal">
        <div class="content">
            <div class="ui fluid container">
                <div class="ui segment container" id="contextSurvey" style="width: 50%; _margin-top: 50px;">
                    <!-- left rail starts here -->
                    <div class="">
                        <div class="" style="width: 300px !important; height: 262.663px !important; left: 5%; position: fixed;">
                            <div class="ui segment">
                                <div class="ui link list" style="margin-left: 20px">
                                    <a href="#contextSurvey" class="item active" @click="page = -1">Top</a>
                                    <a v-for="(competency, c) in competencies" :key="c" class="item" :style="form_data.competency_scores[competency.id]?'color: green !important;':''" @click="page = c">{{`${c+1}.) ${competency.name}`}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- left rail ends here -->

                    <div class="ui form">
                        <div style="page-break-inside: avoid; font-size: 12px;">
                            <div :hidden="page > -1">
                                <button class="ui button primary large" @click="next_page()">Start</button>

                                <header class="ui block center aligned header" style="background-color: #607d8b; color: white;">
                                    <h3>JOB COMPETENCY PROFILE</h3>
                                </header>

                                <div class="ui container">
                                    <i style="font-size: 14px;">
                                        <p>Competencies are observable abilities, skills, knowledge, motivations or traits defined in terms of the behaviors needed for successful job performance.</p>
                                        <h4 style="font-weight: bold">PROFICIENCY/MASTERY LEVEL</h4>
                                        <p><b>Level 1 (Introductory)</b>: Demonstrates introductory understanding and ability and, with guidance, applies the competency in a few simple situations.</p>
                                        <p><b>Level 2 (Basic)</b>: Demonstrates basic knowledge and ability and, with guidance, can apply the competency in common situations that present limited difficulties.</p>
                                        <p><b>Level 3 (Intermediate)</b>: Demonstrates solid knowledge and ability, and can apply the competency with minimal or no guidance in the full range of typical situations. Would require guidance to handle novel or more complex situations.</p>
                                        <p><b>Level 4 (Advanced)</b>: Demonstrates advanced knowledge and ability, and can apply the competency in new or complex situations. Guides other professionals.</p>
                                        <p><b>Level 5 (Expert)</b>: Demonstrates expert knowledge and ability, and can apply the competency in the most complex situations. Develops new approaches, methods or policies in the area. Is recognized as an expert, internally and/or externally. Leads the guidance of other professionals.</p>
                                        <h4 style="font-weight: bold; display: inline-block;">INSTRUCTION:</h4>
                                        <p style="display: inline-block;"> Please check the proficiency/mastery level of each competency classifications that qualifies.</p>
                                    </i>
                                </div>
                            </div>
                            <div :hidden="page != c" v-for="(competency, c) in competencies" :key="c">

                                <button class="ui button primary large" @click="previous_page()">Previous</button>
                                <button v-if="page < 23" class="ui button primary large" @click="next_page()">Next</button>
                                <button v-if="page == 23" class="ui button green large" @click="submit_subordinate_assessment()">Submit</button>

                                <!-- {{competencies[page].id}} -->
                                <div :id="competency.id" class="subordinate_assessment_form_section" style="page-break-inside: avoid; font-size: 12px;">
                                    <br>
                                    <div>
                                        <header class="ui block header" style="background-color: #607d8b; color: white;">
                                            <h4>{{page+1}}. {{upper_case_name(competency.name)}}</h4>
                                        </header>
                                        <div class="ui container">
                                            <p>{{competency.description}}</p>
                                            <table class="w3-table w3-bordered">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th style="text-align: center; vertical-align: middle;">PROFICIENCY/MASTERY LEVEL</th>
                                                        <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(level,l) in competency.levels" :key="l">
                                                        <td colspan="2" style="width: 100px; text-align: left;">
                                                            <div class="ui checkbox">
                                                                <input type="radio" :value="(l+1)" :name="competency.id" v-model="form_data.competency_scores[competency.id]" style="transform: scale(2)">
                                                                <label> <strong>LEVEL {{l+1}}</strong><br>{{level.proficiency}} </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <ul>
                                                                <li v-for="(behavior,b) in level.behaviors" :key="b">{{behavior}}</li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="actions">
            <!-- <div class="ui approve button" @click="submit_subordinate_assessment()">Submit</div> -->
            <div class="ui cancel red button">Cancel</div>
        </div>
    </div>
    <!-- survey form end -->

</div>

<script>
    var subordinates_assessment_app = new Vue({
        el: "#subordinates-assessment-app",
        data() {
            return {
                years: [{
                        id: 1,
                        year: 2019,
                        is_current: false
                    },
                    {
                        id: 2,
                        year: 2020,
                        is_current: false
                    },
                    {
                        id: 3,
                        year: 2021,
                        is_current: false
                    },
                    {
                        id: 4,
                        year: 2022,
                        is_current: true
                    },
                ],
                year: 2022,
                charts: [],
                page: -1,
                subordinates: [],
                competencies: [],
                form_data: {
                    employee_id: "",
                    department_id: "",
                    competency_scores: {}
                },
                form_data_default: {
                    employee_id: "",
                    department_id: "",
                    competency_scores: {}
                }
            }
        },
        methods: {

            reset_form_data() {
                this.form_data = JSON.parse(JSON.stringify(this.form_data_default))
            },

            submit_subordinate_assessment() {
                // const competency_scores_length = Object.keys(this.form_data.competency_scores).length
                // if (competency_scores_length < 24) {
                //     alert("Not all competencies were completed. Please make sure all competencies are complete before submitting.");
                //     return false
                // }
                $.post("dashboard_competencies_subordinates_proc.php", {
                        submit_subordinate_assessment: true,
                        form_data: this.form_data
                    },
                    (data, textStatus, jqXHR) => {
                        if (data.status == "success") {
                            this.get_subordinates()
                            if (confirm("Assessment successfully saved!")) {
                                $("#subordinate_assessment_form_modal").modal("hide");
                            }
                        } else if (data.status == "invalid") {
                            alert(data.message)
                        } else if (data.status == "existing") {
                            alert(data.message)
                        }
                    },
                    "json"
                );
            },

            async check_if_subordinate_exists(subordinate) {
                // var exists = false;
                let result = await $.post("dashboard_competencies_subordinates_proc.php", {
                        check_if_subordinate_exists: true,
                        form_data: this.form_data
                    }, (data, textStatus, jqXHR) => {
                        // console.log(data.status);
                        // exists = data.status
                        return data.status
                    },
                    "json"
                );
                // console.log(exists);
                return result;
            },

            assess_subordinate(subordinate) {
                // console.log('assess_subordinate:', subordinate);
                this.form_data.employee_id = subordinate.employee_id

                this.check_if_subordinate_exists(subordinate).then(res => {
                    if (res.status) {
                        alert(res.message)
                    } else {
                        this.show_subordinate_assessment_form_modal()
                    }
                })
            },

            show_subordinate_assessment_form_modal() {
                $('#subordinate_assessment_form_modal')
                    .modal({
                        closable: false,
                        onHidden: () => {
                            this.page = -1
                            this.reset_form_data()
                        }

                    })
                    .modal('show')
            },

            previous_page() {
                this.page = this.page - 1
                // console.log('previous_page', this.page);
            },


            next_page() {
                this.page += 1;
                // console.log(this.competencies)
            },

            upper_case_name(name) {
                return name.toUpperCase()
            },

            view_assessment(subordinate) {
                // console.log(subordinate.full_name);
            },

            sort_by_year() {
                // console.log(this.year);
                this.get_subordinates()
            },

            format_position(position, functional) {
                var formatted_position = "";
                if (!position) {
                    return formatted_position;
                }
                formatted_position = position;
                if (functional) {
                    formatted_position += " - " + functional;
                }
                return formatted_position;
            },

            get_subordinates() {
                this.charts = [];
                $.post("dashboard_competencies_subordinates_proc.php", {
                        get_subordinates: true,
                        year: this.year
                    }, (data, textStatus, jqXHR) => {
                        this.subordinates = data
                        this.$nextTick(() => {
                            this.subordinates.forEach(subordinate => {
                                this.charts.push(this.create_chart(subordinate))
                            });
                        })
                    },
                    "json"
                );
                // $.ajax({
                //     type: "post",
                //     url: "dashboard_competencies_subordinates_proc.php",
                //     data: {
                //         get_subordinates: true
                //     },
                //     dataType: "json",
                //     success: (response) => {
                //         // console.log("get_user_role:", response);
                //         this.subordinates = response
                //         console.log(response);

                //         // this.$nextTick(() => {
                //         //     this.subordinates.forEach(subordinate => {
                //         //         this.create_chart(subordinate)
                //         //     });
                //         // })

                //     }
                // });
            },
            create_chart(subordinate) {
                var datasets = []
                var competency_sup_assessment_chart = $("#competency_sup_assessment_chart" + subordinate.superior_records_id);
                var competency_sup_assessment_chart_config = {
                    type: 'line',
                    data: {
                        labels: [
                            "Adaptability",
                            "Continuous Learning",
                            "Communication",
                            "Organizational Awareness",
                            "Creative Thinking",
                            "Networking Relationship Building",
                            "Conflict Management",
                            "Stewardship of Resources",
                            "Risk Management",
                            "Stress Management",
                            "Influence",
                            "Initiative",
                            "Team Leadership",
                            "Change Leadership",
                            "Client Focus",
                            "Partnering",
                            "Developing Others",
                            "Planning and Organizing",
                            "Decision Making",
                            "Analytical Thinking",
                            "Results Orientation",
                            "Teamwork",
                            "Values and Ethics",
                            "Visioning and Strategic Direction"
                        ],
                        datasets: subordinate.datasets
                    },
                    options: {
                        responsive: true,
                        title: {
                            display: true,
                            text: 'Self Assessment vs Supervisor\'s Assessment'
                        },
                        scales: {
                            xAxes: [{
                                display: true,
                                autoSkip: false
                            }],
                            yAxes: [{
                                ticks: {
                                    stepSize: 1,
                                    beginAtZero: true,
                                    max: 5
                                },
                                display: true
                            }]
                        }
                    }
                };

                return new Chart(competency_sup_assessment_chart, competency_sup_assessment_chart_config);
            }
        },
        created() {
            fetch('./competencies.json')
                .then(response => response.json())
                .then((obj) => {
                    this.competencies = obj.competencies
                    this.$nextTick(() => {
                        $('.ui.checkbox').checkbox()
                    })
                })
        },
        mounted() {
            this.get_subordinates()
            // console.log("mounted dashboard subordinates competencies")
        }
    })
</script>
<style type="text/css">
    p {
        margin-left: 20px;
    }

    .active {
        color: teal !important;
        margin-left: -10px;
        font-weight: bold;
    }

    .w3-check {
        transform: scale(2);
    }

    @media print {
        .printOnly {
            display: block;
        }

        .noprint {
            display: none;
        }

        .centerPrint {
            margin: 0px;
            width: 100% !important;
        }
    }

    .item {
        color: black !important;
    }

    .active {
        color: #607d8b !important;
    }
</style>