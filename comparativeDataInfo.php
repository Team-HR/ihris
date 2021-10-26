<?php
$title = "Comparative Data Info";
require "_connect.db.php";
require "header.php";
$rspvac_id = $_GET["rspvac_id"];
?>


<div id="comparative_data_vue">
  <template>
    <div class="ui containerA" style="padding-left: 20px; padding-right: 20px;">
      <div class="printOnly" style="padding-top: 5px !important;"></div>
      <div class="ui borderless blue inverted mini menu">
        <div class="left item" style="margin-right: 0px !important;">
          <button onclick="window.location.href='comparativeData.php';" class="blue ui icon button noprint" title="Back" style="width: 65px;">
            <i class="icon chevron left"></i> Back
          </button>
        </div>
        <div class="item">
          <h3>
            <i class="pie chart icon"></i> Comparative Data <i class="caret right icon"></i>
            {{position.positiontitle}}
          </h3>
        </div>

        <div class="right item noprint">

          <button onclick="print()" class="blue ui icon button" title="Print" style="margin-right: 5px;">
            <i class="icon print"></i> Print
          </button>
        </div>
      </div>

      <!-- <div class="ui segments"> -->
      <table class="ui very compact small celled table printCompactText" style="font-size: 14px;">
        <tr>
          <td class="actives">VACANT POSITION:</td>
          <td>
            {{position.positiontitle}}
            <i v-if="!position.positiontitle" style="color: grey;">n/a</i>
          </td>
          <td class="actives">CSC ITEM NO:</td>
          <td>
            {{position.itemNo}}
            <i v-if="!position.itemNo" style="color: grey;">n/a</i>
          </td>
        </tr>
        <tr>
          <td class="actives">EDUCATION:</td>
          <td>
            <!-- {{position.education}} -->
            <p class="item" v-for="(edu,i) in position.education" :key="i">{{edu}}</p>
            <i v-if="!position.education" style="color: grey;">n/a</i>
          </td>
          <td class="actives">SG:</td>
          <td>
            {{position.sg}}
            <i v-if="!position.sg" style="color: grey;">n/a</i>
          </td>
        </tr>
        <tr>
          <td class="actives">EXPERIENCE:</td>
          <td>
            <!-- {{position.experience}} -->
            <p v-for="(exp,i) in position.experience" :key="i">{{exp}}</p>
            <i v-if="!position.experience" style="color: grey;">n/a</i>
          </td>
          <td class="actives">OFFICE:</td>
          <td>
            {{position.office}}
            <i v-if="!position.office" style="color: grey;">n/a</i>
          </td>
        </tr>
        <tr>
          <td class="actives">TRAINING:</td>
          <td colspan="3">
            <!-- {{position.training}} -->
            <p v-for="(tr,i) in position.training" :key="i">{{`${tr.training} (${tr.training?tr.training+' hrs':''})`}}</p>
            <i v-if="!position.training" style="color: grey;">n/a</i>
          </td>
        </tr>
        <tr>
          <td class="actives">ELIGIBILITY:</td>
          <td colspan="3">
            <!-- {{position.eligibility}} -->
            <p v-for="(elig,i) in position.eligibility" :key="i">{{elig}}</p>
            <i v-if="!position.eligibility" style="color: grey;">n/a</i>
          </td>
        </tr>
      </table>

      <button @click="add_edit_applicant()" class="ui tiny green button noprint" title="Add applicant to the list"><i class="icon add"></i> Add Applicant</button>

      <table id="trTable" class="ui blue selectable structured celled very compact table printCompactText" style="font-size: 12px;">
        <thead>
          <tr style="text-align: center;">
            <th class="heads">No.</th>
            <th></th>
            <th class="heads">Name</th>
            <th class="heads">Age</th>
            <th class="heads">Gender</th>
            <th class="heads">Years of Service (Gov't/Private)</th>
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
        <tbody>
          <tr v-for="(applicant, i) in applicants">
            <td style="vertical-align: text-top;">{{i+1}}</td>
            <td style="vertical-align: text-top;">
              <a :href="'checklist.php?rspcomp_id='+applicant.rspcomp_id" class="ui button basic icon"><i class="icon list ol" :class="applicant.is_checklisted?'green':'red'"></i></a>
            </td>
            <td style="vertical-align: text-top;">{{applicant.name}}</td>
            <td style="vertical-align: text-top;">{{applicant.age}}</td>
            <td style="vertical-align: text-top;">{{applicant.gender}}</td>
            <td style="vertical-align: text-top;">#num_years_of_service</td>
            <td style="vertical-align: text-top;">{{applicant.civil_status}}</td>
            <td style="vertical-align: text-top;">{{applicant.education}}</td>
            <td style="vertical-align: text-top;">
              <li v-for="(tr,t) in applicant.training" :key="t">{{tr}}</li>
            </td>
            <td style="vertical-align: text-top;">
              <li v-for="(exp,e) in applicant.experience" :key="e"><b>{{exp[2]}}</b> as <b style="color:green">{{exp[0]}}</b>
                {{parse_date(exp[3],exp[4])}}
              </li>
            </td>
            <td style="vertical-align: text-top;">
              <ul>
                <li v-for="(elig,el) in applicant.eligibility" :key="el">
                  {{elig}}
                </li>
              </ul>
            </td>
            <td style="vertical-align: text-top;">
              <li v-for="(award,a) in applicant.awards" :key="a">
                {{award}}
              </li>
            </td>
            <td style="vertical-align: text-top;">
              <li v-for="(record,inf) in applicant.records_infractions" :key="inf">
                {{record}}
              </li>
            </td>

            <td class="noprint" style="width: 50px;">
              <div class="ui mini basic icon buttons">
                <!-- edit: {{applicant.applicant_id}} -->
                <button class="ui positive button" title="Edit" @click="add_edit_applicant(applicant.applicant_id)"><i class="icon edit"></i></button>
                <div class="or"></div>
                <!-- delete: {{applicant.rspcomp_id}} -->
                <button class="ui negative button" title="Delete" @click="delete_entry(applicant.rspcomp_id)"><i class="icon trash"></i></button>
              </div>
            </td>

          </tr>
        </tbody>
      </table>
      <!-- </div> -->
    </div>
    <!-- modals start -->
    <?php
    // require "comparativeDataInfo.modals.php";
    ?>

    <div class="ui large modal" id="add_new_applicant_modal" style="background-color: lightgrey !important;">
      <div class="ui blue header" id="addNewModalheader"></div>
      <div class="scrolling content">
        <div class="ui small form">
          <!-- personal information start -->
          <h3 class="ui dividing blue header">Personal Information</h3>
          <div class="fields">
            <div class="eleven wide field">
              <label>Name:</label>
              <!-- <input type="text" v-model="applicant.name" placeholder="Last Name, First Name MI., ext"> -->
              <div class="ui search">
                <div class="ui left icon input">
                  <input class="prompt" type="text" placeholder="Enter name (or Search existing name)" v-model="applicant.name">
                  <i class="user icon"></i>
                </div>
              </div>
            </div>
            <div class="two wide field">
              <label>Age:</label>
              <input type="text" v-model="applicant.age" placeholder="Enter age...">
            </div>
            <div class="three wide field">
              <label>Gender:</label>
              <select class="ui compact dropdown gender" v-model="applicant.gender">
                <option value="">Gender</option>
                <option value="Female">Female</option>
                <option value="Male">Male</option>
              </select>
            </div>
          </div>
          <div class="fields">
            <div class="three wide field">
              <label>Civil Status:</label>
              <select class="ui compact dropdown civil_status" v-model="applicant.civil_status">
                <option value="">Civil Status</option>
                <option value="Single">Single</option>
                <option value="Married">Married</option>
                <option value="Annulled">Annulled</option>
                <option value="Widowed">Widowed</option>
              </select>
            </div>
            <div class="three wide field">
              <label>Mobile No:</label>
              <input type="text" v-model="applicant.mobile_no" placeholder="Mobile number...">
            </div>
            <div class="ten wide field">
              <label>Address:</label>
              <input type="text" v-model="applicant.address" placeholder="Enter full address...">
            </div>
          </div>
          <!-- personal information end -->

          <!-- education start -->
          <h3 class="ui dividing blue header">Education</h3>
          <div class="fields">
            <div class="eight wide field">
              <label>Education:</label>
              <input type="text" v-model="applicant.education" placeholder="Enter highest educational degree attained...">
            </div>
            <div class="eight wide field">
              <label>School:</label>
              <input type="text" v-model="applicant.school" placeholder="Enter last school attended...">
            </div>
          </div>
          <!-- education end -->

          <!-- trainings start -->
          <h3 class="ui dividing blue header">Trainings</h3>
          <!-- <div class="fields">
            <div class="eight wide field">
              <label>Title of Training:</label>
              <input type="text" v-model="form_training_input.training" @keyup.enter="add_applicant_training" placeholder="Enter training attended (no. of hours)...">
            </div>
            <div class="field">
              <label># of Hours:</label>
              <input type="text" v-model="form_training_input.hrs" @keyup.enter="add_applicant_training" placeholder="(no. of hours)...">
            </div>
          </div>
          <button class="ui small green button" @click="add_applicant_training">
            <i class="icon add"></i>
            Add
          </button> -->

          <table class="ui mini very compact structured celled table">
            <thead>
              <tr>
                <th style="width: 10px;">
                  <i class="ui icon circular times" style="color: white; box-shadow: none;"></i>
                </th>
                <th>TITLE OF TRAINING</th>
                <th># OF HOURS</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(training,t) in applicant.trainings" :key="t" style="text-align: center;">
                <td>
                  <i class="ui icon link circular times red" @click="applicant.trainings.splice(t, 1)"></i>
                </td>
                <td>
                  <input type="text" v-model="applicant.trainings[t].training" placeholder="Title of training...">
                </td>
                <td>
                  <input type="text" v-model="applicant.trainings[t].hrs" placeholder="Total number of hours...">
                </td>
              </tr>
              <tr v-if="applicant.trainings.length < 1">
                <td colspan="3" style="text-align: center; color: grey;">NO TRAININGS</td>
              </tr>
              <tr>
                <td colspan="3">
                  <button class="ui mini green button" @click="add_applicant_training">
                    <i class="icon add"></i>
                    Add Training
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
          <!-- trainings end -->


















          <!-- experience start -->
          <h3 class="ui dividing blue header">Experience</h3>

          <table class="ui mini very compact structured celled table">
            <thead>
              <tr style="text-align: center;">
                <th style="color: white;">
                  <i class="ui icon edit"></i>
                  <i class="ui icon times"></i>
                </th>
                <th>SECTOR</th>
                <th>COMPANY</th>
                <th>POSITION</th>
                <th>DESCRIPTION</th>
                <th>STATUS</th>
                <th>FROM</th>
                <th>TO</th>
                <th>YEARS OF SERVICE</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(xp, x) in applicant.experiences" :key="x" style="text-align: center;">
                <td>
                  <i class="ui green icon link circular edit" @click="edit_applicant_experience(x)"></i>
                  <i class="ui red icon link circular times" @click="applicant.experiences.splice(x,1)"></i>
                </td>
                <td>{{xp.sector}}</td>
                <td>{{xp.company}}</td>
                <td>{{xp.position}}</td>
                <td>{{xp.description}}</td>
                <td>{{xp.status}}</td>
                <td>{{format_date_to_str(xp.date_from.mm,xp.date_from.dd,xp.date_from.yyyy)}}</td>
                <td>{{format_date_to_str(xp.date_to.mm,xp.date_to.dd,xp.date_to.yyyy)}}</td>
                <td>{{`Years: ${xp.years_of_service.years} Months: ${xp.years_of_service.months}`}}</td>
              </tr>
              <tr v-if="!applicant_experience_has_data(applicant.experiences)" centered>
                <td colspan="9" style="text-align: center; color:grey;">NO EXPERIENCE</td>
              </tr>
              <tr>
                <td colspan="9">
                  <button class="ui mini green button" @click="applicant_experience_editor"><i class="ui icon add"></i> Add Experience</button>
                </td>
              </tr>
            </tbody>
          </table>

          <!-- experience editor start -->
          <div class="ui modal" id="applicant_experience_editor_modal" style="margin-top: 100px;">
            <div class="ui blue header">Experience Editor</div>
            <div class="content">
              <div class="ui form">
                <div class="four wide fields">
                  <div class="field">
                    <label>Sector:</label>
                    <select class="ui compact dropdown" id="form_experience_sector" v-model="form_experience.sector">
                      <option value="">Sector</option>
                      <option value="PRIVATE">PRIVATE</option>
                      <option value="GOVERNMENT">GOVERNMENT</option>
                      <option value="SELF-EMPLOYED">SELF-EMPLOYED</option>
                    </select>
                  </div>
                  <div class="field">
                    <label>Company/Agency:</label>
                    <input type="text" v-model="form_experience.company" placeholder="Company/Agency">
                  </div>
                  <div class="field">
                    <label>Position:</label>
                    <input type="text" v-model="form_experience.position" placeholder="Position...">
                  </div>
                  <div class="field">
                    <label>Job Description:</label>
                    <input type="text" v-model="form_experience.description" placeholder="Job Description...">
                  </div>
                </div>
                <div class="four wide fields">
                  <div class="field">
                    <label>Status:</label>
                    <select class="ui compact dropdown" id="form_experience_status" v-model="form_experience.status">
                      <option value="">Status</option>
                      <option value="REGULAR">REGULAR</option>
                      <option value="CASUAL">CASUAL</option>
                      <option value="JOW">JOW</option>
                      <option value="CONTRACTUAL">CONTRACTUAL</option>
                      <option value="TEMPORARY">TEMPORARY</option>
                      <option value="ELECTIVE">ELECTIVE</option>
                    </select>
                  </div>
                  <div class="fields" style="padding-left: 8px;">
                    <!-- <label>From:</label> -->
                    <!-- <input type="text" placeholder="Started from..." v-model="form_experience.date_from"> -->
                    <div class="field" style="padding-right: 0px;">
                      <label>From:</label>
                      <input @keyup="get_yos" type="text" placeholder="mm" v-model="form_experience.date_from.mm">
                    </div>
                    <div class="field" style="padding-left: 2px; padding-right: 0px;">
                      <label><br /></label>
                      <input @keyup="get_yos" type="text" placeholder="dd" v-model="form_experience.date_from.dd">
                    </div>
                    <div class="field" style="padding-left: 2px;">
                      <label><br /></label>
                      <input @keyup="get_yos" type="text" placeholder="yyyy" v-model="form_experience.date_from.yyyy">
                    </div>
                  </div>
                  <div class="fields" style="padding-left: 18px;">
                    <!-- <label>To:</label> -->
                    <!-- <input type="text" placeholder="Started to..." v-model="form_experience.date_to"> -->
                    <div class="field" style="padding-right: 0px;">
                      <label>To:</label>
                      <input @keyup="get_yos" type="text" placeholder="mm" v-model="form_experience.date_to.mm">
                    </div>
                    <div class="field" style="padding-left: 2px; padding-right: 0px;">
                      <label><br /></label>
                      <input @keyup="get_yos" type="text" placeholder="dd" v-model="form_experience.date_to.dd">
                    </div>
                    <div class="field" style="padding-left: 2px;">
                      <label><br /></label>
                      <input @keyup="get_yos" type="text" placeholder="yyyy" v-model="form_experience.date_to.yyyy">
                    </div>
                  </div>
                  <div class="field" style="padding-left: 32px;">
                    <label>Years of Service:</label>
                    <input readonly type="text" :value="`Years: ${form_experience.years_of_service.years} Months: ${form_experience.years_of_service.months}`">
                  </div>
                </div>
                <!-- <button @click="add_applicant_experience()" class="ui mini green button"><i class="add icon"></i> Add</button> -->


              </div>
            </div>
            <div class="actions">
              <button class="ui mini button green approve" @click="add_applicant_experience()">Save</button>
              <button class="ui mini button deny" @click="reset_applicant_experience()">Cancel</button>
            </div>
          </div>

          <!-- experience editor end -->

          <!-- experience end -->








          <!-- eligibility start -->
          <h3 class="ui dividing blue header">Eligibility</h3>
          <!-- <div class="field">
            <label>Add Eligibility:</label>
            <input type="text" v-model="form_eligibility_input" @keyup.enter="add_applicant_eligibility" placeholder="Enter eligibility...">
          </div>
          <button class="ui mini green button" @click="add_applicant_eligibility">
            <i class="icon add"></i>
            Add
          </button> -->
          <table class="ui mini very compact structured celled table">
            <thead>
              <tr>
                <th style="width: 10px;">
                  <i class="ui icon circular times" style="color: white; box-shadow: none;"></i>
                </th>
                <th>ELIGIBILITY</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(eligibility,e) in applicant.eligibilities" :key="e" style="text-align: center;">
                <td>
                  <i class="ui icon link circular times red" @click="applicant.eligibilities.splice(e, 1)"></i>
                </td>
                <td>
                  <input type="text" v-model="applicant.eligibilities[e]" placeholder="Title of eligibility...">
                </td>
              </tr>
              <tr v-if="applicant.eligibilities.length < 1">
                <td colspan="2" style="text-align: center; color: grey;">NO ELIGIBILITIES</td>
              </tr>
              <tr>
                <td colspan="2">
                  <button class="ui mini green button" @click="add_applicant_eligibility">
                    <i class="icon add"></i>
                    Add Eligibility
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
          <!-- eligibility end -->
          <!-- awards start -->
          <h3 class="ui dividing blue header">Awards, Citations Received</h3>
          <table class="ui mini very compact structured celled table">
            <thead>
              <tr>
                <th style="width: 10px;">
                  <i class="ui icon circular times" style="color: white; box-shadow: none;"></i>
                </th>
                <th>TITLE OF AWARD/CITATION</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(award,a) in applicant.awards" :key="a" style="text-align: center;">
                <td>
                  <i class="ui icon link circular times red" @click="applicant.awards.splice(a, 1)"></i>
                </td>
                <td>
                  <input type="text" v-model="applicant.awards[a]" placeholder="Title of award/citation...">
                </td>
              </tr>
              <tr v-if="applicant.awards.length < 1">
                <td colspan="2" style="text-align: center; color: grey;">NO AWARDS/CITATIONS</td>
              </tr>
              <tr>
                <td colspan="2">
                  <button class="ui mini green button" @click="add_applicant_award">
                    <i class="icon add"></i>
                    Add Award/Citation
                  </button>
                </td>
              </tr>
            </tbody>
          </table>

          <!-- awards end -->
          <!-- records of infraction start -->
          <h3 class="ui dividing blue header">Records of Infractions</h3>
          <table class="ui mini very compact structured celled table">
            <thead>
              <tr>
                <th style="width: 10px;">
                  <i class="ui icon circular times" style="color: white; box-shadow: none;"></i>
                </th>
                <th>TITLE OF RECORD OF INFRACTION</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(rec,r) in applicant.records_infractions" :key="r" style="text-align: center;">
                <td>
                  <i class="ui icon link circular times red" @click="applicant.records_infractions.splice(r, 1)"></i>
                </td>
                <td>
                  <input type="text" v-model="applicant.records_infractions[r]" placeholder="Title of record of infraction...">
                </td>
              </tr>
              <tr v-if="applicant.records_infractions.length < 1">
                <td colspan="2" style="text-align: center; color: grey;">NO RECORDS OF INFRACTIONS</td>
              </tr>
              <tr>
                <td colspan="2">
                  <button class="ui mini green button" @click="add_applicant_records_infraction">
                    <i class="icon add"></i>
                    Add Record of Infraction
                  </button>
                </td>
              </tr>
            </tbody>
          </table>

          <!-- records of infraction end -->
          <h3 class="ui dividing blue header">Remarks</h3>
          <div class="field">
            <label>Remarks:</label>
            <textarea v-model="applicant.remarks" placeholder="Remarks..."></textarea>
          </div>
          <div class="ui error message"></div>
          </d>
        </div>
        <div class="actions">
          <button class="ui tiny basic blue button approve"><i class="icon save"></i> Save</button>
          <button class="ui tiny basic button deny"><i class="icon cancel"></i> Cancel</button>
        </div>
      </div>

      <!-- modals end -->
  </template>
</div>

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
<script src="comparativeDataInfo.js"></script>

<?php require_once "footer.php"; ?>