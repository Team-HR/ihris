new Vue({
    el: "#pds_voluntary",
    data: {
        readonly: true,
        employee_id: null,
        vols: []
    },
    methods: {  
        getEmployeeData(){
            window.$_GET = new URLSearchParams(location.search);
            this.employee_id = $_GET.get('employees_id');
            $.get("pds/config.php",{getPdsVoluntaries: true, employee_id: this.employee_id},
                (data, textStatus, jqXHR)=>{
                    this.vols = data
                },
                "json"
            );
        },
        goUpdate(){
            this.readonly = false
            $("#btn_pds_voluntary_update").hide();
            $(".btns_pds_voluntary_update").show();
            
        },
        goSave(){
            $.post("pds/config.php", {savePdsVoluntaries: true, employee_id: this.employee_id, data: this.vols},
                (data, textStatus, jqXHR)=>{    
                    if (data > 0) {
                        this.savedToast()
                    }
                    this.getEmployeeData()
                    this.readonly = true
                    $("#btn_pds_voluntary_update").show();
                    $(".btns_pds_voluntary_update").hide();
                },
                "json"
            );
        },
        savedToast(){
            $('#form_pds_voluntary').toast({
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
            $("#btn_pds_voluntary_update").show();
            $(".btns_pds_voluntary_update").hide();
        },
        addItem(){
            this.vols.push({
                vw_organization:null,
                vw_from:null,
                vw_to:null,
                vw_hours:null,
                vw_nature_work:null
             })
        },
        removeItem(i){
            this.vols.splice(i,1);
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
