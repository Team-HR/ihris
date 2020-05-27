
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


<?php require 'pds.php';?>

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