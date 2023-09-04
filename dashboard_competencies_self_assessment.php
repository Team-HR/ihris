<div id="competency_self_assessment">
    <label for="sort_year">Sort by Year:</label>
    <select name="year" id="sort_year" class="ui dropdown" v-model="year" @change="sort_by_year()">
        <option value="0">All</option>
        <option v-for="year in years" :key="year.id" :value="year.year">{{year.year}}</option>
    </select>

    <!-- survey form start -->
    <div class="ui overlay fullscreen modal" id="self_assessment_form_modal">
        <div class="content">
            <div class="ui fluid container">
                <div class="ui segment container" id="contextSurvey" style="width: 50%; _margin-top: 50px;">
                    <!-- left rail starts here -->
                    <div class="">
                        <div class="" style="width: 300px !important; height: 262.663px !important; left: 5%; position: fixed;">
                            <div class="ui segment">
                                <div class="ui link list" style="margin-left: 20px">
                                    <a href="#contextSurvey" class="item active" @click="page = -1">Top</a>
                                    <a v-for="(competency, c) in competencies" :key="competency.id" class="item" :style="form_data.competency_scores[competency.id]?'color: green !important;':''" @click="page = c">{{`${c+1}.) ${competency.name}`}}</a>
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
                                <button v-if="page == 23" class="ui button green large" @click="submit_self_assessment()">Submit</button>

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
            <!-- <div class="ui approve button" @click="submit_self_assessment()">Submit</div> -->
            <div class="ui cancel red button">Cancel</div>
        </div>
    </div>
    <!-- survey form end -->
    <button class="ui primary button" style="margin-left: 15px;" v-if="is_not_assessed" @click="show_subordinate_assessment_form_modal()">Assess Self</button>

    <div class="ui segment">
        <canvas id="competency_self_assessment_chart" height="150"></canvas>
    </div>

</div>
<script>
    new Vue({
        el: "#competency_self_assessment",
        data() {
            return {
                datasets: [],
                is_not_assessed: false,
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
                page: -1,
                year: 0,
                chart: '',
                competencies: [],
                form_data: {
                    // employee_id: "",
                    // department_id: "",
                    competency_scores: {}
                },
                form_data_default: {
                    // employee_id: "",
                    // department_id: "",
                    competency_scores: {}
                }
            }
        },
        methods: {
            show_subordinate_assessment_form_modal() {
                $('#self_assessment_form_modal')
                    .modal({
                        closable: false,
                        onHidden: () => {
                            this.page = -1
                            this.reset_form_data()
                        }
                    })
                    .modal('show')
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
            reset_form_data() {
                this.form_data = JSON.parse(JSON.stringify(this.form_data_default))
            },
            submit_self_assessment() {
                console.log(this.form_data);
                $.post("dashboard_competencies_self_assessment_proc.php", {
                        submit_self_assessment: true,
                        form_data: this.form_data,
                        year: this.year
                    },
                    (data, textStatus, jqXHR) => {
                        if (data.status == "success") {
                            this.is_not_assessed = false
                            this.year = 0
                            this.get_data()
                            if (confirm("Assessment successfully saved!")) {
                                $("#self_assessment_form_modal").modal("hide");
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
            sort_by_year() {
                // if (this.chart) {
                //     this.chart.destroy()
                // }
                // get index of data with selected year
                var i = -1; // -1 means show all years
                for (let index = 0; index < this.datasets.length; index++) {
                    if (this.year == 0) {
                        this.is_not_assessed = false
                        i = -1;
                        break;
                    } else if (this.datasets[index].label == this.year) {
                        this.is_not_assessed = false
                        i = index;
                        break;
                    } else {
                        this.is_not_assessed = true
                        i = -2
                    }
                }
                this.create_chart(i)
            },

            upper_case_name(name) {
                return name.toUpperCase()
            },

            previous_page() {
                this.page = this.page - 1
                // console.log('previous_page', this.page);
            },


            next_page() {
                this.page += 1;
                // console.log(this.competencies)
            },



            get_data() {
                // if (this.chart) {
                //     this.chart.destroy()
                // }
                $.get("dashboard_competencies_self_assessment_proc.php", {
                        get_data: true,
                        year: this.year
                    }, (data, textStatus, jqXHR) => {
                        this.datasets = data
                        this.create_chart()
                    },
                    "json"
                );
            },
            create_chart(i) {
                if (this.chart) {
                    this.chart.destroy()
                }
                var datasets = []

                if (i > -1) {
                    datasets.push(this.datasets[i])
                } else if (i < -1) {
                    datasets = []
                } else {
                    datasets = this.datasets
                }

                var competency_self_assessment_chart = $("#competency_self_assessment_chart");
                var competency_self_assessment_chart_config = {
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
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        title: {
                            display: true,
                            text: 'Self Assessment'
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

                this.chart = new Chart(competency_self_assessment_chart, competency_self_assessment_chart_config);
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
            this.get_data()
            // this.get_years_with_data().then(() => {
            //     this.get_data()
            // })
        }
    })
</script>