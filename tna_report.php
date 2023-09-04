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
            </div>
            <!-- content end -->

            <div class="ui centered grid" style="margin-top: 5px;">
                <div class="column" style="width: 700px;">
                    <div class="ui segment">
                        <canvas id="performanceIssuesChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- content report -->
            <div class="ui basic segment ">
                <!-- <div class="ui middle aligned divided list">
                    <table class="ui fixed table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Highlights of Accomplishments as a team /unit / section</th>
                                <th>Employee performance issue within the department</th>
                                <th>Others</th>
                                <th>Improvement planning on workshop</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div class="left floated content">
                                <tr class="item" v-for="(item,i) in items" :key="i" style="vertical-align: middle !important;">
                                    <td>
                                        <div class="center aligned column">
                                            <div class="ui basic icon button" onclick="openModal()">
                                                <i class="ui green icon edit outline"></i>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{item.highlights}}</td>
                                    <td>{{item.performance_issues}}</td>
                                    <td>{{item.performance_issues_others}} </td>
                                    <td>{{item.areas_of_improvement}}</td>
                                </tr>
                            </div>
                        </tbody>
                    </table>
                </div> -->
                <div class="ui segment">
                    <h4>I. Other performance issues within the department:</h4>
                    <ol v-if="performance_issues_others.length > 0">
                        <li v-for="(performance_issues_other,i) in performance_issues_others" :key="i">{{performance_issues_other}}</li>
                    </ol>
                    <span v-else style="margin-left: 25px;">None</span>
                    <h4>II. Highlights of accomplishment as a team / unit / section according to trainees:</h4>
                    <ol v-if="highlights.length > 0">
                        <li v-for="(highlight,i) in highlights" :key="i">{{highlight}}</li>
                    </ol>
                    <span v-else style="margin-left: 25px;">None</span>
                    <h4>III. Areas for improvement needs to be addressed in the strategic planning workshop according to trainees:</h4>
                    <ol v-if="areas_of_improvement.length > 0">
                        <li v-for="(area_of_improvement,i) in areas_of_improvement" :key="i">{{area_of_improvement}}</li>
                    </ol>
                    <span v-else style="margin-left: 25px;">None</span>
                </div>

                <!-- Modal form -->
                <div class="active">
                    <div class="ui fullscreen modal">
                        <i class="close icon"></i>
                        <div class="header" style="text-align:center">
                            Update Form
                        </div>
                        <div class="ui segment">
                            <form class="ui form" @submit.prevent="submitEntry()">
                                <div class="field">
                                    <label>1.) What are the highlights of your accomplishment as a team / unit /
                                        section?</label>
                                    <textarea type="text" v-model="formData.highlights" name="highlights" placeholder="Type here..."></textarea>
                                </div>

                                <div class="field">
                                    <label>2.) Please identify three employee performance issues within your
                                        department?</label>

                                    <div v-for="(issue, i) in performance_issues_options" :key="i">
                                        <div class="ui checkbox" style="padding:2px">
                                            <input v-model="formData.performance_issues" type="checkbox" :value="issue" tabindex="0" class="hidden">
                                            <label>{{issue}}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="field">
                                    <label>
                                        Others:
                                    </label>
                                    <input v-model="formData.others" type="text" name="others" placeholder="Type here...">
                                </div>
                                <div class="field">
                                    <label> 3.) Areas for improvement that you wish to address in the strategic planning
                                        workshop?
                                    </label>
                                    <input v-model="formData.areas_of_improvement" type="text" name="areas_of_improvement" placeholder="Type here...">
                                </div>

                                <button class="ui button green" type="submit">
                                    Submit
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End Modal Form -->
                <!-- end content report -->
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
                formData: {
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
            async getEntries() {
                await $.post("tna_report_proc.php", {
                        getEntries: true,
                        personneltrainings_id: this.id
                    },
                    (data, textStatus, jqXHR) => {
                        this.items = data
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
                    },
                    "json"
                );
            }

        },
        mounted() {
            this.getPersonnelTraining()
            this.getEntries()
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
</script>

<?php require_once "footer.php"; ?>