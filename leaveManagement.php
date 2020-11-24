<?php
    require_once "_connect.db.php";
    $title = "Leave Management";

    require_once "header.php";
?>

<style type="text/css">
    #leaveCont {
      transform-origin: 50% 50% 0px;
      top: 141px;
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
  </style>
  <div class="ui segment" id="leaveCont">
    <!--    Add model    -->
    <div class="ui modal small" id="addModal">
      <div class="header">
        <h3 class="ui header">Add Leave Record</h3>
      </div>
      <div class="content">
        <div class="ui form">
          <div class="field">
            <div class="two fields">
              <div class="field">
                <label>Control #:</label>
                <input type="text" name="" readonly value="HRMO-LEAVE<?=DATE('Y')?>-*****">
              </div>
              <div class="field">
                <label>Date Received:</label>
                <input type="date" name="" v-model="date_received"> 
              </div>
            </div>
          </div>
          <div class="field">
            <div class="two fields">
              <div class="field">
                <label>Name:</label>
                <select class="ui fluid search dropdown" v-model="emp_id">
                    <option value="">Employee</option>
                    <template>
                      <option v-for="(employee,index) in Employees" :value="employee.employees_id">{{employee.lastName}}, {{employee.firstName}}</option>
                    </template>
                </select>
              </div>
              <div class="field">
                <label>Type of leave:</label>
                <select class="ui fluid search dropdown" v-model="leaveType">
                    <option value="">Type</option>
                    <option value="VL">Vacation Leave</option>
                    <option value="FL">Forced Leave</option>
                    <option value="SL">Sick Leave</option>
                    <option value="SP">Special Leave</option>
                </select>
              </div>
            </div>
          </div>
          <template  v-if="leaveType=='SP'">
            <div class="field">
                <label>Type of Special Leave:</label>
                <select class="ui fluid search dropdown" v-model="sp_type">
                    <option value="Filial Leave">Filial Leave</option>
                    <option value="SP">Domestic Emergency Leave</option>
                    <option value="VL">Maternity Leave</option>
                    <option value="FL">Rehabilitation Leave</option>
                    <option value="SL">Solo Parent Leave</option>
                    <option value="SP">Paternity Leave</option>
                    <option value="SP">Magna Carta Leave</option>
                    <option value="SP">Anti-VAWCY Leave</option>
                    <option value="SP">Study Leave</option>
                </select>
          </div>
          </template>
          <div class="field">
            <label>Applied Date:</label>
            <form class="two fields" @submit.prevent="cal()">
              <div class="field">
                <input type="date" name="" id="calen" required>
              </div>
              <div class="field">
                <input type="submit" class="ui button primary" value="ADD">
              </div>
            </form>
          </div>
          <div class="ui link list">
            <a class="item" v-for="(d,index) in selectedDate" :key="index">
              <span class="left floated like">
                  {{d}}
              </span>
              <span class="right floated">
                <i class="close icon" @click="slice_date(index)"></i>
              </span>          
            </a>
          </div>
          <br>
          <div class="field">
            <label>Remarks:</label>
            <textarea width="100%" v-model="remarks"></textarea>
          </div>
        </div>
      </div>
      <div class="actions">
        <div class="ui approve button positive" @click="saveLeave()">Save</div>
        <div class="ui button cancel negative">Close</div>
      </div>
    </div>
<!--   add modal End   -->

