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
    <h2 class="ui dividing header" id="headerAppoint" style="padding: 5px;">
      <div style="display: inline-block;">Appointment for {{ Plantilla["position"] }} - {{ Plantilla["item_no"] }}</div>

      <a :href="`/forms/appointment.CS_form33.pdf.php?appointment_id=${Plantilla['incumbent']}`" target="_blank" class="ui basic button"><i class="ui icon print"></i> Print</a>
    </h2>

    <form class="ui form" :class="waitLoad" id="appointments_form" data-id="<?= $_GET['id'] ?>" @submit.prevent="saveAppointment()">
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
          <td><input name="itemNo" v-model="plantillaEdit.itemNo" style="background-color: white;"></td>
          <td class="tLabel" style="min-width: 150px;">Position:</td>
          <td>
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
          <td><input name="vacatedByInput" :value="Plantilla['vac_lastName']+' '+Plantilla['vac_firstName']+' '+Plantilla['vac_middleName']+' '+Plantilla['vac_extName']" readonly style="background: #efefef; border: none;"></td>
          <td class="tLabel">Reason of Vacancy:</td>
          <td><input name="reasonForVacancyInput" :value="Plantilla['reason_of_vacancy']" readonly style="background: #efefef; border: none;"></td>
        </tr>
      </table>
      <br>
      <button type="button" @click="savePlantillaEdit()" class="ui primary button"><i class="ui icon save"></i> Save Plantilla Info</button>
</div>

<h4 class="ui dividing header" style="color: #00000066">Appointment</h4>
<table class="pInfoTable" border="1" style="border-collapse: collapse;">
  <tr>
    <td class="tLabel">Date of Appointment:</td>
    <td><input type="date" v-model="date_of_appointment" /></td>
    <td class="tLabel">Status of Appointment:</td>
    <td>
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
    </td>
  </tr>
  <tr>
    <td class="tLabel">Nature of Appointment:</td>
    <td>
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
    </td>
    <td class="tLabel">Office Assignment:</td>
    <td><input type="text" v-model="office_assignment" /></td>
  </tr>
  <tr>
    <td class="tLabel">HRMPSB Chairman:</td>
    <td>
      <select id="committee_chair" class="ui search dropdown" v-model="committee_chair">
        <option value="">Search Name</option>
        <option v-for="(comChair,index) in All_Employees" :value="comChair.employees_id">
          {{ comChair.lastName }} {{ comChair.firstName }}
        </option>
      </select>
    </td>
    <td class="tLabel">Probation Period:</td>
    <td><input type="text" v-model="probationary_period" /></td>
  </tr>
  <tr>
    <td class="tLabel" colspan="4">Assessment Date</td>
    <!-- <td colspan="3"></td> -->
  </tr>
  <tr>
    <td class="tLabel" style="text-align: right;">From:</td>
    <td><input type="date"></td>
    <td class="tLabel" style="text-align: right;">To:</td>
    <td><input type="date"></td>
  </tr>
  <tr>
    <td class="tLabel">Deliberation Date:</td>
    <td><input type="date" v-model="deliberation_date_from" /></td>
    <td class="tLabel">Sworn Date:</td>
    <td><input type="date" v-model="deliberation_date_from" /></td>
  </tr>
</table>

<!-- 
<div class="four fields">
  <div class="field">
    <label>CSC Authorized Official:</label>
    <input type="text" v-model="csc_authorized_official" />
  </div>
  <div class="field">
    <label>Date of Signed by CSC:</label>
    <input type="date" v-model="date_signed_by_csc" />
  </div>
</div>
<div class="four fields">
  <div class="two fields">
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
</div>
<div class="four fields">
  <div class="field">
    <label>Date of Signing</label>
    <input type="date" v-model="date_of_signing" />
  </div>
  <div class="field">
    <label>To:</label>
    <input type="date" v-model="deliberation_date_to" />
  </div>
</div>
<div class="field four wide">
  <label>Date of Last Promotion</label>
  <input type="date" v-model="date_of_last_promotion" />
</div> -->



<h4 class="ui dividing header" style="color: #00000066">
  Publication Info
</h4>

<table class="pInfoTable" border="1" style="border-collapse: collapse;">
  <tr>
    <td class="tLabel" style="width: 150px;">Published at:</td>
    <td>
      <input type="text" v-model="published_at" />
    </td>
    <td class="tLabel" style="width: 150px;">Posted in:</td>
    <td>
      <input type="text" v-model="posted_in" />
    </td>
  </tr>
  <tr>
    <td class="tLabel" colspan="4">Posted Date:</td>
  </tr>
  <tr>
    <td class="tLabel" style="text-align: right;">From:</td>
    <td>
      <input type="date" v-model="posted_date_from" />
    </td>
    <td class="tLabel" style="text-align: right;">To:</td>
    <td>
      <input type="date" v-model="posted_date_to" />
    </td>
  </tr>
</table>

<h4 class="ui dividing header" style="color: #00000066">
  Other Info
</h4>



<table class="pInfoTable" border="1" style="border-collapse: collapse;">
  <tr>
    <td class="tLabel" style="width: 150px;">Type of Gov ID:</td>
    <td>
      <input type="text" v-model="govId_type" />
    </td>
    <td class="tLabel" style="width: 150px;">Gov ID No.:</td>
    <td>
      <input type="text" v-model="govId_no" />
    </td>
  </tr>
  <tr>
    <td class="tLabel">Date Issued:</td>
    <td>
      <input type="date" v-model="govId_issued_date" />
    </td>
    <td class="tLabel">Address :</td>
    <td>
      <input type="text" v-model="address" />
    </td>
  </tr>
</table>

<!-- <div class="five fields">
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
</div> -->
<button type="submit" class="ui button primary" style="margin-top: 10px;"><i class="ui save icon"></i> Save Appointment</button>
</form>
</template>
</div>
<script src="umbra/appointments/config.js"></script>
<?php require_once "footer.php"; ?>