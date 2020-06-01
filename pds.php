
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
        <a class="item" data-tab="personal">Personal</a>
        <a class="item" data-tab="family">Family</a>
        <a class="item" data-tab="education">Education</a>
        <a class="item" data-tab="eligibility">Eligibility</a>
        <a class="item" data-tab="work_experience">Work Experiences</a>
        <a class="item" data-tab="voluntary_works">Voluntary Works</a>
        <a class="item" data-tab="trainings">Trainings</a>
        <a class="item active" data-tab="other_information">Other Information</a>
      </div>
      <div class="ui tab segment" data-tab="personal">
      <div class="ui tiny form">
    <h4 class="ui header">I. PERSONAL INFORMATION</h4>

    <i>Bio</i>
    <hr>
    <div class="four fields">
        <div class="field">
            <label for="">Surname:</label>
            <input type="text" placeholder="">
        </div>
        <div class="field">
            <label for="">Firstname:</label>
            <input type="text" placeholder="">
        </div>
        <div class="field">
            <label for="">Middlename:</label>
            <input type="text" placeholder="">
        </div>
        <div class="field">
            <label for="">Name extension:</label>
            <input type="text" placeholder="">
        </div>
    </div>
    <div class="fields">
        <div class="field">
            <label for="">Date of Birth:</label>
            <input type="date"> 
        </div>
        <div class="field">
            <label for="">Place of Birth:</label>
            <input type="text"> 
        </div>
        <div class="field">
            <label for="">Citizenship:</label>
            <input type="text"> 
        </div>
        <div class="field">
            <label for="">Sex:</label>
            <input type="text"> 
        </div>
        <div class="field">
            <label for="">Civil Status:</label>
            <input type="text"> 
        </div>
    </div>
    <div class="fields">
        <div class="field">
            <label for="">Height (m):</label>
            <input type="text"> 
        </div>
        <div class="field">
            <label for="">Weight (kg):</label>
            <input type="text"> 
        </div>
        <div class="field">
            <label for="">Blood Type:</label>
            <input type="text"> 
        </div>
    </div>
    <!-- <h5 class="ui dividing header">Government Agency Details:</h5> -->
    <i>Government Agency Details</i>
    <hr>
    <div class="five fields">
        <div class="field">
            <label for="">GSIS ID No:</label>
            <input type="text"> 
        </div>
        <div class="field">
            <label for="">PAG-IBIG ID No:</label>
            <input type="text"> 
        </div>
        <div class="field">
            <label for="">PHILHEALTH No:</label>
            <input type="text"> 
        </div>
        <div class="field">
            <label for="">SSS No:</label>
            <input type="text"> 
        </div>
        <div class="field">
            <label for="">TIN No:</label>
            <input type="text"> 
        </div>
    </div>
    <i>Residential Address</i> 
    <hr>
    <div class="three fields">
        <div class="field">
            <label for="">House/Block/Lot No.:</label>
            <input type="text">
        </div>
        <div class="field">
            <label for="">Street:</label>
            <input type="text">
        </div>
        <div class="field">
            <label for="">Subdivision/Village:</label>
            <input type="text">
        </div>
    </div>
    <div class="four fields">
        <div class="field">
            <label for="">Barangay:</label>
            <input type="text">
        </div>
        <div class="field">
            <label for="">City/Municipality:</label>
            <input type="text">
        </div>
        <div class="field">
            <label for="">Province:</label>
            <input type="text">
        </div>
        <div class="field">
            <label for="">Zip Code:</label>
            <input type="text">
        </div>
    </div>
    <i>Permanent Address</i> 
    <hr>
    <div class="three fields">
        <div class="field">
            <label for="">House/Block/Lot No.:</label>
            <input type="text">
        </div>
        <div class="field">
            <label for="">Street:</label>
            <input type="text">
        </div>
        <div class="field">
            <label for="">Subdivision/Village:</label>
            <input type="text">
        </div>
    </div>
    <div class="four fields">
        <div class="field">
            <label for="">Barangay:</label>
            <input type="text">
        </div>
        <div class="field">
            <label for="">City/Municipality:</label>
            <input type="text">
        </div>
        <div class="field">
            <label for="">Province:</label>
            <input type="text">
        </div>
        <div class="field">
            <label for="">Zip Code:</label>
            <input type="text">
        </div>
    </div>
    <i>Contact Details:</i>
    <hr>
    <div class="three fields">
        <div class="field">
            <label>Tel#:</label>
            <input type="text">
        </div>
        <div class="field">
            <label>Mobile#:</label>
            <input type="text">
        </div>
        <div class="field">
            <label>Email:</label>
            <input type="text">
        </div>
    </div>
</div>
      </div>
      <div class="ui tab segment" data-tab="family">
        <?php require 'pds_family.php';?>
      </div>
      <div class="ui tab segment" data-tab="education">
        <?php require 'pds_education.php';?>
      </div>
      <div class="ui tab segment" data-tab="eligibility">
        <?php require 'pds_eligibility.php'?>
      </div>
      <div class="ui tab segment" data-tab="work_experience">
        <?php require 'pds_work_experience.php'?>
      </div>
      <div class="ui tab segment" data-tab="voluntary_works">
        <?php require 'pds_voluntary.php'?>
      </div>
      <div class="ui tab segment" data-tab="trainings">
        <?php require 'pds_trainings.php'?>
      </div>
      <div class="ui tab segment active" data-tab="other_information">
        <?php require 'pds_other_information.php'?>
      </div>
    </div>
    <div class="ui tab" data-tab="service_records"></div>
    <div class="ui tab" data-tab="leave_records"></div>
  </div>
</div>

<script src="pds/config.js"></script>