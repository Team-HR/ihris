<?php
  if(!isset($_GET['id'])||$_GET['id']==""||$_GET['id']==0){
     header("location:plantilla.php");
  }
 $title = "Appointments"; require_once "header.php"; require_once "_connect.db.php";
 ?>
  <div id="app" style="background: white; margin-top:30px; width:95%;;margin-left:40px;padding:20px">
    <h2 class="ui dividing header" id="headerAppoint">Appointment for Administrative III - clerk 1</h2>  
    <div class="ui fluid action input" style="padding-bottom:20px" v-if="employ==''">
      <select class="ui search dropdown fluid" id="empList" v-model="pre_employ">
        <option value="">Search Employee</option>
        <option v-for="(emp,index) in Employees" :value="index">{{emp.lastName}} {{emp.firstName}} {{emp.middleName}} {{emp.extName}}</option>
      </select>
      <div class="ui button primary" @click="employ=String(pre_employ)">Confirm</div>
    </div>
    <form class="ui form " :class="waitLoad" id="appointments_form" data-id="<?=$_GET['id']?>" @submit.prevent="saveAppointment()">      
      <div class="four wide fields" v-if="employ!=''">
        <div class="field">
          <label>Employee Information <i class="edit icon green" @click="employ=''"></i></label>
          <input type="text" v-model="lastName" readonly>
        </div>    
        <div class="field">
          <label>&nbsp;</label>
          <input type="text" v-model="firstName" readonly>
        </div>    
        <div class="field">
          <label>&nbsp;</label>
          <input type="text"  v-model="middleName" readonly>
        </div>   
        <div class="field"> 
          <label>&nbsp;</label>
          <input type="text" readonly v-model='extName'> 
        </div>    
      </div>

      <h4 class="ui dividing header" style="color:#00000066">Plantilla Information</h4>
      <div class="four fields">        
          <div class="field">
            <label>Item No.</label>
            <input v-model="Plantilla['item_no']" readonly>
          </div>
          <div class="field">
            <label>Position</label>
            <input v-model="Plantilla['position']" readonly>
          </div>
          <div class="field">
            <label>Functional</label>  
            <input v-model="Plantilla['functional']" readonly>
          </div>
          <div class="field">
            <label>Department</label>  
            <input v-model="Plantilla['department']" readonly>
          </div>
      </div>
      <div class="five fields">
        <div class="field">
            <label>Step</label>
            <input v-model="Plantilla['step']" readonly>
        </div>
        <div class="field">
          <label> Salary Grade</label>
          <input v-model="Plantilla['salaryGrade']" readonly>
        </div>
        <div class="field">
          <label> Salary Schedule</label>
          <input v-model="Plantilla['schedule']" readonly>
        </div>
        <div class="field">
          <label>Monthly Salary</label>
          <input :value="'Php '+formatNumber(parseInt(Plantilla['monthly_salary']))" readonly>
        </div>
        <div class="field">
          <label>Annual Salary</label>
          <input :value="'Php '+formatNumber(parseInt(Plantilla['monthly_salary']*12))" readonly>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label>Vacated by:</label>
          <input :value="Plantilla['vac_lastName']+' '+Plantilla['vac_firstName']+' '+Plantilla['vac_middleName']+' '+Plantilla['vac_extName']" readonly>
        </div>
        <div class="field">
          <label>Reason of Vacancy</label>
          <input :value="Plantilla['reason_of_vacancy']" readonly>
        </div>
      </div>
      <h4 class="ui dividing header" style="color:#00000066">Appointment</h4>
      <div class="four fields">
        <div class="field">
          <label>Status of Appointment</label>
          <select id="status" class="ui fluid search selection dropdown" v-model="status_of_appointment" required>
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
          <input type="text" v-model="csc_authorized_official" required>
        </div>
        <div class="field">
          <label>Date of Signed by CSC:</label>
          <input type="date" v-model="date_signed_by_csc" required>
        </div>
        <div class="field">
          <label>Committee Chair</label>
          <select class="ui search dropdown" v-model="committee_chair" required>
              <option value="">Search Name</option>
              <option v-for="(comChair,index) in All_Employees" :value="comChair.employees_id">{{comChair.lastName}} {{comChair.firstName}}</option>
          </select>
        </div>
      </div>
      <div class="four fields">
        <div class="two fields">
          <div class="field">
            <label>Date of Appointment</label>
            <input type="date" v-model="date_of_appointment" required>
          </div>
          <div class="field">
            <label>Date of Assumption</label>
            <input type="date" v-model="date_of_assumption" required>
          </div>
        </div>
        <div class="field">
          <label>CSC MC NO.</label>
          <input type="text" v-model="csc_mc_no" required>
        </div>
        <div class="field">
          <label>HRMO</label>
          <select class="ui search dropdown" v-model="HRMO" required>
              <option value="">Search Name</option>
              <option v-for="(hr,index) in All_Employees" :key="index" :value="hr.employees_id">{{hr.lastName}} {{hr.firstName}}</option>
          </select>
        </div>
        <div class="two fields">
          <div class="field">
            <label>Office Assignment</label>
            <input type="text" v-model="office_assignment" required>
          </div>
          <div class="field">
            <label>Probationary Period</label>
            <input type="text" v-model="probationary_period" required>
          </div>
        </div>
      </div>
      <div class="four fields">
        <div class="field">
          <label>Nature of appointment</label>
          <select class="ui search dropdown" v-model="nature_of_appointment" required>
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
          <input type="date" v-model="date_of_signing" required>
        </div>
        <div class="field">
          <label>Deliberation Date From:</label>
          <input type="date" v-model="deliberation_date_from" required>
        </div>
        <div class="field">
          <label>To:</label>
          <input type="date" v-model="deliberation_date_to" required>
        </div>
      </div>
      <div class="field four wide">
        <label>Date of Last Promotion</label>
        <input type="date" v-model="date_of_last_promotion">
      </div>
      <h4 class="ui dividing header" style="color:#00000066">Publication & Other Information</h4>
      <div class="four fields">
        <div class="field">
          <label>Published At:</label>
          <input type="text" v-model="published_at" required>
        </div>
        <div class="field">
          <label>Posted In</label>
          <input type="text" v-model="posted_in" required>
        </div>
          <div class="field">
            <label>Type of Gov ID</label>
            <input type="text" v-model="govId_type" required>
          </div>
        <div class="two fields">
          <div class="field">
            <label>Gov ID No.</label>
            <input type="text" v-model="govId_no" required>
          </div>
          <div class="field">
            <label>Date Issued:</label>
            <input type="date" v-model="govId_issued_date" required>
          </div>
        </div>
      </div>
      <div class="five fields">
        <div class="field">
          <label>Posted Date:</label>
          <input type="date" v-model="posted_date" required>
        </div>
        <div class="field">
          <label>CSC Release Date:</label>
          <input type="date" v-model="csc_release_date" required>
        </div>
        <div class="field">
          <label>Sworn Date:</label>
          <input type="date" v-model="sworn_date" required>
        </div>        
        <div class="field">
          <label>Cert. Issued Date:</label>
          <input type="date" v-model="cert_issued_date" required>
        </div>
        <div class="field">
          <label>Casual Appointment Date:</label>
          <input type="date" v-model="casual_promotion" required>
        </div>
      </div>
      <input type="submit" class="ui button primary" value="Save">
    </form>
  </div>
  <script src="umbra/appointments/config.js"></script>  
<?php require_once "footer.php";?>
