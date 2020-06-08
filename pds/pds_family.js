new Vue({
    el: "#pds_family",
    data: {
        readonly: true,
        employee: {
            employee_id: 0,
            father_ext_name:"",
            father_first_name:"",
            father_last_name:"",
            father_middle_name:"",
            mother_first_name:"",
            mother_last_name:"",
            mother_middle_name:"",
            spouse_business_address:"",
            spouse_employeer:"",
            spouse_ext_name:"",
            spouse_first_name:"",
            spouse_last_name:"",
            spouse_middle_name:"",
            spouse_mobile:"",
            spouse_occupation:"",
            children: {}
        },

    },
    methods: {
        getEmployeeData(){
            window.$_GET = new URLSearchParams(location.search);
            this.employee.employee_id = $_GET.get('employees_id');
            $.get("pds/config.php",{getPdsFamily: true, employee_id: this.employee.employee_id},
                (data, textStatus, jqXHR)=>{
                    this.employee = data
                    console.log(this.employee);
                },
                "json"
            );
        },
        goUpdate(){
            this.readonly = false
            $("#btn_pds_family_update").hide();
            $(".btns_pds_family_update").show();
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
                    $("#btn_pds_family_update").show();
                    $(".btns_pds_family_update").hide();
                },
                "json"
            );
        },
        savedToast(){
            $('#form_pds_family').toast({
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
            $("#btn_pds_family_update").show();
            $(".btns_pds_family_update").hide();
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
        numOfChildren(){
            return this.employee.children.length;
        }
    },
    created() {
        this.getEmployeeData()
    }
})