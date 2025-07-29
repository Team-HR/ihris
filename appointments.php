<?php
if (!isset($_GET['id']) || $_GET['id'] == "" || $_GET['id'] == 0) {
  header("location:plantilla.php");
}

$title = "Appointments";
require_once "header.php";
require_once "_connect.db.php";
?>
<style>
  .pInfoTable tr td {
    padding: 5px;
    border-color: #dbdbdb;
  }

  .tLabel {
    background-color: #d6d6d6;
  }
</style>
<div id="app" style="
    background: #efefef;
    margin-top: 30px;
    width: 95%;
    margin-left: 40px;
    padding: 20px;
  ">
  <template>
    <h2 class="ui dividing header" id="headerAppoint">
      Appointment for {{ Plantilla["position"] }} - {{ Plantilla["item_no"] }}
      <!-- #plantilla: {{Plantilla}} -->
    </h2>

    <form class="ui form" :class="waitLoad" id="appointments_form" data-id="<?= $_GET['id'] ?>" @submit.prevent="saveAppointment()">
      <!-- <input type="text" v-model="reason_of_vacancy" :value="promotion"> -->
      <div class="field" style="width: 500px;" :style="!isVacant ? 'display:none;':''">
        <label>Select Appointee:</label>
        <select class="ui search dropdown fluid clearable" id="empList" v-model="employees_id" required>
          <option value="">Search Employee</option>
          <option v-for="(emp,index) in Employees" :value="emp.employees_id">
            {{ emp.lastName }} {{ emp.firstName }} {{ emp.middleName }}
            {{ emp.extName }}
          </option>
        </select>
      </div>
      <div class="field" style="width: 500px;" :style="!isVacant ? '':'display:none;'">
        <label>Appointee:</label>
        {{incumbentName}}
      </div>

      <h4 class="ui dividing header" style="color: #00000066">
        Plantilla Information
      </h4>

      <table class="pInfoTable" border="1" style="border-collapse: collapse;">
        <tr>
          <td class="tLabel" style="min-width: 150px;">Item No.:</td>
          <td style="min-width: 200px;"><input name="itemNo" v-model="plantillaEdit.itemNo" style="background-color: white;"></td>
          <td class="tLabel" style="min-width: 150px;">Position:</td>
          <td style="min-width: 200px;">
            <select name="positionDropdown" class="ui fluid search selection dropdown" id="positionDropdown" v-model="plantillaEdit.position_id">
              <option value="">Select Position</option>
              <template v-for="position in positionOptions">
                <option :key="position.id" :value="position.id">{{position.position}}{{position.functional ? ' --- (' + position.functional + ')' : ''}}</option>
              </template>
            </select>
          </td>
        </tr>
        <tr>
          <td class="tLabel">Step:</td>
          <td><input name="step" v-model="plantillaEdit.step" type="number" min="1" max="8"></td>
          <td class="tLabel">Department:</td>
          <td>
            <select name="departmentDropdown" class="ui fluid search selection dropdown" id="departmentDropdown" v-model="plantillaEdit.department_id">
              <option value="">Select Department</option>
              <template v-for="department in departmentOptions">
                <option :key="department.id" :value="department.id">{{department.department}}</option>
              </template>
            </select>
          </td>
        </tr>
        <tr>
          <td class="tLabel">Salary Schedule:</td>
          <td><input name="salarySchedule" value="1st Class" readonly style="background: #efefef; border: none; border: none;"></td>
          <td class="tLabel"> Salary Grade:</td>
          <td><input name="salaryGrade" v-model="plantillaEdit.sg" readonly style="background: #efefef; border: none;"></td>
        </tr>
        <tr>
          <td class="tLabel">Monthly Salary:</td>
          <td><input name="monthlySalary" v-model="plantillaEdit.monthlySalary" readonly style="background: #efefef; border: none;"></td>
          <td class="tLabel">Annual Salary:</td>
          <td><input name="annualSalary" v-model="plantillaEdit.annualSalary" readonly style="background: #efefef; border: none;"></td>
        </tr>
        <tr>
          <td class="tLabel">Vacated by:</td>
          <td><input name="vacatedByInput" :value="Plantilla['vac_lastName']+' '+Plantilla['vac_firstName']+' '+Plantilla['vac_middleName']+' '+Plantilla['vac_extName']" readonly style="background: #efefef; width: 512px; border: none;"></td>
          <td class="tLabel">Reason of Vacancy:</td>
          <td><input name="reasonForVacancyInput" :value="Plantilla['reason_of_vacancy']" readonly style="background: #efefef; border: none;"></td>
        </tr>
      </table>

      <!-- Plantilla Editor Start -->
      <!-- <div class="ui form" style="padding: 20px;">

        <div class="fields">
          <div class="field" style="_width: 200px;">
            <label for="itemNo">Item No:</label>
            <input name="itemNo" v-model="plantillaEdit.itemNo" style="background-color: white;">
          </div>
          <div class="field">
            <label for="positionDropdown">Position & Functional:</label>
            <select name="positionDropdown" class="ui fluid search selection dropdown" id="positionDropdown" v-model="plantillaEdit.position_id">
              <option value="">Select Position</option>
              <template v-for="position in positionOptions">
                <option :key="position.id" :value="position.id">{{position.position}}{{position.functional ? ' --- (' + position.functional + ')' : ''}}</option>
              </template>
            </select>
          </div>
          <div class="field">
            <label for="departmentDropdown">Department:</label>
            <select name="departmentDropdown" class="ui fluid search selection dropdown" id="departmentDropdown" v-model="plantillaEdit.department_id">
              <option value="">Select Department</option>
              <template v-for="department in departmentOptions">
                <option :key="department.id" :value="department.id">{{department.department}}</option>
              </template>
            </select>
          </div>
        </div>
        <div class="fields">

          <div class="field">
            <label for="stepDropdown">Step:</label>
            <input name="step" v-model="plantillaEdit.step" type="number" min="1" max="8">
          </div>

          <div class="field">
            <label for="salaryGrade">Salary Grade:</label>
            <input name="salaryGrade" v-model="plantillaEdit.sg" readonly style="background: #efefef;">
          </div>

          <div class="field">
            <label for="salarySchedule">Salary Schedule:</label>
            <input name="salarySchedule" value="1st Class" readonly style="background: #efefef;">
          </div>

          <div class="field">
            <label for="monthlySalary">Monthly Salary:</label>
            <input name="monthlySalary" v-model="plantillaEdit.monthlySalary" readonly style="background: #efefef;">
          </div>

          <div class="field">
            <label for="annualSalary">Annual Salary:</label>
            <input name="annualSalary" v-model="plantillaEdit.annualSalary" readonly style="background: #efefef;">
          </div>

        </div>
        <div class="fields">
          <div class="field">
            <label for="vacatedByInput">Vacated by:</label>
            <input name="vacatedByInput" :value="Plantilla['vac_lastName']+' '+Plantilla['vac_firstName']+' '+Plantilla['vac_middleName']+' '+Plantilla['vac_extName']" readonly style="background: #efefef; width: 512px;">
          </div>

          <div class="field">
            <label for="reasonForVacancyInput">Reason of Vacancy:</label>
            <input name="reasonForVacancyInput" :value="Plantilla['reason_of_vacancy']" readonly style="background: #efefef;">
          </div>
        </div> -->
      <!-- Plantilla Editor End -->
      <br>
      <button type="button" @click="savePlantillaEdit()" class="ui primary button"><i class="ui icon save"></i> Save Plantilla Info</button>

