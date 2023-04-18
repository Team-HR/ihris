<div class="ui fluid container center aligned">
    Self-Assessed Competency Report
</div>


<div class="ui grid center aligned" style="margin-bottom: -56px;">
    <div class="eight wide column" height="">
        <canvas id="overall_chart"></canvas>
    </div>
    <div class="eight wide column" height="">
        <canvas id="gender_chart"></canvas>
    </div>
</div>

<table class="reportTb" style="margin-top: 50px;">
    <thead>
        <tr>
            <th class="rotate"></th>
            <th style="vertical-align: bottom;"></th>
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
    <tbody id="tableBody" style="margin-top: 500px;">
        <tr id="loading_el">
            <td colspan="27" style="width: 1087px; text-align: center; font-size: 32px; color: lightgrey; padding: 100px;">
                <!-- FETCHING DATA... -->
                <img src="assets/images/loading.gif" style="height: 50px; margin-top: -100px;">
                <br>
                <span>Fetching data...</span>
            </td>
        </tr>

    </tbody>
</table>


<style type="text/css">
    table {
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
        height: 160px;
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

    .reportTb table {
        width: 1008px;
    }

    .reportTb tr:nth-child(even) {
        background-color: #edf3fb;
    }
</style>

<?php require_once "_connect.db.php"; ?>
<script src="js/competencies_array.js"></script>
<script type="text/javascript">
    var dept_filters = "";
    var overallChart;
    var genderChart;

    $(document).ready(function() {
        $(load_it(['dept_id=3']))
        var loading = $('#loading_el');
        $('.popup').popup();
    });


    function load_it(filters) {
        $.post('personnelCompetenciesReport_proc.php', {
            load: true,
            filters: filters,
        }, function(data, textStatus, xhr) {
            $("#tableBody").html(data);

            $.post('personnelCompetenciesReport_proc.php', {
                get_average_data: true,
                filters: filters
            }, function(data, textStatus, xhr) {
                /* optional stuff to do after success */
                // console.log(data);
                var overall_chart_data = [];
                if (data) {
                    overall_chart_data = jQuery.parseJSON(data);
                    // console.log(overall_chart_data);
                } else {
                    overall_chart_data = [];
                }

                // sorting indexed array start 
                overall_chart_data.sort(function(a, b) {
                    if (a.value > b.value) return -1;
                    if (a.value < b.value) return 1;
                    return 0;
                });
                // sorting indexed array end 
                if (overallChart instanceof Object) {
                    overallChart.destroy();
                }

                createChart(overall_chart_data);
                // overallChart.update();
            });



            // getting average data for male and male
            $.post('personnelCompetenciesReport_proc.php', {
                get_average_data_by_gender: true,
                filters: filters
            }, function(data, textStatus, xhr) {
                /* optional stuff to do after success */
                // console.log(data);

                var overall_chart_data_by_gender = [];
                if (data) {
                    overall_chart_data_by_gender = jQuery.parseJSON(data);
                    console.log(overall_chart_data_by_gender);
                } else {
                    overall_chart_data_by_gender = [];
                }

                // sorting indexed array start 
                // overall_chart_data_by_gender.sort(function(a,b){
                //   if(a.value > b.value) return -1;
                //   if(a.value < b.value) return 1;
                //   return 0;
                // });
                // sorting indexed array end

                if (genderChart instanceof Object) {
                    genderChart.destroy();
                }

                createGenderChart(overall_chart_data_by_gender);
                // overallChart.update();
            });



        });
    }




    function createGenderChart(overall_chart_data_by_gender) {

        var chart_data_label = [];
        var chart_data_data = {
            male: [],
            female: []
        };
        var gender_chart = $("#gender_chart");

        $.each(overall_chart_data_by_gender.male, function(index, val) {
            chart_data_label.push(val.competency.split("_").join(" "));
            chart_data_data.male.push(val.value);
        });
        $.each(overall_chart_data_by_gender.female, function(index, val) {
            //  chart_data_label.push(val.competency.split("_").join(" "));
            chart_data_data.female.push(val.value);
        });

        var config = {
            type: 'bar',
            data: {
                labels: chart_data_label,
                datasets: [{
                    label: 'Male:',
                    data: chart_data_data.male,
                    backgroundColor: '#055bc8',
                    borderColor: [
                        // '#055bc8'
                    ],
                    fill: false,
                    borderWidth: 1,
                    lineTension: 0,
                }, {
                    label: 'Female:',
                    data: chart_data_data.female,
                    backgroundColor: '#ff80ff',
                    borderColor: [
                        // '#e03997'
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
                                label += ' Level ';
                            }
                            label += tooltipItem.yLabel;
                            return label;
                        }
                    }
                },
                responsive: true,
                title: {
                    display: true,
                    text: "Average Mastery by Gender"
                },
                legend: {
                    display: true,
                },
                scales: {
                    xAxes: [{

                        ticks: {
                            // fontSize:14,
                            // beginAtZero: true,
                            // stepSize:1
                            autoSkip: false
                        }
                    }],
                    yAxes: [{
                        display: true,
                        ticks: {
                            beginAtZero: true,
                            stepSize: 1,
                            autoSkip: false,
                            max: 5
                        }
                    }],
                },
                onClick: function(evt, items) {
                    var firstPoint = this.getElementAtEvent(evt)[0];
                    if (firstPoint) {
                        var label = this.data.labels[firstPoint._index];
                        var value = this.data.datasets[firstPoint._datasetIndex].data[firstPoint._index];
                        showCompInfo(label, value);
                    }
                }
            }
        };
        // console.log(overallChart instanceof Object);
        genderChart = new Chart(gender_chart, config);
        // console.log(overallChart instanceof Object);
    }



    function createChart(overall_chart_data) {

        var overall_chart_data_label = [];
        var overall_chart_data_data = [];
        var overall_chart = $("#overall_chart");
        $.each(overall_chart_data, function(index, val) {
            overall_chart_data_label.push(val.competency.split("_").join(" "));
            overall_chart_data_data.push(val.value);
        });

        var config = {
            type: 'bar',
            data: {
                labels: overall_chart_data_label,
                datasets: [{
                    label: 'Average Mastery is ',
                    data: overall_chart_data_data,
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
                                label += 'Level ';
                            }
                            label += tooltipItem.yLabel;
                            return label;
                        }
                    }
                },
                responsive: true,
                title: {
                    display: true,
                    text: "General Average"
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
                            max: 5
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
                        showCompInfo(label, value);

                    }

                }

            }
        };
        // console.log(overallChart instanceof Object);
        overallChart = new Chart(overall_chart, config);
        // console.log(overallChart instanceof Object);
    }
</script>