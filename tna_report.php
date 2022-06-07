<?php $title = "Report - Training Needs Analysis (TNA)";
require_once "header.php"; ?>
<div id="tna-report-app" style="min-height: 500px;">
    <template>
        <div class="ui container">
            <div class="ui borderless blue inverted mini menu noprint">
                <div class="left item" style="margin-right: 0px !important;">
                    <button onclick="window.history.back();" class="blue ui icon mini button" title="Back" style="width: 65px;">
                        <i class="icon chevron left"></i> Back
                    </button>
                </div>
                <div class="item">
                    <h3><i class="icon compass outline"></i> L&D Training Needs Analysis /Report</h3>
                </div>
                <div class="right item">
                    <div class="ui right input">
                        <button @click="print()" class="ui icon green mini button" style="margin-right: 5px;"><i class="ui icon print"></i> Print</button>
                    </div>
                </div>
            </div>
            <!-- content start -->

            <div class="ui segment">

                <h1>{{personneltraining.training}}</h1>
                <p>
                    <strong>Start:</strong> {{personneltraining.startDate}} <br />
                    <strong>End:</strong> {{personneltraining.endDate}} <br />
                    <strong>Venue:</strong> {{personneltraining.venue}} <br />
                    <strong>Remarks:</strong> {{personneltraining.remarks}}
                </p>
                <br>
                <strong>Filter By Department:</strong>
              
                <select class="ui search dropdown" v-model="formData.department_id" name="departments" @change="select()" id="filter">
                    <option value="">Filter by Department</option>
                    <option value="all">All</option>
                    <option v-for="data in departments" :value="data.id">{{ data.name }}</option>
                </select>
            </div>
            <!-- content end -->

            <div class="ui centered grid" style="margin-top: 5px;">
                <div class="column" style="width: 700px;">
                    <div class="ui segment">
                        <canvas id="performanceIssuesChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="ui segment">
                <h4>I. Other performance issues within the department:</h4>
                <ol v-if="performance_issues_others.length > 0">
                    <li v-for="(performance_issues_other,i)  in data" :key="i">{{performance_issues_other.performance_issues_others}}</li>
                </ol>
                <span v-else style="margin-left: 25px;">None</span>
                <h4>II. Highlights of accomplishment as a team / unit / section according to trainees:</h4>
                <ol v-if="highlights.length > 0">
                    <li v-for="(highlight,i) in data" :key="i">{{ highlight.highlights}}</li>
                </ol>
                <span v-else style="margin-left: 25px;">None</span>
                <h4>III. Areas for improvement needs to be addressed in the strategic planning workshop according to trainees:</h4>
                <ol v-if="areas_of_improvement.length > 0">
                    <li v-for="(area_of_improvement,i) in data" :key="i">{{area_of_improvement.areas_of_improvement}}</li>
                </ol>
                <span v-else style="margin-left: 25px;">None</span>
            </div>

    </template>
</div>
<script>
    function openModal() {
        $('.fullscreen.modal').modal('show');
    };
    window.onload = function() {};
