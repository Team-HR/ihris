var app = new Vue({
    el:"#app",
    data:{
        salary_grade:"",
        step_no:"",
        monthly_salary:"",
        updt:"",
        dat:[],
        load: "loading",
    },
    methods:{
        showModal:function(){
            $('#salaryModalSetup').modal('show');
            app.salary_grade = ""
            app.step_no=""
            app.monthly_salary = ""
            app.updt =""
        },
        sumbitSetupForm:function(dataId){
            var fd = new FormData()
                fd.append('saveSalarySetup',true)
                fd.append('salary_grade',app.salary_grade)
                fd.append('step_no',app.step_no)
                fd.append('monthly_salary',app.monthly_salary)
                fd.append('dataId',dataId)
                fd.append('dat',app.updt);
            var xml = new XMLHttpRequest()
                xml.onload = function(){
                    var result = JSON.parse(xml.responseText);
                    $('body').toast({position: 'top center',class:result['status'],message:result.msg});
                    app.dat = result.setup_data;
                    app.salary_grade = ""
                    app.step_no=""
                    app.monthly_salary = ""
                    app.updt =""
                    $('#salaryModalSetup').modal('hide');

                }
                xml.open('POST','umbra/salary_adjustment/config_setup.php',false)
                xml.send(fd)
        },
        setup_update:function(i){
            var a = app.dat[i];
            app.salary_grade = a.salary_grade
            app.step_no= a.step_no
            app.monthly_salary = a.monthly_salary
            app.updt = a.id
            $('#salaryModalSetup').modal('show');
        },
        get_dat:function(){
            var dat = document.getElementById('setup_table').attributes['data-id'].value
            var fd = new FormData()
                fd.append('get_setup',dat)
            var xml = new XMLHttpRequest()
                xml.onload = function(){
                    app.dat = JSON.parse(xml.responseText)
                    app.load= ""
                }
                xml.open('POST','umbra/salary_adjustment/config_setup.php',false)
                xml.send(fd)
        },
        removeSetup:function(dataId){
            var conf = confirm("Are you sure?");
            if(conf){
                var fd = new FormData()
                    fd.append('removeSetup',dataId)
                var xml = new XMLHttpRequest()
                xml.onload = function(){
                    console.log(xml.responseText);                    
                    var result = JSON.parse(xml.responseText);
                    $('body').toast({position: 'top center',class:result['status'],message:result.msg});   
                    app.get_dat()        
                }
                xml.open('POST','umbra/salary_adjustment/config_setup.php',false)
                xml.send(fd)
            }

        },
        formatNumber:function (num){
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
        }
    },
    mounted:function(){
        var i = setInterval(() => {
                if(document.readyState =="complete"){
                    app.get_dat()        
                    clearInterval(i)
                }
        },500);
    }
});