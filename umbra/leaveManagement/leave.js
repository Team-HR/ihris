var lm_app = new Vue({
    el:"#leaveCont",
    data:{
        selectedDate:[],
        Logs:[],
        Employees:"",
        leaveType:"",
        date_received:"",
        emp_id:"",
        sp_type:"",
        remarks:"",
        log_editId:"",
    },
    methods: {
        cal:function(){
            datePicked = document.getElementById("calen").value;
            if(lm_app.selectedDate.length){
                for(i=0;i<=lm_app.selectedDate.length;i++){
                    if(i==lm_app.selectedDate.length){
                        lm_app.selectedDate.push(datePicked);
                        break;
                    }else if(lm_app.selectedDate[i]==datePicked){
                        $('body')
                        .toast({
                            title: 'Duplication',
                            message: 'Date '+datePicked+' is already Added',
                            showProgress: 'bottom',
                            classProgress: 'red'
                        })
                        ;
                        break;
                    }
                }
            }else{
                lm_app.selectedDate.push(datePicked);
            }
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
        saveLeave:function(e){
            var buttonEvent = event;
            buttonEvent.target.disabled = true;
            // $("#saveLogs").addClass("disabled")
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
            fd.append('totalDays',this.selectedDate.length)
            fd.append('log_editId',this.log_editId)
            xml.onload =function(){
              $("#addModal").modal('hide');
                this_app.emp_id = "";
                this_app.selectedDate="";
                this_app.leaveType = "";
                this_app.date_received="";
                this_app.sp_type="";
                this_app.remarks="";
                this_app.log_editId = "";
              this_app.getLog()
                setTimeout(() => {
                    buttonEvent.target.disabled = "";
                },1000);
            }
            xml.open('POST','umbra/leaveManagement/config.php',true)
            xml.send(fd) 
        },
        getEdit:function(index){
            this_app = this;
            log = this_app.Logs[index];
            $('#emp_id').dropdown('set selected', log['employees_id']);
            $('#sp_type').dropdown('set selected', log['sp_type']);
            $('#leaveType').dropdown('set selected', log['leaveType']);
            this_app.selectedDate= log["dateApplied"].split(",");
            this_app.date_received= log['dateReceived'];
            this_app.remarks= log['remarks'];
            this_app.log_editId = log['log_id'];
            $("#addModal").modal('show');
        },
        getLog:function(){
            var this_app = this
            var xml = new XMLHttpRequest();
            var fd = new FormData();
                fd.append('getLog',true)
                xml.onload =function(){
                    this_app.Logs = JSON.parse(xml.responseText)  
                }
                xml.open('POST','umbra/leaveManagement/config.php',false)
                xml.send(fd)
        }
    }
    ,mounted:function(){
        this.getEmployeeData();
        this.getLog();
    }

})
