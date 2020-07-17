<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true && $_SESSION["type"] !== "admin"){
  header("location: login.php");
  exit;
}

?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title?></title>
<!--  <meta charset="UTF-8" name="google" value="notranslate" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/> -->
  <meta name="viewport" content="width=device-width, height=device-height , initial-scale=1">

  <script src="node_modules\vue\dist\vue.min.js"></script>
  <!-- development version, includes helpful console warnings -->
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <!-- <script src="node_modules\moment\min\moment.min.js"></script> -->

  <!-- <script src="jquery/jquery-3.3.1.min.js"></script> -->
  <script src="node_modules/jquery/dist/jquery.min.js"></script>
  <!-- <link rel="stylesheet" type="text/css" href="ui/dist/semantic.css"> -->
  <link rel="stylesheet" type="text/css" href="semantic/dist/semantic.min.css">
  <script src="semantic/dist/semantic.min.js"></script>
  <script src="node_modules/chart.js/dist/Chart.js"></script>
  <script src="node_modules/chart.js/dist/Chart.min.js"></script>
  
  <!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> -->

  <link href='fullcalendar4/packages/core/main.css' rel='stylesheet' />
  <link href='fullcalendar4/packages/daygrid/main.css' rel='stylesheet' />
  <script src='fullcalendar4/packages/core/main.js'></script>
  <script src='fullcalendar4/packages/interaction/main.js'></script>
  <script src='fullcalendar4/packages/daygrid/main.js'></script>


  <style>
    @page {
      margin-top: 0.5cm;
      margin-bottom: 0.5cm;
      margin-left: 0.5cm;
      margin-right: 0.5cm;
    }
    .printOnly {
      display : none;
    }
    @media print{
      body {
        background: none !important;
        background-image: none !important;
      }

      .printCompactText{
        font-size: 11px !important;
      }
      .printOnly {
         display : block;
        }
      .noprint {
        display:none !important;
        /*margin: 0px !important;*/
        /*padding: 0px !important;*/
      }
      .noBorderPrint {
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
        /*margin: 0px !important;*/
        /*padding: 0px !important;*/
        border: none !important;
      }
      .centerPrint {margin: 0 auto; width: 100%;}
    }
    .modal {
      top: 20px !important;
    }
  </style>

</head>
<!-- <body class="" style="background-image: url(assets/bgs/ihris_bg2.png); background-repeat: no-repeat; background-attachment: fixed;"> -->
  <body style="
    background: url(assets/bgs/circuitboardbg.gif) no-repeat center center fixed;
    -moz-background-size: cover;
    -webkit-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
