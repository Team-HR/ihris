new Vue({
    el: "#pds_family",
    data: {
        readonly: true,
        employee: {
            employee_id: 0,
            father_ext_name:"",
            father_first_name:"",
            father_last_name:"",
            father_middle_name:"",
            mother_first_name:"",
            mother_last_name:"",
            mother_middle_name:"",
            spouse_business_address:"",
            spouse_employeer:"",
            spouse_ext_name:"",
            spouse_first_name:"",
            spouse_last_name:"",
            spouse_middle_name:"",
            spouse_mobile:"",
            spouse_occupation:""
        },
        updateSuccess: false
    },
    methods: {
        getEmployeeData(){
            window.$_GET = new URLSearchParams(location.search);
            this.employee.employee_id = $_GET.get('employees_id');
            $.get("pds/config.php",{getPdsFamily: true, employee_id: this.employee.employee_id},
                (data, textStatus, jqXHR)=>{
                    this.employee = data
                    console.log(this.employee);
                },
                "json"
            );
        },
        goUpdate(){
            this.readonly = false
            $("#btn_pds_family_update").hide();
            $("#btns_pds_family_update").show();
        },
        goSave(){
            // console.log(this.employee);
            $.post("pds/config.php", {savePdsFamily: true, employee: this.employee},
                (data, textStatus, jqXHR)=>{
                    if (data > 0) {
                        $('body').toast({
                            title: 'LOOK',
                            message: 'See, how long i will last',
                            showProgress: 'bottom',
                            classProgress: 'red'
                        });
                        // this.savedToast()
                        // this.updateSuccess = true
                        // setTimeout(()=>{
                        //     this.updateSuccess = false
                        // }, 2000);
                    }
                    this.readonly = true
                    $("#btn_pds_family_update").show();
                    $("#btns_pds_family_update").hide();
                },
                "json"
            );
        },
        goCancel(){
            this.getEmployeeData()
            this.readonly = true
            $("#btn_pds_family_update").show();
            $("#btns_pds_family_update").hide();
        },
        savedToast(){
            $('body').toast({
                title: 'LOOK',
                message: 'See, how long i will last',
                showProgress: 'bottom',
                classProgress: 'red'
            });
        }
    },
    created() {
        this.getEmployeeData()
    }
})

