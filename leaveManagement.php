<?php
    require_once "_connect.db.php";
    $title = "Leave Management";

    require_once "header.php";
    
?>

<style type="text/css">
    #leaveCont {
      transform-origin: 50% 50% 0px;
      top: 0;
      left: 19px;
      width: 96.92%;
    }
    .gwd-table-16du {
      left: 14px;
      top: 98px;
    }
    .gwd-button-11xy {
      top: 48px;
      left: 14px;w
    }
    #addModal {
      padding: 15px;
    }
  </style>
  <div class="ui segment" id="leaveCont">

 
  <!--    Add model    -->
  <div class="ui modal small" id="addModal">
      <div class="header">
        <h3 class="ui header">Add New Leave Record</h3>
      </div>
      <div class="content">
        <div class="ui form">
          <div class="field">
            <div class="two fields">
              <div class="field">
                  <strong>Control Number:</strong> <span>HRMO - <?php echo date('Y');?> - <span>*****</span></span>
                </div>
                <div class="eight wide field" style="visibility:hidden">
                  <strong>Date Logged:</strong> <span><?php echo date('F d, Y');?></span>
                </div>
            </div>
          </div>
          <div class="field">
           <div class="two fields">
              <div class="field">
                <label>Date Received</label>
                <input type="date" name=""  v-model="date_received"> 
              </div>
              <div class="field">
                <label>Date of Filing:</label>
                <input type="date" name="" v-model="date_filed"> 
              </div>
            </div>
          </div> 
          <div class="field">
            <div class="two fields">
              <div class="field">
                <label>Name:</label>
                <select class="ui fluid search dropdown" id="emp_id" v-model="emp_id">
                    <option value="">Employee</option>
                    <template>
                      <option v-for="(employee,index) in Employees" :value="employee.employees_id">{{employee.lastName}}, {{employee.firstName}}</option>
                    </template>
                </select>
              </div>
              <div class="field">
                <label>Type of leave:</label>
                <select class="ui fluid search dropdown" id="leaveType" v-model="leaveType">
                    <option value="">Type</option>
                    <option value="Vacation">Vacation Leave</option>
                    <option value="Forced">Forced Leave</option>
                    <option value="Sick">Sick Leave</option>
                    <option value="SP">Special Leave</option>
                    <option value="Monetization">Monetization</option>
                    <option value="Others">Others</option>
                </select>
              </div>
            </div>        
          </div>
          <template  v-if="leaveType=='Monetization'">
          <div class="field">
            <div class="two fields">
              <div class="field">
                <label>Total Days:</label>
                  <div class="field" >
                     <input v-model="mone_days" type="number" placeholder="Days" required>
                   </div>
              </div>
              <div class="field">
                <label>Type of monetization:</label>
                <select class="ui fluid search dropdown"   id="mone_type" v-model="mone_type">
                    <option value="">Type</option>
                    <option value="(Regular)">Regular Monetization</option>
                    <option value="(50%)">50% Monetization</option>
                </select>
              </div>
            </div>
          </div>
          </template>
          <template  v-if="leaveType=='Others'">
            <div class="field" >
              <input type="text" id="others" v-model="others" placeholder="Please type what kind of other leave it is.." required>
          </div>
          </template>
          <template  v-if="leaveType=='SP'">
            <div class="field">
                <label>Type of Special Leave:</label>
                <select class="ui fluid search dropdown" id="sp_type" v-model="sp_type">
                    <option value="(Filial)">Filial Leave</option>
                    <option value="(Domestic)">Domestic Emergency Leave</option>
                    <option value="(Maternity)">Maternity Leave</option>
                    <option value="(Rehabilitation)">Rehabilitation Leave</option>
                    <option value="(Solo Parent)">Solo Parent Leave</option>
                    <option value="(Paternity)">Paternity Leave</option>
                    <option value="(Magna Carta)">Magna Carta Leave</option>
                    <option value="(Anti-VAWCY)">Anti-VAWCY Leave</option>
                    <option value="(Study)">Study Leave</option>
                    <option value="(Birthday)">Birthday Leave</option>
                    <option value="(Fiesta)">Fiesta Leave</option>
                </select>
          </div>
          </template>
          <div class="ui segment">
              <div id="clndr"></div>    
          </div>
            <div class="field">
              <label>Number of days</label>
              <input type="text" v-model="numberOfDays">
            </div>
          <div class="ui link list">
            <!-- <a class="item" v-for="(d,index) in selectedDate" :key="index">
              <span class="left floated like">
                  {{d}}
              </span>
              <span class="right floated">
                <i class="close icon" @click="slice_date(index)"></i>
              </span>          
            </a> -->
          </div>
          <br>
          <div class="field">
            <label>Remarks:</label>
            <textarea width="100%" v-model="remarks"></textarea>
          </div>
        </div>
      </div>
      <div class="actions">
        <button class="ui approve button positive" id="saveLogs"  @click="saveLeave()">Save</button>
        <div class="ui button cancel negative">Close</div>
      </div>
    </div>
<!--   add modal End   -->