<!--    edit model    -->
 <div class="ui modal small" id="editModal">
      <div class="header">
        <h3 class="ui header">Edit Leave Record</h3>
      </div>
      <div class="content">
        <div class="ui form">
          <div class="field">
            <div class="two fields">
              <div class="field">
                <label>Control #:</label>
                <input type="text" name="" readonly value="HRMO-LEAVE<?=DATE('Y')?>-*****">
              </div>
              <div class="field">
                <label>Date Received:</label>
                <input type="date" name=""> 
              </div>
            </div>
          </div>
          
          <div class="field">
            <div class="two fields">
              <div class="field">
                <label>Name:</label>
                <select class="ui fluid search dropdown" >
                    <option value="">Employee</option>
                    <template>
                      <option v-for="(employee,index) in Employees" :value="employee.employees_id">{{employee.lastName}}, {{employee.firstName}}</option>
                    </template>
                </select>
              </div>
              <div class="field">
                <label>Type of leave:</label>
                <select class="ui fluid search dropdown" >
                    <option value="">Type</option>
                    <option value="VL">Vacation Leave</option>
                    <option value="FL">Forced Leave</option>
                    <option value="SL">Sick Leave</option>
                    <option value="SP">Special Leave</option>
                </select>
              </div>
            </div>
          </div>
          <template  v-if="leaveType=='SP'">
            <div class="field">
                <label>Type of Special Leave:</label>
                <select class="ui fluid search dropdown" >
                    <option value="Filial Leave">Filial Leave</option>
                    <option value="SP">Domestic Emergency Leave</option>
                    <option value="VL">Maternity Leave</option>
                    <option value="FL">Rehabilitation Leave</option>
                    <option value="SL">Solo Parent Leave</option>
                    <option value="SP">Paternity Leave</option>
                    <option value="SP">Magna Carta Leave</option>
                    <option value="SP">Anti-VAWCY Leave</option>
                    <option value="SP">Study Leave</option>
                </select>
          </div>
          </template>
          <div class="field">
            <label>Applied Date:</label>
            <form class="two fields" @submit.prevent="cal()">
              <div class="field">
                <input type="date" name="" id="calen" required>
              </div>
              <div class="field">
                <input type="submit" class="ui button primary" value="ADD">
              </div>
            </form>
          </div>
          <div class="ui link list">
            <a class="item" v-for="(d,index) in selectedDate" :key="index">
              <span class="left floated like">
                  {{d}}
              </span>
              <span class="right floated">
                <i class="close icon" @click="slice_date(index)"></i>
              </span>          
            </a>
          </div>
          <br>
          <div class="field">
            <label>Remarks:</label>
            <textarea width="100%" v-model="remarks"></textarea>
          </div>
        </div>
      </div>
      <div class="actions">
        <div class="ui approve button positive" @click="saveLeave()">Save</div>
        <div class="ui button cancel negative">Close</div>
      </div>
    </div>
<!--   edit modal End   -->

<!--    open model    -->
 <div class="ui small modal" id="approveModal">
      <div class="header">
        <h3 class="ui header"> Approving Leave Application</h3>
      </div>
      <div class="content">
        <div class="ui form">

         <div class="two fields">
              <div class="field">
                <label>Control Number: HRMO-LEAVE-2020-0001</label>
            </div>
            <div class="field">
                <strong>Date Received: February 30, 2021</strong>
            </div>
          </div>

          <div class="two fields">
            <div class="field">
              <strong>Name of Applicant: Juan Dela Cruz</strong> 
            </div>
            <div class="field">
              <strong>Type of Leave: Sick Leave</strong> 
            </div>
          </div>

          <div class="two fields">
            <div class="field">
              <strong>Name of Applicant: Juan Dela Cruz</strong> 
            </div>
            <div class="field">
              <strong>Type of Leave: Sick Leave</strong> 
            </div>
          </div>

        </div>
        
      </div>
      <div class="actions">
        <div class="ui approve button positive" @click="saveLeave()">Approve</div>
        <div class="ui button cancel negative">Close</div>
      </div>
    </div>
 <!--   open modal End   -->

    <div class="ui medium header">Leave Admin Dashboard</div>
    <button class="ui positive button" id="addButton" onclick="showAddModal()">Add New</button>
    <template v-if="Logs.length">
    <table class="ui celled table gwd-table-16du">
      <thead>
        <tr>
            <th>Control Number</th>
            <th>Date Received</th>
            <th>Name of Applicant</th>
            <th>Date Applied</th>
            <th>Type of Leave</th>
            <th>Total Days</th>
            <th>Remarks</th>
            <th>Status</th>
            <th>Options</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(log,index) in Logs" :key="index">
          <td>{{ log.log_id }}
          </td>
          <td>{{ log.dateReceived }}</td>
          <td>{{ log.firstName}} {{ log.lastName}}</td>
          <td>{{ log.dateApplied }}</td>
          <td>{{ log.leaveType }}</td>
          <td>{{ log.totalDays }}</td>
          <td>{{ log.remarks }}</td>
          <td>{{ log.status }}</td>
          <td>
            <button class="circular ui icon button green" id="openButton" onclick="approveModal()">
              <i class="icon check"></i>
            </button>
            <button class="circular ui icon button red">
              <i class="icon close"></i>
            </button>
            <button class="circular ui icon button blue" id="editButton" onclick="showEditModal()">
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

    function showAddModal() {
      $("#addModal").modal('show');
    }
    function showEditModal() {
      $("#editModal").modal('show');
    }
    function approveModal() {
      $("#approveModal").modal('show');
    }
  </script>
  <script src="umbra/leaveManagement/leave.js"></script>

<?php
    require_once "footer.php";
?>