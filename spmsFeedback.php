<?php    
$title = "Feedback";
require_once "header.php";
?>
<div class='ui segment' style="width:80%;margin:auto" id="app">
  <!-- content -->
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
                <tr v-for="e in Employees">
                    <td>{{e.lastName}} {{e.firstName}}</td>
                    <td>{{e.employmentStatus}}</td>
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
        },
        methods:{
           getEmployees:()=>{
                var xml = new XMLHttpRequest()
                    xml.onload = ()=>{
                        app.Employees = JSON.parse(xml.responseText)
                        app.mergeTable()
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
                var a_null = {feedbacking_id: "", feedbacking_emp: "", feedbacking_year: "", feedbacking_feedback: ""};
                app.Employees.forEach(Employee=>{
                    feed = app.feedbacks.find( ({ feedbacking_emp }) => feedbacking_emp === Employee.employees_id )
                    if(feed){
                        ar = feed
                    }else{
                        ar = a_null
                    }
                        app.mergedData.push({Employee,ar})
                });
           }
        },
        watch:{
            feedBackYR:()=>{
                app.getFeedback()
            },
            feedbacks:()=>{
                app.mergeTable()
            }
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