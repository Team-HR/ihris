var dtr_app = new Vue({
    el: "#dtr_app",
    data:{
        Employees: [],
        period:"",
        emp_id:"",
        dtr:[],
        amTardy:"",
        pmTardy:"",
        amUnder: "",
        pmUnder:"",
        editId:'',
        others:"",
        selectedDate:"",
        dtrSummary:[],
        passSlipForm:"",
        // logs
            totalMinsTardy: 0,
            totalTimesTardy:0,
            totalMinUnderTime:0,
            halfDaysTardy:[],
            halfDaysUndertime:[],
            remarksDtr:[],
    },methods: {
        countLogs:function(){
            dtr = this.dtr;
            minsTardy = 0;
            totalTardy = 0;
            minsUnderTime = 0;
            halfTardy = [];
            halfUnder = [];
            remarks = [];
            if(dtr.length>=1){
                dtr.forEach(row => {
                    if(row['amTardy']){
                        minsTardy +=parseInt(row['amTardy']);
                        totalTardy++; 
                    }
                    if(row['pmTardy']){
                        minsTardy +=parseInt(row['pmTardy']);
                        totalTardy++; 
                    }
                    if(row['amUnderTime']){
                        minsUnderTime +=parseInt(row['amUnderTime'])
                    }
                    if(row['pmUnderTime']){
                        minsUnderTime +=parseInt(row['pmUnderTime'])
                    }
                    if(parseInt(row['amTardy'])==240){
                        halfTardy.push(row['date'].split('-')[2]);
                    }
                    if(parseInt(row['pmUnderTime'])==240){
                        halfUnder.push(row['date'].split('-')[2]);
                    }if(row['other']){
                        d = row['date'].split('-')[2]+"-"+row['other']
                        remarks.push(d);
                    }
                });
            }
            this.totalMinsTardy = minsTardy;
            this.totalTimesTardy = totalTardy;
            this.totalMinUnderTime = minsUnderTime;
            this.halfDaysTardy = halfTardy;
            this.halfDaysUndertime = halfUnder;
            this.remarksDtr = remarks;
        },
        passSlipFormSave:function(){
                this_dtr = this;
            var fd = new FormData();
                fd.append('passSlipFormSave',this.passSlipForm);
                fd.append('emp_id',this.emp_id);
                fd.append('period',this.period);
            var xml = new XMLHttpRequest()
                xml.onload = function(){
                    this_dtr.submitReport()
                    $('#passSlipModal').modal('hide')
                }
                xml.open('POST','umbra/dtrManagement/config.php',false)
                xml.send(fd);
            },
        cancelMove:function(id){
            this_dtr = this;
            $('body').toast({
                message: 'Do you really want Revert changes?',
                class: 'red',
                actions:	[{
                  text: 'Yes',
                  icon: 'check',
                  class: 'green',
                  click: function() {
                    var fd = new FormData() 
                    fd.append('cancelMove',true);
                    fd.append('period',this_dtr.period)
                    fd.append('emp_id',this_dtr.emp_id)
                var xml = new XMLHttpRequest()
                    xml.onload = function(){
                        this_dtr.submitReport();
                    }   
                    xml.open('POST','umbra/dtrManagement/config.php',false)
                    xml.send(fd)                  }
                },{
                  icon: 'ban',
                  class: 'icon red'
                }]
              })
            },
        addDTR:function(){
            this_dtr = this
            var dtr_date = this.period+"-"+this.selectedDate;
            var fd = new FormData()
                fd.append('others',this.others.toUpperCase())
                fd.append('emp_id',this.emp_id)
                fd.append('dtr_date',dtr_date)
                fd.append('amTardy',this.amTardy)
                fd.append('pmTardy',this.pmTardy)
                fd.append('amUnder',this.amUnder)
                fd.append('pmUnder',this.pmUnder)
                fd.append('editId',this.editId)
                fd.append('addDTR',true)
            var xml = new XMLHttpRequest()
                xml.onload = function(){
                    this_dtr.setupData();
                    $("#modalEdit").modal('hide');
                    this_dtr.amTardy = ""
                    this_dtr.editId = ""
                    this_dtr.pmTardy = ""
                    this_dtr.amUnder = ""
                    this_dtr.pmUnder = ""
                    this_dtr.selectedDate = ""
                    this_dtr.absent = ""
                    this_dtr.dayoff = ""    
                    this_dtr.submitReport();        
                }
                xml.open('POST','umbra/dtrManagement/config.php',false)
                xml.send(fd)
        },
        openModal:function(i){
            dat = this.dtr[i]
            this.selectedDate = dat.date.split('-')[2];
            this.editId = dat.id;
            this.amTardy = dat.amTardy
            this.pmTardy = dat.pmTardy
            this.amUnder = dat.amUnderTime
            this.pmUnder = dat.pmUnderTime
            this.others = dat.other


            $("#modalEdit").modal('show');
        },
        hasSumitted:function(){
            this_dtr = this
            var fd = new FormData()
                fd.append('hasSumitted',true)
                fd.append('period',this.period)
                fd.append('emp_id',this.emp_id)
            var xml = new XMLHttpRequest()
                xml.onload = function(){
                    this_dtr.submitReport();
                }
                xml.open('POST','umbra/dtrManagement/config.php',false)
                xml.send(fd);
        },
        getEmp:function(){
            this_dtr = this
            var fd = new FormData();
            var xml = new XMLHttpRequest()
                fd.append("getEmp",true)
            xml.onload = function(){
                this_dtr.Employees = JSON.parse(xml.responseText)
            }
            xml.open('POST','umbra/dtrManagement/config.php',false)
            xml.send(fd)
        },
        setupData:function(){
            $("#seachBtn").addClass("loading")
            this_app = this
            document.getElementById("seachBtn").disabled = true;
            if(!this.period||!this.emp_id){
                $("#seachBtn").removeClass("loading")
                document.getElementById("seachBtn").disabled = false;        
                $('body')
                .toast({
                        message: 'Please complete the information needed',
                        showProgress: 'bottom',
                        position: 'top center',
                        class: 'warning',
                        classProgress: 'red'
                    });
            }else{   
                period = this.period.split("-");
                totalDate = new Date(period[0], period[1], 0).getDate();
                a = [];
                xml = new XMLHttpRequest();
                fd = new FormData();
                 fd.append('dtrDate',totalDate);
                 fd.append('period',this.period);
                 fd.append('emp_id',this_app.emp_id);
                xml.onload = function(){
                    try {
                        this_app.dtr = JSON.parse(xml.responseText);
                        this_app.countLogs();
                    } catch (error) {
                        console.log(error);
                    }
                    $("#seachBtn").removeClass("loading")
                    document.getElementById("seachBtn").disabled = false;        
                }
                xml.open('POST','umbra/dtrManagement/config.php',false)
                xml.send(fd)
            }
            this.getSum();
        },
        submitReport:function(){
                this_dtr = this
                this.dtrSummary = [];
            var fd = new FormData();
                fd.append('totalMinsTardy',this.totalMinsTardy);
                fd.append('totalTimesTardy',this.totalTimesTardy);
                fd.append('totalMinUnderTime',this.totalMinUnderTime);
                fd.append('halfDaysTardy',this.halfDaysTardy);
                fd.append('halfDaysUndertime',this.halfDaysUndertime);
                fd.append('remarksDtr',this.remarksDtr);
                fd.append('period',this.period);
                fd.append('emp_id',this.emp_id);   
                fd.append('submitReport',true); 
            var xml = new XMLHttpRequest()
                xml.onload = function(){
                    try {
                        this_dtr.dtrSummary = JSON.parse(xml.responseText);
                    } catch (error) {
                        console.log(xml.responseText);  
                    }
                }
                xml.open('POST','umbra/dtrManagement/config.php',false)
                xml.send(fd);
        },
        getSum:function(){
            this.dtrSummary = [];
            this_dtr = this
            var fd = new FormData()
                fd.append('getSum',true)
                fd.append('period',this.period);
                fd.append('emp_id',this.emp_id);   
            var xml = new XMLHttpRequest()
                xml.onload = function(){
                    try {
                        this_dtr.dtrSummary = JSON.parse(xml.responseText);
                    } catch (error) {
                        console.log(xml.responseText);  
                    }
                }
                xml.open('POST','umbra/dtrManagement/config.php',false)
                xml.send(fd)
        },
        passSlipModal:function(){
            $('#passSlipModal').modal('show')
        }
    },mounted:function(){
        this.getEmp();
    },watch:{
        emp_id:function(){
            this.dtr = [];
            this.totalMinsTardy =  0;
            this.totalTimesTardy = 0;
            this.totalMinUnderTime = 0;
        },
        period:function(){
            this.dtr = [];
            this.totalMinsTardy =  0;
            this.totalTimesTardy = 0;
            this.totalMinUnderTime = 0;
        }, 
    }
});