">
  <script type="text/javascript">
    var addQueries_cal = [];
    var calendar;
    $(document).ready(function() {

      // $('.coupled').modal({
      //   allowMultiple: true
      // });

      $('.ui.sticky').sticky({context: '#side_rail'});

    var events = [];
    var calendarEl = document.getElementById('calendarElem');

    calendar = new FullCalendar.Calendar(calendarEl, {
      // aspectRatio: 3.2,
      // width: 1000,
      theme: "bootstrap",
      height: "auto",
      plugins: [ 'interaction', 'dayGrid' ],
      // plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth'
        // right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
      },
      
      eventLimit: true, // for all non-TimeGrid views
      views: {
        dayGrid: {
          eventLimit: 2 // adjust to 6 only for timeGridWeek/timeGridDay
        }
      },

      selectable: true,
      select: function(info) {
        // alert('selected ' + info.startStr + ' to ' + info.endStr);
        // alert('clicked ' + info.dateStr);
        dateStart = info.startStr;
        $("#inputDate1_cal").val(dateStart);

        str = info.endStr;
        dateEnd = (parseInt(str.substring(0, 4), 10)) + "-" +
            pad(parseInt(str.substring(6), 10)) + "-" +
            pad(parseInt(str.substring(8, 10), 10)-1);
        // alert(dateEnd);
        $("#inputDate2_cal").val(dateEnd);
        // $("#event").html(info.dateStr);

        hrs = date_diff_indays_cal(dateStart, dateEnd);
        $("#inputHrs_cal").val(hrs);

        $(loadListToAdd_cal);
        $("#calendar_add_modl").modal({
          // transition: "drop",
          closable: false,
          allowMultiple: true,
          onApprove: function (){
            // alert($("#inputDate1_cal").val());
            // alert(addQueries_cal);
            $(addTraining_cal());
          },
          onDeny: function(){
            $(clear_cal);
          }
        }).modal("show");
      },
      defaultDate: <?php echo json_encode(date('Y-m-d'));?>,//'2019-06-12',
      navLinks: false,
      editable: false,
      allDay: true,
      displayEventTime: true,
      displayEventEnd: true,
      eventLimit: true, // allow "more" link when too many events
      events: {
        url: 'calendar_proc.php',
        method: 'POST',
        extraParams: {
          getCalendarData: true
        },
        failure: function() {
          alert('there was an error while fetching events!');
        },
        // color: 'yellow',   // a non-ajax option
        // textColor: 'black' // a non-ajax option
      },

    eventClick: function (info){
      info.jsEvent.preventDefault();

      if (info.event.url) {
        // window.open(info.event.url+"&start="+info.event.start.toISOString(),"_blank");
        // window.open(info.event.url+"&start="+info.event.start.toISOString(),"_blank");
        window.location.replace(info.event.url+"&start="+info.event.start.toISOString());
        // alert(info.event.start.toISOString());
      }
    }
    });

    calendar.render();

  $("#inputDate1_cal").change(function(){
    var date1 = $("#inputDate1_cal").val(),
    date2 = $("#inputDate2_cal").val(),
    hrs = date_diff_indays_cal(date1,date2);
    $("#inputHrs_cal").val(hrs)
  });

  $("#inputDate2_cal").change(function(){
    var date1 = $("#inputDate1_cal").val(),
    date2 = $("#inputDate2_cal").val(),
    hrs = date_diff_indays_cal(date1,date2);
    $("#inputHrs_cal").val(hrs)
  });

  $("#clearBtn_cal").click(function(event) {
    $("#inputTraining_cal").val("");
  });


$("#inputSearchToAdd_cal").on("keyup", function() {
  var value = $(this).val().toLowerCase();
  $(".listToAdd_cal .item").filter(function() {
    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
  });
});

$("#inputSearchAdded_cal").on("keyup", function() {
  var value = $(this).val().toLowerCase();
  $(".listAdded_cal .item").filter(function() {
    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
  });
});

    });

  function _calendar(){
      // alert();
      calendar.refetchEvents();
      $("#calendar_modl").modal({
        transition: "drop",
        closable: false,
        allowMultiple: true
      }).modal("show");
      // $(".fc-dayGridMonth-button").click();

    }

  function pad (str) {
      str = str.toString();
      return str.length < 2 ? pad("0" + str, 2) : str;
    }

      // functions from personnel trainings down below
  function loadListToAdd_cal(){
        $(".listToAdd_cal").load('personneltrainings_proc.php',{
          loadListToAdd_cal: true,
        }, function(){
          /* Stuff to do after the page is loaded */
        }); 
      }
  
  function addTraining_cal(){
    // alert(addQueries);
    $.post('personneltrainings_proc.php', {
      addTraining: true,
      training: $("#inputTraining_cal").val(),
      startDate: $("#inputDate1_cal").val(),
      endDate: $("#inputDate2_cal").val(),
      numHours: $("#inputHrs_cal").val(),
      venue: $("#inputVenue_cal").val(),
      remarks: $("#inputRemarks_cal").val(),
      timeStart: $("#inputTime1_cal").val(),
      timeEnd: $("#inputTime2_cal").val(),
      addQueries: addQueries_cal,
    }, function(data, textStatus, xhr) {
      $(clear_cal);
      $(load(""));
      // $(addedMsg);
      calendar.refetchEvents();
    });
  }


function addToList_cal(employees_id){
  addQueries_cal.push(employees_id);
  $(".listAdded_cal").prepend($('#cal'+ employees_id));
  $('#cal'+ employees_id+" button").attr('onclick', 'removeFromList_cal('+employees_id+')');
  $('#cal'+ employees_id+" button i").removeClass('add');
  $('#cal'+ employees_id+" button i").addClass('times');
}

