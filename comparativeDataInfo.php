<?php

$title = "Comparative Data";
require "_connect.db.php";
require "header.php";

if ($rspvac_id = $_GET["rspvac_id"]) {

  $sql = "SELECT * FROM `rsp_vacant_positions` WHERE `rspvac_id` = ?";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("i", $rspvac_id);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($rspvac_id, $positiontitle, $itemNo, $sg, $office, $dateVacated, $dateOfInterview, $education, $training, $experience, $eligibility, $datetime_added);
  $stmt->fetch();
  $stmt->close();
}
?>

<script type="text/javascript">
  $(document).ready(function() {
    $("#table_search").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#tableBody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

    $(load);
    $("#sortYear").dropdown();
    $('#officeDropdown').dropdown();
  });

  function load() {
    $.post('comparativeDataInfo_proc.php', {
      load: true,
      rspvac_id: <?= $rspvac_id ?>
    }, function(data) {
      arr = JSON.parse(data);
      $("#itemNoTitle").html(arr.itemNo);
      $("#positiontitle").html(arr.position);
      $("#educationTitle").html(arr.education);
      $("#officeTitle").html(arr.office);
      $("#trainingTitle").html(arr.training);
      $("#experienceTitle").html(arr.experience);
      $("#eligibilityTitle").html(arr.eligibility);
    });

  }

  function dateInterviewed(id, interviewed) {
    // alert(id)
    $("#inputDateInterviewed").val(interviewed);

    $('#dateInterviewedModal').modal({
      closable: false,
      onApprove: function() {
        // alert(id);
        $.post('comparativeDataInfo_proc.php', {
          dateInterviewed: true,
          id: id,
          date: $("#inputDateInterviewed").val()
        }, function(data, textStatus, xhr) {
          loadList();
        });

      }
    }).modal("show");
  }
</script>
<div class="ui mini modal" id="dateInterviewedModal">
  <div class="header">
    Date Interviewed
  </div>
  <div class="content">
    <div class="ui fluid input">
      <input type="date" id="inputDateInterviewed">
    </div>

  </div>
  <div class="actions">
    <div class="ui mini basic button deny">Cancel</div>
    <div class="ui mini basic button green approve">Save</div>
  </div>
</div>


