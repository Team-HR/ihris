<?php
$title = "Casual Plantilla Setup";
require_once "header.php";
?>

<div class="ui container segment" id="app">
  <template>
    <table class="ui mini very compact celled structured table">
      <thead>
        <tr>
          <th></th>
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
          <td></td>
          <td>{{dat.year}}</td>
          <td>{{dat.period}}</td>
          <td>{{dat.nature}}</td>
        </tr>
        <tr>
          <td colspan="4">
            <button @click="initAdd" class="ui mini green icon button"><i class="icon add"></i></button>
          </td>
        </tr>
      </tbody>
    </table>


    <!-- modal start -->
    <div id="addNewModal" class="ui mini modal">
      <div class="header">Add New Plantilla</div>
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
            <select class="ui dropdown">
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
      <div class="actions"></div>
    </div>
    <!-- modal end -->
  </template>
</div>

<script>
  // $("#addNewModal").modal();
  Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    console.log(local.toJSON());
    return local.toJSON().slice(0, 4);
  });

  var app = new Vue({
    el: "#app",
    data: {
      data_insert: {
        fromId: null,
        year: null,
        period: null,
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
      addData() {
        console.log(this.data_insert)
        // $.ajax({
        //   type: "post",
        //   url: "casual_plantilla.ajax.php",
        //   data: {
        //     addData: true,
        //     data:data
        //   },
        //   dataType: "json",
        //   success: (response) => {

        //   }
        // });
      },
      initAdd() {
        $("#addNewModal").modal("show")
        if (this.data.length == 0) {
          // this.fromId = null
          this.addData()
        }
      }

    },
    mounted() {
      this.getData()
      this.data_insert.year = new Date().toDateInputValue()
      $("#addNewModal").modal("show")
    },
  });
</script>

<?php require_once "footer.php"; ?>