function removeFromList_cal(employees_id){
  addQueries_cal = jQuery.grep(addQueries_cal, function(value) {
    return value != employees_id;
});

  $(".listToAdd_cal").prepend($('#cal'+ employees_id));
  $('#cal'+ employees_id+" button").attr('onclick', "addToList_cal('"+employees_id+"')");
  $('#cal'+ employees_id+" button i").removeClass('times');
  $('#cal'+ employees_id+" button i").addClass('add');
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

function clear_cal(){
  $("#inputTraining_cal").val("");
  $("#inputDate1_cal").val("");
  $("#inputDate2_cal").val("");
  $("#inputTime1_cal").val("08:00:00");
  $("#inputTime2_cal").val("17:00:00");
  $("#inputHrs_cal").val("");
  $("#inputVenue_cal").val("");
  $("#inputRemarks_cal").val("");
  $("#inputSearchToAdd_cal").val("");
  $("#inputSearchAdded_cal").val("");
  $(".listAdded_cal").empty();  
  addQueries_cal = [];
}

  </script>

<?php 
require_once "navbar.php";
?>

<!-- calendar modal start -->
<div class="ui modal coupled" id="calendar_modl" style="width: 1200px !important;">
  <!-- <i class="close icon"></i> -->
  <div class="header" style="color: #4075a9;"><i class="icon calendar outline"></i> Training Calendar
  </div>
  <div class="content">
    <div id='calendarElem'></div>
  </div>
  <div class="actions">
    <button class="ui blue deny button"><i class="icon close"></i> Close</button>
  </div>
</div>
<!-- calendar modal end -->

<!-- add training start -->
<div id="calendar_add_modl" class="ui large modal">
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
                <input required="" list="trainingsList_cal" id="inputTraining_cal" type="text" placeholder="Training Title">
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
                <input id="inputDate1_cal" type="date" name="">
              </div>
              <div class="seven wide field">
                <label>End Date:</label>
                <input id="inputDate2_cal" type="date" name="">
              </div>
              <div class="three wide field">
                <label>Hrs:</label>
                <input id="inputHrs_cal" type="text" name="">
              </div>
            </div>

<!-- input time start  -->
            <div class="fields">
              <div class="six wide field">
                <label>Time to Start:</label>
                <input id="inputTime1_cal" type="time" name="" value="08:00">
              </div>
              <div class="six wide field">
                <label>Time to End:</label>
                <input id="inputTime2_cal" type="time" name="" value="17:00">
              </div>
            </div>
<!-- input time end  -->


            <div class="field">
              <label>Venue:</label>
              <input id="inputVenue_cal" type="text" name="" placeholder="Venue">
            </div>
            <div class="field">
              <label>Remarks:</label>
              <input id="inputRemarks_cal" type="text" name="" placeholder="Remarks">
            </div>
          </div>

        </div>
        <div class="four wide column">
          <div class="ui form">
            <div class="field">
              <label>Personnels Involved:</label>
              <div class="ui icon input">
                <input id="inputSearchAdded_cal" type="text" placeholder="Search...">
                <i class="search icon"></i>
              </div>
            </div>
            <div class="listAdded_cal ui middle aligned tiny list" style="overflow-y: scroll; height: 300px;"></div>
          </div>
        </div>
        <div class="four wide column">
          <div class="ui form">
            <div class="field">
              <label>Personnel List:</label>
              <div class="ui icon input">
                <input id="inputSearchToAdd_cal" type="text" placeholder="Search...">
                <i class="search icon"></i>
              </div>
            </div>
            <div class="listToAdd_cal ui middle aligned tiny list" style="overflow-y: scroll; height: 300px;"></div>
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

<!-- calendar add event modal start -->
<!-- <div class="ui tiny modal coupled" id="calendar_add_modl" style="/*height: 500px*/;">
  <div class="header" style="color: #4075a9;"><i class="icon calendar outline"></i> Add Training</div>
  <div class="content">
    <div class="ui form">
      <div class="field">
        <label>Training:</label>
        <input type="text" name="" placeholder="Enter training title...">
      </div>  
      <div class="fields">
        <div class="eight wide field">
          <label>Start Date:</label>
          <input id="inputDate1_cal" type="date" name="">
        </div>
        <div class="eight wide field">
          <label>End Date:</label>
          <input id="inputDate2_cal" type="date" name="">
        </div>
      </div>
      <div class="fields">
        <div class="five wide field">
            <label>Start Time:</label>
            <input id="startTime" type="time" name="" value="08:00">
        </div>
        <div class="five wide field">
            <label>End Time:</label>
            <input id="endTime" type="time" name="" value="17:00">
        </div>
      </div>
    </div>
  </div>
  <div class="actions">
    <button class="ui mini button approve">Save</button>
    <button class="ui mini button deny">Cancel</button>
  </div>
</div> -->
<!-- calendar add event modal end -->



<!--   <div class="noprint ui stackable menu mini" style="margin-top: 10px;">
    <a title="Home" href="index.php" class="item" title="Home">
      <img src="assets/ico/ihris.png" style="width: 55px; height: 25px;">
     </a>
    <a class="item" href="employeelist.php"><i class="users icon"></i>Employee List</a>
    <a class="item" href="departmentsetup.php"><i class="building outline icon"></i>Departments</a>
    <a class="item" href="positionsetup.php"><i class="briefcase icon"></i>Positions</a>
    <div class="right menu">
      <a class="ui item" href="logout.php"><i class="icon sign-out"></i> Logout</a>
    </div>
  </div> -->
  <!-- 
  <div class="ui mini container" style="width: 800px; min-height: 700px;">
    <div class="ui segment noBorderPrint" id="side_rail">
      <div class="left ui rail noprint" style="left: -250px; width: 272px">
        <div class="ui sticky" style="">
          <div class="ui blue segment" id="sidebar1">
            <div class="content" style="color: blue; font-weight: bold; font-style: italic;">
              RECRUITMENT, SELECTION, AND PLACEMENT (RSP)
            </div>
            <hr>
            <div class="content">
              <div class="ui link list">
                <a class="item" href="">Comparative Assessment</a>
                <a class="item" href="">System of Ranking Position</a>
                <a class="item" href="">Staffing Plan</a>
                <a class="item" href="">Turn Around</a>
                <a class="item" href="personnelCompetenciesSurvey.php">Personnel Competencies</a>
              </div>
            </div>
          </div>
        
        
          <div class="ui blue segment" id="sidebar2">
            <div class="content" style="color: blue; font-weight: bold; font-style: italic;">
              LEARNING AND DEVELOPMENT (L&D)
            </div>
            <hr>
            <div class="content">
              <div class="ui link list">
                <a class="item" href="reqsandcoms.php">Training/Seminar Invitation/Communication</a>
                <a class="item" href="personneltrainings.php">Training Schedule/Evaluation</a>
                <a class="item" href="">L&D Plan</a>
                <a class="item" href="">Training Needs Assessment (Target Participants)</a>
                <a class="item" href="">Training Report</a>
                <a class="item" href="">System Review</a>
              </div>
            </div>
          </div>
        
        </div>
      </div>
      <div class="right ui rail noprint" style="left: 748px; width: 285px;">
        <div class="ui sticky" style="width: 250px !important; height: 262.531px !important;">
        
          <div class="ui blue segment" id="sidebar3">
            <div class="content" style="color: blue; font-weight: bold; font-style: italic;">
              STRATEGIC PERFORMANCE MANAGEMENT SYSTEM (SPMS)
            </div>
            <hr>
            <div class="content">
              <div class="ui link list">
                <a class="item" href="">Performance Rating Report</a>
                <a class="item" href="">Coaching and Mentoring Report</a>
                <a class="item" href="">Feedback Mechanism Report</a>
                <a class="item" href="">Turn Around Time</a>
              </div>
            </div>
          </div>
        
        
          <div class="ui blue segment" id="sidebar4">
            <div class="content" style="color: blue; font-weight: bold; font-style: italic;">
              REWARDS AND RECOGNITION (R&R)
            </div>
            <hr>
            <div class="content">
              <div class="ui link list">
                <a class="item" href="">R&R Plan (Yearly)</a>
                <a class="item" href="">System Review</a>
                <a class="item" href="">Search for Outstanding Employees</a>
              </div>
            </div>
          </div>
        
        </div>
      </div> -->