<!-- <div class="ui container" style="padding:/* 20px*/;"> -->
<div class="ui containerA" style="padding-left: 20px; padding-right: 20px;">
  <div class="printOnly" style="padding-top: 5px !important;"></div>
  <div class="ui borderless blue inverted mini menu">
    <div class="left item" style="margin-right: 0px !important;">
      <button onclick="window.location.href='comparativeData.php';" class="blue ui icon button noprint" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
    </div>
    <div class="item">
      <h3><i class="pie chart icon"></i> Comparative Data <i class="caret right icon"></i> <?= $positiontitle; ?></h3>
    </div>

    <div class="right item noprint">

      <button onclick="print()" class="blue ui icon button" title="Print" style="margin-right: 5px;">
        <i class="icon print"></i> Print
      </button>
    </div>
  </div>

  <!-- <div class="ui segments"> -->
  <style type="text/css">
    .actives {
      text-align: right !important;
      width: 175px;
      background-color: #f2f2f2;
      color: #4075a9;
    }

    .ui.tab.segment {
      min-height: 300px;
    }
  </style>

  <table class="ui very compact small celled table printCompactText" style="font-size: 14px;">
    <tr>
      <td class="actives">VACANT POSITION:</td>
      <td id="positiontitle"><i style="color: grey;">n/a</i></td>
      <td class="actives">CSC ITEM NO:</td>
      <td id="itemNoTitle"><i style="color: grey;">n/a</i></td>
    </tr>
    <tr>
      <td class="actives">EDUCATION:</td>
      <td id="educationTitle"><i style="color: grey;">n/a</i></td>
      <td class="actives">OFFICE:</td>
      <td id="officeTitle"><i style="color: grey;">n/a</i></td>
    </tr>
    <tr>
      <td class="actives">EXPERIENCE:</td>
      <td colspan="3" id="experienceTitle"><i style="color: grey;">n/a</i></td>
    </tr>
    <tr>
      <td class="actives">TRAINING:</td>
      <td colspan="3" id="trainingTitle"><i style="color: grey;">n/a</i></td>
    </tr>
    <tr>
      <td class="actives">ELIGIBILITY:</td>
      <td colspan="3" id="eligibilityTitle"><i style="color: grey;">n/a</i></td>
    </tr>
  </table>

  <style type="text/css">
    .heads {
      padding: 2px !important;
    }

    .text-valign-top {
      vertical-align: top !important;
    }
  </style>


  <div id="applicants_vue_app">
    <button @click="addApplicant()" class="ui tiny green button noprint" title="Add applicant to the list"><i class="icon add"></i> Add Applicant</button>

    <table id="trTable" class="ui blue selectable structured celled very compact table printCompactText" style="font-size: 12px;">
      <thead>
        <tr style="text-align: center;">
          <th class="heads">No.</th>
          <th class="heads">Name</th>
          <th class="heads">Age</th>
          <th class="heads">Gender</th>
          <th class="heads">Years in Service</th>
          <th class="heads">Civil Status</th>
          <th class="heads">Education</th>
          <th class="heads">Training</th>
          <th class="heads">Experience</th>
          <th class="heads">Eligibility</th>
          <th class="heads">Awards, Citations<br>Received</th>
          <th class="heads">Records <br>of<br> Infractions</th>
          <th class="heads noprint"></th>
        </tr>
      </thead>
      <tbody id="tableBody_">
        <tr v-for="(applicant, no) in applicants" :key="applicant.applicant_id">
          <td>{{no+1}}.</td>
          <td class="text-valign-top">{{applicant.name}}</td>
          <td class="text-valign-top">{{applicant.age}}</td>
          <td class="text-valign-top">{{applicant.gender}}</td>
          <td class="text-valign-top">
            <div v-if="applicant.years_of_service_gov.length > 0">
              <b>Government:</b>
              <div v-for="(yos, k) in applicant.years_of_service_gov" :key="k">
                {{`* ${yos.status}: ${yos.num_years}`}}
              </div>
            </div>
            <div v-if="applicant.years_of_service_priv.length > 0">
              <b>Private:</b>
              <div v-for="(yos, k) in applicant.years_of_service_priv" :key="k">
                {{`* ${yos.status}: ${yos.num_years}`}}
              </div>
            </div>
          </td>
          <td class="text-valign-top">
            {{applicant.civil_status}}
          </td>
          <td class="text-valign-top">
            {{applicant.education}}
          </td>
          <td class="text-valign-top">
            <div v-for="(training,k) in applicant.trainings" :key="k">{{`* ${training}`}}</div>
          </td>
          <td class="text-valign-top">
            <div v-for="(experience, k) in applicant.experiences" :key="k">
              * <b>{{experience.company}}</b> <i>as</i> <b style="color: green;">{{experience.title}}</b> (From: {{experience.from}} To: {{experience.to}})
            </div>
          </td>
          <td class="text-valign-top">
            <!-- {{applicant.eligibility}} -->
            <div v-for="(eligibility, k) in applicant.eligibilities" :key="k">
              * {{eligibility}}
            </div>
          </td>
          <td class="text-valign-top">
            <!-- {{applicant.awards}} -->
            <div v-for="(award, k) in applicant.awards" :key="k">
              * {{award}}
            </div>
          </td>
          <td class="text-valign-top">
            <!-- {{applicant.records_infractions}} -->
            <div v-for="(record, k) in applicant.record_of_infractions" :key="k">
              * {{record}}
            </div>
          </td>
          <td class="noprint" style="width: 50px;">

            <div class="ui mini basic icon buttons">
              <button class="ui positive button" title="Edit" @click="editApplicant(applicant)"><i class="icon edit"></i></button>
              <div class="or"></div>
              <button class="ui negative button" title="Delete" @click="unlistApplicant(applicant.id)"><i class="icon trash"></i></button>
            </div>

          </td>
        </tr>
        <!-- <tr id="loading_el">
          <td colspan="13" style="text-align: center; font-size: 32px; color: lightgrey; padding: 100px;">
            <img src="assets/images/loading.gif" style="height: 50px; margin-top: -100px;">
            <br>
            <span>Fetching data...</span>
          </td>
        </tr> -->
      </tbody>
    </table>
    <!-- </div> -->


    <!-- modals start -->

    <div class="ui tiny modal" id="addApplicant">
      <div class="ui blue header"> <i class="icon blue circle user"></i> Add Applicant</div>
      <div class="content">
        <form @submit.prevent="addNewApplicantBtn ? addNewApplicant(): false" id="applicantSearchForm">
          <div class="ui search" id="addApplicantSearch">
            <div class="ui fluid icon input">
              <input v-model="applicant.name" id="searchInput" class="prompt" type="text" placeholder="Add applicant...">
              <i class="search icon"></i>
            </div>
            <div class="results"></div>
          </div>
        </form>
      </div>
      <div class="actions">
        <button form="applicantSearchForm" v-if="addNewApplicantBtn" class="ui mini basic green button"><i class="icon add"></i>Add</button>
        <div class="ui mini basic button deny"><i class="icon cancel"></i>Cancel</div>
      </div>
    </div>

    <div class="ui mini modal" id="deleteModal">
      <div class="ui blue header"><i class="icon trash"></i> Unlist Applicant?</div>
      <div class="content">
        <p><span><i class="icon big blue warning"></i></span> Are you sure you want to unlist this applicant?</p>
      </div>
      <div class="actions">
        <button class="ui tiny basic button approve"><i class="icon check"></i>Yes</button>
        <button class="ui tiny basic button deny"><i class="icon cancel"></i>No</button>
      </div>
    </div>

    <!-- 
