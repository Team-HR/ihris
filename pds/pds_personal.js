new Vue({
    el: "#pds_personal",
    data: {
        readonly: true,
        employee: {employee_id: 0,lastName: "",firstName: "",middleName: "",extName: "",birthdate: "",birthplace: "",citizenship: "",gender: "",civil_status: "",height: "",weight: "",blood_type: "",gsis_id: "",pag_ibig_id: "",philhealth_id: "",sss_id: "",tin_id: "",res_house_no: "",res_street: "",res_subdivision: "",res_barangay: "",res_city: "",res_province: "",res_zip_code: "",res_tel: "",perm_house_no: "",perm_street: "",perm_subdivision: "",perm_barangay: "",perm_city: "",perm_province: "",perm_zip_code: "",perm_tel: "",mobile: "",email: "",
        }
    },
    methods: {
        getEmployeeData(){
            window.$_GET = new URLSearchParams(location.search);
            this.employee.employee_id = $_GET.get('employees_id');
            console.log(this.employee.employee_id);
            
            $.get("pds/config.php",{getEmployeeData: true, employee_id: this.employee.employee_id},
                (data, textStatus, jqXHR)=>{
                    this.employee = data
                    console.log(this.employee);
                },
                "json"
            );
        },
        goUpdate(){
            this.readonly = false
            $("#btn_pds_personal_update").hide();
            $("#btns_pds_personal_update").show();
        },
        goSave(){
            $.post("pds/config.php", {savePdsPersonal: true, employee: this.employee},
                (data, textStatus, jqXHR)=>{
                    console.log('data',data);
                    if (data > 0) {
                        $("#pds_personal_update_saved").show();
                    }
                    // console.log('textStatus',textStatus);
                    // console.log('jqXHR',jqXHR);
                    this.readonly = true
                    $("#btn_pds_personal_update").show();
                    $("#btns_pds_personal_update").hide();
                },
                "json"
            );
        },
        goCancel(){
            this.getEmployeeData()
            this.readonly = true
            $("#btn_pds_personal_update").show();
            $("#btns_pds_personal_update").hide();
        }
    },
    created() {
        this.getEmployeeData()
    }
})

