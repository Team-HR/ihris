<?php
$title = "Trainings/Evaluation";
require_once "header.php";
// if (!empty($_GET['deleteSuccess']) && $_GET['deleteSuccess'] == "" ){
// if (isset($_GET['deleteSuccess'])){
//   echo '<script>
//     $(document).ready(function() {
//       $(deletedMsg);
//     });
//   </script>';
// }
?>
<!-- asdadwasd -->
<script type="text/javascript">
  var addQueries = [];
  $(document).ready(function() {

    // search listAdded Start
    $("#inputSearchAdded").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $(".listAdded .item").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
    // search listAdded End
    // search listToAdd Start
    $("#inputSearchToAdd").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $(".listToAdd .item").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
    // search listToAdd End

    $("#inputDate1").change(function() {
      var date1 = $("#inputDate1").val(),
        date2 = $("#inputDate2").val(),
        hrs = date_diff_indays(date1, date2);
      $("#inputHrs").val(hrs)
    });

    $("#inputDate2").change(function() {
      var date1 = $("#inputDate1").val(),
        date2 = $("#inputDate2").val(),
        hrs = date_diff_indays(date1, date2);
      $("#inputHrs").val(hrs)
    });

    $("#inputDate1Edit").change(function() {
      var date1 = $("#inputDate1Edit").val(),
        date2 = $("#inputDate2Edit").val(),
        hrs = date_diff_indays(date1, date2);
      $("#inputHrsEdit").val(hrs)
    });

    $("#inputDate2Edit").change(function() {
      var date1 = $("#inputDate1Edit").val(),
        date2 = $("#inputDate2Edit").val(),
        hrs = date_diff_indays(date1, date2);
      $("#inputHrsEdit").val(hrs)
    });

    $("#sortYear").dropdown({
      onChange: function(value) {
        load(value);
      }
    });

    $("#trainings_search").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#tableBody1 tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

    $("#clearBtn").click(function(event) {
      $("#inputTraining").val("");
    });

    $("#clearBtnEdit").click(function(event) {
      $("#inputTrainingEdit").val("");
    });

    $(load(""));
  });

  function clear() {
    $("#inputTraining").val("");
    $("#inputDate1").val("");
    $("#inputDate2").val("");
    $("#inputTime1").val("08:00:00");
    $("#inputTime2").val("17:00:00");
    $("#inputHrs").val("");
    $("#inputVenue").val("");
    $("#inputRemarks").val("");
    $(".listAdded").empty();
    addQueries = [];
  }

  function load(year) {

    this.personneltrainingsApp.initLoad()
    // $("#tableBody1").load('personneltrainings_proc.php', {
    //     load: true,
    //     year: year,
    //   },
    //   function() {
    //   });
  }

  function addTraining() {
    // alert(addQueries);
    $.post('personneltrainings_proc.php', {
      addTraining: true,
      training: $("#inputTraining").val(),
      startDate: $("#inputDate1").val(),
      endDate: $("#inputDate2").val(),
      numHours: $("#inputHrs").val(),
      venue: $("#inputVenue").val(),
      remarks: $("#inputRemarks").val(),
      timeStart: $("#inputTime1").val(),
      timeEnd: $("#inputTime2").val(),
      addQueries: addQueries,
    }, function(data, textStatus, xhr) {
      $(clear);
      $(load(""));
      $(addedMsg);
    });
  }


  function addModalFunc() {
    $(loadListToAdd);
    $("#addModal").modal({
      closable: false,
      onApprove: function() {
        $(addTraining);
      },
      onDeny: function() {
        $(clear);
      }
    }).modal("show");
  }

  function loadListToAdd() {
    $(".listToAdd").load('personneltrainings_proc.php', {
        loadListToAdd: true,
      },
      function() {
        /* Stuff to do after the page is loaded */
      });
  }

  function addToList(employees_id) {
    addQueries.push(employees_id);
    $(".listAdded").prepend($('#' + employees_id));
    $('#' + employees_id + " button").attr('onclick', 'removeFromList(' + employees_id + ')');
    $('#' + employees_id + " button i").removeClass('add');
    $('#' + employees_id + " button i").addClass('times');
  }

  function removeFromList(employees_id) {
    // addQueries.push("DELETE FROM `personneltrainingslist` WHERE `employees_id`='"+employees_id+"' AND `personneltrainings_id` = ");

    addQueries = jQuery.grep(addQueries, function(value) {
      return value != employees_id;
    });

    $(".listToAdd").prepend($('#' + employees_id));
    $('#' + employees_id + " button").attr('onclick', "addToList('" + employees_id + "')");
    $('#' + employees_id + " button i").removeClass('times');
    $('#' + employees_id + " button i").addClass('add');
  }

  // get num of hours start
  var date_diff_indays = function(date1, date2) {
    dt1 = new Date(date1);
    dt2 = new Date(date2);
    days = Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate())) / (1000 * 60 * 60 * 24));
    if (days == 0) {
      return 8;
    } else if (days > 0) {
      return Math.floor((days + 1) * (8));
    } else {
      return 0;
    }
  }
  // get num of hours end
