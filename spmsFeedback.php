<?php    
$title = "Feedback";
require_once "header.php";
?>
<div class='ui segment' style="width:80%;margin:auto" id="app">
<div class="ui modal" id="spms_feedback">
  <i class="close icon"></i>
  <div class="header" style="text-align:center">
    PERFORMANCE REVIEW & FEEDBACKING MONITORING FORM
  </div>
  <div style='position:absolute;margin-top:-50px;margin-left:100px;z-index:100px;'>
            <div class='ui negative message' style='width:700px;' :style="errormsg">
                <div class='header'>
                    Something Went Wrong
                </div>
                <p>{{ alertmsg }}</p>
            </div>
            <div class='ui positive message' style='width:700px;' :style="successmsg">
                <div class='header'>
                    SUCCESS!
                </div>
                <p>{{ alertmsg }}</p>
            </div>
  </div>
  <br>
  <!-- content -->
    <form class="ui form" :class='savingData' @submit="saveFeedback" style="padding:20px">
        <div>
            <div class="two fields">
                <div class="field">
                    <label> Period</label>
                    <select type="text" v-model="period" @change="editIfExist" >
                            <option value="January - June">January - June</option>
                            <option value="July - December">July - December</option>
                    </select>
                </div>            
                <div class="field">
                    <label>Year</label>
                    <input type="number" v-model="yr" @change="editIfExist" required >

                </div>
            </div>
            <div class='field'>
                <label>Name</label>
                <select class="ui fluid search dropdown" id="emp" :class="searchLoad" @change="editIfExist">
                    <option value="">Search...</option>
                    <option v-for='emp in searchResultEmp' :value="emp.employees_id">{{ emp.firstName }} {{ emp.lastName }}</option>
                </select>
            </div>
            <div class="field">
                <label>FEEDBACKS</label>
                <textarea v-model="feedback" required></textarea>
            </div>
        </div>
        <!--  -->
        <div class="actions">
            <br>
            <input class="ui button green" type="submit" value="Save">
            <br>
        </div>
        </div>
    </form>

    <div style="">
        <button class="ui right floated button blue" @click="openModal">Open Form</button>
        <h1>Feedback and Monitoring</h1>
    </div>
    <div>
        <div class="ui divider"></div>
        <form class="ui form" :class="loading" name="periodForm" @submit="noSubmit">
            <div class="two fields">
                <div class="field">
                    <label>Period</label>
                    <select type="text" name="period" @change="generate">
                        <option value="January - June">January - June</option>
                        <option value="July - December">July - December</option>
                    </select>
                </div>
                <div class="field" > 
                    <label>Year</label>
                    <input type="text" name="year" @keyup="generate">
                </div>
            </div>
        </form>
        <table class="ui celled table ">
            <thead>
                <tr>
                    <th>Employee's Name</th>
                    <th>Dapartment</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Pascual Tomulto</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
    // JQUERY
    $(document).ready(function(){
        $('.dropdown').dropdown({
            fullTextSearch:true,
            // clearable: true
        });
    });
    // vue
    var app = new Vue({
        el:"#app",
        data:{
            yr:"",
            period:"",
            feedback:"",
            searchResultEmp:[],
            loading:'loading',
            savingData: "",
            searchLoad:'',
            saveReturn: [],
            errormsg:"display:none",
            successmsg:"display:none",
            alertmsg:"",
            trying:""
        },
        methods:{
            editIfExist: function(){
                var  emp= document.getElementById('emp').value
                if(app.period.length>0&&app.yr>0){
                    app.savingData = "loading"
                    var fd = new FormData()
                        fd.append('editIfExist',true)
                        fd.append('emp',emp)
                        fd.append('period',app.period)
                        fd.append('yr',app.yr)
                    var xml = new XMLHttpRequest()
                        xml.onload = function(){
                            app.feedback = xml.responseText;
                            app.savingData = ""
                        }
                        xml.open('POST','umbra/feedback/feedback.config.php',false)
                        xml.send(fd)
                }             
            },
            saveFeedback :function(){
                app.savingData = "loading"
                event.preventDefault()
                var fd = new FormData()
                    fd.append('savefeedback',true)
                    fd.append('period',app.period)
                    fd.append('yr',app.yr)
                    fd.append('emp',document.getElementById('emp').value)
                    fd.append('feedback',app.feedback)
                var xml = new XMLHttpRequest()
                    xml.onload = function(){
                        app.saveReturn = JSON.parse(xml.responseText)
                        if(app.saveReturn.success){
                            app.feedback = ""
                            $(".dropdown").dropdown('clear');
                            app.successmsg="display:block"
                        }else{
                            app.errormsg = "display:block"
                        }
                        app.savingData=""  
                        app.alertmsg = app.saveReturn.message;
                        setTimeout(() => {
                            app.successmsg= "display:none"
                            app.errormsg= "display:none"
                        },2000);
                    }
                    xml.open('POST','umbra/feedback/feedback.config.php',false)
                    xml.send(fd)
            },
            generate: function(){
                var el = event.target.offsetParent.elements;
                if(el.year.value.length>=4){
                    var fd = new FormData()
                    // fd.append("per",app.period)
                    // fd.append('yr',app.year)
                    fd.append('getEmpList',true)
                    var http = new XMLHttpRequest()
                    http.onload = ()=>{
                    }               
                    http.open('POST','umbra/feedback/jason.php',false)
                    http.send(fd)                
                }
            },
            searchEmp:function(){
                    var fd = new FormData()
                        fd.append('empSearch','');
                    var xml = new XMLHttpRequest()
                        xml.onload =function(){
                            if(xml.readyState==4&&xml.status==200){
                                app.searchResultEmp = JSON.parse(xml.responseText)
                                app.searchLoad = ""
                            }else{
                                console.log("something is wrong");
                            }
                        }
                        xml.open('POST','umbra/feedback/jason.php',false)
                        xml.send(fd);
                },
            noSubmit : function(){
                event.preventDefault()
            },
            openModal : function(){
                $("#spms_feedback").modal('show')
            }
        },
        mounted:function(){
            var c = setInterval(()=>{
                if(document.readyState=='complete'){
                    // function and codes after this line
                        app.loading = ""
                        app.searchEmp()
                    //function and codes above this line
                    clearInterval(c)
                }
            },500)
        }
    })    
</script>
<?
require_once "footer.php";
?>