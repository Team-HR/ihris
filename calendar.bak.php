<?php
  // Initialize the session
  session_start();

  // Check if the user is logged in, if not then redirect him to login page
  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
  }

     $start = json_encode(date('Y-m-d'));
?>
<!DOCTYPE html>
<html>
<head>
  <title>Calendar</title>
   <meta charset="UTF-8" name="google" value="notranslate" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" type="text/css" href="ui/dist/semantic.css">
   <script src="jquery/jquery-3.3.1.min.js"></script>
   <script src="ui/dist/semantic.min.js"></script>


  <link href='fullcalendar4/packages/core/main.css' rel='stylesheet' />
  <link href='fullcalendar4/packages/daygrid/main.css' rel='stylesheet' />
  <link href='fullcalendar4/packages/timegrid/main.css' rel='stylesheet' />
  <link href='fullcalendar4/packages/list/main.css' rel='stylesheet' />
  <script src='fullcalendar4/packages/core/main.js'></script>
  <script src='fullcalendar4/packages/interaction/main.js'></script>
  <script src='fullcalendar4/packages/daygrid/main.js'></script>
  <script src='fullcalendar4/packages/timegrid/main.js'></script>
  <script src='fullcalendar4/packages/list/main.js'></script>
   
</head>
<body>
<?php
  require "navbar.php";
?>

<script type="text/javascript">
  $(document).ready(function() {
    // alert(<?=json_encode($start)?>);
    $('.ui.sticky').sticky({
      context: '#example1'
    });


var events = [];


    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      // aspectRatio: 1.9,
      plugins: [ 'interaction', 'dayGrid' ],
      // plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
      },
      defaultDate: <?php echo $start;?>,//'2019-06-12',
      navLinks: true,
      editable: false,
      allDay: true,
      displayEventTime: false,
      eventLimit: true, // allow "more" link when too many events
      events: 
<?php
require '../hris/_connect.db.php';

  $events = array();
  $sql = "SELECT * FROM `personneltrainings` RIGHT JOIN `trainings` on `personneltrainings`.`training_id` = `trainings`.`training_id`";
  $result = $mysqli->query($sql);
  while ($row = $result->fetch_assoc()) {
    $personneltrainings_id = $row["personneltrainings_id"];
    $training = $row["training"];
    $startDate = $row["startDate"];
    $endDate = $row["endDate"];
    $startDate = $startDate."T08:00:00";
    $groupId = null;

if ($startDate !== $endDate) {
      $endDate = $endDate."T12:00:00";
      $groupId = $personneltrainings_id;
    }

    $inside_events = array(
      'groupId' => $groupId,
      'title' => $training, 
      'start' => $startDate, 
      'end' => $endDate,
      'url' => "../hris/personneltrainingspreview.php?personneltrainings_id=".$personneltrainings_id
      
    );

    array_push($events, $inside_events);
  }

  $sql = "SELECT * FROM `requestandcoms` WHERE `isMeeting` != 'yes' AND `isMeeting` != ''";
  $result = $mysqli->query($sql);
  while ($row = $result->fetch_assoc()) {

    $subject = $row["subject"];
    $fromDate = $row["fromDate"];
    $toDate = $row["toDate"];

    $fromDate = $fromDate."T08:00:00";
if ($fromDate !== $toDate) {
      $toDate = $toDate."T17:00:00";
    }

    $inside_events = array(
      'title' => $subject, 
      'start' => $fromDate, 
      'end' => $toDate
    );

    // array_push($events, $inside_events);
  }


  echo json_encode($events);
?>,
eventClick: function (info){
  info.jsEvent.preventDefault();

  if (info.event.url) {
    window.open(info.event.url+"&start="+info.event.start.toISOString(),"_blank");
    // alert(info.event.start.toISOString());
  }

}


      // [
      //   {
      //     title: 'All Day Event',
      //     start: '2019-06-01'
      //   },
      //   {
      //     title: 'Long Event',
      //     start: '2019-06-07',
      //     end: '2019-06-10'
      //   },
      //   {
      //     groupId: 999,
      //     title: 'Repeating Event',
      //     start: '2019-06-09T16:00:00'
      //   },
      //   {
      //     groupId: 999,
      //     title: 'Repeating Event',
      //     start: '2019-06-16T16:00:00'
      //   },
      //   {
      //     title: 'Conference',
      //     start: '2019-06-11',
      //     end: '2019-06-13'
      //   },
      //   {
      //     title: 'Meeting',
      //     start: '2019-06-12T10:30:00',
      //     end: '2019-06-12T12:30:00'
      //   },
      //   {
      //     title: 'Lunch',
      //     start: '2019-06-12T12:00:00'
      //   },
      //   {
      //     title: 'Meeting',
      //     start: '2019-06-12T14:30:00'
      //   },
      //   {
      //     title: 'Happy Hour',
      //     start: '2019-06-12T17:30:00'
      //   },
      //   {
      //     title: 'Dinner',
      //     start: '2019-06-12T20:00:00'
      //   },
      //   {
      //     title: 'Birthday Party',
      //     start: '2019-06-13T07:00:00',
      //     description: 'This is a cool event'
      //   },
      //   {
      //     title: 'Click for Google',
      //     url: 'http://google.com/',
      //     start: '2019-06-28'
      //   }
      // ],
    });

    calendar.render();

  });
</script>


<div class="ui segment" id="example1" style="width: 1000px !important; left: 500px;">
  <div class="left ui rail">
    <div class="ui sticky">
      

  <p>LEFT RAIL LEFT RAIL LEFT RAIL LEFT RAIL LEFT RAIL LEFT RAIL LEFT RAIL LEFT RAIL LEFT RAIL LEFT RAIL LEFT RAIL LEFT RAIL LEFT RAIL LEFT RAIL LEFT RAIL LEFT RAIL LEFT RAIL LEFT RAIL LEFT RAIL LEFT RAIL LEFT RAIL LEFT RAIL LEFT RAIL LEFT RAIL LEFT RAIL LEFT RAIL</p>


    </div>
  </div>

  <div class="right ui rail" style="">
    <div class="ui sticky" style="width: 272px !important; height: 262.531px !important; left: 1356.5px;">
    
  <p>
    RIGHT RAIL RIGHT RAIL RIGHT RAIL RIGHT RAIL RIGHT RAIL RIGHT RAIL RIGHT RAIL RIGHT RAIL RIGHT RAIL RIGHT RAIL RIGHT RAIL RIGHT RAIL RIGHT RAIL RIGHT RAIL RIGHT RAIL RIGHT RAIL RIGHT RAIL RIGHT RAIL RIGHT RAIL RIGHT RAIL RIGHT RAIL RIGHT RAIL RIGHT RAIL RIGHT RAIL
  </p>

    </div>
  </div>


    <div id='calendar'></div>


</div>




<?php
  require "footer.php";
?>