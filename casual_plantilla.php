<?php
$title = "Casual Plantilla Setup";
require_once "header.php";
?>

<div class="ui container borderless blue inverted mini menu">
    <div class="left item" style="margin-right: 0px !important;">
        <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
            <i class="icon chevron left"></i> Back
        </button>
    </div>
    <div class="item">
        <h3><i class="briefcase icon"></i>Casual Plantilla</h3>
    </div>
    <div class="right item">
        <!-- 
      <button onclick="addModalFunc()" class="circular blue ui icon button" style="margin-right: 10px;" title="Add New Personnel">
        <i class="icon plus circle"></i>
      </button> -->
        <!-- <div class="ui right input">
            <button class="ui icon mini green button" onclick="addModalFunc()" style="margin-right: 5px;" title="Add New Department"><i class="icon plus"></i>Add</button>
            <div class="ui icon fluid input" style="width: 300px;">
                <input id="pos_search" type="text" placeholder="Search...">
                <i class="search icon"></i>
            </div>
        </div> -->
        <!-- <div class="ui icon fluid input">
        <input id="pos_search" type="text" placeholder="Search...">
        <i class="search icon"></i>
      </div> -->
    </div>
</div>

<div class="ui container segment" id="app">
  <template>
    <table class="ui mini collapsing very compact celled structured table">
      <thead>
        <tr>
          <th><button @click="initAdd" class="ui mini green icon button"><i class="icon add"></i></button></th>
          <th>Year</th>
          <th>Period</th>
          <th>Nature of Appointment</th>
        </tr>
      </thead>
      <tbody>
        <tr v-if="data.length == 0">
          <td colspan="4" class="center aligned">-- Records Empty! --</td>
        </tr>
        <tr v-for="(dat,id) in data">
          <td><a :href="'casual_plantilla_list.php?id='+dat.id" class="ui mini button icon yellow"><i class="icon link folder"></i></a></td>
          <td>{{dat.year}}</td>
          <td>{{dat.period}}</td>
          <td>{{dat.nature}}</td>
        </tr>
      </tbody>
    </table>


    <!-- modal start -->
    <div id="addNewModal" class="ui mini modal">
      <div class="header">Add New Casual Plantilla</div>
      <div class="content">
        <div class="ui form">
          <div class="two fields">
            <div class="field">
              <label>Nature of Appointment</label>
              <select class="ui dropdown" v-model="data_insert.nature">
                <option value="" disabled selected>Select...</option>
                <option value="Orginal">Orginal</option>
                <option value="Reappointment">Reappointment</option>
                <option value="Reemployment">Reemployment</option>
              </select>
            </div>
            <div class="field">
              <label>Year</label>
              <input type="number" min="2019" max="3000" step="1" v-model="data_insert.year">
            </div>
          </div>
          <h5>Period</h5>
          <hr>
          <div class="field">
            <select class="ui dropdown" v-model="data_insert.period">
              <option value="1">1st Period (January 1 - June 30)</option>
              <option value="2">2nd Period (July 1 - December 30)</option>
            </select>
          </div>

          <!-- <div class="two fields">
            <div class="field">
              <label>From</label>
              <input type="date">
            </div>
            <div class="field">
              <label>To</label>
              <input type="date">
            </div>
          </div> -->

        </div>
      </div>
      <div class="actions">
        <button class="ui green button approve" @click="submitData">Save</button>
        <button class="ui red button deny">Cancel</button>
      </div>
    </div>
    <!-- modal end -->
  </template>
</div>

<script>
  Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0, 4);
  });

  var app = new Vue({
    el: "#app",
    data: {
      data_insert: {
        fromId: null,
        year: null,
        period: 1,
        nature: ""
      },
      data: []
    },
    methods: {
      getData() {
        $.ajax({
          type: "post",
          url: "casual_plantilla.ajax.php",
          data: {
            getData: true,
          },
          dataType: "json",
          success: (response) => {
            this.data = response
          },
          async: false
        });
      },
      submitData() {
        // console.log(this.data_insert)
        $.ajax({
          type: "post",
          url: "casual_plantilla.ajax.php",
          data: {
            addData: true,
            data: this.data_insert
          },
          dataType: "json",
          success: (response) => {
            this.getData()
            console.log("added");
          }
        });
      },
      reset() {
        return {
          fromId: null,
          year: new Date().toDateInputValue(),
          period: 1,
          nature: ""
        }
      },

      initAdd() {
        this.data_insert = this.reset()
        $("#addNewModal").modal("show")
      }

    },
    mounted() {
      this.getData()
      // this.initAdd()
    },
  });
</script>

<?php require_once "footer.php"; ?>