#
#
#  Add/Edit applicant form start
# 
#
#
 -->

    <div class="ui fullscreen modal" id="addNewModal" style="background-color: lightgrey !important;">
      <div class="ui blue header">Add/Edit Applicant</div>
      <div class="content">
        <div class="ui form">
          <!-- personal information start -->
          <h3 class="ui dividing blue header">Personal Information</h3>
          <div class="field">
            <label>Name:</label>
            <input v-model="applicant.name" class="dataInput" type="text" name="name" placeholder="Enter fullname of applicant...">
          </div>
          <div class="field">
            <label>Age:</label>
            <input v-model="applicant.age" class="dataInput" type="number" name="age" placeholder="Enter age...">
          </div>
          <div class="field">
            <label>Gender:</label>
            <select id="gender_dropdown" v-model="applicant.gender">
              <option value="">Gender</option>
              <option value="Female">Female</option>
              <option value="Male">Male</option>
            </select>
          </div>
          <div class="field">
            <label>Civil Status:</label>
            <select id="civil_status_dropdown" v-model="applicant.civil_status" class="dataInput" class="ui compact dropdown">
              <option value="">Civil Status</option>
              <option value="Single">Single</option>
              <option value="Married">Married</option>
              <option value="Annulled">Annulled</option>
              <option value="Widowed">Widowed</option>
            </select>
          </div>
          <h3 class="ui dividing blue header">Education</h3>
          <div class="field">
            <input v-model="applicant.education" class="dataInput" type="text" name="education" placeholder="Enter the highest degree earned...">
          </div>

          <h3 class="ui dividing blue header">Trainings</h3>
          <form @submit.prevent="add_new_training()">
            <input v-model="new_training" class=" " type="text" placeholder="Enter training... (number of hours)">
            <div class="ui action fluid input" v-for="(training, k) in applicant.trainings" :key="k" style="margin-top: 2px;">
              <button type="button" class="ui icon button basic" :class="k == 0 ?'disabled':''" @click="move_up_experience(k,applicant.trainings)"><i class="ui arrow up icon"></i></button>
              <button type="button" class="ui icon button basic" :class="applicant.trainings.length-1 == k ?'disabled':''" @click="move_down_experience(k,applicant.trainings)" style="margin-right: 2px;"><i class="ui arrow down icon"></i></button>
              <input type="text" v-model="applicant.trainings[k]">
              <button class="ui icon button" type="button" @click="applicant.trainings.splice(k,1)"><i class="ui times icon"></i></button>
            </div>
            <button hidden type="submit">Add</button>
          </form>
          <h3 class="ui dividing blue header">Experience</h3>
          <!-- Length of Service and Experience start -->
          <div class="two column fields">
            <div class="field">
              <h3 style="color: #2185d0;">Length of Service in Government: </h3>
              <form @submit.prevent="add_new_yos_gov()">
                <div class="ui fields">
                  <div class="field">
                    <label for="">Status: </label>
                    <input v-model="new_yos_gov.status" type="text" placeholder="e.g. Jow/Casual/Permanent/..." list="statuses">
                  </div>
                  <div class="field">
                    <label for="">Length of Service: </label>
                    <input v-model="new_yos_gov.num_years" type="text" placeholder="e.g. 4 years & 6 mos.">
                  </div>
                </div>
                <button hidden type="submit">Add</button>
              </form>
              <div class="ui fields" v-for="(service, i) in applicant.years_of_service_gov" :key="i" style="margin-top: 5px;">
                <div class="field">
                  <input v-model="applicant.years_of_service_gov[i].status" type="text" placeholder="e.g. Jow/Casual/Permanent/..." list="statuses">
                </div>
                <div class="field">
                  <input v-model="applicant.years_of_service_gov[i].num_years" type="text" placeholder="e.g. 4 years & 6 mos.">
                </div>
                <div class="field">
                  <button class="ui icon button" @click="applicant.years_of_service_gov.splice(i,1)"><i class="ui icon times"></i></button>
                  <button type="button" class="ui icon button basic" :class="i == 0 ?'disabled':''" @click="move_up_experience(i,applicant.years_of_service_gov)"><i class="ui arrow up icon"></i></button>
                  <button type="button" class="ui icon button basic" :class="applicant.years_of_service_gov.length-1 == i ?'disabled':''" @click="move_down_experience(i,applicant.years_of_service_gov)" style="margin-right: 2px;"><i class="ui arrow down icon"></i></button>
                </div>
              </div>
            </div>
            <div class="field">
              <h3 style="color: #2185d0;">Length of Service in Private: </h3>
              <form @submit.prevent="add_new_yos_priv()">
                <div class="ui fields">
                  <div class="field">
                    <label for="">Status: </label>
                    <input v-model="new_yos_priv.status" type="text" placeholder="e.g. Jow/Casual/Permanent/..." list="statuses">
                  </div>
                  <div class="field">
                    <label for="">Length of Service: </label>
                    <input v-model="new_yos_priv.num_years" type="text" placeholder="e.g. 4 years & 6 mos.">
                  </div>
                </div>
                <button hidden type="submit">Add</button>
              </form>
              <div class="ui fields" v-for="(service, i) in applicant.years_of_service_priv" :key="i" style="margin-top: 5px;">
                <div class="field">
                  <input v-model="applicant.years_of_service_priv[i].status" type="text" placeholder="e.g. Jow/Casual/Permanent/..." list="statuses">
                </div>
                <div class="field">
                  <input v-model="applicant.years_of_service_priv[i].num_years" type="text" placeholder="e.g. 4 years & 6 mos.">
                </div>
                <div class="field">
                  <button class="ui icon button" @click="applicant.years_of_service_priv.splice(i,1)"><i class="ui icon times"></i></button>

                  <button type="button" class="ui icon button basic" :class="i == 0 ?'disabled':''" @click="move_up_experience(i,applicant.years_of_service_priv)"><i class="ui arrow up icon"></i></button>
                  <button type="button" class="ui icon button basic" :class="applicant.years_of_service_priv.length-1 == i ?'disabled':''" @click="move_down_experience(i,applicant.years_of_service_priv)" style="margin-right: 2px;"><i class="ui arrow down icon"></i></button>
                </div>
              </div>
            </div>
            <datalist id="statuses">
              <option value="Temporary">
              <option value="JOW">
              <option value="Casual">
              <option value="Contractual">
              <option value="Permanent">
              <option value="Elective">
            </datalist>

          </div>
          <!-- Work History Start -->
          <h3 class="ui dividing header"></h3>
          <h3 style="color: #2185d0;">Work History: </h3>
          <form @submit.prevent="add_new_experience()">
            <div class="ui fields">
              <div class="field">
                <label for="">Job Title:</label>
                <input type="text" v-model="new_experience.title" placeholder="Enter the job title...">
              </div>
              <div class="field">
                <label for="">Status:</label>
                <input type="text" v-model="new_experience.status" placeholder="e.g. Casual/Regular/Contractual/">
              </div>
              <div class="field">
                <label for="">Company:</label>
                <input type="text" v-model="new_experience.company" placeholder="Enter name of the company...">
              </div>
              <div class="field">
                <label for="">From:</label>
                <input type="text" v-model="new_experience.from" placeholder="Enter date started..." list="months">
              </div>
              <div class="field">
                <label for="">To:</label>
                <input type="text" v-model="new_experience.to" placeholder="Enter date or 'To Present'..." list="months">
              </div>
            </div>
            <button type="submit" hidden>Submit</button>
          </form>
          <!-- --work history list start -->
          <div class="ui fields" v-for="(work,i) in applicant.experiences" :key="i">
            <div class="field">
              <!-- <label for="">Job Title:</label> -->
              <input type="text" v-model="applicant.experiences[i].title" placeholder="Enter the job title...">
            </div>
            <div class="field">
              <!-- <label for="">Status:</label> -->
              <input type="text" v-model="applicant.experiences[i].status" placeholder="e.g. Casual/Regular/Contractual/">
            </div>
            <div class="field">
              <!-- <label for="">Company:</label> -->
              <input type="text" v-model="applicant.experiences[i].company" placeholder="Enter name of the company...">
            </div>
            <div class="field">
              <!-- <label for="">From:</label> -->
              <input type="text" v-model="applicant.experiences[i].from" placeholder="Enter date started..." list="months">
            </div>
            <div class="field">
              <!-- <label for="">To:</label> -->
              <input type="text" v-model="applicant.experiences[i].to" placeholder="Enter date or 'To Present'..." list="months">
            </div>
            <div class="field">
              <button class="ui icon button" @click="applicant.experiences.splice(i,1)"><i class="ui times icon"></i></button>
              <button class="ui icon button basic" :class="i == 0 ?'disabled':''" @click="move_up_experience(i,applicant.experiences)"><i class="ui arrow up icon"></i></button>
              <button class="ui icon button basic" :class="applicant.experiences.length-1 == i ?'disabled':''" @click="move_down_experience(i,applicant.experiences)"><i class="ui arrow down icon"></i></button>
            </div>
          </div>

          <datalist id="months">
            <option value="January">
            <option value="February">
            <option value="March">
            <option value="April">
            <option value="May">
            <option value="June">
            <option value="July">
            <option value="August">
            <option value="September">
            <option value="October">
            <option value="November">
            <option value="December">
          </datalist>

          <!-- --work history list end -->
          <!-- Work History  End -->
          <!-- Length of Service and Experience end -->
          <h3 class="ui dividing blue header">Eligibility</h3>
          <form @submit.prevent="add_new_eligibility()">
            <input v-model="new_eligibility" class=" " type="text" placeholder="Enter eligibility...">
            <div class="ui action fluid input" v-for="(eligibility, k) in applicant.eligibilities" :key="k" style="margin-top: 2px;">

              <button type="button" class="ui icon button basic" :class="k == 0 ?'disabled':''" @click="move_up_experience(k,applicant.eligibilities)"><i class="ui arrow up icon"></i></button>
              <button type="button" class="ui icon button basic" :class="applicant.eligibilities.length-1 == k ?'disabled':''" @click="move_down_experience(k,applicant.eligibilities)" style="margin-right: 2px;"><i class="ui arrow down icon"></i></button>

              <input type="text" v-model="applicant.eligibilities[k]">
              <button class="ui icon button" type="button" @click="applicant.eligibilities.splice(k,1)"><i class="ui times icon"></i></button>
            </div>
            <button hidden type="submit">Add</button>
          </form>
          <h3 class="ui dividing blue header">Awards, Citations Received</h3>
          <form @submit.prevent="add_new_awards()">
            <input v-model="new_award" class=" " type="text" placeholder="Enter the award...">
            <div class="ui action fluid input" v-for="(award, k) in applicant.awards" :key="k" style="margin-top: 2px;">


              <button type="button" class="ui icon button basic" :class="k == 0 ?'disabled':''" @click="move_up_experience(k,applicant.awards)"><i class="ui arrow up icon"></i></button>
              <button type="button" class="ui icon button basic" :class="applicant.awards.length-1 == k ?'disabled':''" @click="move_down_experience(k,applicant.awards)" style="margin-right: 2px;"><i class="ui arrow down icon"></i></button>

              <input type="text" v-model="applicant.awards[k]">
              <button class="ui icon button" type="button" @click="applicant.awards.splice(k,1)"><i class="ui times icon"></i></button>
            </div>
            <button hidden type="submit">Add</button>
          </form>
          <h3 class="ui dividing blue header">Records of Infractions</h3>
          <form @submit.prevent="add_new_record_of_infraction()">
            <input v-model="new_record_of_infraction" class=" " type="text" placeholder="Enter record of infraction...">
            <div class="ui action fluid input" v-for="(record, k) in applicant.record_of_infractions" :key="k" style="margin-top: 2px;">

              <button type="button" class="ui icon button basic" :class="k == 0 ?'disabled':''" @click="move_up_experience(k,applicant.record_of_infractions)"><i class="ui arrow up icon"></i></button>
              <button type="button" class="ui icon button basic" :class="applicant.record_of_infractions.length-1 == k ?'disabled':''" @click="move_down_experience(k,applicant.record_of_infractions)" style="margin-right: 2px;"><i class="ui arrow down icon"></i></button>

              <input type="text" v-model="applicant.record_of_infractions[k]">
              <button class="ui icon button" type="button" @click="applicant.record_of_infractions.splice(k,1)"><i class="ui times icon"></i></button>
            </div>
            <button hidden type="submit">Add</button>
          </form>
          <h3 class="ui dividing blue header">Remarks</h3>
          <div class="field">
            <label>Remarks:</label>
            <textarea class="dataInput" id="remarksArea" placeholder="Enter remarks here..." v-model="applicant.remarks"></textarea>
          </div>
          <div class="ui error message"></div>
        </div>
      </div>
      <div class="actions" style="padding-bottom: 5px;">
        <button type="button" class="ui basic blue button approve"><i class="icon save"></i> Save</button>
        <button class="ui basic button deny"><i class="icon cancel"></i> Cancel</button>
      </div>
    </div>
    <!-- 
