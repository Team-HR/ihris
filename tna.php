<?php $title = "Training Needs Analysis (TNA)";
require_once "header.php"; ?>
<div id="tna-app">
  <template>
    <div class="ui container">
      <div class="ui borderless blue inverted mini menu noprint">
        <div class="left item" style="margin-right: 0px !important;">
          <button onclick="window.history.back();" class="blue ui icon mini button" title="Back" style="width: 65px;">
            <i class="icon chevron left"></i> Back
          </button>
        </div>
        <div class="item">
          <h3><i class="icon compass outline"></i> L&D Training Needs Analysis</h3>
        </div>
        <div class="right item">
          <div class="ui right input">
            <button class="ui icon green mini button" style="margin-right: 5px;" @click="addNewModal()"><i class="icon plus"></i>Add New</button>
            <a href="tna_view_report.php" class="ui icon green mini button" style="margin-right: 5px;"><i class="folder open outline icon"></i>View Report</a>
          </div>
        </div>
      </div>
      <!-- content start -->

      <div class="ui fluid container segment" style="min-height: 100%;">
        <div class="ui top attached tabular tna menu">
          <a class="item active" data-tab="first"> For Strategic</a>
          <a class="item" data-tab="second">For Employee Engagement</a>
        </div>
        <div class="ui bottom attached tab segment active" data-tab="first">
          <table class="ui very small compact structured table blue">
            <thead>
              <tr class="center aligned">
                <th width="10"></th>
                <th width="10"></th>
                <th>Training</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Venue</th>
                <th>Remarks</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item,i) in addedScheduledTrainings" :key="i">
                <td>({{i+1}})</td>
                <td>
                  <a :href="'tna_entries.php?id='+item.personneltrainings_id" title="Open" class="ui basic mini icon button"><i class="folder open outline primary icon"></i></a>
                </td>
                <td>{{item.training}}</td>
                <td>{{item.startDate}}</td>
                <td>{{item.endDate}}</td>
                <td>{{item.venue}}</td>
                <td>{{item.remarks}}</td>
                <td class="center aligned">
                  <div class="ui icon basic mini buttons">

                  </div>
                </td>
              </tr>

            </tbody>
          </table>
        </div>
        <div class="ui bottom attached tab segment" data-tab="second">
          <form class="ui form" @submit.prevent="submitEntry()" id="myForm">
            <div class="ui segment">
              <div class="field">
                <label for="department">Department:</label>
                <select id="department_select" class="ui dropdown" name="departments" v-model="form_entry.department_id">
                  <option value="department">Department</option>
                  <option v-for="data in departments" :value="data.id">{{ data.name }}</option>
                </select>
              </div>
              <div class="field">
                <label>1.) What challenges are you confronted with?</label><br>
                <label>COMMUNICATION:</label>
                <input type="text" name=" communication" placeholder="Type here..." size="10" v-model="form_entry.communication"><br><br>

                <label>LOGISTICS:</label>
                <input type="text" name="logistics" placeholder="Type here..." size="20" v-model="form_entry.logistics"><br><br>

                <label>RELATIONSHIPS:</label>
                <input type="text" name="relationship" placeholder="Type here..." size="10" v-model='form_entry.relationships' name="relationships"><br><br>

                <label>SUPPORT:</label>
                <input type="text" name="support" placeholder="Type here..." size="10" v-model='form_entry.support'><br><br>
              </div>
              <div class="field">
                <label>2.)Are you aware of what you need to do in order to be successful in your role?</label>
                <div class="inline field" style="padding-left:2em" v-for="(role, i) in successful_roles" :key="i">
                  <div class="ui checkbox">
                    <input v-model="form_entry.successful_role" type="checkbox" :value="role" tabindex="0" class="hidden">
                    <label>{{role}}</label>
                  </div>
                </div>

              </div>
              <div class="field"><br>
                <label>3.) What tools do you need to consistently do your job well?</label>
                <input type="text" name="consistently" placeholder="Type here..." size="10" v-model='form_entry.consistently'><br>
              </div>
              <div class="field"><br>
                <label>4.) Areas for improvement that you wish to address in this workshop?</label>
                <input type="text" name="improvement" placeholder="Type here..." size="10" v-model='form_entry.improvement'><br>
              </div>
            </div>
            <button class="ui button" type="submit" id="myBtn">Submit</button>
          </form>
          <input type="button" class="ui button" id="dis_myBtn" @click="update_data()" style="position:relative;top: -36px;left:8rem" value="Update">
          <!-- onclick="enableBtn2();enableBtn1()" -->
          <div class="ui segment container">
            <div class="ui middle aligned divided list">
              <div class="item" v-for="(form,i) in forms" :key="i" style="vertical-align: middle !important;">
                <div class="right floated content">
                  <div class="ui basic icon button" @click="get_Entries(form.id) ">
                    <i class="ui green icon edit outline"></i>
                  </div>
                  <div class="ui basic icon button" @click="deleteEntry(form.id)">
                    <i class="ui icon trash alternate red o utline"></i>
                  </div>
                </div>
                <div class="content">
                  <span><strong>Department: </strong>{{form.department_id}}</span><br>
                  <span><strong>Communication: </strong>{{form.communication}}</span><br>
                  <span><strong>Logistics: </strong>{{form.logistics}}</span><br>
                  <span><strong>Relationships: </strong>{{form.relationships}}</span><br>
                  <span><strong>Support: </strong>{{form.support}}</span><br>
                  <span><strong>Role: </strong>{{form.successful_role}}</span><br>
                  <span><strong>Consistently: </strong>{{form.consistently}}</span><br>
                  <span><strong>Improvement: </strong>{{form.improvement}}</span>
                </div><br>

              </div>
            </div>
          </div>
        </div>




        <!-- add new modal start -->
        <!-- <div class="ui modal" id="addNewModal">
          <div class="header">
            Add a Scheduled Training
          </div>
          <div class="content">

            <form @submit.prevent="">
              <div class="ui clearable input">
                <input name="search" type="text" placeholder="Search..." v-model="training" @keyup="getScheduledTrainings()">
              </div>
            </form>

            <table id="scheduledTrainingsTable" class="ui table very comapct small">
              <tbody>
                <tr v-for="(scheduledTraining, s) in scheduledTrainings" :key="s">
                  <td>{{scheduledTraining.personneltrainings_id}}</td>
                  <td class="center aligned">
                    <button v-if="!scheduledTraining.isExisting" class="ui mini button" @click="addScheduledTraining(scheduledTraining.personneltrainings_id)"> Add </button>
                    <button v-else class="ui mini button disabled"> Added </button>
                  </td>
                  <td>{{ scheduledTraining.training }}</td>
                  <td>{{ scheduledTraining.startDate }}</td>
                  <td>{{ scheduledTraining.endDate }}</td>
                  <td>{{ scheduledTraining.venue }}</td>
                  <td>{{ scheduledTraining.remarks }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="actions">
            <div class="ui deny button">
              Cancel
            </div>
          </div>
        </div> -->
        <!-- add new modal end -->



        <!-- content end -->
      </div>
    </div>
  </template>
</div>
<script>
  var tna = new Vue({
    el: "#tna-app",
    data() {
      return {
        id: new URLSearchParams(window.location.search).get("id"),
        addedScheduledTrainings: [],
        forms: [],
        training: '',
        scheduledTrainings: [],
        departments: [],
        successful_roles: [
          'yes',
          'no'
        ],

        form_entry: {
          department_id: '',
          communication: '',
          logistics: '',
          relationships: '',
          support: '',
          successful_role: [],
          consistently: '',
          improvement: '',
        },

        form_entry_cleared: {
          communication: '',
          department_id: '',
          logistics: '',
          relationships: '',
          support: '',
          successful_role: [],
          consistently: '',
          improvement: '',

        }
      }
    },

    methods: {


      getAddedScheduledTrainings() {
        $.post("tna_proc.php", {
            getAddedScheduledTrainings: true,
          },
          (data, textStatus, jqXHR) => {
            this.addedScheduledTrainings = data
            console.log(data);
          },
          "json"
        );
      },

      addScheduledTraining(personneltrainings_id) {
        // console.log(personneltrainings_id);
        $.post("tna_proc.php", {
            addScheduledTraining: true,
            personneltrainings_id: personneltrainings_id
          },
          (data, textStatus, jqXHR) => {
            // console.log(data);
            window.location.href = 'tna_entries.php?id=' + personneltrainings_id;
          },
          "json"
        );
      },
      getDepartments() {
        $.post("tna_proc.php", {
            getDepartments: true,
          },
          (data, textStatus, jqXHR) => {
            this.departments = data
            // console.log(data);
          },
          "json"
        );
      },

      // For engagement
      update_data() {
        $.post('tna_proc.php', {
          update: true,
          department_id: this.id,
          for_engagement_id: this.form_entry.id,
          form_entry: this.form_entry

        }, (data, textStatus, xhr) => {
          this.getEntries()
          this.form_entry = JSON.parse(JSON.stringify(this.form_entry_cleared))
        });
        console.log(this.form_entry);
      },

      async deleteEntry(id) {
        await $.post('tna_proc.php', {
            deleteEntry: true,
            id: id
          },
          (data, textStatus, jqXHR) => {
            this.getEntries()
          },
          'json'
        );
      },

      submitEntry() {
        this.addNewEntry().then(() => {
          this.getEntries()
          this.form_entry = JSON.parse(JSON.stringify(this.form_entry_cleared))
        })
        console.log(this.form_entry);
      },
      async addNewEntry() {
        await $.post("tna_proc.php", {
            addNewEntry: true,
            form_entry: this.form_entry
          },
          (data, textStatus, jqXHR) => {
            // console.log(data);
          },
          "json"
        );
      },

      getScheduledTrainings() {
        $.post("tna_proc.php", {
            getScheduledTrainings: true,
            training: this.training
          },
          (data, textStatus, jqXHR) => {
            console.log(data);
            this.scheduledTrainings = data
          },
          "json"
        );
      },

      async getEntries() {
        await $.post("tna_proc.php", {
            getEntries: true,
          },
          (data, textStatus, jqXHR) => {
            this.forms = data

          },
          "json"
        );
      },

      get_Entries(id) {
        $.ajax({
          url: "tna_proc.php",
          method: "GET",
          data: {
            pull_data: true,
            for_engagement_id: id
          },
          dataType: "JSON",
          success: (form) => {
            this.form_entry = form
            console.log(form);
            $('#department_select').dropdown('set selected', form.department_id)
          }
        })
      },
      //end for engagement


      addNewModal() {
        $("#addNewModal").modal('show')
      },
    },

    mounted() {
      this.getAddedScheduledTrainings()
      $("#addNewModal").modal({
        onShow: () => {
          this.getScheduledTrainings()
        },
        onHide: () => {
          this.training = ''
          this.scheduledTrainings = []
        },
      })

      // var last;
      // document.addEventListener('input', (e) => {
      //   if (e.target.getAttribute('name') == "check") {
      //     if (last)
      //       last.checked = false;
      //   }
      //   e.target.checked = true;
      //   last = e.target;
      // })

      // test starts
      // $("#addNewModal").modal("show")
      // test end

      $('select.dropdown')
        .dropdown({
          fullTextSearch: 'exact'
        });

      $('.menu .item')
        .tab();
      $('.ui.checkbox')
        .checkbox();
      this.getEntries()
      this.getDepartments()

    }
  })
</script>





<?php require_once "footer.php"; ?>