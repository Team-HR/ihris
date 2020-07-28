var oldIncumbent = new Vue({
    el:"#oldIncumbent",
    data: {
        Employees:[],
        selectedEmp:"",
        plantilla_id:"",
    },methods:{
        showModalOldIncumbent:function(i){
            $('#oldIncumbentModal').modal('show');
            oldIncumbent.plantilla_id = i 
        },
        saveIncumbent:function(){
            var fd = new FormData()
                fd.append('saveIncumbent',oldIncumbent.selectedEmp)
                fd.append('Oldplantilla',oldIncumbent.plantilla_id)
            var xml = new XMLHttpRequest()
                xml.onload = function(){
                    if(xml.responseText){
                        console.log(xml.responseText);
                    }else{
                        window.location.href="?"
                    }
                }
                xml.open('POST','umbra/plantillaOld/config.php');
                xml.send(fd);
        },
        getEmployeeData:function(){
            var fd = new FormData()
                fd.append('getEmployee',true);
            var xml = new XMLHttpRequest()
                xml.onload = function(){
                    oldIncumbent.Employees = JSON.parse(xml.responseText);
                }
                xml.open('POST','umbra/plantillaOld/config.php',false);
                xml.send(fd)
        }
    },mounted:function(){
        var i = setInterval(() => {
            if(document.readyState == 'complete'){
                try {
                        oldIncumbent.getEmployeeData();
                        clearInterval(i);
                } catch (e) {
                        alert("Something Went Wrong: <See console>");
                        console.log(e);
                        clearInterval(i);
                }
            }
        }, 500);
    }
})