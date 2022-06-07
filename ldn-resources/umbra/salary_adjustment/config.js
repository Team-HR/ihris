$(document).ready(function(){
    $('.ui.checkbox').checkbox();
    ;
});
var app = new Vue({
    el:"#app",
    data:{
        dataId:"",
        effectivity_date:"",
        date_approved:"",
        schedule:"",
        notation:"",
        active_status:0,
        salary_adjustments:[],
        loader:"loading"
    },
    methods:{
        openform:function(){
            app.dataId = ""
            app.effectivity_date = ""
            app.date_approved = ""
            app.schedule = ""
            app.notation = ""
            $('#salaryAdjustmentModal').modal('show')
        },
        removeData:function(i){
            var r = confirm("Are you sure?");
            if (r) {
                var fd  = new FormData();
                fd.append('removeData',app.salary_adjustments[i]['id']);
                var xml = new XMLHttpRequest();
                xml.onload = function() {
                    var rs = JSON.parse(xml.responseText);
                    $('body').toast({position:'top center',title:'Message',class: rs['status'],message: rs['msg']});    
                    if(rs['status']=="success"){
                        app.salary_adjustments = rs['salary'];
                    }
                }
                xml.open('POST','umbra/salary_adjustment/config.php')
                xml.send(fd)
            }
        },
        editData:function(index){    
            $('#salaryAdjustmentModal').modal('show')
            var dat = app.salary_adjustments[index] 
            app.dataId =  dat['id']
            app.effectivity_date = dat['effectivity_date']
            app.date_approved = dat['date_approved']
            app.schedule = dat['schedule']
            app.notation = dat['notation']
            app.active_status = dat['active']
            if(app.active_status=='1'){
                console.log($('#activeCheckBox').checkbox('check'));
            }else{
                console.log($('#activeCheckBox').checkbox('uncheck'));
            }
        },
        active_check:function(){
            if(event.target.checked){
                app.active_status = 1
            }else{
                app.active_status = 0
            }
                return app.active_status
        },
        addData:function(){
            var fd = new FormData();
                fd.append('salary_adjustment',true);
                fd.append('dataId',app.dataId);
                fd.append('effectivity_date',app.effectivity_date);
                fd.append('date_approved',app.date_approved);
                fd.append('schedule',app.schedule);
                fd.append('notation',app.notation);
                fd.append('active_status',app.active_status)
            var xml = new XMLHttpRequest();
                xml.onload = function(){
                    var rs = JSON.parse(xml.responseText);
                    $('body').toast({position:'top center',title:'Message',class: rs['status'],message: rs['msg']});    
                    if(rs['status']=="success"){
                        app.effectivity_date="";
                        app.date_approved="";
                        app.schedule="";
                        app.notation="";
                        $('#salaryAdjustmentModal').modal('hide')
                        app.salary_adjustments = rs['salary'];
                    }
                }
                xml.open('POST','umbra/salary_adjustment/config.php');
                xml.send(fd);
        },
        get_salary_adjustment:function(){
            var fd = new FormData();
                fd.append('get_salary_adjustment',true);
            var xml = new XMLHttpRequest()
                xml.onload = function(){
                    app.salary_adjustments = JSON.parse(xml.responseText);
                    setTimeout(() => {
                        app.loader = ""
                    }, 1000);
                }
                xml.open('POST','umbra/salary_adjustment/config.php');
                xml.send(fd);
        },
        gotopage:function(dat){
            window.location.href = "salary_adjustment_setup.php?dat="+dat;
        }
    },
    mounted:function(){
        var i = setInterval(() => {
            if(document.readyState=="complete"){
                console.log("done");
                app.get_salary_adjustment();
                clearInterval(i);
                }  
            },500 );
    },
});
