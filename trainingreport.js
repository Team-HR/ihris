var json = [], ldnLsaCharts, ldnLsaCharts2, ldnLsaCharts_total, ldnLsaCharts2_total, performanceChart;

$(document).ready(function () {

    var sortBbyDept = "all",
        departmentText = "All Departments",
        sortBbyYear = "all",
        loading_el = $("#loading_el"),
        tbody = $("#tbody");
    // $("#reportDepartment").html("All Departments");
    tbody.html(loading_el.show());

    $(load(sortBbyDept, sortBbyYear));

    $("#sortYear").dropdown({
        onChange: function (value, text) {
            ldnLsaCharts.destroy();
            ldnLsaCharts_total.destroy();
            ldnLsaCharts2.destroy();
            ldnLsaCharts2_total.destroy();
            // performanceChart.destroy();
            tbody.html(loading_el.show());
            sortBbyYear = value;
            // console.log('check', sortBbyDept+" and "+sortBbyYear);
            if (sortBbyDept === "all" && sortBbyYear !== "all") {
                $("#reportDepartment").html(departmentText + " of " + sortBbyYear);
            } else if (sortBbyDept !== "all" && sortBbyYear === "all") {
                $("#reportDepartment").html(departmentText + " of all years");
            } else if (sortBbyDept !== "all" && sortBbyYear !== "all") {
                $("#reportDepartment").html(departmentText + " of " + sortBbyYear);
            } else {
                $("#reportDepartment").html(departmentText + " of all years");
            }
            load(sortBbyDept, sortBbyYear);
        }
    });
    $("#sortDept").dropdown({
        onChange: function (value, text) {
            ldnLsaCharts.destroy();
            ldnLsaCharts_total.destroy();
            ldnLsaCharts2.destroy();
            ldnLsaCharts2_total.destroy();
            tbody.html(loading_el.show());
            sortBbyDept = value;
            if (text !== "all") {
                departmentText = text;
            } else {
                departmentText = "All Departments";
            }

            load(sortBbyDept, sortBbyYear);
            if (sortBbyYear !== "all") {
                html = departmentText + " of " + sortBbyYear;
                // console.log(sortBbyYear)
            } else {
                html = departmentText + " of all years";
            }
            $("#reportDepartment").html(html);
        }
    });

    var ctxPerformance = $("#performance_chart");
    $.post("trainingreport_proc.php",{fetchPerfData:true},
    function (jsonData, textStatus, jqXHR) {
        // console.log(data);
        var datasets = [];
        var bgColors = ['#ff000070', '#00800075', '#0000ff70', '#ffa50070', '#ffff0070'];
        var colors = ['red', 'green', 'blue', 'orange', 'yellow'];
        var counter = 0;
        $.each(jsonData, function (i, val) {
            data = [];
            for (let index = 0; index < 12; index++) {
                data[index] = (val.months[index+1]?val.months[index+1].num_trainings:'');
            }
            set = {
                label: val.year,
                // steppedLine: 'middle',
                backgroundColor: bgColors[counter],
                borderColor: colors[counter],
                borderWidth: 1,
                fill: true,
                data: data
            }
            datasets.push(set);
            counter++;
        });
        console.log(datasets);
        var pfChartCfg = {
            type: 'line',

            data: {
                labels: ['January','February','March','April','May','June','July','August','September','October','November','December'],
                datasets: datasets
            },
            options: {
                // legend: {
                //     onClick: function (e, legendItem) {
                //         var index = legendItem.datasetIndex;
                //         var ci = this.chart;
                //         var dataset_num = this.chart.config.data.datasets.length;
                        
                //         var thereIsHidden = false;
                //         for (let i = 0; i < dataset_num; i++) {
                //             meta = ci.getDatasetMeta(i);
                //             if (meta.hidden){
                //                 thereIsHidden = true;
                //                 break;
                //             }
                //         }

                //         if (thereIsHidden) {
                //             for (let i = 0; i < dataset_num; i++) {
                //                 if (i != index) {
                //                     meta = ci.getDatasetMeta(i);
                //                     meta.hidden = null;
                //                 }
                //             }
                //         } else {
                //             for (let i = 0; i < dataset_num; i++) {
                //                 if (i != index) {
                //                     meta = ci.getDatasetMeta(i);
                //                     meta.hidden = true;
                //                 } else {
                //                     meta = ci.getDatasetMeta(i);
                //                     meta.hidden = false;
                //                 }
                //             }
                //         }
                //         ci.update();
                //     }
                // },
                responsive: true,
                title: {
                    display: true,
                    text: 'Training Conducted Performance'
                },
                scales: {
                    xAxes: [{
                        display: true,
                        autoSkip: false
                    }],
                    yAxes: [{
                        ticks: {
                            stepSize: 1,
                            beginAtZero: true
                        },
                        display: true
                    }]
                }
            }
        };

        performanceChart = new Chart(ctxPerformance, pfChartCfg);
        
    },
    "json"
);


});

