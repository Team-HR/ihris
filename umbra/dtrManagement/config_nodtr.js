var noDtr = new Vue({
    el: "#app_nodtr",
    data:{
        Departments:[],
        period:"",
        noDtrs:[]
    },
    methods: {
        getDepartments:function(){
            this_dtr = this;
            var fd = new FormData()
                fd.append('getDepartment',true);
            var xml = new XMLHttpRequest()
                xml.onload = function(){
                    try {
                        this_dtr.Departments = JSON.parse(xml.responseText);                    
                    } catch (error) {
                        alert(error);
                    }
                }               
                xml.open('POST','umbra/dtrManagement/config_nodtr.php',false);
                xml.send(fd);
        },
        periodSearch:function(){
            searchPeriod = document.getElementById("searchPeriod");
            searchPeriod.classList.add("loading","disabled");
                $('body').toast({
                    class: 'warning',
                    message: `Fetching Please wait....`
                });
                this.noDtrs = [];
                this_dtr = this
            var fd = new FormData() 
                fd.append('getNoDtr',this.period);
            var xml = new XMLHttpRequest()
                xml.onload = function(){
                    $('body').toast({
                        class: 'warning',
                        message: `Checking for ERROR`
                    });                       
                    try {
                        $('body').toast({
                            class: 'warning',
                            message: `Storing fetched Data`
                        });                           
                        this_dtr.noDtrs  = JSON.parse(xml.responseText);
                        $('body').toast({
                            class: 'success',
                            message: `Complete`
                        });                           
                    } catch (error) {
                        alert(error);
                    }
                }
                xml.open('POST','umbra/dtrManagement/config_nodtr.php',false);
                xml.send(fd);
                searchPeriod.classList.remove("loading","disabled");
        },
        submitted:function(i){
            dat = this.noDtrs[i]
            this_dtr = this
            var fd = new FormData();
                fd.append('dtrSubmitted',dat['dtrSummary_id']);
                fd.append('employee_id',dat['employees_id']);
                fd.append('period',this.period);
            var xml = new XMLHttpRequest();
                xml.onload = function(){
                    this_dtr.periodSearch()
                }
                xml.open('POST','umbra/dtrManagement/config_nodtr.php',false)
                xml.send(fd);
        },
        letterSent:function(i){
            dat = this.noDtrs[i]
            this_dtr = this
            var fd = new FormData();
                fd.append('letterSent',dat['dtrSummary_id']);
                fd.append('employee_id',dat['employees_id']);
                fd.append('period',this.period);
            var xml = new XMLHttpRequest();
                xml.onload = function(){
                    this_dtr.periodSearch()
                }
                xml.open('POST','umbra/dtrManagement/config_nodtr.php',false)
                xml.send(fd);
        }
    },
    mounted:function(){
        this.getDepartments();
    }
})