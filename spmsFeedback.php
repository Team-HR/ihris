<?php    
$title = "Feedback";
require_once "header.php";
?>
<div id='app'>
  <div class="ui dimmer" :class="dimmer_status" style="position:fixed">
      <div class="ui text loader" >Fetching Data...</div>
  </div>
<div class='ui segment' style="width:80%;margin:auto">
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
                    <label>Date</label>
                    <input type="date" v-model="txtdate" required>
                </div>
                <div class="field">
                    <label>Feedback</label>
                    <textarea v-model="txtfeed" required></textarea>
                </div>                
                <div class="field">
                    <button class='ui primary button fluid' name="saveBTN">SAVE</button>
                </div>
            </form>
            <br>
                <div class="field">
                    <button class='ui negative button fluid' onclick="$(this.offsetParent).modal('hide')">Close</button>
                </div>
        </div>
    </div>

    <div>
        <h1>Feedback and Monitoring Year {{feedBackYR}}</h1>
    </div>
    <div>
        <div class="ui divider"></div>
        <form class="ui form" @submit="noSubmit">
            <div class="three fields">
                <div class="two wide field " > 
                    <label>Year</label>
                    <input type="text" name="year" v-model.number="pre_feedBackYR" >
                </div>
                <div class="two wide field">
                    <label>Gender</label>
                    <select type="text" name="period" v-model="gender">
                        <option value="">All</option>
                        <option value="MALE">MALE</option>
                        <option value="FEMALE">FEMALE</option>
                    </select>
                </div> 
                <div class="twelve wide field">
                    <label>Search</label>
                    <input type="search" name="searchData" v-model="searchData">
                </div> 
            </div>
        </form>
        <table class="ui celled table selectable" id="feedbackTable">
            <thead>
                <tr>
                    <!-- <th>Employee's Name</th>
                    <th>Dapartment</th> -->
                    <th>Fullname</th>
                    <th>Gender</th>
                    <th>Status</th>
                    <th>Colors</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="e in mergedData" class="ui" :class='e.color' :key="e.employees_id">
                    <td>{{e.lastName}}, {{ e.firstName }}</td>
                    <td>{{Employees[e.employees_id].gender}}</td>
                    <td>{{Employees[e.employees_id].employmentStatus}}</td>
                    <td style="text-align:center">
                        <div class="ui buttons">
                            <button class="ui button" @click="rowColor(e.employees_id,1)"  > </button>
                            <div class="or"></div>
                            <button class="ui yellow button" @click="rowColor(e.employees_id,0)"></button>
                        </div>
                    </td>
                    <td style="text-align:center">
                        <button class="ui positive button" @click="openFeed(e.employees_id)">Open form</button>
                        <a class="ui button" @click="hyperLinker(e.employees_id)" target="_blank">Print</a>
                    </td>                    
                </tr>
            </tbody>
        </table>
    </div>
