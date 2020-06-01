<?php    
$title = "Feedback";
require_once "header.php";
?>
<div class='ui segment' style="width:80%;margin:auto" id="app">
  <!-- content -->
  
    <div class="ui modal" id="feedbackSaveModal">
        <div class="header">Add Feedback</div>
        <div class="content">
            <form class="ui form" @submit="saveFeed">
                <div class="field">
                    <label>Feedback</label>
                    <textarea v-model="txtfeed"></textarea>
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
                </tr>
            </thead>
            <tbody>
                <tr v-for="e in mergedData" class="ui" :class='e.color' @click="openFeed(e.employees_id)" :key="e.employees_id">
                    <td>{{Employees[e.employees_id].lastName}} {{ Employees[e.employees_id].firstName }}</td>
                    <td>{{Employees[e.employees_id].employmentStatus}}</td>
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
            
        },
        methods:{
           getEmployees:()=>{
                var xml = new XMLHttpRequest()
                    xml.onload = ()=>{
                        app.Employees = JSON.parse(xml.responseText)
                    }
                    xml.open('POST','umbra/feedback/jason.php',true)
                    xml.send()
           },
           getFeedback:()=>{
                if(app.feedBackYR.toString().length==4){
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
                        if(feedback['color']){
                            rowColor = ""
                        }                      
                        app.mergedData[ind] = {employees_id:Employee['employees_id'],employmentStatus:Employee['employmentStatus'],feedbacking_id:feedback['feedbacking_id'],feedbacking_feedback:feedback['feedbacking_feedback'],color:rowColor}
                    }else{       
                        app.mergedData[ind] = {employees_id:Employee['employees_id'],employmentStatus:Employee['employmentStatus'],feedbacking_id:"", feedbacking_feedback:"",color: "yellow"}
                    }

                        app.mergedData = app.mergedData.filter(()=>true)
                }
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
                event.preventDefault()
                var fd = new FormData()
                    fd.append('savefeedback',true)
                    fd.append('yr',app.feedBackYR)
                    fd.append('emp',app.txtid)
                    fd.append('feedback',app.txtfeed)
                var xhr = new XMLHttpRequest()
                    xhr.onload = function(){
                        app.getFeedback()
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