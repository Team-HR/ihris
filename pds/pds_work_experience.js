new Vue({
    el: "#pds_exp",
    data: {
        readonly: true,
        employee_id: null,
        exps: []
    },
    methods: {
        nullDate(date){
            return date=="0000-00-00"||date==null||date==""?true:false;
        },
        getEmployeeData(){
            window.$_GET = new URLSearchParams(location.search);
            this.employee_id = $_GET.get('employees_id');
            $.get("pds/config.php",{getPdsExperiences: true, employee_id: this.employee_id},
                (data, textStatus, jqXHR)=>{
                    this.exps = data
                },
                "json"
            );
        },
        goUpdate(){
            this.readonly = false
            $("#btn_pds_exp_update").hide();
            $(".btns_pds_exp_update").show();
            
        },
        goSave(){
            $.post("pds/config.php", {savePdsExperiences: true, employee_id: this.employee_id, data: this.exps},
                (data, textStatus, jqXHR)=>{    
                    if (data > 0) {
                        this.savedToast()
                    }
                    this.getEmployeeData()
                    this.readonly = true
                    $("#btn_pds_exp_update").show();
                    $(".btns_pds_exp_update").hide();
                },
                "json"
            );
        },
        savedToast(){
            $('#form_pds_exp').toast({
                title: 'Saved!',
                message: 'Succesfully saved changes!',
                showProgress: 'bottom',
                classProgress: 'green',
                position: 'top center',
                className: {
                    toast: 'ui message'
                }
            });
        },
        goCancel(){
            this.getEmployeeData()
            this.readonly = true
            $("#btn_pds_exp_update").show();
            $(".btns_pds_exp_update").hide();
        },
        addItem(){
            this.exps.push({
                exp_from: null,
                exp_to: null,
                exp_position: null,
                exp_company: null,
                exp_monthly_salary: null,
                exp_sg: null,
                exp_status_of_appointment: null,
                exp_govt: null
             })
        },
        removeItem(i){
            this.exps.splice(i,1);
        }
    },
    created() {
        var checkLoaded = setInterval(() => {
            if (document.readyState == 'complete') {
                this.getEmployeeData()
                clearInterval(checkLoaded);
            }
        }, 100);
    },
})