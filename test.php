
<div class="ui segment grid" id="pds-app">
  <div class="three wide column">
    <div id="pim-menu" class="ui secondary vertical pointing menu fluid">
      <a class="item" data-tab="appointments">
        Appointment
      </a>
      <a class="item active" data-tab="pds">
        PDS
      </a>
      <a class="item" data-tab="service_records">
        Service Records
      </a>
      <a class="item" data-tab="leave_records">
        Leave Records
      </a>
    </div>
  </div>
  <div class="thirteen wide stretched column">
    <div class="ui tab" data-tab="appointments"></div>
    <div class="ui tab active" data-tab="pds">
      <div class="ui pointing secondary blue menu fluid" id="pds">
        <a class="item active" data-tab="personal">Personal</a>
        <a class="item" data-tab="family">Family</a>
        <a class="item" data-tab="education">Education</a>
        <a class="item" data-tab="eligibility">Eligibility</a>
        <a class="item" data-tab="work_experience">Work Experiences</a>
        <a class="item" data-tab="voluntary_works">Voluntary Works</a>
        <a class="item" data-tab="trainings">Trainings</a>
        <a class="item" data-tab="other_information">Other Information</a>
      </div>
      <div class="ui tab segment active" data-tab="personal">

<h5>PERSONAL INFORMATION</h5>
<hr>


<div class="ui form">
  <div class="fields">
    <div class="two wide field">
      <label for="">Employee ID:</label>
      <input type="text" placeholder="ID" v-model="employee.employee_id">
    </div>
  </div>
  <div class="fields">
    <div class="field">
      <label for="">Last Name:</label>
      <input type="text" placeholder="Last Name" v-model="employee.lastName">
    </div>
    <div class="field">
      <label for="">First Name:</label>
      <input type="text" placeholder="First Name" v-model="employee.firstName">
    </div>
    <div class="field">
      <label for="">Middle Name:</label>
      <input type="text" placeholder="Middle Name" v-model="employee.middleName">
    </div>
    <div class="field">
      <label for="">Ext Name:</label>
      <input type="text" placeholder="Extension" v-model="employee.extName">
    </div>
  </div>
  <div class="fields">
    <div class="field">
      <label for="">Birthdate:</label>
      <input type="date">
    </div>
    <div class="field">
      <label for="">Birthplace:</label>
      <input type="text" placeholder="Birthplace">
    </div>
    <div class="field">
      <label for="">Gender:</label>
      <input type="text" v-model="employee.gender" placeholder="Gender"> 
    </div>
  </div>
</div>






      </div>
      <div class="ui tab segment" data-tab="family">
        Family
      </div>
      <div class="ui tab segment" data-tab="education">
        Education
      </div>
      <div class="ui tab segment" data-tab="eligibility">
        Elligibility
      </div>
      <div class="ui tab segment" data-tab="work_experience">
        Work Experiences
      </div>
      <div class="ui tab segment" data-tab="trainings">
        Trainings
      </div>
      <div class="ui tab segment" data-tab="voluntary_works">
        Voluntary Works
      </div>
      <div class="ui tab segment" data-tab="other_information">
        Other Information
      </div>
    </div>
    <div class="ui tab" data-tab="service_records"></div>
    <div class="ui tab" data-tab="leave_records"></div>
  </div>
</div>

<script src="pds/config.js"></script>