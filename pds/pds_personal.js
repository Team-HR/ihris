
var app_pds_personal = new Vue({
    el: "#pds_personal",
    data: {
        readonly: true,
        employee: {employee_id: 0,lastName: "",firstName: "",middleName: "",extName: "",birthdate: "",birthplace: "",citizenship: "",gender: "",civil_status: "",height: "",weight: "",blood_type: "",gsis_id: "",pag_ibig_id: "",philhealth_id: "",sss_id: "",tin_id: "",res_house_no: "",res_street: "",res_subdivision: "",res_barangay: "",res_city: "",res_province: "",res_zip_code: "",res_tel: "",permadd_resadd_same: false,perm_house_no: "",perm_street: "",perm_subdivision: "",perm_barangay: "",perm_city: "",perm_province: "",perm_zip_code: "",perm_tel: "",mobile: "",email: "",
        },
    },
    methods: {
        testinger(){
            alert("TESTINGER!");
        },
        getEmployeeData(){
            window.$_GET = new URLSearchParams(location.search);
            this.employee.employee_id = $_GET.get('employees_id');

                $.ajax({
                    type: "get",
                    url: "pds/config.php",
                    data: {
                        getPdsPersonal: true, employee_id: this.employee.employee_id
                    },
                    dataType: "json",
                    success: (response) => {
                        this.employee = response
                    },
                    async: false,
                });

        },
        goUpdate(){
            this.readonly = false
            $("#btn_pds_personal_update").hide();
            $("#btns_pds_personal_update").show();
        },
        goSave(){
            console.log(this.employee);
            $.post("pds/config.php", {savePdsPersonal: true, employee: this.employee},
                (data, textStatus, jqXHR)=>{
                    if (data > 0) {
                        this.savedToast()
                    }
                    this.readonly = true
                    $("#btn_pds_personal_update").show();
                    $("#btns_pds_personal_update").hide();
                },
                "json"
            );
        },
        savedToast(){
            $('body').toast({
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
            $("#btn_pds_personal_update").show();
            $("#btns_pds_personal_update").hide();
        }
    },
    mounted() {
        
        this.getEmployeeData()
        $('.ui.checkbox').checkbox();
        $('#pds_gender').dropdown({
             onChange: (value, text, $choice)=>{
                this.employee["gender"] = value;
             }
        });
        $('#pds_gender').dropdown('set selected',this.employee.gender);
        $('#pds_civil_status').dropdown({
            onChange: (value, text, $choice)=>{
               this.employee["civil_status"] = value;
            }
        });
        $('#pds_civil_status').dropdown('set selected',this.employee.civil_status);
        $('#pds_blood_type').dropdown({
            onChange: (value, text, $choice)=>{
            this.employee["blood_type"] = value;
            }
        });
        $('#pds_blood_type').dropdown('set selected',this.employee.blood_type);
        
    },
    watch: {
        permadd_resadd_same: function (val,oldVal){
            // console.log(val+" "+oldVal);
            if (val == true) {

            this.employee.perm_house_no = this.employee.res_house_no
            this.employee.perm_street = this.employee.res_street
            this.employee.perm_subdivision = this.employee.res_subdivision
            this.employee.perm_barangay = this.employee.res_barangay
            this.employee.perm_city = this.employee.res_city
            this.employee.perm_province = this.employee.res_province
            this.employee.perm_zip_code = this.employee.res_zip_code
            this.employee.perm_tel = this.employee.res_tel
















            }
        }
    }

})

// $(document).ready(function () {
//     $('#pds_gender').dropdown();
// });