<!----on disapprove leave ---->
<div class="ui mini  modal" id="disapproveModal">
      <div class="header">
            Do you really want to disapprove this leave application?</label>
      </div>
      <div class="content">
           <div class="ui form">
                 <div class="field">
                    <div class="header"> <label class=""><i>[If yes, please enter your reason]</i></label> </div>
                 </div>
                 <div class="field">
                    <textarea width="100%" v-model="remarks" placeholder="Type reason here"></textarea>
                 </div> 
                 <center>
                  <button class="ui approve button positive" id="saveDis" @click="saveDis()">Save</button>
                  <div class="ui button cancel negative">Close</div>
                  </center>
            </div>
       </div>
</div>
<!---end---->

<!----on revert leave ---->
<div class="ui mini  modal" id="revertModal">
      <div class="header">
            This leave application has been disapproved, do you really want to revert this one?</label>
      </div>
      <div class="content">
           <div class="ui form">
                   <center>
                   <button class="ui approve blue button" id="saveRev" @click="saveRev()">Yes</button>
                   <div class="ui button cancel negative">No</div>
                  </center>
            </div>
       </div>
</div>
<!---end---->

<!--    On approve modal    -->
<div class="ui fullscreen  modal" id="approveModal">
    <div class="header">
        <h3 class="ui header">Approving Leave Application</h3>
    </div>

    <div class="content">
        <div class="ui internally celled grid">
           <div class="row">
                <div class="eight wide column">
                     <div class="content">
                         <div class="ui form">
                            <div class="field">
                                <div class="header">
                                 <center> <h3 class="ui header">Details of Action on Application</h3> </center>
                                 </div><br>
                                 <div class ="field">
                                     <div class="two fields">
                                          <div class="field">
                                              <label>Date Received</label>
                                              <input type="date" name=""  v-model="date_received"> 
                                          </div>
                                          <div class="field">
                                              <label>Date of Filing</label>
                                              <input type="date" name=""  v-model="date_filed"> 
                                          </div>
                                     </div>
                                 </div>

                                 <div class ="field">
                                     <div class="two fields">
                                         <div class="field">
                                             <label>Name:</label>
                                             <select  id="emp_id" v-model="emp_id">
                                             <option value="">Employee</option>
                                             <template>
                                              <option v-for="(employee,index) in Employees" :value="employee.employees_id">{{employee.lastName}}, {{employee.firstName}}</option>
                                            </template>
                                             </select>
                                         </div>
                                         <div class="field">
                                             <label>Type of leave:</label>
                                            <select id="leaveType" v-model="leaveType">
                                                <option value="">Type</option>
                                                <option value="Vacation">Vacation Leave</option>
                                                <option value="Forced">Forced Leave</option>
                                                <option value="Sick">Sick Leave</option>
                                                <option value="SP">Special Leave</option>
                                                <option value="Monetization">Monetization</option>
                                                <option value="Others">Others</option>
                                            </select>
                                         </div>
                                     </div>
                                 </div>
                                 <template  v-if="leaveType=='SP'">
                                    <div class="field">
                                        <label>Type of Special Leave:</label>
                                        <select v-model="sp_type">
                                            <option value="(Filial)">Filial Leave</option>
                                            <option value="(Domestic)">Domestic Emergency Leave</option>
                                            <option value="(Maternity)">Maternity Leave</option>
                                            <option value="(Rehabilitation)">Rehabilitation Leave</option>
                                            <option value="(Solo Parent)">Solo Parent Leave</option>
                                            <option value="(Paternity)">Paternity Leave</option>
                                            <option value="(Magna Carta)">Magna Carta Leave</option>
                                            <option value="(Anti-VAWCY)">Anti-VAWCY Leave</option>
                                            <option value="(Study)">Study Leave</option>
                                            <option value="(Birthday)">Birthday Leave</option>
                                            <option value="(Fiesta)">Fiesta Leave</option>
                                        </select>
                                    </div>
                                </template>
                                <template  v-if="leaveType=='Monetization'">
                                    <div class="field">
                                    <div class="two fields">
                                        <div class="field">
                                        <label>Total Days:</label>
                                            <div class="field" >
                                            <input v-model="totalDays" type="number" placeholder="Days" required>
                                            </div>
                                        </div>
                                        <div class="field">
                                        <label>Type of monetization:</label>
                                        <input  v-model="sp_type">
                                        </div>
                                    </div>
                                    </div>
                                    </template>
                                <template v-else>
                                <div class="two fields">          
                                    <div class="field">
                                            <label>Date Applied</label>
                                            <input type="text" v-model="decodeAppliedDates(dateApplied)">
                                    </div>
                                    <div class="field">
                                            <label>Number of days</label>
                                            <input type="text" v-model="totalDays">
                                            
                                    </div>
                                    </div>
                                </template>
                                <div class="field">
                                        <label>Remarks</label>
                                        <textarea width="100%" v-model="remarks"></textarea>
                                </div>
                            </div>
                         </div>
                      </div>
                </div>

                 <div class="eight wide column">                           
                     <div class="ui form">   
                         <div class="header">
                          <center> <h3 class="ui header">Certification of Leave Credits</h3> </center>
                         </div><br>
                           <div class="two fields">
                                          <div class="field">
                                              <label>CHECK BALANCE</label>
                                              <input type="date" name=""  v-model="date_received"> 
                                          </div>
                            </div>
                          <button @click="goDeduct" id="btn_deduct" class="ui mini blue button"><i class="icon edit"></i> Deductions</button>
                          <h4 class="ui header">DEDUCTIONS</h4>
                          <hr>
                         <table class="ui very small compact structured celled table" >
                              <thead>
                              <tr class="center aligned">
                                  <th rowspan="2">Deducted to</th>
                                  <th rowspan="2">Leave credits to deduct</th>
                                  <th rowspan="2">Options</th>
                              </tr>
                              </thead>
                              <tbody>
                              <template v-if="deducts.length != 0">
                              <tr  v-for="(deducts,i) in deducts" :key="i">
                                  <td><select :readonly="readonly" :class="{readOnly: readonly}"v-model="deducted_to">
                                              <option value="(vl)">Vacation Leave Credits</option>
                                              <option value="(sl)">Sick Leave Credits</option>
                                              <option value="(sp)">Special Leave</option>
                                          </select></td>
                                  <td><input :readonly="readonly" :class="{readOnly: readonly}" type="number"  v-model="deductions"></td>
                                  <td :hidden="readonly">
                                      <button class="ui mini button red icon" @click="removeItem(i)"> 
                                          <i class="icon times"></i>
                                      </button>
                                  </td>
                              </tr>
                              </template>
                              <template  v-else>
                                  <tr class="center aligned" style="color:lightgrey">
                                      <td colspan="7">-- Nothing to show --</td>
                                  </tr>
                              </template>
                              <template v-if="!readonly">
                                  <tr>
                                      <td colspan="7">
                                          <strong>
                                             Total: [total here]
                                          </strong>
                                      </td>
                                  </tr>
                              </template>
                              <template v-if="!readonly">
                                  <tr>
                                      <td colspan="7">
                                          <button class="ui mini icon button blue" @click="addItem">
                                              <i class="icon add"></i> Add
                                          </button>
                                      </td>
                                  </tr>
                              </template>
                              </tbody>
                          </table>  

                          
                          <center>
                          <button class="ui approve button positive">Save</button>
                          <div class="ui button cancel negative">Close</div>
                          </center>
                        

                      </div>
                 </div>
           </div>             
        </div> 
   </div>