</div>
</div>
<script>
    var app = new Vue({
        el:"#app",
        data:{
            pre_feedBackYR  :new Date().getFullYear(),
            feedBackYR  :0,
            Employees   :[],
            feedbacks   :[],
            mergedData  :[],
            txtfeed     :"",
            txtid       :0,
            txtdate     :"",
            server_msg  :"",
            searchData  :"",
            gender      :"",
            dimmer_status:"active",
        },
        methods:{
           getEmployees:()=>{
                $('body').toast({ title:'Employees',message: 'Fecthing........'});
                var xml = new XMLHttpRequest()
                    xml.onload = ()=>{
                        app.Employees = JSON.parse(xml.responseText)
                    }
                    xml.open('POST','umbra/feedback/jason.php',true)
                    xml.send()                    
           },
           getFeedback:()=>{
               if(app.pre_feedBackYR.toString().length==4){
                app.feedBackYR = app.pre_feedBackYR
                    $('body').toast({title:'Feedback',message:'Loading..... '});
                    var fd = new FormData();
                        fd.append('year',app.feedBackYR)
                        fd.append('getFeedback',true)
                    var xml = new XMLHttpRequest()
                        xml.onload = function(){
                                app.feedbacks = JSON.parse(xml.responseText)
                        }
                        xml.open('POST','umbra/feedback/jason.php',false)
                        xml.send(fd)
                }
           },
           checkYr: ()=>{
                if(app.pre_feedBackYR.length==4){
                    app.feedBackYR = app.pre_feedBackYR
                }else{
                    app.pre_feedBackYR = app.feedBackYR
                }
                app.getFeedback()
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
                        app.mergedData[ind] = {employees_id:Employee['employees_id'],lastName:Employee['lastName'],firstName:Employee['firstName'],middleName:Employee['middleName'],extName:Employee['extName'],feedbacking_id:feedback['feedbacking_id'],feedbacking_feedback:feedback['feedbacking_feedback'],color:rowColor}
                    }else{       
                        app.mergedData[ind] = {employees_id:Employee['employees_id'],lastName:Employee['lastName'],firstName:Employee['firstName'],middleName:Employee['middleName'],extName:Employee['extName'],feedbacking_id:"", feedbacking_feedback:"",color: "yellow"}
                    }
                }
                        app.mergedData = app.mergedData.filter(()=>true);
                        app.mergedData = app.mergedData.sort(function(a,b){
                            if (a.lastName < b.lastName) {
                                return -1;
                            }
                            if (a.lastName > b.lastName) {
                                return 1;
                            }
                            // names must be equal
                            return 0;
                        })
                        setTimeout(() => {
                            app.dimmer_status = ""
                        }, 1000);
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
                var el = event.target.saveBTN;
                    el.innerHTML = "Saving Data..."
                    el.disabled = true
                if(app.feedBackYR.length < 4){
                    app.server_msg = "Invalid Year";
                    app._('warning_msg').style.display = ""
                    setTimeout(() => {
                        app._('warning_msg').style.display = "none"
                    }, 2000); 
                }else{
                    app.server_msg = ""
                    var fd = new FormData()
                    fd.append('savefeedback',true)
                    fd.append('yr',app.feedBackYR)
                    fd.append('emp',app.txtid)
                    fd.append('feedback',app.txtfeed)
                    fd.append('date',app.txtdate)
                var xhr = new XMLHttpRequest()
                    xhr.onload = function(){
                        app.checkYr()
                        var msg = JSON.parse(this.responseText);
                        if(msg.success){
                            $('body').toast( {class: 'success',message: msg.message});
                            $("#feedbackSaveModal").modal('hide')        
                        }else{
                            $('body').toast({class: 'error',message: msg.message});
                        } 
                        el.innerHTML = "SAVE"
                        el.disabled = false
                    }   
                    xhr.open('POST','umbra/feedback/feedback.config.php',true)
                    xhr.send(fd)             
                }
           },
           _: function(el){
                return document.getElementById(el);
           },
           rowColor: function(dataId,dat){
                var el = event.target;
                    el.disabled = true;
                app.server_msg = ""
                var fd = new FormData();
                    fd.append('colorChange',true)
                    fd.append('emp',dataId)
                    fd.append('yr',app.feedBackYR)
                    fd.append('dat',dat)
                var xhr = new XMLHttpRequest()
                    xhr.onload = function(){
                        app.checkYr()
                        var msg = JSON.parse(this.responseText)
                            app.server_msg = msg.message
                        if(msg.success){
                            $('body').toast({class: 'success',message: msg.message});
                        }else{
                            $('body').toast({class: 'error',message: msg.message});
                        }
                        el.disabled = false
                    }
                    xhr.open('POST','umbra/feedback/feedback.config.php',true)
                    xhr.send(fd)             
            },searcher:function(){
                    table = document.getElementById("feedbackTable");
                    tr  = table.getElementsByTagName("tr");
                    for(var i=1;i < tr.length ; i++) {                        
                        td = tr[i].getElementsByTagName("td")
                        if (td) {
                            name = td[0].textContent || td[0].innerText;
                            gender = td[1].textContent || td[1].innerText;
                            if(app.gender!=""){
                                if (name.toUpperCase().indexOf(app.searchData.toUpperCase()) > -1 && gender.toUpperCase() == app.gender.toUpperCase()) {
                                    tr[i].style.display = "";
                                } else {
                                    tr[i].style.display = "none";
                                }
                            }else{
                                if (name.toUpperCase().indexOf(app.searchData.toUpperCase()) > -1) {
                                    tr[i].style.display = "";
                                } else {
                                    tr[i].style.display = "none";
                                }
                            }
                        }
                    }
                },
                hyperLinker:function(employees_id){
                    // return window.location.href = "umbra/feedback/pdf.php?reference="+employees_id+"&feedBackYR="+app.feedBackYR
                    return window.open("umbra/feedback/pdf.php?reference="+employees_id+"&feedBackYR="+app.feedBackYR,'_blank');
                }

        },
        watch:{
            pre_feedBackYR:()=>{
                app.getFeedback()
            },
            feedbacks:()=>{
                app.mergeTable()
            },
            Employees:()=>{
                app.mergeTable()
            },
            searchData:function () {
                app.searcher()
            },
            gender:function () {
                app.searcher()
            }
        },
        mounted:function(){
            var rdy = setInterval(() => {
                if(document.readyState=="complete"){
                    console.log('Document Load Done');
                    app.getFeedback()
                    app.getEmployees()
                    app.searcher()
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