#
#
#  Add/Edit applicant form end
# 
#
#
 -->
    <!-- modals end -->
  </div>
</div>

<script>
  new Vue({
    el: "#applicants_vue_app",
    data() {
      return {
        rspvac_id: <?= $rspvac_id ?>,
        addNewApplicantBtn: false,
        applicants: [],
        applicant: {
          id: null,
          name: "",
          age: "",
          gender: null,
          civil_status: null,
          education: "",
          years_of_service_gov: [],
          years_of_service_priv: [],
          experiences: [],
          trainings: [],
          eligibilities: [],
          awards: [],
          record_of_infractions: [],
          remarks: ""
        },
        applicant_default: {
          id: null,
          name: "",
          age: "",
          gender: null,
          civil_status: null,
          education: "",
          years_of_service_gov: [],
          years_of_service_priv: [],
          experiences: [],
          trainings: [],
          eligibilities: [],
          awards: [],
          record_of_infractions: [],
          remarks: ""
        },
        new_training: "",
        new_yos_gov: {
          status: "",
          num_years: ""
        },
        new_yos_priv: {
          status: "",
          num_years: ""
        },
        new_experience: {
          title: "",
          status: "",
          company: "",
          from: "",
          to: "",
        },
        new_eligibility: "",
        new_award: "",
        new_record_of_infraction: ""
      }
    },
    methods: {
      move_up_experience(k, arr) {
        const el = arr.splice(k, 1)[0]
        arr.splice(k - 1, 0, el)
      },
      move_down_experience(k, arr) {
        const el = arr.splice(k, 1)[0]
        arr.splice(k + 1, 0, el)
      },
      add_new_experience() {
        this.applicant.experiences.unshift(this.new_experience);
        this.new_experience = JSON.parse(JSON.stringify({
          title: "",
          status: "",
          company: "",
          from: "",
          to: "",
        }))
      },
      add_new_yos_priv() {
        this.applicant.years_of_service_priv.unshift(this.new_yos_priv);
        this.new_yos_priv = JSON.parse(JSON.stringify({
          status: "",
          num_years: ""
        }))
      },
      add_new_yos_gov() {
        this.applicant.years_of_service_gov.unshift(this.new_yos_gov);
        this.new_yos_gov = JSON.parse(JSON.stringify({
          status: "",
          num_years: ""
        }))
      },
      add_new_training() {
        this.applicant.trainings.unshift(this.new_training)
        this.new_training = ""
      },
      add_new_eligibility() {
        this.applicant.eligibilities.unshift(this.new_eligibility)
        this.new_eligibility = ""
      },
      add_new_awards() {
        this.applicant.awards.unshift(this.new_award)
        this.new_award = ""
      },
      add_new_record_of_infraction() {
        this.applicant.record_of_infractions.unshift(this.new_record_of_infraction)
        this.new_record_of_infraction = ""
      },
      initload() {
        $.post('comparativeDataInfo_proc.php', {
          initload: true,
          rspvac_id: this.rspvac_id
        }, (data) => {
          this.applicants = JSON.parse(data)
        });
      },
      addNewApplicant() {
        $("#addNewModal").modal({
          closable: false,
          onApprove: () => {
            this.add_new_experience()
            this.add_new_yos_priv()
            this.add_new_yos_gov()
            this.add_new_training()
            this.add_new_eligibility()
            this.add_new_awards()
            this.add_new_record_of_infraction()
            this.submitForm()
            // console.log(this.applicant);
            // this.clearForm()
          }
        }).modal("show");
      },
      editApplicant(applicant) {
        // console.log(applicant);
        this.applicant = JSON.parse(JSON.stringify(applicant))
        // this.applicant = applicant

        $("#gender_dropdown").dropdown("set selected", applicant.gender)
        $("#civil_status_dropdown").dropdown("set selected", applicant.civil_status)

        $("#addNewModal").modal({
          closable: false,
          onApprove: () => {
            this.add_new_experience()
            this.add_new_yos_priv()
            this.add_new_yos_gov()
            this.add_new_training()
            this.add_new_eligibility()
            this.add_new_awards()
            this.add_new_record_of_infraction()
            this.submitForm()
            // console.log(this.applicant);
            // this.clearForm()
          }
        }).modal("show");
      },

      submitForm() {
        $.post('comparativeDataInfo_proc.php', {
          addEditApplicant: true,
          rspvac_id: this.rspvac_id,
          applicant: this.applicant,
        }, (data, textStatus, xhr) => {
          console.log(data);
          this.initload()
          this.clearForm()
        });
      },

      clearForm() {
        this.applicant = JSON.parse(JSON.stringify(this.applicant_default))
        $("#gender_dropdown").dropdown("clear")
        $("#civil_status_dropdown").dropdown("clear")
      },

      unlistApplicant(id) {
        $("#deleteModal").modal({
          onApprove: () => {
            $.post('comparativeDataInfo_proc.php', {
              unlistApplicant: true,
              rspvac_id: this.rspvac_id,
              applicant_id: id,
            }, (data, textStatus, xhr) => {
              this.initload()
            });
          },
        }).modal('show');
      },
      addApplicant() {
        this.clearForm()
        $.post("rsp_addApplicant_modal_proc.php", {
          getApplicants: true
        }, (data) => {
          content = JSON.parse(data);
          $("#addApplicant").modal({
            closable: false,
          }).modal('show');
          $('#addApplicantSearch').search({
            source: content,
            cache: false,
            error: {
              noResults: 'Click add button to add new record for this new applicant.'
            },
            onSelect: (result, response) => {
              // console.log(result.title);
              // console.log(result.id);
              $.post("rsp_addApplicant_modal_proc.php", {
                addExistingApplicant: true,
                applicant_id: result.id,
                rspvac_id: this.rspvac_id
              }, (data) => {
                this.initload()
              })
              $("#addApplicant").modal('hide');
              $('#addApplicantSearch').search('set value', '');
              $('#addApplicantSearch').search('hide results');
            },
            onResults: (response) => {
              if (response.results.length === 0) {
                this.addNewApplicantBtn = true
              } else if (response.results.length > 0) {
                this.addNewApplicantBtn = false
              }
            }
          });
        });
      }
    },
    created() {
      this.initload()
    },
    mounted() {
      $("#gender_dropdown").dropdown()
      $("#civil_status_dropdown").dropdown()
    }
  })
</script>

<?php require_once "footer.php"; ?>