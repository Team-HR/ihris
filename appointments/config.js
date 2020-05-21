$(document).ready(function(){
    $('.dropdown').dropdown()
  });


var app = new Vue({
    el:'#app', 
    data:{
        plantilla_id            :'',
        status_of_appointment   :'',
        date_of_appointment     :'',
        date_ended              :'',
        nature_of_appointment   :'',
        legal_doc               :'',
        memo_for_legal          :'',
        head_of_agency          :'',
        date_of_signing         :'',
        csc_auth_official       :'',
        date_signed_by_csc      :'',
        csc_mc_no               :'',
        published_at            :'',
        date_of_publication     :'',
        hrmo                    :'',
        screening_body          :'',
        date_of_screening       :'',
        committee_chair         :'',
        notation_1              :0,
        notation_2              :0,
        notation_3              :0,
        notation_4              :0,
        csc_release_date        :'',
        timestamp_created       :'',
        timestamp_updated       :'',
        employees_id            :0,
        firstName               :'',
        middleName              :'',
        lastName                :'',
        extName                 :'',
        Employees               :[],
        Plantillas              :[],
        txt_rate                :'',
        txt_dep                 :'',
        txt_salaryGrd           :'',
        txt_annual              :'',
        txt_section             :'',
    },
    methods:{
        submitForm  :function(){
        },
        getJSON     :function(val){
            var fd = new FormData()
                fd.append(val,true);
            var xml = new XMLHttpRequest();
                xml.onload = function(){
                    if(val=="getEmployees"){
                        app.Employees = JSON.parse(xml.responseText)
                    }else if(val=="getPlantillas"){
                        app.Plantillas = JSON.parse(xml.responseText)
                    }
                }
                xml.open('POST','appointments/config.php',true)
                xml.send(fd)
        },
        fillEmp     :function(){
                app.firstName = app.Employees[app.employees_id].firstName
                app.lastName = app.Employees[app.employees_id].lastName
                app.middleName = app.Employees[app.employees_id].middleName
                app.extName = app.Employees[app.employees_id].extName                
        },
        fillPlantilla :function(){
                console.log('changed');
        }
    },  
    mounted:function(){
        var interval = setInterval(() => {
            if(document.readyState=="complete"){
                app.getJSON('getEmployees')
                app.getJSON('getPlantillas')

                clearInterval(interval)
            }
        }, 500);
    }
})