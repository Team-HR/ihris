    $(document).ready(function(){
        $(".dropdown").dropdown();
    })
    var app = new Vue({
        el:"#app",
        data:{
            Employees:[],
            Plantillas:[],
            employees_id:0,
            firstName:"",
            lastName:"",
            middleName:"",
            extName:"",
            supervisor:"",
            sup_position:"",
            plantilla_id:0,
            sg:"",
            actual_salary:"",
            actual_salary_in_words:"",
            item_no:"",
            Department_Head:"",
            Section_Head:"",
            department:"",
            nextInRank:"",
            probationary_period:"",
            vacated_by:"",
            section: "",
            other_compensation:"",
            page_no:"",
            status_of_appointment:"",
            date_of_appointment: "",
            date_of_assumption:"",
            nature_of_appointment:"",
            head_of_agency:"",
            date_of_signing:"",
            csc_auth_official:"",
            date_signed_by_csc:"",
            csc_mc_no:"",
            assessment_date_from:"",
            assessment_date_to:"",
            deliberation_date_from:"",
            deliberation_date_to:"",
            committee_chair:"",
            hrmo:"",
            cert_fund_available:"",
            published_at:"",
            probationary_date_from:"",
            probationary_date_to:"",
            posted_in:"",
            posted_date:"",
            csc_release_date:"",
            govID_type: "",
            govID_no:"",
            govID_issued_data:"",
            sworn_date:"",
            cert_issued_date:"",



        },
        methods:{
            getEmployees:function(){
                var fd = new FormData();
                    fd.append('getEmployees',true)
                var xml = new XMLHttpRequest();
                    xml.onload = function(){
                        app.Employees = JSON.parse(this.responseText)
                    }
                    xml.open("POST","appointments/config.php",false)
                    xml.send(fd)
            },
            getPlantillas:function(){
                var fd = new FormData()
                    fd.append('getPlantillas',true)
                var xml = new XMLHttpRequest();
                    xml.onload = function() {
                        app.Plantillas = JSON.parse(this.responseText);                    
                    }
                    xml.open("POST","appointments/config.php",false)
                    xml.send(fd)
            },
            NumInWords:function(number) {
                const first = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
                const tens = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];
                const mad = ['', 'thousand', 'million', 'billion', 'trillion'];
                let word = '';
                for (let i = 0; i < mad.length; i++) {
                let tempNumber = number%(100*Math.pow(1000,i));
                if (Math.floor(tempNumber/Math.pow(1000,i)) !== 0) {
                    if (Math.floor(tempNumber/Math.pow(1000,i)) < 20) {
                    word = first[Math.floor(tempNumber/Math.pow(1000,i))] + mad[i] + ' ' + word;
                    } else {
                    word = tens[Math.floor(tempNumber/(10*Math.pow(1000,i)))] + '-' + first[Math.floor(tempNumber/Math.pow(1000,i))%10] + mad[i] + ' ' + word;
                    }
                }
                tempNumber = number%(Math.pow(1000,i+1));
                if (Math.floor(tempNumber/(100*Math.pow(1000,i))) !== 0) word = first[Math.floor(tempNumber/(100*Math.pow(1000,i)))] + 'hunderd ' + word;
                }
                return word;
            },
            saveData  :function(){
                var obj  = {
                        "employees_id"    :app.employees_id,
                        "firstName"       :app.firstName,
                        "middleName"      :app.middleName,
                        "lastName"        :app.lastName,
                        "extName"         :app.extName,
                        "plantilla_id"    :app.plantilla_id,
                        "probationary_period":app.probationary_period,
                        "vacated_by"      :app.vacated_by,
                        "supervisor"      :app.supervisor,
                        "nextInRank"      :app.nextInRank,
                        "Department_Head" :app.Department_Head,
                        "section"         :app.section,
                        "Section_Head"    :app.Section_Head,
                        "other_compensation":app.other_compensation,
                        "page_no"         :app.page_no,
                        "status_of_appointment":app.status_of_appointment,
                        "date_of_appointment":app.date_of_appointment,
                        "date_of_assumption" :app.date_of_assumption,
                        "nature_of_appointment":app.nature_of_appointment,
                        "head_of_agency" :app.head_of_agency,
                        "date_of_signing"   :app.date_of_signing,
                        "csc_auth_official" :app.csc_auth_official,
                        "date_signed_by_csc":app.date_signed_by_csc,
                        "csc_mc_no"         :app.csc_mc_no,
                        "assessment_date_from":app.assessment_date_from,
                        "assessment_date_to":app.assessment_date_to,
                        "deliberation_date_from":app.deliberation_date_from,
                        "deliberation_date_to":app.deliberation_date_to,
                        "committee_chair"   :app.committee_chair,
                        "hrmo"            :app.hrmo,
                        "cert_fund_available":app.cert_fund_available,
                        "published_at"      :app.published_at,
                        "probationary_date_from":app.probationary_date_from,
                        "probationary_date_to":app.probationary_date_to,
                        "posted_in":app.posted_in,
                        "posted_date":app.posted_date,
                        "csc_release_date":app.csc_release_date,
                        "govID_type"      :app.govID_type,
                        "govID_no"        :app.govID_no,
                        "govID_issued_data":app.govID_issued_data,      
                        "sworn_date"       :app.sworn_date,
                        "cert_issued_date" :app.cert_issued_date,
                }
                $.post('appointments/config.php',{
                    set_appiontment:obj,
                },function(data){
                })
            }
        },watch:{
            employees_id:function () {
                app.firstName = app.Employees[app.employees_id].firstName   
                app.lastName = app.Employees[app.employees_id].lastName   
                app.middleName = app.Employees[app.employees_id].middleName   
                app.extName = app.Employees[app.employees_id].extName   
            },
            plantilla_id:function() {
                app.sg = app.Plantillas[app.plantilla_id].sg
                app.actual_salary = app.Plantillas[app.plantilla_id].actual_salary
                app.actual_salary_in_words = app.NumInWords(app.actual_salary)
                app.item_no = app.Plantillas[app.plantilla_id].item_no
                app.department = app.Plantillas[app.plantilla_id].department
            },
            supervisor: function() {
                app.sup_position = app.Employees[app.supervisor].position
            }
        },
        mounted:function(){
            var interval = setInterval(() => {
                if(document.readyState == "complete"){
                    app.getEmployees()
                    app.getPlantillas()
                    clearInterval(interval)
                }                
            }, 1000);
        }
    }) 