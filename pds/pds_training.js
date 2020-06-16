new Vue({
    el: "#pds_training",
    data: {
        readonly: true,
        employee_id: null,
        trs: []
    },
    methods: {  
        getEmployeeData(){
            window.$_GET = new URLSearchParams(location.search);
            this.employee_id = $_GET.get('employees_id');
            $.get("pds/config.php",{getPdsTrainings: true, employee_id: this.employee_id},
                (data, textStatus, jqXHR)=>{
                    this.trs = data
                },
                "json"
            );
        },
        goUpdate(){
            this.readonly = false
            $("#btn_pds_training_update").hide();
            $(".btns_pds_training_update").show();
            
        },
        goSave(){
            console.log(this.trs);
            $.post("pds/config.php", {savePdsTrainings: true, employee_id: this.employee_id, data: this.trs},
                (data, textStatus, jqXHR)=>{    
                    if (data > 0) {
                        this.savedToast()
                    }
                    this.getEmployeeData()
                    this.readonly = true
                    $("#btn_pds_training_update").show();
                    $(".btns_pds_training_update").hide();
                },
                "json"
            );
        },
        savedToast(){
            $('#form_pds_training').toast({
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
            $("#btn_pds_training_update").show();
            $(".btns_pds_training_update").hide();
        },
        addItem(){
            this.trs.push({
                tr_title: null,
                tr_from: null,
                tr_to: null,
                tr_hours: null,
                tr_by: null
             })
        },
        removeItem(i){
            this.trs.splice(i,1);
        }
    },
    created() {
        var checkLoaded = setInterval(() => {
            if (document.readyState == 'complete') {
                this.getEmployeeData()
                clearInterval(checkLoaded);
            }
        }, 100);
    }
})





