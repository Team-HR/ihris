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
          </div>
        </div>
      </div>
      <!-- content start -->

      <div class="ui fluid container segment" style="min-height: 100%;">
        <div class="ui top attached tabular tna menu">
          <a class="item active" data-tab="first"> For Strategic</a>
          <a class="item" data-tab="second">For Employee Engagement</a>
        </div>
        <!-- <div class="ui bottom attached tab segment active" data-tab="first">
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
        </div> -->
        <div class="ui bottom attached tab segment" data-tab="second">

          <form class="ui form" @submit.prevent="submitEntry()">
            <div class="ui segment">
              <div class="field">
                <label>1.) What challenes are you confronted with?</label><br>
                <label>COMMUNICATION:</label>
                <input type="text" name="Challenges Confronted With" placeholder="Type here..." size="10"><br><br>

                <label>LOGISTICS:</label>
                <input type="text" name="Logistics" placeholder="Type here..." size="20"><br><br>

                <label>RELATIONSHIPS:</label>
                <input type="text" name="relationship" placeholder="Type here..." size="10"><br><br>

                <label>SUPPORT:</label>
                <input type="text" name="relationship" placeholder="Type here..." size="10"><br><br>
              </div>
              <div class="field">
                <label>2.)Are you aware of what you need to do in order to be successful in your role?</label>

                <div class="inline field" style="padding-left:2em">
                  <div class="ui checkbox">
                    <input type="checkbox" name="check">
                    <label>Yes</label>
                  </div>
                  <div class="ui checkbox" style="padding-left:10em">
                    <input type="checkbox" name="check">
                    <label>No</label>
                  </div>

                </div>

              </div>
              <div class="field"><br>
                <label>3.) What tools do you need to consistently do your job well?</label>
                <input type="text" name="consistently" placeholder="Type here..." size="10"><br>
              </div>
              <div class="field"><br>
                <label>4.) Areas for improvement that you wish to address in this workshop?</label>
                <input type="text" name="consistently" placeholder="Type here..." size="10"><br>
              </div>
            </div>
            <button class="ui button" type="submit" id="myBtn">Submit</button>
          </form>

        </div>


        <!-- add new modal start -->
        <div class="ui modal" id="addNewModal">
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
                  <!-- <td>{{scheduledTraining.personneltrainings_id}}</td> -->
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
        </div>
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
        items:[],
        training: '',
        scheduledTrainings: [],

        form_entry: {
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

      // For engagement
      submitEntry() {
        this.addNewEntry().then(() => {
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



      $('.menu .item')
        .tab();
      $('.ui.checkbox')
        .checkbox();

    }
  })
</script>


<?php require_once "footer.php"; ?>