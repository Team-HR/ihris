new Vue({
    el: "#pds_education",
    data: {
        readonly: true,
        employee_id: null,
        educations: {
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
            this.employee_id = $_GET.get('employees_id');
            $.get("pds/config.php",{getPdsEducation: true, employee_id: this.employee_id},
                (data, textStatus, jqXHR)=>{
                    this.educations = data
                    // console.log(this.educations);
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
            // console.log(this.educations);
            $.post("pds/config.php", {savePdsEducation: true, employee_id: this.employee_id, data: this.educations},
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
        addSchool(school){
            var insert_index = this.educations[school].push ({
                school: null,
                degree_course: null,
                ed_period: null,
                grade_level_units: null,
                year_graduated: null,
                scholarships_honors: null
            }) - 1;
        },
        remSchool(i,school){
            this.educations[school].splice(i,1)
        }

    },
    computed:{
        numOfElementaries(){
            return this.educations.elementary.length;
        },
        numOfSecondaries(){
            return this.educations.secondary.length;
        },
        numOfVocationals(){
            return this.educations.vocational.length;
        },
        numOfColleges(){
            return this.educations.college.length;
        },
        numOfGraduateStudies(){
            return this.educations.graduate_studies.length;
        }
    },
    created() {
        var checkLoaded = setInterval(() => {
            // console.log(document.readyState);
            if (document.readyState == 'complete') {
                this.getEmployeeData()
                clearInterval(checkLoaded);
            }
        }, 100);
    }
})