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
                    this_dtr = this
                var fd = new FormData() 
                    fd.append('getNoDtr',this.period);
                var xml = new XMLHttpRequest()
                    xml.onload = function(){
                        try {
                            this_dtr.noDtrs  = JSON.parse(xml.responseText);
                        } catch (error) {
                            alert(error);
                        }
                    }
                    xml.open('POST','umbra/dtrManagement/config_nodtr.php',false);
                    xml.send(fd);
                }
    },
    mounted:function(){
        this.getDepartments();
    }

})