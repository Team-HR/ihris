$(document).ready(function () {
    $('#pds .item').tab();
    $('#pim-menu .item').tab();
});

new Vue({
    el: "#pds-app",
    data: {
        employee_id: 0,
        employee: {}
    },
    methods: {
        getEmployeeData() {
            $.ajax({
                type: "get",
                url: "pds/config.php",
                data: { getEmployeeData: true, employee_id: this.employee_id },
                dataType: "json",
                ansyc: false,
                success: (response) => {
                    this.employee = response
                }
            });
        }
    },
    mounted() {
        window.$_GET = new URLSearchParams(location.search);
        this.employee_id = $_GET.get('employees_id');
        this.getEmployeeData()
        var loop = setInterval(() => {
            if (document.readyState == 'complete') {
                this.getEmployeeData();
                console.log(this.employee);

                clearInterval(loop);
            }
        }, 100);
    }
})