    $(document).ready(function (){
    $('.dropdown').dropdown({
        fullTextSearch:true,
    });
});
var app = new Vue({
    el:"#app",
    data:{
        department_id:"",
        OfficeName:"",
        selectedEmp:"",
        Employees:[],
        Offices:[],
        loading:"loading",
        edit:"",
    },
    methods: {
        openModal:function(){
            try{
                $('#officeModal').modal('show');
                app.edit = ""
                app.OfficeName = ""
            }catch(a){
                console.log(a);
            }
        },
        getEmployeeData:function(){
            var fd = new FormData()
                fd.append('getEmployee',true)
            var xml = new XMLHttpRequest();
                xml.onload = function(){
                    try{   
                        app.Employees = JSON.parse(xml.responseText)
                    }catch(a){
                        alert('getEmployeeData:ERROR')
                        console.log(a);
                    }
                }
                xml.open('POST','umbra/office/config.php',false);
                xml.send(fd);
        },
        office_setup:function(){
            var fd = new FormData();
                fd.append('office_setup',app.OfficeName);
                fd.append('department_id',app.department_id);
                fd.append('emp',app.selectedEmp);
                fd.append('edit',app.edit)
            var xml = new XMLHttpRequest();
                xml.onload = function(){

                    var rs = JSON.parse(xml.responseText);
                    $('body').toast({
                        class: rs.status,
                        message: rs.msg
                    });
                    if(rs.bol){
                        $('#officeModal').modal('hide');
                        app.OfficeName = "";
                        app.getOffice();
                        app.loading = "loading"
                    }
                }
                xml.open('POST','umbra/office/config.php',false);
                xml.send(fd);
            },
            getOffice:function(){
                app.department_id = app.$refs.listOffice.attributes['data-id'].value;
                var fd = new FormData();
                    fd.append('getOffice',app.department_id);
                var xml = new XMLHttpRequest();
                    xml.onload = function(){
                        app.Offices = JSON.parse(xml.responseText);
                        setTimeout(() => {
                            app.loading = "";
                        }, 1000);
                    }
                    xml.open('POST','umbra/office/config.php',false);
                    xml.send(fd);
            },
            editOffice:function(i){
                var dat = app.Offices[i] 
                $('#officeModal').modal('show'); 
                app.OfficeName = dat.office_name;
                $("#sectionHead").dropdown('set selected',dat.section_head)
                app.edit = dat.id;
            },
            deleteOffice:function(ind){
                var con = confirm("Are you Sure?")
                var fd = new FormData();
                    fd.append('removeOffice',ind)
                    if (con) {
                var xml = new XMLHttpRequest();
                    xml.onload = function(){
                        var dat = [];
                        try{
                            var ind = JSON.parse(xml.responseText);
                            dat['status'] = ind.status;
                            dat['msg'] = ind.msg;
                            app.loading = "loading";
                            app.getOffice();
                        }catch(e){
                            dat['status'] = "error";
                            dat['msg'] = e;
                        }
                            $('body').toast({
                                class: dat['status'],
                                message: dat['msg']
                            });
                    }   
                    xml.open('POST','umbra/office/config.php',false);
                    xml.send(fd);                     
                    }
            }
    },mounted:function(){
          var i = setInterval(() => {
            if(document.readyState == 'complete'){
                clearInterval(i)
                app.getOffice()
                app.getEmployeeData()
            }
          },500)
    }
})
