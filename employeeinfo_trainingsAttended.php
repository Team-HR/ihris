<?php
require_once "_connect.db.php";
$employees_id = $_GET["employees_id"];
?>
  <script type="text/javascript">
    $(document).ready(function(){
        // $(function() {
        //   $("#myTable").tablesorter({
        //     sortList: [[2,1]]
        //   });
        // });
    });
</script>
<button class="mini teal ui button" onclick="addTraining()"><i class="icon add"></i> Add Training</button>
<br>
<br>

  <table id="myTable" class="ui very basic celled table tablesorter" style="font-size: 12px">
    <thead>
    <tr>
        <th></th> 
        <!-- <th>Link</th> -->
        <th>Title of Training</th>
        <!-- <th>Remarks</th> -->
        <th>Date</th>
        <th>No. of Hours</th>
        <th>Venue</th>
    </tr>
    </thead>
    <tbody id="table-body"></tbody> 
  </table>
  

<!-- add training start -->
<div id="modal_add_tr" class="ui small modal">
  <div class="header">
    Add Training
  </div>
  <div class="content">
    <div class="ui grid">
      <div class="row">
        <div class="column">
            <!-- form start -->
          <form id="formAddTraining" class="ui form">
            <div class="field">
              <label>Training Title:</label>
              <div class="ui action input">
                <input required="" list="trainingsList_cal" id="inputTrainingsAttended" name="inputTrainingsAttended" type="text" placeholder="Training Title">
                <button id="clearBtn_cal" class="ui button icon mini" title="Clear"><i class="icon large times"></i></button>
                <datalist id="trainingsList_cal">
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
                <input required="" id="inputDate1TrainingsAttended" type="date" name="inputDate1TrainingsAttended">
              </div>
              <div class="seven wide field">
                <label>End Date:</label>
                <input required="" id="inputDate2TrainingsAttended" type="date" name="inputDate2TrainingsAttended">
              </div>
              <div class="three wide field">
                <label>Hrs:</label>
                <input id="inputHrsTrainingsAttended" type="text" name="inputHrsTrainingsAttended" placeholder="No. Hours">
              </div>
            </div>
            <div class="fields">
              <div class="six wide field">
                <label>Time to Start:</label>
                <input id="inputTime1TrainingsAttended" type="time" name="inputTime1TrainingsAttended" value="08:00">
              </div>
              <div class="six wide field">
                <label>Time to End:</label>
                <input id="inputTime2TrainingsAttended" type="time" name="inputTime2TrainingsAttended" value="17:00">
              </div>
            </div>
            <div class="field">
              <label>Venue:</label>
              <input required="" id="inputVenueTrainingsAttended" type="text" name="inputVenueTrainingsAttended" placeholder="Venue">
            </div>
            <div class="field">
              <label>Remarks:</label>
              <input id="inputRemarksTrainingsAttended" type="text" name="inputRemarksTrainingsAttended" placeholder="Remarks">
            </div>
          </form>
          <!-- form end -->
        </div>
      </div>
    </div>


  </div>
  <div class="actions"> 
    <button onclick="$('#formAddTraining')[0].reset();" class="ui deny button mini">
      Cancel
    </button>
    <button form="formAddTraining" class="ui approve blue right labeled icon button mini">
      Save
      <i class="checkmark icon"></i>
    </button>
  </div>
</div>
<!-- add training end -->



  <script type="text/javascript">
      jQuery(document).ready(function($) {
            
            $(getRows);

        $("#inputDate1TrainingsAttended").change(function(){
            var date1 = $("#inputDate1TrainingsAttended").val(),
            date2 = $("#inputDate2TrainingsAttended").val(),
            hrs = date_diff_indays_cal(date1,date2);
            $("#inputHrsTrainingsAttended").val(hrs)
          });

          $("#inputDate2TrainingsAttended").change(function(){
            var date1 = $("#inputDate1TrainingsAttended").val(),
            date2 = $("#inputDate2TrainingsAttended").val(),
            hrs = date_diff_indays_cal(date1,date2);
            $("#inputHrsTrainingsAttended").val(hrs)
          });


          // on submit formAddTraining

          $('#formAddTraining').submit(function(event) {
              /* Act on the event */
              event.preventDefault();

    $.post('personneltrainings_proc.php', {
      addTraining: true,
      training: $("#inputTrainingsAttended").val(),
      startDate: $("#inputDate1TrainingsAttended").val(),
      endDate: $("#inputDate2TrainingsAttended").val(),
      numHours: $("#inputHrsTrainingsAttended").val(),
      venue: $("#inputVenueTrainingsAttended").val(),
      remarks: $("#inputRemarksTrainingsAttended").val(),
      timeStart: $("#inputTime1TrainingsAttended").val(),
      timeEnd: $("#inputTime2TrainingsAttended").val(),
      addQueries: [<?=$employees_id?>],
    }, function(data, textStatus, xhr) {
        $('#formAddTraining')[0].reset();
        $(getRows);
        $('#modal_add_tr').modal('hide');
    });
              // $('#modal_add_tr').modal('hide');

            // console.log($(this).serializeArray());

          });
      });

      function addTraining(){

        $('#modal_add_tr').modal({
                closable: false,
                onApprove: function(){
                    return false;
                },
                onDeny: function(){
            
                },
            }).modal("show");
      }

      function getRows(){

        $.post('employeeinfo_trainingsAttended_proc.php', {'getTrainingRows': true , 'employees_id': <?=$employees_id?>}, function(data, textStatus, xhr) {
            /*optional stuff to do after success */
            // console.log('done: ',data);
            if (data) {
                json = $.parseJSON(data);
                $('#table-body').html(json);    
            }
            
        });
      }

      function date_diff_indays_cal(date1, date2) {
          dt1 = new Date(date1);
          dt2 = new Date(date2);
          days = Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate()) ) /(1000 * 60 * 60 * 24));
          if (days == 0) {
            return 8;
          } else if (days > 0){
            return Math.floor((days+1)*(8));
          } else {
            return 0;
          }
        }
  </script>
