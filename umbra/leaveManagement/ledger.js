new Vue({
    el: "#ledger",
    data: {
        readonly: true,
        employee_id: null,
        Employees: "",
        ledgers: []
    },
    methods: {

        // getEmp: function () {
        //     var this_app = this
        //     var xml = new XMLHttpRequest();
        //     var fd = new FormData();
        //     fd.append('getEmployee', true)
        //     xml.onload = function () {
        //         this_app.Employees = JSON.parse(xml.responseText)
        //     }
        //     xml.open('POST', 'umbra/leaveManagement/config.php', true)
        //     xml.send(fd)
        // },
        getEmployeeData: function () {
            var this_app = this
            var xml = new XMLHttpRequest();
            var fd = new FormData();
            window.$_GET = new URLSearchParams(location.search);
            this.employee_id = $_GET.get('employees_id');
            $.get("umbra/leaveManagement/ledger_config.php",{getLedger: true, employee_id: this.employee_id},
                (data, textStatus, jqXHR)=>{
                    this.ledgers = data
                },
                "json"
            );
            fd.append('getLedger', true)
            xml.onload = function () {
                this_app.Logs = JSON.parse(xml.responseText)
            }
            xml.open('POST', 'umbra/leaveManagement/config.php', false)
            xml.send(fd)
        },

        // getEmployeeData(){
        //     window.$_GET = new URLSearchParams(location.search);
        //     this.employee_id = $_GET.get('employees_id');
        //     $.get("umbra/leaveManagement/ledger_config.php",{getLedger: true, employee_id: this.employee_id},
        //         (data, textStatus, jqXHR)=>{
        //             this.ledgers = data
        //         },
        //         "json"
        //     );
        // },
        showParticulars:function(num){  
         
            d = Math.floor(num*480/480); 
            h = Math.floor((num-d)/60*480);
            m = Math.floor(num-d)*60;        
    
            d = parseInt(d).toString().padStart(2, '0');
            h = parseInt(h).toString().padStart(2, '0');
            m = parseInt(m).toString().padStart(2, '0');
            if(d>0){
                return(d + "-" + h + "-" + m );
              }else{
                return("00"+ "-" + h + "-" + m );
              }
          },
          decodeAppliedDates: function (dat) {
            s = "";
            try {
                dat = JSON.parse(dat);
                for (c = 0; c <= dat.length; c++) {
                    if (c == dat.length) {
                        break;
                    } else {
                        // dat = new Date(dat.start);
                        // console.log(dat.toDateString());
                        strt = new Date(dat[c].start);
                        
                        // console.log(strt.toISOString());

                        if (dat[c].end != "") {
                            e_nd = new Date(dat[c].end);
                            s += `${this.getD_ate(strt)} <b>TO</b> ${this.getD_ate(e_nd)} <br>`;
                        } else {
                            s += this.getD_ate(strt) + ",<br>";
                        } 
                    }
                }
            } catch (e) {

            }
            return s;
        }
        , getD_ate: function (d) {
            monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"];
            d = new Date(d);
            // console.log(d.toISOString());
            det = d.toISOString().split('T')[0].split("-")
            // console.log(det);

            year = det[0]
            month = Number(det[1]!==0?det[1]-1:det[1])
            day = det[2]
            
            s = `${monthNames[month]} ${day}, ${year}`;
            return s;
        }
       ,
      
    },
    created() {
     
                this.getEmployeeData()
                this.getEmp()
            
    },
})