<?php    
$title = "Feedback";
require_once "header.php";
?>
<div class='ui segment' style="width:80%;margin:auto" id="app">
  <!-- content -->
    <div style="position:fixed;right:0;min-width:50%;z-index:5000;top:0;">
        <div class="ui icon message" style="display:none" id="fetching_msg">
            <i class="notched circle loading icon"></i>
            <div class="content">
                <div class="header">
                Just one second
                </div>
                <p>We're fetching that content for you.</p>
            </div>
        </div>

        <div class="ui warning message transition" style="display:none" id="warning_msg">
            <div class="header">
                Warning
            </div>
            {{ server_msg }}
        </div>
        <div class="ui negative message transition" style="display:none" id="error_msg">
            <div class="header">
                ERROR!!
            </div>
            {{ server_msg }}
        </div>
        <div class="ui success message transition" style="display:none" id="success_msg">
            <div class="header">
                SUCCESS!!
            </div>
            {{ server_msg }}
        </div>
    </div>



    <div class="ui modal" id="feedbackSaveModal">
        <div class="header">Add Feedback</div>
        <div class="content">
            <form class="ui form" @submit.prevent="saveFeed">
                <div class="field">
                    <label>Feedback</label>
                    <textarea v-model="txtfeed" required></textarea>
                </div>
                <div class="field">
                    <button class='ui primary button fluid'>Submit</button>
                </div>
            </form>
        </div>
    </div>

    <div>
        <h1>Feedback and Monitoring</h1>
    </div>
    <div>
        <div class="ui divider"></div>
        <form class="ui form" @submit="noSubmit">
            <div class="two fields">
                <div class="field" > 
                    <label>Year</label>
                    <input type="text" name="year" v-model.number="feedBackYR" >
                </div>
                <div class="field">
                    <label>Status</label>
                    <select type="text" name="period">
                        <option value=""></option>
                        <option value="PERMANENT">PERMANENT</option>
                        <option value="CASUAL">CASUAL</option>
                        <option value="ELECTIVE">ELECTIVE</option>
                    </select>
                </div>  
            </div>
        </form>
        <table class="ui celled table selectable">
            <thead>
                <tr>
                    <!-- <th>Employee's Name</th>
                    <th>Dapartment</th> -->
                    <th>Fullname</th>
                    <th>Status</th>
                    <th>Colors</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="e in mergedData" class="ui" :class='e.color' :key="e.employees_id">
                    <td>{{Employees[e.employees_id].lastName}} {{ Employees[e.employees_id].firstName }}</td>
                    <td>{{Employees[e.employees_id].employmentStatus}}</td>
                    <td style="text-align:center">
                        <div class="ui buttons">
                            <button class="ui button" @click="rowColor(e.employees_id,1)"> </button>
                            <div class="or"></div>
                            <button class="ui yellow button" @click="rowColor(e.employees_id,0)"></button>
                        </div>
                    </td>
                    <td style="text-align:center">
                        <button class="ui positive button" @click="openFeed(e.employees_id)">Open form</button>
                    </td>
                    
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
    var app = new Vue({
        el:"#app",
        data:{
            feedBackYR  :new Date().getFullYear(),
            Employees   :[],
            feedbacks   :[],
            mergedData  :[],
            txtfeed     :"",
            txtid       :0,
            server_msg  :"",
            
        },
        methods:{
           getEmployees:()=>{
                app._("fetching_msg").style.display=""
                var xml = new XMLHttpRequest()
                    xml.onload = ()=>{
                        app.Employees = JSON.parse(xml.responseText)
                    }
                    xml.open('POST','umbra/feedback/jason.php',true)
                    xml.send()
           },
           getFeedback:()=>{
               if(app.feedBackYR.toString().length==4){
                app._("fetching_msg").style.display=""
                    var fd = new FormData();
                        fd.append('year',app.feedBackYR)
                        fd.append('getFeedback',true)
                    var xml = new XMLHttpRequest()
                        xml.onload = function(){
                                app.feedbacks = JSON.parse(xml.responseText)
                        }
                        xml.open('POST','umbra/feedback/jason.php',true)
                        xml.send(fd)
                }
           },
           noSubmit:()=>{
               event.preventDefault()
           },
           mergeTable:()=>{
                // var a_null = {feedbacking_id: "", feedbacking_emp: "", feedbacking_year: "", feedbacking_feedback: "",color: "red"};
                app.mergedData = [];
                for ( ind in app.Employees) {
                    Employee = app.Employees[ind];
                    if(app.feedbacks[ind]){
                        feedback = app.feedbacks[ind] 
                        rowColor = 'yellow';
                        if(feedback['color']==1){
                            rowColor = ""
                        }                      
                        app.mergedData[ind] = {employees_id:Employee['employees_id'],employmentStatus:Employee['employmentStatus'],feedbacking_id:feedback['feedbacking_id'],feedbacking_feedback:feedback['feedbacking_feedback'],color:rowColor}
                    }else{       
                        app.mergedData[ind] = {employees_id:Employee['employees_id'],employmentStatus:Employee['employmentStatus'],feedbacking_id:"", feedbacking_feedback:"",color: "yellow"}
                    }

                        app.mergedData = app.mergedData.filter(()=>true);   
                }
                app._("fetching_msg").style.display="none"
           },
           openFeed: function(dataId){
                app.txtfeed = ""
                app.txtid   = dataId
                if(app.feedbacks[dataId]){
                    app.txtfeed =  app.feedbacks[dataId].feedbacking_feedback
                }
                $("#feedbackSaveModal").modal('show')        
           },
           saveFeed: function(){
                    app.server_msg = ""
                    var fd = new FormData()
                    fd.append('savefeedback',true)
                    fd.append('yr',app.feedBackYR)
                    fd.append('emp',app.txtid)
                    fd.append('feedback',app.txtfeed)
                var xhr = new XMLHttpRequest()
                    xhr.onload = function(){
                        app.getFeedback()
                        var msg = JSON.parse(this.responseText);
                        app.server_msg = msg.message
                        if(msg.success){
                            app._('success_msg').style.display = ""
                            setTimeout(() => {
                                app._('success_msg').style.display = "none"
                            }, 2000); 
                            $("#feedbackSaveModal").modal('hide')        
                        }else{
                            app._('error_msg').style.display = ""
                            setTimeout(() => {
                                app._('error_msg').style.display = "none"
                            }, 2000); 
                        } 
                    }   
                    xhr.open('POST','umbra/feedback/feedback.config.php',true)
                    xhr.send(fd)             
           },
           _: function(el){
                return document.getElementById(el);
           },
           rowColor: function(dataId,dat){
                app.server_msg = ""
                var fd = new FormData();
                    fd.append('colorChange',true)
                    fd.append('emp',dataId)
                    fd.append('yr',app.feedBackYR)
                    fd.append('dat',dat)
                var xhr = new XMLHttpRequest()
                    xhr.onload = function(){
                        app.getFeedback()
                        var msg = JSON.parse(this.responseText)
                            app.server_msg = msg.message
                        if(msg.success){
                            app._('success_msg').style.display = ""
                            setTimeout(() => {
                                app._('success_msg').style.display = "none"
                            }, 2000); 
                            $("#feedbackSaveModal").modal('hide')        
                        }else{
                            app._('error_msg').style.display = ""
                            setTimeout(() => {
                                app._('error_msg').style.display = "none"
                            }, 2000); 
                        }

                    }
                    xhr.open('POST','umbra/feedback/feedback.config.php',true)
                    xhr.send(fd)             
            }
            
        },
        watch:{
            feedBackYR:()=>{
                app.getFeedback()
            },
            feedbacks:()=>{
                app.mergeTable()
            },
            Employees:()=>{
                app.mergeTable()
            },
        },
        mounted:function(){
            var rdy = setInterval(() => {
                if(document.readyState=="complete"){
                    console.log('Document Load Done');
                    app.getFeedback()
                    app.getEmployees()
                    clearInterval(rdy)
                }
            }, 100);
        }
    })    
</script>
<?
require_once "footer.php";
?>
<style>
    .yellow{
        background:#ffe0034d;
    }
</style>