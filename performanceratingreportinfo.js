var vue_prr = new Vue({
    el: "#vue_prr",
    data: {
        sort_by: "lastName",
        is_asc: true,
        myChart: null,
        items: [],
        emps: [],
        ova_rates: {},
        prr_id: new URL(window.location.href).searchParams.get("prr_id"),
        type: new URL(window.location.href).searchParams.get("type"),
        is_loading: false
    },
    watch: {
        sort_by(nVal, oVal) {
            this.do_sort()
        },
        is_asc(nVal, oVal) {
            this.do_sort()
        }
    },
    methods: {
        do_sort() {
            console.log("do sort:", this.sort_by + " " + this.is_asc);
            // this.items = []
            var sort_by = this.sort_by
            if (!this.is_asc) {
                sort_by = "-" + sort_by
            }
            this.items.sort(this.dynamicSort(sort_by))
        },
        dynamicSort(property) {
            var sortOrder = 1;
            if(property[0] === "-") {
                sortOrder = -1;
                property = property.substr(1);
            }
            return function (a,b) {
                /* next line works with strings and numbers, 
                 * and you may want to customize it to your needs
                 */
                var result = (a[property] < b[property]) ? -1 : (a[property] > b[property]) ? 1 : 0;
                return result * sortOrder;
            }
        },
        get_items() {
            this.items = []
            this.is_loading = true
            $.post("performanceratingreportinfo_proc.v2.php", {
                load: true,
                prr_id: this.prr_id,
                type: this.type
            },
                (data, textStatus, jqXHR) => {
                    // console.log(data);
                    // this.items = []
                    this.items = JSON.parse(JSON.stringify(data))
                    this.do_sort()
                    this.is_loading = false

                    this.get_emps()
                    this.get_ova_rates().then(() => {
                        if (this.myChart) {
                            this.myChart.destroy()
                        }
                        this.load_chart()
                    })
                    
                },
                "json"
            );
            // if (this.items.length > 0) {
            //    this.do_sort() 
            // }
        },
        format_date(date) {
            if (date == '0000-00-00') return ""
            date = date.split("-")
            date = date[1] + "/" + date[2] + "/" + date[0]
            return date
        },
        stage_color(stages) {
            if (!stages || stages == "") return "blue"
            colors = {
                "Y": "yellow",
                "C": "cyan",
                "W": "white",
            }

            return colors[stages]
        },
        ratingModal(prrlist_id, employees_id, prr_id) {
            $('#rating_modal').modal('show');
            $("#rating_modal").html("<center><img style='transform: scale(0.1); margin-top: -200px;' src='assets/images/loading.gif'></center>");
            $.post('umbra/ratingAjaxForm.php', {
                prrList: prrlist_id,
                prr_id: prr_id,
                empId: employees_id
            }, (data, textStatus) => {
                if (textStatus == "success") {
                    $("#rating_modal").html(data)
                } else {
                    $("#rating_modal").html("<center><h1>Something went Wrong</h1></center>");
                }

            });
        },
        stateColor(prrlist_id, employees_id, prr_id, Scolor) {
            eventColor = event;
            $.post('umbra/PrrSaveRate.php', {
                prrList: prrlist_id,
                prr_id: prr_id,
                empId: employees_id,
                Scolor: Scolor
            }, (data, textStatus, xhr) => {
                // console.log("state:", data);
                if (data == 1) {
                    if (Scolor == "C") {
                        back = "CYAN";
                    } else if (Scolor == 'Y') {
                        back = 'YELLOW';
                    } else if (Scolor == 'W') {
                        back = 'WHITE';
                    }
                    eventColor.srcElement.parentElement.parentElement.style.background = back;
                }
            });
        },
        removePerInfo(i) {
            el = event.srcElement;
            con = confirm("Are you sure?");
            if (con) {
                $.post('umbra/PrrRemoveRate.php', {
                    prrDataRemove: i
                }, (data, textStatus, xhr) => {
                    if (data == 1) {
                        el.parentElement.parentElement.remove();
                    }
                });
            }
        },
        get_emps() {
            $.post("performanceratingreportinfo_proc.v2.php", {
                get_emps: true
            },
                (data) => {
                    this.emps = JSON.parse(JSON.stringify(data))
                },
                "json"
            );
        },
        async get_ova_rates() {
            await $.post("performanceratingreportinfo_proc.v2.php", {
                get_ova_rates: true,
                prr_id: this.prr_id
            }, (data, textStatus, jqXHR) => {
                // console.log(data);
                this.ova_rates = JSON.parse(JSON.stringify(data))
            },
                "json"
            );
        },
        load_chart() {
            var ctx = document.getElementById('myChart');
            this.myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['POOR', 'UNSATISFACTORY', 'SATISFACTORY', 'VERY SATISFACTORY	', 'OUTSTANDING'],
                    datasets: [{
                        label: ['Performance Rating Report'],
                        data: [
                            vue_prr.ova_rates[4].total,
                            vue_prr.ova_rates[3].total,
                            vue_prr.ova_rates[2].total,
                            vue_prr.ova_rates[1].total,
                            vue_prr.ova_rates[0].total
                        ],
                        backgroundColor: [
                            'rgba(231, 0, 0, 0.2)',
                            'rgba(231, 115, 0, 0.2)',
                            'rgba(231, 231, 0, 0.2)',
                            'rgba(0, 231, 0, 0.2)',
                            'rgba(0, 231, 231, 0.2)',
                        ],
                        borderColor: [
                            'rgba(231, 0, 0, 1)',
                            'rgba(231, 115, 0, 1)',
                            'rgba(231, 231, 0, 1)',
                            'rgba(0, 231, 0, 1)',
                            'rgba(0, 231, 231, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        }
    },
    mounted() {
        this.get_items()
    }
})