function load(department_id, year) {
    $.post('trainingreport_proc.php', {
        load_graph: true,
        department_id: department_id,
        year: year,
    }, function (data, textStatus, xhr) {
        /*optional stuff to do after success */
        json = $.parseJSON(data);
        // console.log(json[0]);
        // console.log([json[0][0]+json[0][1],json[0][2]+json[0][3]]);
        var ctx = $("#graph_permanent");
        var ctx_total = $("#graph_permanent_total");
        var ctx2 = $("#graph_casual");
        var ctx2_total = $("#graph_casual_total");
        var config = {
            type: 'horizontalBar',
            data: {
                labels: [
                    "Male w/ TR",
                    "Female w/ TR",
                    "Male w/o TR",
                    "Female w/o TR",
                ],
                datasets: [{
                    label: 'Personnels',
                    data: json[0],
                    backgroundColor: [
                        '#4075a9',
                        '#fd00d2',
                        '#4075a957',
                        '#fd00d257',
                    ],
                    borderColor: [
                        // '#00000',
                        // '#00000',
                        // '#055bc8',
                        // '#055bc8',
                    ],
                    fill: true,
                    borderWidth: 2,
                }]
            },
            options: {

                title: {
                    display: true,
                    text: "Permanent With and Without Trainings (M/F)"
                },
                legend: {
                    display: false,
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        };

        var config2 = jQuery.extend(true, {}, config);
        config2.data.datasets[0].data = json[1];
        config2.options.title.text = "Casual With and Without Trainings (M/F)";

        var config_total = {
            type: 'horizontalBar',
            data: {
                labels: [
                    "Number of Employees",
                ],
                datasets: [{
                    label: 'With Training',
                    data: [json[0][0] + json[0][1]],
                    backgroundColor: [
                        '#4075a9',
                    ],
                    fill: true,
                    borderWidth: 2,
                },
                {
                    label: 'No Training',
                    data: [json[0][2] + json[0][3]],
                    backgroundColor: [
                        '#4075a957',
                    ],
                    fill: true,
                    borderWidth: 2,
                }]
            },
            options: {

                title: {
                    display: true,
                    text: "Permanent Employees With vs Without Trainings"
                },
                legend: {
                    display: true,
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        };

        var config2_total = jQuery.extend(true, {}, config_total)
        config2_total.data.datasets[0].data = [json[1][0] + json[1][1]];
        config2_total.data.datasets[1].data = [json[1][2] + json[1][3]];
        config2_total.options.title.text = "Casual Employees With vs Without Trainings";
//TODO:
        
        ldnLsaCharts = new Chart(ctx, config);
        ldnLsaCharts_total = new Chart(ctx_total, config_total);
        ldnLsaCharts2 = new Chart(ctx2, config2);
        ldnLsaCharts2_total = new Chart(ctx2_total, config2_total);
    });


    $("#tbody").load('trainingreport_proc.php', {
        load: true,
        department_id: department_id,
        year: year
    },
        function () {
            /* Stuff to do after the page is loaded */
            $(load2(department_id));
        });
}

function load2(department_id) {
    $("#load2Container").load('trainingreport_proc.php', {
        load2: true,
        department_id: department_id
    },
        function () {
            /* Stuff to do after the page is loaded */
        });

}