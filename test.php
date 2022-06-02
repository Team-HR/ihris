<?php
$title = "TNA Report";
require_once "header.php";
?>

<div id="tna-report-applet" class="ui container">
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
                <!-- <a href="#" class="ui icon green mini button" style="margin-right: 5px;">View Report</a> -->
                <button class="ui green mini button" @click="print()">
                    <i class="ui icon print"></i>
                    Print
                </button>
            </div>
        </div>
    </div>

    <div class="ui segment" style="margin: 5px;">
        <h1>{{personneltraining.training}}</h1>
        <p>
            <strong>Start:</strong> {{personneltraining.startDate}} <br />
            <strong>End:</strong> {{personneltraining.endDate}} <br />
            <strong>Venue:</strong> {{personneltraining.venue}} <br />
            <strong>Remarks:</strong> {{personneltraining.remarks}}
        </p>
    </div>

    <div class="ui centered grid" style="margin-top: 5px;">
        <div class="column" style="width: 700px;">
            <div class="ui segment">
                <canvas id="performanceIssuesChart"></canvas>
            </div>
        </div>
    </div>


    <div class="ui segment">
        <h4>I. Other performance issues within the department:</h4>
        <ol>
            <li v-for="(performance_issues_other,i) in performance_issues_others" :key="i">{{performance_issues_other}}</li>
        </ol>
        <h4>II. Highlights of accomplishment as a team / unit / section according to trainees:</h4>
        <ol>
            <li v-for="(highlight,i) in highlights" :key="i">{{highlight}}</li>
        </ol>
        <h4>III. Areas for improvement needs to be addressed in the strategic planning workshop according to trainees:</h4>
        <ol>
            <li v-for="(area_of_improvement,i) in areas_of_improvement" :key="i">{{area_of_improvement}}</li>
        </ol>
    </div>



</div>

<script>
    var tnaReportApplet = new Vue({
        el: "#tna-report-applet",
        data() {
            return {
                id: new URLSearchParams(window.location.search).get("id"),
                personneltraining: {},
                performanceIssuesData: {},
                performance_issues_others: [],
                highlights: [],
                areas_of_improvement: []
            }
        },
        methods: {
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
            async getPersonnelTraining() {
                await $.post("tna_entries_proc.php", {
                        getPersonnelTraining: true,
                        personneltrainings_id: this.id
                    },
                    (data, textStatus, jqXHR) => {
                        this.personneltraining = data
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
            }
        },
        mounted() {
            this.getPersonnelTraining()
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


        }
    })
</script>