</div>
  <!-- On-approve modal End   -->

  <button class="ui blue button" id="addButton" @click="showAddModal()">Add New Log</button>
    <center><div class="ui large header">Leave Logs</div></center> 
    <template v-if="Logs.length">
    <table class="ui celled table gwd-table-16du">
      <thead>
        <tr style="text-align:center">
            <th>Control Number</th>
            <th>Date Filed</th>
            <th>Date Received</th>
            <th>Name of Applicant</th>
            <th>Date/s Applied</th>
            <th>Type of Leave</th>
            <th>Total Days</th>
            <th>Remarks</th>
            <th>Status</th>
            <th>Options</th>
        </tr>
      </thead>
      <tbody>
          
         <tr v-for="(log,index) in Logs" :key="index" style="text-align:center">
          <td>HRMO-{{new Date(log.dateReceived).getFullYear()}}-{{log.log_id.toString().padStart(5, '0')}}</td>
          <td>{{ log.dateReceived }}</td>
          <td>{{ log.date_filed}}</td>
          <td><a :href="'lm_ledger.php?employees_id='+log.employees_id" target="_blank">{{ log.firstName}} {{ log.lastName}}</td>
          <td> <span v-html="decodeAppliedDates(log.dateApplied)"></span></td>
          <td>{{ log.leaveType }} {{ log.sp_type }} </td>
          <td>{{ log.totalDays }}</td>
          <td>{{ log.remarks }}</td>
          <td>{{ log.stats }}</td>
          <td >
            <template  v-if="log.stats=='PENDING'">
              <button class=" mini ui icon button green" id="approveButton" @click="approve(index)"  title="Approve Leave">
                <i class="icon check"></i>
              </button>    
              <button class=" mini ui icon button blue" id="editButton" @click="getEdit(index)"  title="Edit Leave">
                <i class="icon edit"></i>
              </button>
              <button class=" mini ui icon button red"   id="DisButton" @click="getDis(index)"  title="Disapprove Leave">
                <i class="icon close"></i>
              </button>
            </template>
            <template  v-else>
              <button class=" mini ui icon button orange" id="" @click="getRev(index)"  title="Approve Leave">
                <i class="icon reply"></i>
              </button>   
            </template>
          </td>
        </tr>
      </tbody>
    </table>
    </template>
  </div>  
</div>
<script src="umbra/leavemanagement/deduction.js"></script>
  <script>
    $(document).ready(function() {
        $(".dropdown").dropdown();
    });
    // function approveModal() {
    //   $("#approveModal").modal('show');
    // }
  </script>
  <script src="umbra/leaveManagement/leave.js"></script>

<?php
    require_once "footer.php";
?>