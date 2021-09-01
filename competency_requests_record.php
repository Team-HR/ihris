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
                            <v-card-title primary-title>
                                <v-btn color="info" class="mr-5" text @click="back()">Back</v-btn>
                                <h3>{{full_name}}</h3>
                                <v-subheader>{{timestamp}}</v-subheader>
                            </v-card-title>

                            <v-card-text>
                                <!-- chart start -->
                                <v-card class="mx-auto elevation-0 mb-5" width="600">
                                    <canvas id="myChart" height="250"></canvas>
                                </v-card>
                                <!-- chart end -->
                                <!-- table start -->
                                <v-card class="mx-auto elevation-0 mb-5" width="700">

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
                async get_all_data(){
                    await this.get_self_assessed_record()
                    await this.get_sup_assessed_record()
                }
            },
            computed: {
                full_name() {
                    return this.self_assessed_record.last_name + ", " + this.self_assessed_record.first_name + " " + this.self_assessed_record.middle_name + " " + this.self_assessed_record.ext_name
                },
                timestamp() {
                    return this.self_assessed_record.created_at
                }
            },
            mounted() {
                this.get_all_data().then(()=>{
                    chartApp(this.self_assessed_record.data,this.sup_assessed_record.data)      
                })
            }
        })


         function chartApp (arr1, arr2) {
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
                            backgroundColor: 'teal',
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
                        display: true,
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

</html>