</script>
<script>
    var tnaentries = new Vue({
        el: "#tna-report-app",
        data() {
            return {
                id: new URLSearchParams(window.location.search).get("id"),
                personneltraining: {},
                performanceIssuesData: {},
                performance_issues_others: [],
                highlights: [],
                areas_of_improvement: [],
                items: [],
                performance_issues_options: [
                    'Initiative',
                    'Resourcefulness',
                    'Efficiency',
                    'Teamwork',
                    'Attitude Towards Colleagues',
                    'Time and Cost consciousness in Delivery of Service',
                    'Professionalism in Delivery of Service',
                    'Customer-Friendliness',
                    'Responsiveness',
                    'Punctuality',
                ],
                data: {
                    highlight: [],
                    performance_issues_other: [],
                    area_of_improvement: []
                },
                departments: [],
                formData: {
                    department_id: '',
                    highlights: '',
                    performance_issues: [],
                    others: '',
                    areas_of_improvement: ''
                },
                formDataCleared: {
                    highlights: '',
                    performance_issues: [],
                    others: '',
                    areas_of_improvement: ''
                }
            }
        },
        methods: {
            allRecords: function() {
                $.get('tna_report_proc.php')
                    .then(function(response) {
                        all_value = this.response.data;
                    })
            },
            select() {
                $.ajax({
                    url: "tna_report_proc.php",
                    method: "GET",
                    data: {
                        get_department_data: true,
                        department_id: this.formData.department_id
                    },
                    dataType: "JSON",
                    success: (report) => {
                        this.data = report
                        console.log(report);
                    }
                });
                // console.log('test')
            },

            //######################## chart methods start
            async getPerformanceIssues() {
                const personneltrainings_id = this.id
                await $.post("tna_entries_proc.php", {
                        getPerformanceIssues: true,
                        personneltrainings_id: this.id
                    }, (data, textStatus, jqXHR) => {
                        this.performanceIssuesData = data
                    },
                    "json"
                );
            },
            async getHiglightsAndAreasNeedsImprovement() {
                await $.post("tna_entries_proc.php", {
                        getHiglightsAndAreasNeedsImprovement: true,
                        personneltrainings_id: this.id
                    },
                    (data, textStatus, jqXHR) => {
                        // console.log(data);
                        this.performance_issues_others = data.performance_issues_others
                        this.highlights = data.highlights
                        this.areas_of_improvement = data.areas_of_improvement
                    },
                    "json"
                );
            },
            //################# chart methods end

            async deleteEntry(id) {
                await $.post("tna_report_proc.php", {
                        deleteEntry: true,
                        id: id
                    },
                    (data, textStatus, jqXHR) => {
                        this.getEntries()
                    },
                    "json"
                );
            },

            getDepartments() {
                $.post("tna_report_proc.php", {
                        getDepartments: true,
                        personneltrainings_id: this.id
                    },
                    (data, textStatus, jqXHR) => {
                        this.departments = data
                        console.log(data);
                    },
                    "json"
                );
            },

            async getEntries() {
                await $.post("tna_report_proc.php", {
                        getEntries: true,
                        personneltrainings_id: this.id
                    },
                    (data, textStatus, jqXHR) => {
                        this.data = data

                    },
                    "json"
                );
            },
            submitEntry() {
                this.addNewEntry().then(() => {
                    this.getEntries()
                    this.formData = JSON.parse(JSON.stringify(this.formDataCleared))
                })
            },
            async addNewEntry() {
                await $.post("tna_report_proc.php", {
                        addNewEntry: true,
                        personneltrainings_id: this.id,
                        formData: this.formData
                    },
                    (data, textStatus, jqXHR) => {
                        // console.log(data);
                    },
                    "json"
                );
            },

            getPersonnelTraining() {
                $.post("tna_report_proc.php", {
                        getPersonnelTraining: true,
                        personneltrainings_id: this.id
                    },
                    (data, textStatus, jqXHR) => {
                        this.personneltraining = data
                        // console.log(data);
                    },
                    "json"
                );
            },

        },
        mounted() {

            this.getPersonnelTraining()
            this.getEntries()
            this.getDepartments()
            $('.ui.checkbox').checkbox();

            //############################### chart init starts
            this.getHiglightsAndAreasNeedsImprovement()
            this.getPerformanceIssues().then(() => {
                var performanceIssuesChart = $("#performanceIssuesChart");
                var config = {
                    type: 'bar',
                    data: {
                        labels: this.performanceIssuesData.labels,
                        datasets: [{
                            label: 'Counts: ',
                            data: this.performanceIssuesData.data,
                            backgroundColor: '#055bc8',
                            borderColor: [
                                // '#055bc8'
                            ],
                            fill: false,
                            borderWidth: 1,
                            lineTension: 0,
                        }]
                    },
                    options: {
                        tooltips: {
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    var label = data.datasets[tooltipItem.datasetIndex].label || '';

                                    if (label) {
                                        // label += 'Level ';
                                    }
                                    label += tooltipItem.yLabel;
                                    return label;
                                }
                            }
                        },
                        responsive: true,
                        title: {
                            display: true,
                            text: "Number of Performance Issues According to Trainees"
                        },
                        legend: {
                            display: false,
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

                            var firstPoint = this.getElementAtEvent(evt)[0];

                            if (firstPoint) {
                                var label = this.data.labels[firstPoint._index];
                                var value = this.data.datasets[firstPoint._datasetIndex].data[firstPoint._index];
                                // console.log(firstPoint);
                                // console.log(label+': '+value);
                                console.log(label, value);

                            }
                        }
                    }
                };
                new Chart(performanceIssuesChart, config);
            })
            //############################### chart init ends
        }
    })

    $('select.dropdown')
        .dropdown({
            fullTextSearch: 'exact'
        });
</script>

<?php require_once "footer.php"; ?>