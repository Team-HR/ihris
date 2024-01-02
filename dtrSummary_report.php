<?php
    $title = "DTR Summary";
    require_once "header.php";
?>
<style>


</style>

<div id="dtrSummary_app">
<div class="ui segment noprint"   style="margin:auto;max-width:50%;min-width:500px;">
        <h3>DTR Summary Report</h3>
        <div class="ui section divider"></div> 
            <form class="ui form" @submit.prevent="getDataNeeded()">
                <div class="field">
                    <label>Select month:</label>
                    <input type="month" placeholder="Month" v-model="period" required>
                </div>
                <input type="submit" value="Generate" class="ui button blue">
            </form>
            <br>
    </div>
    <br>    
        <template>
            <table class="ui celled table" style="width:1080px;margin:auto;font-size:12px;" v-if="DataRequest.length>0">
                <thead>
                    
                     <tr> 
                        <th colspan="12">
                              <center>      
                                    <div style="background:white; width:1080px;">
                                        <div style="float:left; margin-left:30%">
                                                <img src="bayawanLogo.png" width="100px" style="margin-left:5px;margin-top:16px">
                                        </div>
                                
                                        <div style="float: left; width:25%; margin-top:30px">
                                            <strong>
                                                Republic of the Philippines<br>Province of Negros Oriental<br>CITY OF BAYAWAN
                                            </strong>
                                            <br><br>
                                        </div>
                                    
                                        <div style="clear:both"></div>

                                        
                                            <div  style="margin-top:20px;font-size:14px"> 
                                                        <b>Office of the Human Resource Management and Development</b>
                                            </div>

                                        <div style="text-align:left; margin-top:40px">
                                                <p>
                                                <b> PRYDE HENRY TEVES<br>
                                                    City Mayor<br>
                                                    LGU-Bayawan City<br>
                                                    <br><br>
                                                    Sir,</b>
                                                    <br><br>
                                                        Respectfully submitting to your office the report  on Attendance/Tardiness/Punctuality & Leave of Absence/s of permanent and casual employees of the
                                                    City Government for the Month of {{period}}  to wit;
                                                </p>
                                        </div>
                                    
                                    
                                    </div>
                             </center>      
                        </th>
                    </tr>

                    <tr> 
                        <th  class="ab"></th>
                        <th  class="ab"></th>
                        <th  class="ab"colspan="4" style="text-align: center">TARDY</th>        
                        <th  class="ab" colspan="3" style="text-align: center">UNDERTIME</th>
                        <th  class="ab"></th>
                       
                    </tr>
                    <tr>    
                        <th  class="a">Employee</th>
                        <th  class="a"  style="width:20%">Department</th>
                        <th  class="a"  style="width:10px">No. of times</th>
                        <th  class="a"  style="width:10px">Total mins.</th>
                        <th  class="a"  style="width:10px">Date of half-day</th>
                        <th  class="a"  style="width:10px">Equiv.</th>
                        <th  class="a"  style="width:10px">Total mins.</th>
                        <th  class="a"  style="width:10px">Date of half-day</th>
                        <th  class="a"  style="width:10px" >Equiv.</th>
                        <th  class="a" style="text-align: center">Remarks</th>
                        
                    </tr>
                </thead>
                <tbody id="allDataTable" style="font-size:12px; border: 1px solid black ">
                    <tr v-for="(ar,index) in sortArrays(DataRequest)">
                       
                        <td>{{ar.lastName}} {{ar.firstName}} {{ar.middleName}} {{ar.extName}}</td>
                        <td style="font-size:10px">{{ar.department}}</td>
                        <td>{{ar.totalTardy}}</td>
                        <td>{{ar.totalMinsTardy}}</td>
                        <td>{{ar.halfDaysTardy}}</td>
                        <td>{{showEquiv(ar.totalMinsTardy)}}</td>
                        <td>{{ar.totalMinsUndertime}}</td>
                        <td>{{ar.halfDaysUndertime}}</td>
                        <td>{{showEquiv(ar.totalMinsUndertime)}}</td>
                        <td><span v-html="newLine(ar.remarks,',')"></span></td>
                      
                    </tr>
                    <tr>
                        <th  colspan="12">
                            <center>      
                                <div style="background:white; width:1080px;">
                                    <div style="text-align:left; margin-top:30px">
                                    <div class="ui horizontal list">
                                        <div class="item">
                                            <i >Prepared by:</i> <br><br><br><br>
                                                    <p style="margin-left:20px; font-weight: bold">
                                                        Jonalyn G. Velasco <br>
                                                        AAI<br>
                                                    </p>
                                            </div>
                                        <div class="item"  style="margin-left:150px">
                                            <i >Noted by:</i> <br><br><br><br>
                                                    <p style="margin-left:20px; font-weight: bold">
                                                        VERONICA GRACE P. MIRAFLOR <br>
                                                        CGDH-I<br>
                                                </p>
                                        </div>
                                        <div class="item"  style="margin-left:200px">
                                            <i >Approved by:</i> <br><br><br><br>
                                                    <p style="margin-left:20px; font-weight: bold">
                                                        PRYDE HENRY A. TEVES <br>
                                                        CITY MAYOR<br>
                                                    </p>
                                    </div>
                                </div>
                          </center>  
                        </th>
                    </tr>
                </tbody>
            </table>

                 <template v-else>
                 <center>
                    <div style="text-align: center; background:white; width:800px;">
                        <br>
                        <h2 style="color:#bfbfbf">Please select period to print report.</h2>
                        <br>
                    </div>
                </center>
                </template>       
        </template>

    </template>    
</div>
<script src="umbra/dtrManagement/config_summary.js"></script>
<script>
    $(document).ready(function(){
        $('.dropdown').dropdown(
            {
                fullTextSearch: true
            }
        );
    });
</script>
<?php
    require_once "footer.php";
?>