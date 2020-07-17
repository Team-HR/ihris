    $(document).ready(function(){
        $(".dropdown").dropdown({
            fullTextSearch:true,
        });
    })
    var app = new Vue({
        el:"#app",
        data:{
            Employees:[],
            Plantilla:[],
            employ:"",
            pre_employ:"",
            employees_id:0,
            firstName:"",
            middleName:"",
            lastName:"",
            extName:"",
            waitLoad:"loading",
            employees_id:"",
            plantilla_id:"",
            status_of_appointment:"",
            csc_authorized_official:"",
            date_signed_by_csc:"",
            committee_chair:"",
            date_of_appointment:"",
            date_of_assumption:"",
            csc_mc_no:"",
            HRMO:"",
            office_assignment:"",
            nature_of_appointment:"",
            date_of_signing:"",
            deliberation_date_from:"",
            deliberation_date_to:"",
            published_at:"",
            posted_in:"",
            govId_type:"",
            govId_no:"",
            govId_issued_date:"",
            posted_date:"",
            csc_release_date:"",
            sworn_date:"",
            cert_issued_date:"",
            casual_promotion:"",
            probationary_period:""
        },
        methods:{
            getEmployees:function(){
                var fd = new FormData();
                    fd.append('Employees',true)
                var xml = new XMLHttpRequest()
                    xml.onload = function(){
                        app.Employees = JSON.parse(xml.responseText)
                    }
                    xml.open('POST','umbra/appointments/config.php',true)
                    xml.send(fd)
            }, 
            get_plantilla:function(){
                dataId = document.getElementById('appointments_form').attributes['data-id'].value;
                app.plantilla_id = dataId;
                var fd = new FormData();
                    fd.append('Plantilla',dataId);
                var xml = new XMLHttpRequest();
                    xml.onload = function(){
                        app.Plantilla = JSON.parse(xml.responseText);
                        app.waitLoad="";
                    }
                    xml.open('POST','umbra/appointments/config.php',true)
                    xml.send(fd)
            },
            formatNumber:function (num){
                return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
            },saveAppointment:function(){
                var fd = new FormData();
                    fd.append('saveAppointment',true);
                    fd.append("employees_id",app.employees_id)
                    fd.append("plantilla_id",app.plantilla_id)
                    fd.append("status_of_appointment",app.status_of_appointment)
                    fd.append("csc_authorized_official",app.csc_authorized_official)
                    fd.append("date_signed_by_csc",app.date_signed_by_csc)
                    fd.append("committee_chair",app.committee_chair)
                    fd.append("date_of_appointment",app.date_of_appointment)
                    fd.append("date_of_assumption",app.date_of_assumption)
                    fd.append("csc_mc_no",app.csc_mc_no)
                    fd.append("HRMO",app.HRMO)
                    fd.append("office_assignment",app.office_assignment)
                    fd.append("nature_of_appointment",app.nature_of_appointment)
                    fd.append("date_of_signing",app.date_of_signing)
                    fd.append("deliberation_date_from",app.deliberation_date_from)
                    fd.append("deliberation_date_to",app.deliberation_date_to)
                    fd.append("published_at",app.published_at)
                    fd.append("posted_in",app.posted_in)
                    fd.append("govId_type",app.govId_type)
                    fd.append("govId_no",app.govId_no)
                    fd.append("govId_issued_date",app.govId_issued_date)
                    fd.append("posted_date",app.posted_date)
                    fd.append("csc_release_date",app.csc_release_date)
                    fd.append("sworn_date",app.sworn_date)
                    fd.append("cert_issued_date",app.cert_issued_date)
                    fd.append("casual_promotion",app.casual_promotion)
                    fd.append("probationary_period",app.probationary_period)
                var xml = new XMLHttpRequest();
                    xml.onload = function(){

                    }
                    xml.open('POST','umbra/appointments/config.php');
                    xml.send(fd);
            }
        },watch:{
            employ:function(){
                if(app.employ==""){
                    app.employees_id="";
                }else{
                    d = app.Employees[app.employ];
                    app.employees_id = d.employees_id;
                    app.firstName = d.firstName;
                    app.middleName = d.middleName;
                    app.lastName = d.lastName;
                    app.extName = d.extName;
                }
            },
        },
        mounted:function(){
            var interval = setInterval(() => {
                if(document.readyState == "complete"){
                    app.getEmployees();
                    app.get_plantilla();
                    clearInterval(interval)
                }                
            }, 1000);
        }
    }) 