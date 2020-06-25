var app = new Vue({
    el:"#app",
    data:{
        loading:"loading",
        positions:[],
        q_standards:[],
        position_form:"",
        positionID_form:"",
        sg_form:"",
        level_form:"",
        functional_form:"",
        category_form:"",
        education_form:"",
        experience_form:"",
        training_form:"",
        eligibility_form:"",
        competency_form:"",
        edID:"",
        findValue:"",
    },methods:{ 
        openQsModal:function(i){
            $('#qs_modal').modal('show');
            app.position_form = app.positions[i].position;
            app.sg_form = app.positions[i].salaryGrade;
            app.level_form = app.positions[i].level;
            app.category_form = app.positions[i].category;
            app.functional_form = app.positions[i].functional;
            app.positionID_form = app.positions[i].position_id;
            app.education_form = ""
            app.experience_form = ""
            app.training_form = ""
            app.eligibility_form = ""
            app.competency_form = ""
            app.edID = ""
        },
        closeModal:function(){
            $('#qs_modal').modal('hide');
        },
        editOpenModal:function(i,qs){
            $('#qs_modal').modal('show');
            app.edID = app.q_standards[qs].id
            app.position_form = app.positions[i].position;
            app.sg_form = app.positions[i].salaryGrade;
            app.level_form = app.positions[i].level;
            app.category_form = app.positions[i].category;
            app.functional_form = app.positions[i].functional;
            app.positionID_form = app.positions[i].position_id;
            app.education_form = app.q_standards[qs].education
            app.experience_form = app.q_standards[qs].experience
            app.training_form = app.q_standards[qs].training
            app.eligibility_form = app.q_standards[qs].eligibility
            app.competency_form = app.q_standards[qs].competency
        },
        qsModalFormSubmit:function(){
            var fd = new FormData()
                fd.append('saveQS',app.edID)
                fd.append('positionID',app.positionID_form)
                fd.append('education',app.education_form)
                fd.append('experience',app.experience_form)
                fd.append('training',app.training_form)
                fd.append('eligibility',app.eligibility_form)
                fd.append('competency',app.competency_form)
            var xml = new XMLHttpRequest()
                xml.onload = function(){
                    res = JSON.parse(xml.responseText);
                    app.q_standards = res.QS;
                    $('body').toast({class: res.status,message: res.msg});
                    app.closeModal()
                }
                xml.open('POST','umbra/qualification_standards/config.php',false)
                xml.send(fd)
        },
        get_position:function(){
            var fd = new FormData();
                fd.append('positions',true)
            var xml = new XMLHttpRequest();
                xml.onload = function(){
                    app.positions = JSON.parse(xml.responseText)
                    setTimeout(() => {
                        app.loading = "";
                    },1000);
                }
                xml.open('POST','umbra/qualification_standards/config.php',false)
                xml.send(fd)
        },
        get_qs:function(){
            var fd = new FormData();
                fd.append('qs',true);
            var xml = new XMLHttpRequest();
                xml.onload = function(){
                    app.q_standards = JSON.parse(xml.responseText);
                }
                xml.open('POST','umbra/qualification_standards/config.php',false)
                xml.send(fd)
        },
        removeData:function(i){
            con = confirm("Are you sure?");
            if(con){
                var fd = new FormData();
                    fd.append('removeData',app.q_standards[i].id);
                var xml = new XMLHttpRequest();
                    xml.onload = function(){
                        res = JSON.parse(xml.responseText)
                        $('body').toast({class: res.status,message: res.msg})      
                        app.q_standards = res.QS;              
                    }
                    xml.open('POST','umbra/qualification_standards/config.php',false)
                    xml.send(fd)
            }
        },
    },watch:{
        findValue:function(){
            var table = document.getElementById('qs_table');
            var tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                  txtValue = td.textContent || td.innerText;
                  if (txtValue.toUpperCase().indexOf(app.findValue.toUpperCase()) > -1) {
                    tr[i].style.display = "";
                  } else {
                    tr[i].style.display = "none";
                  }
                }
              }
        }
    },
    mounted:function(){
        var i = setInterval(() => {
            if(document.readyState == "complete"){
                app.get_position();
                app.get_qs()
                clearInterval(i);
            }            
        },500);
    }
})