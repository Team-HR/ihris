new Vue({
    el: "#pds_elig",
    data: {
        readonly: true,
        employee_id: null,
        eligs: [],
        elig: {
            elig_title: null,
            rating: null,
            exam_date: null,
            exam_place: null,
            license_id: null,
            release_date: null
        },
    },
    methods: {
        getEmployeeData(){
            window.$_GET = new URLSearchParams(location.search);
            this.employee_id = $_GET.get('employees_id');
            $.get("pds/config.php",{getPdsEligibility: true, employee_id: this.employee_id},
                (data, textStatus, jqXHR)=>{
                    this.eligs = data
                    console.log("test:",this.eligs);
                },
                "json"
            );
        },
        goUpdate(){
            this.readonly = false
            $("#btn_pds_elig_update").hide();
            $(".btns_pds_elig_update").show();
            
        },
        goSave(){
            console.log(this.eligs);
            $.post("pds/config.php", {savePdsEligibility: true, employee_id: this.employee_id, data: this.eligs},
                (data, textStatus, jqXHR)=>{    
                    // console.log("saved! ",data);
                    if (data > 0) {
                        this.savedToast()
                    }
                    this.getEmployeeData()
                    this.readonly = true
                    $("#btn_pds_elig_update").show();
                    $(".btns_pds_elig_update").hide();
                },
                "json"
            );
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
        goCancel(){
            this.getEmployeeData()
            this.readonly = true
            $("#btn_pds_elig_update").show();
            $(".btns_pds_elig_update").hide();
        },
        addItem(){
            this.eligs.push({
                elig_title: null,
                rating: null,
                exam_date: null,
                exam_place: null,
                license_id: null,
                release_date: null
             })
        },
        removeItem(i){
            this.eligs.splice(i,1);
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