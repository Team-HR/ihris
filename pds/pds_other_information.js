new Vue({
    el: "#pds_other_information",
    data: {
        readonly: true,
        employee_id: null,
        numOfChanges:0,
        pds_hobbies_and_skills:[],
        pds_non_academic_recognitions:[],
        pds_org_memberships: []
    },
    methods: {  
        getEmployeeData(){
            window.$_GET = new URLSearchParams(location.search);
            this.employee_id = $_GET.get('employees_id');
            $.get("pds/config.php",{getPdsOtherInformation: true, employee_id: this.employee_id},
                (data, textStatus, jqXHR)=>{
                    this.pds_hobbies_and_skills = data[0]
                    this.pds_non_academic_recognitions = data[1]
                },"json"
            );
        },
        goSave(){
            this.numOfChanges = 0;
            $.post("pds/config.php", {save_pds_hobbies_and_skills: true, employee_id: this.employee_id, data: this.pds_hobbies_and_skills},
                (data, textStatus, jqXHR)=>{    
                    // if (data > 0) {
                    //     this.savedToast()
                    // }
                    this.numOfChanges += data
                    this.getEmployeeData()
                    this.readonly = true
                },"json"
            );

            $.post("pds/config.php", {save_pds_non_academic_recognitions: true, employee_id: this.employee_id, data: this.pds_non_academic_recognitions},
                (data, textStatus, jqXHR)=>{    
                    // if (data > 0) {
                    //     this.savedToast()
                    // }
                    this.numOfChanges += data
                    this.getEmployeeData()
                    this.readonly = true
                },"json"
            );
            
            $.post("pds/config.php", {save_pds_org_memberships: true, employee_id: this.employee_id, data: this.pds_org_memberships},
                (data, textStatus, jqXHR)=>{    
                    // if (data > 0) {
                    //     this.savedToast()
                    // }
                    this.numOfChanges += data
                    this.getEmployeeData()
                    this.readonly = true
                },"json"
            );
            
            // console.log();
            
            // if(this.readonly){
            //     this.savedToast();
            // }

        },
        savedToast(){
            $('#form_pds_elig').toast({
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
    },
    watch: {
        numOfChanges: function(val,oldVal){
            // if(val > 0)
            // this.savedToast();
            console.log(val+" "+oldVal);
            // console.log(oldVal);
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