</div>
<!-- <select name="stepDropdown" class="ui fluid search selection dropdown" v-model="plantillaEdit.step" id="stepDropdown">
        <option value="">Select Department</option>
        <template v-for="step,i in stepOptions">
          <option :key="i" :value="step">{{step}}</option>
        </template>
      </select> -->

<h4 class="ui dividing header" style="color: #00000066">Appointment</h4>
<div class="four fields">
  <div class="field">
    <label>Status of Appointment</label>
    <select id="status_of_appointment" class="ui fluid search selection dropdown" v-model="status_of_appointment">
      <option value="">---</option>
      <option value="elective">Elective</option>
      <option value="permanent">Permanent</option>
      <option value="casual">Casual</option>
      <option value="co-term">Co-term</option>
      <option value="temporary">Temporary</option>
      <option value="contactual">Contractual</option>
      <option value="substitute">Substitute</option>
    </select>
  </div>
  <div class="field">
    <label>CSC Authorized Official:</label>
    <input type="text" v-model="csc_authorized_official" />
  </div>
  <div class="field">
    <label>Date of Signed by CSC:</label>
    <input type="date" v-model="date_signed_by_csc" />
  </div>
  <div class="field">
    <label>Committee Chair</label>
    <select id="committee_chair" class="ui search dropdown" v-model="committee_chair">
      <option value="">Search Name</option>
      <option v-for="(comChair,index) in All_Employees" :value="comChair.employees_id">
        {{ comChair.lastName }} {{ comChair.firstName }}
      </option>
    </select>
  </div>
