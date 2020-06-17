new Vue({
    el: "#pds_other_information",
    data: {
        readonly: true,
        employee_id: null,
        numOfChanges:0,
        pds_hobbies_and_skills:[],
        pds_non_academic_recognitions:[],
        pds_org_memberships: [],
        pds_references:[]
    },
    methods: {  
        getEmployeeData(){
            window.$_GET = new URLSearchParams(location.search);
            this.employee_id = $_GET.get('employees_id');
            $.get("pds/config.php",{getPdsOtherInformation: true, employee_id: this.employee_id},
                (data, textStatus, jqXHR)=>{
                    this.pds_hobbies_and_skills = data[0]
                    this.pds_non_academic_recognitions = data[1]
                    this.pds_org_memberships = data[2]
                    this.pds_references = data[3]
                    // console.log(this.pds_references);
                    
                },"json"
            );
        },
        goSave(){
            this.numOfChanges = 0;
            $.ajax({
                type: "post",
                url: "pds/config.php",
                data: {
                    save_pds_hobbies_and_skills: true,
                    employee_id: this.employee_id,
                    data: this.pds_hobbies_and_skills
                },
                dataType: "json",
                success: (data)=>{
                    this.numOfChanges += data
                    this.getEmployeeData()
                    this.readonly = true
                },
                async:false
            });

            $.ajax({
                type: "post",
                url: "pds/config.php",
                data: {
                    save_pds_non_academic_recognitions: true,
                    employee_id: this.employee_id,
                    data: this.pds_non_academic_recognitions
                },
                dataType: "json",
                success: (data)=>{
                    this.numOfChanges += data
                    this.getEmployeeData()
                    this.readonly = true
                },
                async:false
            });

            $.ajax({
                type: "post",
                url: "pds/config.php",
                data: {
                    save_pds_org_memberships: true,
                    employee_id: this.employee_id,
                    data: this.pds_org_memberships
                },
                dataType: "json",
                success: (data)=>{
                    this.numOfChanges += data
                    this.getEmployeeData()
                    this.readonly = true
                },
                async:false
            });

            
            $.ajax({
                type: "post",
                url: "pds/config.php",
                data: {
                    save_pds_references: true,
                    employee_id: this.employee_id,
                    data: this.pds_references
                },
                dataType: "json",
                success: (data)=>{
                    this.numOfChanges += data
                    this.getEmployeeData()
                    this.readonly = true
                },
                async:false
            });

            if(this.numOfChanges > 0){
                this.savedToast();
            }

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
    created() {
        var checkLoaded = setInterval(() => {
            if (document.readyState == 'complete') {
                this.getEmployeeData()
                $('.ui .checkbox').checkbox();
                clearInterval(checkLoaded);
            }
        }, 100);
    },
    
})