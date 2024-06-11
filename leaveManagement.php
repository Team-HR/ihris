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
      left: 14px;
    }
    #addModal {
      padding: 15px;
    }

    .container{
      display: flex;
      justify-content: space-between;
      max-width: 75%;
    }
    .leaveBalanceLayout {
      display: flex;
      flex-direction: column;
      gap: 1;
      margin: 0;
    }
    .balanceLayoutTitle{
      display: flex;
      align-items: center;
      gap: .5rem;
      margin: 0;
      margin: .1rem 0 .1rem 0;
      font-weight: bold;
    }
    .leaveBalanceLayout h4{
      line-height: 0;
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
                <input type="date" name="" v-model="date_filed" @change="getLeaveBalance()"> 
              </div>
            </div>
          </div> 
          <div class="field">
            <div class="two fields">
              <div class="field">
                <label>Name:</label>
                <select class="ui fluid search dropdown" id="emp_id" v-model="emp_id" @change="getLeaveBalance()">
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

          <!-- Remaining Leave Balance -->
          <template>
            <div class="container">
              <div class="leaveBalanceLayout" v-if="emp_id && date_filed">
                <div class="balanceLayoutTitle">
                  <div>Balance</div>
                </div>
                <div>
                  Vacation Leave: 
                  <div :class="['ui tiny input', { disabled: !editMode, transparent: !editMode }]">
                    <input type="text" style="width: 80px;" v-model="leaveBalances.lm_earning_result.vl_bal">
                  </div>
                </div> 
                <div>
                  Sick Leave:
                  <div :class="['ui tiny input', { disabled: !editMode, transparent: !editMode }]">
                    <input type="text" style="width: 80px;" v-model="leaveBalances.lm_earning_result.sl_bal">
                  </div>
                </div> 

                <div>
                  <button class="ui compact icon button mini primary" @click="toggleEditMode">{{ editMode ? "SAVE" : "EDIT" }}</button>
                </div>

              </div>

              <div class="leaveBalanceLayout" v-if="emp_id && date_filed">
                <div class="balanceLayoutTitle">
                  <div>Special Leave Balance</div>
                </div>
                <div>
                  Special Leave:
                  <div class="ui tiny input disabled transparent">
                    <input type="text" style="width: 80px;" v-model="leaveBalances.lm_logs_result.totalDaysSum">
                  </div>
                </div> 
              </div>
            </div>
          </template>
          <!-- Remaining Leave Balance -->
          
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


    <div class="ui medium header">Leave Admin Dashboard</div>
    <button class="ui positive button" id="addButton" @click="showAddModal()">Add New</button>
    <button class="ui blue button" id="addButton">Monetization</button>
    <template v-if="Logs.length">
    <table class="ui celled table gwd-table-16du">
      <thead>
        <tr>
            <th> </th>
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
        <tr v-for="(log,index) in Logs" :key="index">
          <td>{{log.log_id}}</td>
          <td>{{ log.dateReceived }}</td>
          <td>{{ log.date_filed}}</td>
          <td>{{ log.firstName}} {{ log.lastName}}</td>
          <td> <span v-html="decodeAppliedDates(log.dateApplied)"></span></td>
          <td>{{ log.leaveType }} {{ log.sp_type }} </td>
          <td>{{ log.totalDays }}</td>
          <td>{{ log.remarks }}</td>
          <td>{{ log.Status }}</td>
          <td>
            <button class="circular ui icon button green" id="openButton" onclick="approveModal()">
              <i class="icon check"></i>
            </button>
            <button class="circular ui icon button red">
              <i class="icon close"></i>
            </button>
            <button class="circular ui icon button blue" id="editButton" @click="getEdit(index)">
              <i class="icon edit"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    </template>
  </div>  

  <script>
    $(document).ready(function() {
        $(".dropdown").dropdown();
    });
    function approveModal() {
      $("#approveModal").modal('show');
    }
  </script>
  <script src="umbra/leaveManagement/leave.js"></script>

<?php
    require_once "footer.php";
?>