</script>
<div id="personneltrainings-app">
  <template>
    <!-- add msg alert start -->
    <div id="addedMsg" class="" style="top: 15px; display: none; position: fixed; z-index: 10; width: 100%; left: 0; text-align: center;">
      <div class="ui center green inverted aligned segment" style="width: 100px; margin-left: auto; margin-right: auto;">
        <i class="checkmark icon"></i> Added!
      </div>
    </div>
    <!-- add msg alert end -->


    <!-- save msg alert start -->
    <div id="savedMsg" class="" style="top: 15px; display: none; position: fixed; z-index: 10; width: 100%; left: 0; text-align: center;">
      <div class="ui center green inverted aligned segment" style="width: 100px; margin-left: auto; margin-right: auto;">
        <i class="checkmark icon"></i> Saved!
      </div>
    </div>
    <!-- save msg alert end -->

    <!-- delete msg alert start -->
    <div id="deletedMsg" class="" style="top: 15px; display: none; position: fixed; z-index: 10; width: 100%; left: 0; text-align: center;">
      <div class="ui center yellow inverted aligned segment" style="width: 120px; margin-left: auto; margin-right: auto;">
        <i class="checkmark icon"></i> Removed!
      </div>
    </div>
    <!-- delete msg alert end -->

    <!-- add training start -->
    <div id="addModal" class="ui large modal">
      <div class="header">
        Add Training
      </div>
      <div class="content">
        <div class="ui grid">
          <div class="three column row">
            <div class="eight wide column">
              <div class="ui form">
                <div class="field">
                  <label>Training Title:</label>
                  <div class="ui action input">
                    <input required="" list="trainingsList" id="inputTraining" type="text" placeholder="Training Title">
                    <button id="clearBtn" class="ui button icon mini" title="Clear"><i class="icon large times"></i></button>
                    <datalist id="trainingsList">
                      <?php
                      require_once "_connect.db.php";
                      $result = $mysqli->query("SELECT * FROM `trainings`");
                      while ($row = $result->fetch_assoc()) {
                        print "<option value=\"{$row['training']}\">";
                      }
                      ?>
                    </datalist>
                  </div>
                </div>
                <div class="fields">
                  <div class="seven wide field">
                    <label>Start Date:</label>
                    <input id="inputDate1" type="date" name="">
                  </div>
                  <div class="seven wide field">
                    <label>End Date:</label>
                    <input id="inputDate2" type="date" name="">
                  </div>
                  <div class="three wide field">
                    <label>Hrs:</label>
                    <input id="inputHrs" type="text" name="">
                  </div>
                </div>



                <!-- input time start  -->
                <div class="fields">
                  <div class="six wide field">
                    <label>Time to Start:</label>
                    <input id="inputTime1" type="time" name="" value="08:00">
                  </div>
                  <div class="six wide field">
                    <label>Time to End:</label>
                    <input id="inputTime2" type="time" name="" value="17:00">
                  </div>
                </div>
                <!-- input time end  -->



                <div class="field">
                  <label>Venue:</label>
                  <input id="inputVenue" type="text" name="" placeholder="Venue">
                </div>
                <div class="field">
                  <label>Remarks:</label>
                  <input id="inputRemarks" type="text" name="" placeholder="Remarks">
                </div>
              </div>

            </div>
            <div class="four wide column">
              <div class="ui form">
                <div class="field">
                  <label>Personnels Involved:</label>
                  <div class="ui icon input">
                    <input id="inputSearchAdded" type="text" placeholder="Search...">
                    <i class="search icon"></i>
                  </div>
                </div>
                <div class="listAdded ui middle aligned tiny list" style="overflow-y: scroll; height: 300px;"></div>
              </div>
            </div>
            <div class="four wide column">
              <div class="ui form">
                <div class="field">
                  <label>Personnel List:</label>
                  <div class="ui icon input">
                    <input id="inputSearchToAdd" type="text" placeholder="Search...">
                    <i class="search icon"></i>
                  </div>
                </div>
                <div class="listToAdd ui middle aligned tiny list" style="overflow-y: scroll; height: 300px;"></div>
              </div>
            </div>

          </div>
        </div>


      </div>
      <div class="actions">
        <div class="ui deny button mini">
          Cancel
        </div>
        <div class="ui approve blue right labeled icon button mini">
          Save
          <i class="checkmark icon"></i>
        </div>
      </div>
    </div>
    <!-- add training end -->
    <!-- edit training start -->
    <div id="editModal" class="ui tiny modal">
      <div class="header">
        Edit Training
      </div>
      <div class="content">

        <div class="ui form">
          <div class="field">
            <label>Training Title:</label>
            <div class="ui action input">
              <input required="" list="trainingsList" id="inputTrainingEdit" type="text" placeholder="Training Title">
              <button id="clearBtnEdit" class="ui button icon mini" title="Clear"><i class="icon large times"></i></button>
              <datalist id="trainingsList">
                <?php
                require_once "_connect.db.php";
                $result = $mysqli->query("SELECT * FROM `trainings`");
                while ($row = $result->fetch_assoc()) {
                  print "<option value=\"{$row['training']}\">";
                }
                ?>
              </datalist>
            </div>
          </div>
          <div class="fields">
            <div class="seven wide field">
              <label>Start Date:</label>
              <input id="inputDate1Edit" type="date" name="">
            </div>
            <div class="seven wide field">
              <label>End Date:</label>
              <input id="inputDate2Edit" type="date" name="">
            </div>
            <div class="three wide field">
              <label>Hrs:</label>
              <input id="inputHrsEdit" type="text" name="">
            </div>
          </div>


          <!-- input time start  -->
          <div class="fields">
            <div class="six wide field">
              <label>Time to Start:</label>
              <input id="inputTime1_edit" type="time" name="">
            </div>
            <div class="six wide field">
              <label>Time to End:</label>
              <input id="inputTime2_edit" type="time" name="">
            </div>
          </div>
          <!-- input time end  -->



          <div class="field">
            <label>Venue:</label>
            <input id="inputVenueEdit" type="text" name="" placeholder="Venue">
          </div>
          <div class="field">
            <label>Remarks:</label>
            <input id="inputRemarksEdit" type="text" name="" placeholder="Remarks">
          </div>
        </div>

      </div>
      <div class="actions">
        <div class="ui deny button mini">
          Cancel
        </div>
        <div class="ui approve blue right labeled icon button mini">
          Save
          <i class="checkmark icon"></i>
        </div>
      </div>
    </div>
    <!-- edit training end -->
    <!-- delete training start -->
    <div id="deleteModal" class="ui mini modal">
      <i class="close icon"></i>
      <div class="header">
        Delete Training
      </div>
      <div class="content">
        <p>Are you sure you want to delete this training entry?</p>
      </div>
        <div class="ui deny button mini">
          No
        </div>
        <div class="ui blue right labeled icon approve button mini">
          Yes
          <i class="checkmark icon"></i>
        </div>
      </div>
    </div>
    <!-- delete training end -->
    <div class="ui container">
      <div class="ui borderless blue inverted mini menu">
        <div class="left item" style="margin-right: 0px !important;">
          <button onclick="window.history.back();" class="blue ui mini icon button" title="Back" style="width: 65px;"><i class="icon chevron left"></i> Back</button>
        </div>
        <div class="item">
          <h3><i class="certificate icon"></i> Personnel Trainings</h3>
        </div>
        <div class="right item">
          <div class="ui right input">
            <button class="ui icon mini green button" onclick="_calendar()" style="margin-right: 5px;"><i class="icon plus"></i>Add</button>
            <!-- <div style="padding: 0px; margin: 0px; margin-right: 5px;">
              <select id="sortYear" class="ui floating dropdown compact selection">
                <option value="all">All</option>
                <?php
                require_once "_connect.db.php";
                $sql = "SELECT DISTINCT year(`startDate`) AS `years` FROM `personneltrainings` ORDER BY `years` DESC";
                $result = $mysqli->query($sql);
                while ($row = $result->fetch_assoc()) {
                  $years = $row["years"];
                  echo "<option value=\"$years\">$years</option>";
                }
                ?>
              </select>
            </div> -->
            <div class="ui icon fluid input" style="width: 300px;">
              <input id="trainings_search" type="text" placeholder="Search...">
              <i class="search icon"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="ui fluid container segment" style="min-height: 1000px;">
        <div class="ui top attached tabular personneltrainings menu">
          <a class="item active" data-tab="first">Evaluation Reports</a>
          <a class="item" data-tab="second">For Encoding</a>
        </div>
        <div class="ui bottom attached tab segment active" data-tab="first">
          <table id="trTable" class="ui blue selectable striped very compact small table" style="font-size: 12px;">
            <thead>
              <tr>
                <th></th>
                <th></th>
                <th>Training</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Hrs</th>
                <th>Venue</th>
                <th>Remarks</th>
                <th>Survey Respondents</th>
                <th class="center aligned">Options</th>
              </tr>
            </thead>
            <tbody id="tableBody1">
              <tr v-for="(item, index) in items" :key="index">
                <td>({{index+1}})</td>
                <td>
                  <a :href="`personneltrainingspreview.php?personneltrainings_id=${item.personneltrainings_id}`" title="Open" class="ui basic mini icon button"><i class="folder open outline primary icon"></i></a>
                </td>
                <td>{{item.training}}</td>
                <td>{{item.startDate}}</td>
                <td>{{item.endDate}}</td>
                <td>{{item.numHours}}</td>
                <td>{{item.venue}}</td>
                <td>{{item.remarks}}</td>
                <td>{{item.numberOfRespondents}}</td>
                <td>
                  <div class="ui icon basic mini buttons">
                    <!-- <a :href="`personneltrainingspreview.php?personneltrainings_id=${item.personneltrainings_id}`" title="Open" class="ui button"><i class="folder open outline icon"></i></a> -->
                    <button @click="editFunc(`${item.personneltrainings_id}`)" title="Quick Edit" class="ui button"><i class="edit outline icon"></i></button>
                    <button @click="deleteFunc(`${item.personneltrainings_id}`)" title="Delete" class="ui button"><i class="trash alternate outline icon"></i></button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="ui bottom attached tab segment" data-tab="second">
          <table id="trTable" class="ui blue selectable striped very compact small table" style="font-size: 12px;">
            <thead>
              <tr>
                <th></th>
                <th>Training</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Hrs</th>
                <th>Venue</th>
                <th>Remarks</th>
                <!-- <th>Survey Respondents</th> -->
                <th class="center aligned">Options</th>
              </tr>
            </thead>
            <tbody id="tableBody1">
              <tr v-for="(item, index) in itemsNoRespondents" :key="index">
                <td>({{index+1}})</td>
                <td>{{item.training}}</td>
                <td>{{item.startDate}}</td>
                <td>{{item.endDate}}</td>
                <td>{{item.numHours}}</td>
                <td>{{item.venue}}</td>
                <td>{{item.remarks}}</td>
                <!-- <td>{{item.numberOfRespondents}}</td> -->
                <td>
                  <div class="ui icon basic mini buttons">
                    <a :href="`personneltrainingspreview.php?personneltrainings_id=${item.personneltrainings_id}`" title="Open" class="ui button"><i class="folder open outline icon"></i></a>
                    <button @click="editFunc(`${item.personneltrainings_id}`)" title="Quick Edit" class="ui button"><i class="edit outline icon"></i></button>
                    <button @click="deleteFunc(`${item.personneltrainings_id}`)" title="Delete" class="ui button"><i class="trash alternate outline icon"></i></button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </template>
</div>
<script src="personneltrainings.js"></script>
<?php require_once "footer.php"; ?>