</div>
<div class="four fields">
  <div class="two fields">
    <div class="field">
      <label>Date of Appointment</label>
      <input type="date" v-model="date_of_appointment" />
    </div>
    <div class="field">
      <label>Date of Assumption</label>
      <input type="date" v-model="date_of_assumption" />
    </div>
  </div>
  <div class="two fields">
    <div class="field">
      <label>CSC MC NO.</label>
      <input type="text" v-model="csc_mc_no" />
    </div>
    <div class="field">
      <label>Series No.</label>
      <input type="text" v-model.number="series_no" />
    </div>
  </div>
  <div class="field">
    <label>HRMO</label>
    <select id="HRMO" class="ui search dropdown" v-model="HRMO">
      <option value="">Search Name</option>
      <option v-for="(hr,index) in All_Employees" :key="index" :value="hr.employees_id">
        {{ hr.lastName }} {{ hr.firstName }}
      </option>
    </select>
  </div>
  <div class="two fields">
    <div class="field">
      <label>Office Assignment</label>
      <input type="text" v-model="office_assignment" />
    </div>
    <div class="field">
      <label>Probationary Period</label>
      <input type="text" v-model="probationary_period" />
    </div>
  </div>
</div>
<div class="four fields">
  <div class="field">
    <label>Nature of appointment</label>
    <select id="nature_of_appointment" class="ui search dropdown" v-model="nature_of_appointment">
      <option value="">---</option>
      <option value="original">Original</option>
      <option value="promotion">Promotion</option>
      <option value="transfer">Transfer</option>
      <option value="re-employment">Re-employment</option>
      <option value="re-appointment">Re-appointment</option>
      <option value="renewal">Renewal</option>
      <option value="demotion">Demotion</option>
    </select>
  </div>
  <div class="field">
    <label>Date of Signing</label>
    <input type="date" v-model="date_of_signing" />
  </div>
  <div class="field">
    <label>Deliberation Date From:</label>
    <input type="date" v-model="deliberation_date_from" />
  </div>
  <div class="field">
    <label>To:</label>
    <input type="date" v-model="deliberation_date_to" />
  </div>
</div>
<div class="field four wide">
  <label>Date of Last Promotion</label>
  <input type="date" v-model="date_of_last_promotion" />
</div>
<h4 class="ui dividing header" style="color: #00000066">
  Publication & Other Information
</h4>
<div class="four fields">
  <div class="field">
    <label>Published At:</label>
    <input type="text" v-model="published_at" />
  </div>
  <div class="field">
    <label>Posted In</label>
    <input type="text" v-model="posted_in" />
  </div>
  <div class="field">
    <label>Type of Gov ID</label>
    <input type="text" v-model="govId_type" />
  </div>
  <div class="two fields">
    <div class="field">
      <label>Gov ID No.</label>
      <input type="text" v-model="govId_no" />
    </div>
    <div class="field">
      <label>Date Issued:</label>
      <input type="date" v-model="govId_issued_date" />
    </div>
  </div>
</div>
<div class="five fields">
  <div class="field">
    <label>Posted Date From:</label>
    <input type="date" v-model="posted_date_from" />
  </div>
  <div class="field">
    <label>Posted Date To:</label>
    <input type="date" v-model="posted_date_to" />
  </div>
  <div class="field">
    <label>CSC Release Date:</label>
    <input type="date" v-model="csc_release_date" />
  </div>
  <div class="field">
    <label>Sworn Date:</label>
    <input type="date" v-model="sworn_date" />
  </div>
  <div class="field">
    <label>Cert. Issued Date:</label>
    <input type="date" v-model="cert_issued_date" />
  </div>
  <div class="field">
    <label>Casual Appointment Date:</label>
    <input type="date" v-model="casual_promotion" />
  </div>
</div>
<button type="submit" class="ui button primary"><i class="ui save icon"></i> Save Appointment</button>
<!-- <input type="submit" class="ui button primary" value="Save"/> -->
</form>
</template>
</div>
<script src="umbra/appointments/config.js"></script>
<?php require_once "footer.php"; ?>