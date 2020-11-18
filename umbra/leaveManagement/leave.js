var lm_app = new Vue({
    el:"#leaveCont",
    data:{
        selectedDate:[],
        Employees:"",
        leaveType:"",
        date_received:"",
        emp_id:"",
        sp_type:"",
        remarks:"",
        
    },
    methods: {
        cal:function(){
            datePicked = document.getElementById("calen").value;
            lm_app.selectedDate.push(datePicked);
            lm_app.selectedDate = lm_app.selectedDate.sort();    
        },
        slice_date:(i)=>{
            lm_app.selectedDate.splice(i,1);
        },
        getEmployeeData:function(){
            var this_app = this
            var xml = new XMLHttpRequest();
            var fd = new FormData();
            fd.append('getEmployee',true)
            xml.onload =function(){
                this_app.Employees = JSON.parse(xml.responseText)
            }
            xml.open('POST','umbra/leaveManagement/config.php',false)
            xml.send(fd)            
        },
        saveLeave:function(){
            if(this.leaveType!="SP"){
                this.sp_type =""
            }
            var this_app = this
            var xml = new XMLHttpRequest();
            var fd = new FormData();
            fd.append('emp_id',this.emp_id)
            fd.append('selectedDate',this.selectedDate)
            fd.append('leaveType',this.leaveType)
            fd.append('date_received',this.date_received)
            fd.append('sp_type',this.sp_type)
            fd.append('remarks',this.remarks)
            fd.append('saveLeave',true)
            xml.onload =function(){
                console.log(xml.responseText);
            }
            xml.open('POST','umbra/leaveManagement/config.php',false)
            xml.send(fd) 
        }
    }
    ,mounted:function(){
        this.getEmployeeData();
    }

})
