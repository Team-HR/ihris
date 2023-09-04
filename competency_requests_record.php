<!DOCTYPE html>
<html>

<head>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
</head>

<body>
    <div id="app">
        <v-app>
            <v-main>
                <v-container>
                    <template>
                        <v-card class="mx-auto" width="1000">
                            <v-app-bar dense flat color="primary" dark>
                                <v-btn color="" class="noprint" text @click="back()">Back</v-btn>
                                <v-spacer></v-spacer>
                                <v-toolbar-title class="text-right"><b>COMPETENCY PROFILE</b></v-toolbar-title>
                                <v-spacer></v-spacer>
                            </v-app-bar>
                            <v-card-text>
                                <v-card dense class="elevation-0 mx-auto" width="800">
                                    <v-card-title primary-title>
                                        {{full_name}}
                                    </v-card-title>
                                    <v-card-subtitle>
                                        Job Order Worker <br>
                                        Office: CATIPO <br>
                                        Assessment Timestamp: {{timestamp_self_ass}}
                                    </v-card-subtitle>
                                </v-card>
                                <v-card dense class="elevation-0 mx-auto" width="800">
                                    <v-card-title primary-title>
                                        {{sup_assessed_record.assessor_name}}
                                    </v-card-title>
                                    <v-card-subtitle>
                                        Supervisor <br>
                                        Office: CATIPO <br>
                                        Assessment Timestamp: {{timestamp_sup_ass}}
                                    </v-card-subtitle>
                                </v-card>

                                <!-- chart start -->
                                <v-card class="mx-auto elevation-0 mb-5" width="600">
                                    <canvas id="myChart" height="250"></canvas>
                                </v-card>
                                <!-- chart end -->

                                <!-- table start -->
                                <v-card class="mx-auto elevation-0 mb-5" width="700">

                                    <!-- <ol> -->
                                    <template v-for="(comp, i) in reports">
                                        <v-card :key="i" class="my-5">
                                            <v-card-title primary-title class="mb-0 pb-0">
                                                {{comp.name}}
                                            </v-card-title>
                                            <v-subheader>{{comp.description}}</v-subheader>
                                            <v-card-text>


                                                <v-simple-table width="500" class="pa-0 ma-0" dense>
                                                    <template v-slot:default>
                                                        <tbody>
                                                            <tr align="center">
                                                                <td><b>Self-Assessment</b></td>
                                                                <td><b>Supervisor-Assessment</b></td>
                                                            </tr>
                                                            <tr align="center">
                                                                <td colspan="2"><b>Proficiency/Mastery Level:</b></td>
                                                            </tr>
                                                            <tr align="center">
                                                                <td>
                                                                    <v-rating hover length="5" readonly :value="comp.self.level"></v-rating>
                                                                </td>
                                                                <td>
                                                                    <v-rating hover length="5" readonly :value="comp.sup.level"></v-rating>
                                                                </td>
                                                            </tr>
                                                            <tr align="center">
                                                                <td>{{comp.self.proficiency}}</td>
                                                                <td>{{comp.sup.proficiency}}</td>
                                                            </tr>
                                                            <tr align="center">
                                                                <td colspan="2"><b>Behavioral Indicators:</b></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <ul>
                                                                        <li v-for="(behavior, k) in comp.self.behaviors" :key="k">
                                                                            {{behavior}}
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                                <td>
                                                                    <ul>
                                                                        <li v-for="(behavior, k) in comp.sup.behaviors" :key="k">
                                                                            {{behavior}}
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </template>
                                                </v-simple-table>
                                            </v-card-text>
                                        </v-card>
                                    </template>
                                    <!-- </ol> -->

                                </v-card>
                                <!-- table end -->
                            </v-card-text>
                        </v-card>


                    </template>
                </v-container>
            </v-main>
        </v-app>
    </div>
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js" integrity="sha256-bC3LCZCwKeehY6T4fFi9VfOU0gztUa+S4cnkIhVPZ5E=" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- chart.js -->
    <!-- <script src="node_modules/chart.js/dist/Chart.js"></script> -->
    <script src="node_modules/chart.js/dist/Chart.min.js"></script>
    <!-- <script src="competencies_array.js"></script> -->
    <script>
        // const test = "test";
        var app = new Vue({
            el: '#app',
            vuetify: new Vuetify(),
            data() {
                return {
                    id: new URLSearchParams(window.location.search).get("id"),
                    self_assessed_record: [],
                    sup_assessed_record: [],
                    reports: []
                }
            },
            methods: {
                back() {
                    window.history.back();
                },
                async get_self_assessed_record() {
                    await $.get(`competency_requests.ajax.php?get_self_assessed_record=${this.id}`,
                        (data, textStatus, jqXHR) => {
                            this.self_assessed_record = JSON.parse(JSON.stringify(data))
                            // console.log();
                        },
                        "json"
                    );
                },
                async get_sup_assessed_record() {
                    await $.get(`competency_requests.ajax.php?get_sup_assessed_record=${this.id}`,
                        (data, textStatus, jqXHR) => {
                            this.sup_assessed_record = JSON.parse(JSON.stringify(data))
                            // console.log(data);
                        },
                        "json"
                    );
                },
                async generate_report() {
                    await $.post('competency_requests.ajax.php', {
                            generate_report: this.id
                        }, (data, textStatus, jqXHR) => {
                            // console.log(data);
                            this.reports = JSON.parse(JSON.stringify(data))
                        },
                        "json"
                    );
                },
                async get_all_data() {
                    await this.get_self_assessed_record()
                    await this.get_sup_assessed_record()
                    await this.generate_report()
                }
            },
            computed: {
                full_name() {
                    return this.self_assessed_record.last_name + ", " + this.self_assessed_record.first_name + " " + this.self_assessed_record.middle_name + " " + this.self_assessed_record.ext_name
                },
                timestamp_self_ass() {
                    return this.self_assessed_record.created_at
                },
                timestamp_sup_ass() {
                    return this.sup_assessed_record.created_at
                }
            },
            mounted() {
                this.get_all_data().then(() => {
                    chartApp(this.self_assessed_record.data, this.sup_assessed_record.data)
                })
            }
        })


        function chartApp(arr1, arr2) {
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'horizontalBar',
                data: {
                    labels: [
                        "Adaptability",
                        "Continous Learning",
                        "Communication",
                        "Organizational Awareness",
                        "Creative Thinking",
                        "Networking/Relationship Building",
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
                        "Visioning and Strategic Direction",
                    ],
                    datasets: [{
                            label: 'Self Assessment',
                            data: arr1,
                            backgroundColor: "#4bc0c0",
                            borderWidth: 1,
                        },
                        {
                            label: 'Supervisor Assessment',
                            data: arr2,
                            backgroundColor: 'orange',
                            borderWidth: 1
                        }
                    ]
                },
                options: {

                    scales: {
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Proficiency/Mastery Level'
                            },
                            ticks: {
                                // 'rgba(75, 120, 192, 1)',
                                // borderColor: 'rgba(75, 120, 192, 1)',
                                beginAtZero: true,
                                max: 5,
                                stepSize: 1
                            }
                        }]
                    }, //end of scales
                    title: {
                        display: false,
                        text: "COMPETENCY PROFILE"
                    },
                    legend: {
                        display: true
                    }
                }
            });
        }
    </script>
</body>
<style>
    @media print {
        body {
            background: none !important;
            background-image: none !important;
        }

        .printCompactText {
            font-size: 11px !important;
        }

        .printOnly {
            display: block;
        }

        .noprint {
            display: none !important;
            /*margin: 0px !important;*/
            /*padding: 0px !important;*/
        }

        .noBorderPrint {
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            /*margin: 0px !important;*/
            /*padding: 0px !important;*/
            border: none !important;
        }

        .centerPrint {
            margin: 0 auto;
            width: 100%;
        }
    }
</style>

</html>