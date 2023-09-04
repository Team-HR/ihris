new Vue({
    el: "#pds_other_information",
    data: {
        readonly: true,
        employee_id: null,
        numOfChanges:0,
        pds_hobbies_and_skills:[],
        pds_non_academic_recognitions:[],
        pds_org_memberships: [],
        pds_references:[],
        third_degree: false,
        fourth_degree: false,
        degree_details:"",
        admin_offense:false,
        admin_offense_details:"",
        criminally_charged:false,
        case_date_filed:"",
        case_status:"",
        convicted:false,
        convicted_details:"",
        separated_from_service:false,
        separated_from_service_details:"",
        election_candidate:false,
        election_candidate_details:"",
        resigned_gov_to_campaign: false,
        resigned_gov_to_campaign_details:"",
        immigrant: false,
        immigrant_details: "",
        indigenous_member:false,
        indigenous_member_details:"",
        pwd:false,
        pwd_details:"",
        solo_parent:false,
        solo_parent_details:"",
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
                    this.third_degree = data[4].third_degree
                    this.fourth_degree = data[4].fourth_degree
                    this.degree_details = data[4].degree_details
                    this.admin_offense = data[4].admin_offense
                    this.admin_offense_details = data[4].admin_offense_details
                    this.criminally_charged = data[4].criminally_charged
                    this.case_date_filed = data[4].case_date_filed
                    this.case_status = data[4].case_status
                    this.convicted = data[4].convicted
                    this.convicted_details = data[4].convicted_details
                    this.separated_from_service = data[4].separated_from_service
                    this.separated_from_service_details = data[4].separated_from_service_details
                    this.election_candidate = data[4].election_candidate
                    this.election_candidate_details = data[4].election_candidate_details
                    this.resigned_gov_to_campaign = data[4].resigned_gov_to_campaign
                    this.resigned_gov_to_campaign_details = data[4].resigned_gov_to_campaign_details
                    this.immigrant = data[4].immigrant
                    this.immigrant_details = data[4].immigrant_details
                    this.indigenous_member = data[4].indigenous_member
                    this.indigenous_member_details = data[4].indigenous_member_details
                    this.pwd = data[4].pwd
                    this.pwd_details = data[4].pwd_details
                    this.solo_parent = data[4].solo_parent
                    this.solo_parent_details = data[4].solo_parent_details
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


            var pds_personal = {
                    third_degree: this.third_degree,
                    fourth_degree: this.fourth_degree,
                    degree_details: this.degree_details,
                    admin_offense: this.admin_offense,
                    admin_offense_details: this.admin_offense_details,
                    criminally_charged: this.criminally_charged,
                    case_date_filed: this.case_date_filed,
                    case_status: this.case_status,
                    convicted: this.convicted,
                    convicted_details: this.convicted_details,
                    separated_from_service: this.separated_from_service,
                    separated_from_service_details: this.separated_from_service_details,
                    election_candidate: this.election_candidate,
                    election_candidate_details: this.election_candidate_details,
                    resigned_gov_to_campaign: this.resigned_gov_to_campaign,
                    resigned_gov_to_campaign_details: this.resigned_gov_to_campaign_details,
                    immigrant: this.immigrant,
                    immigrant_details: this.immigrant_details,
                    indigenous_member: this.indigenous_member,
                    indigenous_member_details: this.indigenous_member_details,
                    pwd: this.pwd,
                    pwd_details: this.pwd_details,
                    solo_parent: this.solo_parent,
                    solo_parent_details: this.solo_parent_details,
            };

            $.ajax({
                type: "post",
                url: "pds/config.php",
                data: {
                    save_pds_personal: true,
                    employee_id: this.employee_id,
                    data: pds_personal
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