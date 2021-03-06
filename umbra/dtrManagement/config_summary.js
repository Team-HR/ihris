var dtrSummary = new Vue({
    el:"#dtrSummary_app",
    data:{
        Departments:[],
        DataRequest:[],
        // type:"",
        period:"",
        selectedDepartment:[],
        tardyLetter:false,
        filterTardy:[],
        filterDepartment:[],
        findInTable:"",
        // modal dats
            selected_data:"",
            tardayHist:[]
    },
    methods:{
        letterGen:function(l){
            window.location.href = l+".php?selectedDat="+this.selected_data.dtrSummary_id;
        },
        changeColor:function(id,color){
            var this_dtr = this;
            var fd = new FormData()
                fd.append('color',color);
                fd.append('changeColor',id);
            var xml = new XMLHttpRequest()
                xml.onload = function(){
                    this_dtr.getDataNeeded()
                }
                xml.open('POST','umbra/dtrManagement/config_summary.php',false);
                xml.send(fd);
        },
        revertColor:function(id){
            this_dtr = this
            $('body')
            .toast({
                message: 'Do you really want to revert change?',
                actions:	[{
                text: 'Yes',    
                icon: 'check',
                class: 'green',
                click: function() {
                    this_dtr.changeColor(id,''); 
                }
                },{
                icon: 'ban',
                class: 'icon red'
                }]
            })
            ;
        },
        getDepartment:function(){
            this_dtr = this
            var fd = new FormData()
                fd.append('getDepartment',true)
            var xml = new XMLHttpRequest()
                xml.onload = function(){
                    try {
                        this_dtr.Departments = JSON.parse(xml.responseText);
                    } catch (error) {   
                        $('body').toast({
                            class: 'error',
                            showIcon: false,
                            message: 'Response:'+xml.responseText+'<br>Catched:'+error
                        });
                    }
                }
                xml.open('POST','umbra/dtrManagement/config_summary.php',false)
                xml.send(fd)
        },getDataNeeded:function(){
            this_dtr = this;
                var fd = new FormData()
                fd.append('period',this.period)
                // fd.append('type',this.type);
                fd.append('dateNeeded',true);
                var xml = new XMLHttpRequest()
                xml.onload = function(){
                    try {
                        this_dtr.DataRequest = JSON.parse(xml.responseText);   
                        if(this_dtr.DataRequest.length<1){
                            $('body')
                            .toast({
                                class: 'error',
                                position:'center top',
                                message: `ERROR : No data found`
                            })
                            ;
                        }
                        this_dtr.filter();
                    } catch (error) {
                        $('body').toast({
                            class: 'error',
                            showIcon: false,
                            message: 'Response:'+xml.responseText+'<br>Catched:'+error
                        });
                    }
                }   
                xml.open('POST','umbra/dtrManagement/config_summary.php',false)
                xml.send(fd)
        },
        sortArrays(arrays) {
            return arrays.slice().sort(function(a, b){
                return (a.lastName > b.lastName) ? 1 : -1;
              });
        },
        filter:function(){
            this_app = this;
            this.filterDepartment = [];
            this.filterTardy = [];
            if(this.selectedDepartment.length>0){
                countIndex = 0;
                this.selectedDepartment.forEach( a => {
                    this.Departments.forEach( dep =>{
                        if(a==dep.department_id){
                            this.filterDepartment[countIndex] = dep;
                            datCount = 0;
                            tempDat = [];
                            this.DataRequest.forEach(dat=>{
                                if(dat.department_id == a){
                                    if(this_app.tardyLetter){
                                        if(dat.totalTardy>=10){
                                            tempDat[datCount] = dat;
                                            datCount++;    
                                        }
                                    }else{
                                        tempDat[datCount] = dat;
                                        datCount++;
                                    }
                                }
                                this.filterDepartment[countIndex]['dat'] = tempDat;
                            });
                        }
                    });
                    countIndex++;
                });
            }else if(this.tardyLetter){
                datCount = 0;
                this.DataRequest.forEach(dat=>{
                        if(this_app.tardyLetter){
                            if(dat.totalTardy>=10){
                                this.filterTardy[datCount] = dat;
                                datCount++;    
                            }
                        }
                });
            }
        },
        showOptionModal:function(i){
            $('#optionModal').modal('show');
            this.selected_data = this.DataRequest[i];
            this_dtr = this;
            var fd = new FormData();
                fd.append('period',this.selected_data.month);
                fd.append('emp',this.selected_data.employees_id);
                fd.append('tardyHistory',true)
            var xml = new XMLHttpRequest()
                xml.onload = function(){
                    this_dtr.tardayHist = JSON.parse(xml.responseText)                    
                }   
                xml.open('POST','umbra/dtrManagement/config_summary.php',false);
                xml.send(fd);         
        },
        showEquiv:function(num){
            var c = 0.002083333;
            var sum = c*parseInt(num);
                sum = parseFloat(sum).toFixed(3);
            return sum;
        },
        newLine:function(str,r){
            c = str.replaceAll(r,"<br>");
            return c;
        }
    },
    mounted:function(){
        this.getDepartment();
    },watch:{
        findInTable:function(){
            filter = this.findInTable.toUpperCase()       
            tr = document.getElementById("allDataTable").childNodes;            
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                  txtValue = td.textContent || td.innerText;
                  if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                  } else {
                    tr[i].style.display = "none";
                  }
                }
              }
        },
        period:function(){
            this.DataRequest = [];                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
        },
        tardyLetter:function(){
            this.filter();
        },
        selectedDepartment:function(){
            this.filter();
        }

    }
})