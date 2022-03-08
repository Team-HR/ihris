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
                <!-- <button @click="" title="Quick Edit" class="ui button"><i class="edit outline icon"></i></button> -->
                <!-- <button @click="" title="Delete" class="ui button"><i class="red trash alternate outline icon"></i></button> -->
              </div>
            </td>
          </tr>

        </tbody>
      </table>



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
  </template>
</div>
<script>
  var tna = new Vue({
    el: "#tna-app",
    data() {
      return {
        addedScheduledTrainings: [],
        training: '',
        scheduledTrainings: [],
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


      // test starts
      // $("#addNewModal").modal("show")
      // test end

    }
  })
</script>


<?php require_once "footer.php"; ?>