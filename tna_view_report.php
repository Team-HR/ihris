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
                    <h3><i class="icon compass outline"></i> For Engagement Analysis /Report</h3>
                </div>
                <div class="right item">
                    <div class="ui right input">
                        <button @click="print()" class="ui icon green mini button" style="margin-right: 5px;"><i class="ui icon print"></i> Print</button>
                    </div>
                </div>
            </div>
            <!-- content start -->

            <div class="ui segment">
                <h4>I. Challenges confronted within the department:
                    <select id="department_select" class="ui search dropdown" name="departments" size="width:20px" v-model="form_entry.department_id" @change="select()">
                        <option value="all">All</option>
                        <option v-for="data in departments" :value="data.id">{{ data.name }}</option>
                    </select>
                </h4>

                <table class="ui selectable celled table blue">
                    <thead>
                        <tr>
                            <th>COMMUNICATION</th>
                            <th>LOGISTICS</th>
                            <th>RELATIONSHIP</th>
                            <th>SUPPORT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item,i) in forms" :key="i">
                            <td>{{ item.communication  }}</td>
                            <td>{{ item.logistics  }}</td>
                            <td>{{ item.relationships  }}</td>
                            <td>{{ item.support  }}</td>
                        </tr>
                    </tbody>
                </table>
                <h4>II. Numbers aware of what needs in order to be successful:</h4>
                <div class="ui centered grid" style="margin-top: 5px;">
                    <div class="column" style="width: 700px;">
                        <div class="ui segment">
                            <canvas id="roleChart"></canvas>
                        </div>
                    </div>
                </div>
                <h4>III. Tools to be consistenly to do job well:</h4>
                <ol>
                    <li v-for="(consistentlyy,i) in forms" :key="i">{{ consistentlyy.consistently }}</li>
                </ol>
                <h4>IV. Areas of improvement in this workshop:</h4>
                <ol>
                    <li v-for="(improvements,i) in forms" :key="i">{{ improvements.improvement }}</li>
                </ol>
            </div>

    </template>
</div>
<script>
    var tnaentries = new Vue({
        el: "#tna-report-app",
        data() {
            return {

                id: new URLSearchParams(window.location.search).get("id"),
                addedScheduledTrainings: [],
                forms: {},
                chart: null,
                role: {},
                improvement: [],
                training: '',
                scheduledTrainings: [],
                departments: [],
                successful_roles: [
                    'yes',
                    'no'
                ],
                forms: {
                    communications: [],
                    logistic: [],
                    relationship: [],
                    supports: [],
                    // successful_role: [],
                    consistentlyy: [],
                    improvements: []
                },
                form_entry: {
                    department_id: 'all',
                    communication: '',
                    logistics: '',
                    relationships: '',
                    support: '',
                    successful_role: [],
                    consistently: '',
                    improvement: ''
                },

                form_entry_cleared: {
                    communication: '',
                    logistics: '',
                    relationships: '',
                    support: '',
                    successful_role: [],
                    consistently: '',
                    improvement: ''

                }
            }
        },
        methods: {
            getDepartments() {
                $.post("tna_view_report_proc.php", {
                        getDepartments: true,
                    },
                    (data, textStatus, jqXHR) => {
                        this.departments = data
                    },
                    "json"
                );
            },

            async getEntries() {
                await $.post("tna_proc.php", {
                        getEntries: true,
                    },
                    (data, textStatus, jqXHR) => {
                        this.forms = data
                    },
                    "json"
                );
            },
            select() {
                $.ajax({
                    url: "tna_view_report_proc.php",
                    method: "GET",
                    data: {
                        get_department_data: true,
                        department_id: this.form_entry.department_id
                    },
                    dataType: "JSON",
                    success: (report) => {
                        this.forms = report
                        this.getSuccessful_role().then(() => {
                            if (this.chart) {
                                this.chart.destroy()
                            }
                            var roleChart = $("#roleChart");
                            var config = {
                                type: 'bar',
                                data: {
                                    labels: this.role.labels,
                                    datasets: [{
                                        label: 'Counts: ',
                                        data: this.role.data,
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
                                        text: "Number of Sucessful role:"
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
                            this.chart = new Chart(roleChart, config);
                        })
                    }
                });
                // console.log('test')
            },

            //######################## chart methods start
            async getSuccessful_role() {
                await $.post("tna_view_report_proc.php", {
                        getSuccessful_role: true,
                        department_id: this.form_entry.department_id
                    }, (data, textStatus, jqXHR) => {
                        this.role = data
                    },
                    "json"
                );
            },
            async get_for_engagement() {
                await $.post("tna_view_report_proc.php", {
                        get_for_engagement: true,
                    },
                    (data, textStatus, jqXHR) => {
                        // console.log(data);
                        this.commmunication = data.commmunication
                        this.logistics = data.logistics
                        this.relationships = data.relationships
                        this.support = data.support
                        // this.successful_role = data.successful_role
                        this.consistently = data.consistently
                        this.improvement = data.improvement
                    },
                    "json"
                );
            },

            newChart() {
                this.getSuccessful_role().then(() => {
                    var roleChart = $("#roleChart");
                    var config = {
                        type: 'bar',
                        data: {
                            labels: this.role.labels,
                            datasets: [{
                                label: 'Counts: ',
                                data: this.role.data,
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
                                text: "Number of Sucessful role:"
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
                    this.chart = new Chart(roleChart, config);
                })
            }
            //################# chart methods end
        },
        mounted() {
            this.getDepartments()
            this.getEntries()
            $('.ui.checkbox').checkbox();

            this.newChart()
            this.getSuccessful_role()
        }
    })

    $('.ui.dropdown')
        .dropdown({
            fullTextSearch: 'exact'
        });
</script>

<?php require_once "footer.php"; ?>