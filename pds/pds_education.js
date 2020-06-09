new Vue({
    el: "#pds_education",
    data: {
        readonly: true,
        employee: {
            employee_id: 0,
            elementary: {},
            secondary:{},
            vocational:{},
            college:{},
            graduate_studies:{}
        },

    },
    methods: {
        getEmployeeData(){
            window.$_GET = new URLSearchParams(location.search);
            this.employee.employee_id = $_GET.get('employees_id');
            $.get("pds/config.php",{getPdsEducation: true, employee_id: this.employee.employee_id},
                (data, textStatus, jqXHR)=>{
                    this.employee = data
                    console.log(this.employee);
                },
                "json"
            );
        },
        goUpdate(){
            this.readonly = false
            $("#btn_pds_education_update").hide();
            $(".btns_pds_education_update").show();
        },
        goSave(){
            console.log(this.employee);
            $.post("pds/config.php", {savePdsFamily: true, employee: this.employee},
                (data, textStatus, jqXHR)=>{
                    // console.log("saved! ",data);
                    if (data > 0) {
                        this.savedToast()
                    }
                    this.getEmployeeData()
                    this.readonly = true
                    $("#btn_pds_education_update").show();
                    $(".btns_pds_education_update").hide();
                },
                "json"
            );
        },
        savedToast(){
            $('#form_pds_education').toast({
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
            $("#btn_pds_education_update").show();
            $(".btns_pds_education_update").hide();
        },
        addChild(){
            var insert_index = this.employee.children.push ({
                child_name: "",
                child_birthdate: ""
            }) - 1;
            // console.log(insert_index);

        },
        remChild(i){
            this.employee.children.splice(i,1)
            // console.log(this.employee);
        }

    },
    computed:{
        numOfElementaries(){
            return this.employee.elementary.length;
        },
        numOfSecondaries(){
            return this.employee.secondary.length;
        },
        numOfVocationals(){
            return this.employee.vocational.length;
        },
        numOfColleges(){
            return this.employee.college.length;
        },
        numOfGraduateStudies(){
            return this.employee.graduate_studies.length;
        }
    },
    created() {
        this.getEmployeeData()
    }
})