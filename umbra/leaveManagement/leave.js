var lm_app = new Vue({
    el:"#leaveCont",
    data:{
        Logs:[],
        Employees:"",
        leaveType:"",
        date_received:"",
        date_filed:"",
        emp_id:"",
        sp_type:"",
        mone_type:"",
        mone_days:"",
        others:"",
        remarks:"",
        others:"",
        log_editId:"",
        leaveEvents:[]
        ,numberOfDays:0
        ,leaveCalendar:''
        ,selectedEventsForEdit:[]

    },
    methods: {
        slice_date:(i)=>{

        },
        showAddModal:function() {
            $("#addModal").modal('show');
            this.selectedEventsForEdit = [];
            this.calendarRender();
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
            if(this.leaveType!="Monetization"){
                this.mone_type=""
            }
            if(this.leaveType!="Others"){
                this.others=""
            }
            var this_app = this
            var xml = new XMLHttpRequest();
            var fd = new FormData();
            fd.append('emp_id',this.emp_id)
            fd.append('selectedDate',JSON.stringify(this.leaveEvents))
            fd.append('leaveType',this.leaveType)
            fd.append('date_received',this.date_received)
            fd.append('date_filed',this.date_filed)
            fd.append('sp_type',this.sp_type)
            fd.append('mone_type',this.mone_type)
            fd.append('mone_days',this.mone_days)
            fd.append('remarks',this.remarks)
            fd.append('others',this.remarks)
            fd.append('saveLeave',true)
            fd.append('totalDays',this.numberOfDays)
            fd.append('log_editId',this.log_editId)
            xml.onload =function(){
              $("#addModal").modal('hide');
                this_app.emp_id = "";
                this_app.leaveEvents="";
                this_app.leaveType = "";
                this_app.date_received="";
                this_app.date_filed="";
                this_app.sp_type="";
                this_app.mone_type="";
                this_app.mone_days="";
                this_app.others="";
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
            $('#mone_type').dropdown('set selected', log['mone_type']);
            $('#mone_days').dropdown('set selected', log['mone_days']);
            $('#leaveType').dropdown('set selected', log['leaveType']);
            this_app.date_received= log['dateReceived'];
            this_app.selectedEventsForEdit = [];
            try{

                dateApplied = JSON.parse(log.dateApplied);
                for(c=0;c<=dateApplied.length;c++){
                    if(c==dateApplied.length){
                        break;
                    }else{
                        this_app.selectedEventsForEdit.push(
                            {
                                title: 'Selected',
                                start: dateApplied[c].start,
                                end: dateApplied[c].end 
                            });
                        }
                    }
            }catch(e){
                console.log(e);
            }
            this.calendarRender();
            this_app.date_filed= log['date_filed'];
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
        },
        calendarRender:function(){
            this_leave = this;
            clndr = document.getElementById('clndr');
            var event_id = 0;
            if(this.leaveCalendar){
                this.leaveCalendar.destroy();
            }
            this.leaveCalendar = new FullCalendar.Calendar(clndr,{
                plugins:['dayGrid','interaction'],
                height: "auto",
                initialView: 'dayGridMonth',
                dateClick:function(info){
                    e = this.getEvents();
                    if(e.length>0){
                        for(c=0;c<e.length;c++){
                            if(e[c].start.toString()==info.date.toString()){
                                evnt = e[c];
                                evnt.remove();
                            }else if(e[c].end!=null){
                                evnt = e[c];
                                evnt.remove();
                            }
                            else if(c==e.length-1){
                                this.addEvent({start:info.dateStr,title:"Selected",id:event_id});
                                event_id++;
                            }
                        }
                    }else{
                        this.addEvent({start:info.dateStr,title:"Selected",id:event_id});
                        event_id++;
                    }
                    lvevnts = [];
                    this_leave.leaveEvents = [];
                    e = this.getEvents();
                    for(c=0;c<=e.length;c++){
                        if(c==e.length){
                            break;
                        }else{ 
                            end = e[c].end 
                            if(!end){
                                end = "";
                            }
                            lvevnts = {'start':e[c].start,'end':end};
                            this_leave.leaveEvents.push(lvevnts);
                        }
                    }
                },
                eventResize:function(info){
                    lvevnts = [];
                    e = this.getEvents();
                    this_leave.leaveEvents = [];
                    for(c=0;c<=e.length;c++){
                        if(c==e.length){
                            break;
                        }else{ 
                            end = e[c].end 
                            if(!end){
                                end = "";
                            }
                            lvevnts = {'start':e[c].start,'end':end};
                            this_leave.leaveEvents.push(lvevnts);
                        }
                    }
                },
                eventDrop:function(){
                    lvevnts = [];
                    e = this.getEvents();
                    this_leave.leaveEvents = [];
                    for(c=0;c<=e.length;c++){
                        if(c==e.length){
                            break;
                        }else{ 
                            end = e[c].end
                            if(!end){
                                end = "";
                            }
                            lvevnts = {'start':e[c].start,'end':end};
                            this_leave.leaveEvents.push(lvevnts);
                        }
                    }
                },
                events:this_leave.selectedEventsForEdit,
                editable:true
            });
            this.leaveCalendar.render();
            console.log(this.leaveCalendar);
        }
        ,decodeAppliedDates:function(dat){
                s = "";
            try{
                dat = JSON.parse(dat);
                for(c = 0;c<=dat.length;c++){
                    if(c==dat.length){
                        break;
                    }else{
                        // dat = new Date(dat.start);
                        // console.log(dat.toDateString());
                        strt = new Date(dat[c].start);
                        if(dat[c].end!=""){
                            e_nd = new Date(dat[c].end);
                            s+=`${this.getD_ate(strt)} to ${this.getD_ate(e_nd)},<br>`;
                        }else{
                            s+=this.getD_ate(strt)+",<br>";
                        }
                    }
                }
                
            }catch(e){

            }
            return s;
        }
        ,getD_ate:function(d){
            monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"];   
            s = `${monthNames[d.getMonth()]} ${d.getDate()} ${d.getFullYear()}`;
            return s;           
        }
    }
    ,mounted:function(){
        this.getEmployeeData();
        this.getLog();
        this.calendarRender();
    }
    ,watch:{
        leaveEvents:function(){
            d = this.leaveEvents;
            this.numberOfDays = 0;
            for(c=0;c<=d.length;c++){
                if(c==d.length){
                    break;
                }else{
                    if(d[c].end){
                        strt = new Date(d[c].start);
                        e_nd = new Date(d[c].end);
                        totalDays = strt.getTime()-e_nd.getTime();
                        totalDays = Math.round(totalDays/-86400000);
                        this.numberOfDays +=totalDays;
                    }else{
                        this.numberOfDays++;
                    }
                }
            }
        }
    }

})
