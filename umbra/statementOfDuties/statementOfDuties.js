app = new Vue({
    el: "#app",
    data: {
        Positions:[],
        Duties: [],
        cardView:"display:none",
        activeDuties:'',
        header:'',
        totalPercent: 0,
        searchPosition:"",
    // duties modal form varaibles
        num:null,
        percent: null,
        workstatement: null,
        editId:null,
        positionId: null,
    },
    methods: {
        dutiesModal:(edit)=>{
            console.log(edit);
            $('#dutiesModal').modal({
                closable:false,
                onApprove:()=>{
                    var xml = new XMLHttpRequest();
                    var fd = new FormData();
                    fd.append('num',app.num)
                    fd.append('percent',app.percent)
                    fd.append('workstatement',app.workstatement)
                    fd.append('editId',app.editId)
                    fd.append('dutiesConfig',app.positionId)
                    xml.onload = function(){
                        try {
                            app.Duties = JSON.parse(xml.responseText);
                            msg = "Successfully Saved!";
                            if(edit==0||edit){
                                msg = "Successfully Modified!";
                            }
                            $('body')
                            .toast({
                                class: 'success',
                                message: msg
                            })
                            ;
                        } catch (error) {
                            $('body')
                            .toast({
                                class: 'error',
                                message: error
                            })
                            ;
                        }
                    }
                    xml.open('POST','umbra/statementOfDuties/statementOfDuties.php',true)
                    xml.send(fd)
                },onShow:()=>{
                    if(edit==0||edit){
                        duty = app.Duties[edit];
                        app.num = duty['no'];
                        app.percent = duty['percentile'];
                        app.editId = duty['statement_id'];
                        app.workstatement = duty['workstatement'];                            
                    }else{
                        app.num = null;
                        app.percent = null;
                        app.editId = '';
                        app.workstatement = null;
                    }
                },
                autofocus:false,
            }).modal('show');
        },
        getPositions:()=>{
            var xml = new XMLHttpRequest();
            var fd = new FormData();
            fd.append('page','POSITION')
            xml.onload = function(){
                app.Positions = JSON.parse(xml.responseText);         
            }
            xml.open('POST','umbra/statementOfDuties/statementOfDuties.php',true);
            xml.send(fd);
        },
        dutiesCard:(index)=>{
            app.header = app.Positions[index]['position']
            app.positionId = app.Positions[index]['position_id']
            if(app.activeDuties==index){
                if(app.cardView){
                    app.cardView = "";
                    
                }else{
                    app.cardView = "display:none";
                }
            }else{
                app.cardView = "";
            }
            app.activeDuties = index
        },
        deleteDuty:(id)=>{           
            $('body')
            .toast({
                position: 'top center',
                message: 'Are you sure to delete? This cannot be undone!',
                displayTime: 'auto',
                classActions: 'basic left',
                actions:	[{
                text: 'Delete',
                class: 'red',
                click: function() {
                        $('body').toast({message:'Deleting.....'});
                        var xml = new XMLHttpRequest();
                        var fd = new FormData();
                        fd.append('deleteDuty',id)
                        fd.append('positionId',app.positionId)
                        xml.onload = function(){   
                            try {
                                app.Duties = JSON.parse(xml.responseText);         
                                $('body')
                                .toast({
                                class: 'warning',
                                message: `Deleted! Successfully`
                                })
                            ;
                            } catch (error) {
                                $('body')
                                .toast({
                                    class: 'error',
                                    message: error
                                });
                            }
                            
                        }
                        xml.open('POST','umbra/statementOfDuties/statementOfDuties.php',true);
                        xml.send(fd);
                    }
                },{
                    text:'No',
                }]
            });
        }
    },
    mounted:function(){
        this.getPositions();
    },watch:{
        positionId:()=>{
            var xml = new XMLHttpRequest();
            var fd = new FormData();
            fd.append('getDuties',app.positionId)
            xml.onload = function(){
                app.Duties = JSON.parse(xml.responseText);
            }
            xml.open('POST','umbra/statementOfDuties/statementOfDuties.php',true);
            xml.send(fd);
        },
        Duties:()=>{
            app.totalPercent = 0;
            if(app.Duties.length){
                x = 0;
                app.Duties.forEach((percent)=>{
                     x+=parseInt(percent.percentile)
                });
                app.totalPercent = x;
            }
        },
        searchPosition:()=>{
            var rows = document.getElementById('positionRows').children;
            find = app.searchPosition.toUpperCase();
            for(i=0;i<rows.length;i++){
                findIn = rows[i].innerText.toUpperCase();
                if(app.searchPosition=="" || findIn.search(find)>=0){
                    rows[i].style.display = ""
                }
                else{
                    rows[i].style.display = "none"
                }
            }

        },
        percent:()=>{
            x = 100 - app.totalPercent;
            if(x){
                if(app.percent>x){
                    app.percent = x;
                }
            }
        }
    }
});


document.onscroll = ()=>{
    var dutiesChildDiv = document.getElementById('dutiesChildDiv'); 
    if(this.scrollY>130){
        dutiesChildDiv.classList.add('topot');
    }else{
        dutiesChildDiv.classList.remove('topot');
    }
};
