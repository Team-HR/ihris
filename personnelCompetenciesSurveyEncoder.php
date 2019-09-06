
<?php require_once "_connect.db.php";?>

<!DOCTYPE html>
<html>
<head>
  <title>PC Survey Encoder</title>
  <link rel="stylesheet" type="text/css" href="ui/dist/semantic.css">
  <script src="jquery/jquery-3.3.1.min.js"></script>
  <script src="ui/dist/semantic.min.js"></script>
  <link rel="stylesheet" href="jquery-ui-1.12.1/jquery-ui.min.css">
  <script src="jquery-ui-1.12.1/jquery-ui.min.js"></script>
</head>
<style type="text/css">
p{
  margin-left: 20px;
}
.active {
  color: teal !important;
  margin-left: -10px;
  font-weight: bold;
}
.w3-check {
  transform: scale(2);
}
@media print{
  .printOnly {
    display : block;
  }
  .noprint {display:none;}
  .centerPrint {margin: 0px; width: 100% !important;}
}
</style>
<body>

  <script type="text/javascript">
    // window.location.reload();
    $(document).ready(function(){
      // $(submittedForm);
      var employees_id = 0,
      inputName = $("#fullName"),
      inputDept = $("#department"),
      inputName_val;
      $('.ui.sticky').sticky({
        context: '#contextSurvey'
      });
      var req = <?php include_once 'autocompleteName.php'; ?>;
      $(inputName).autocomplete({ 
        source: req,
        select: function(event,ui){
          if (ui.item.dateSurveyed != null) {
            $("#alreadyDoneMsgContainer").html(ui.item.value);
            $(alreadyDone);
            // alert(ui.item.value+" already took the assessment on "+ui.item.dateSurveyed);
            $(inputDept).val(ui.item.department);
            // location.reload();
          } else {
            $(inputDept).val(ui.item.department);
            employees_id = ui.item.employees_id;
            inputName_val = ui.item.value;
          }
        }
      });

      $(inputName).keyup(function(event) {
        var name_on_field = inputName.val();
        // employees_id = 0;
        if ( inputName_val.trim() !== name_on_field.trim()) {
          employees_id = 0;
        } else if (inputName.val() == "") {
          inputDept.val("");
        }
      });

      $('input[type="checkbox"]').on('change', function() {
        $('input[name="' + this.name + '"]').not(this).prop('checked', false);
      });

      $("#comptForm").submit(function(event) {
        /* Act on the event */
        event.preventDefault();
        var scoresArray = [],
        checkUnchecked = [],
        name = inputName.val(),
        department = inputDept.val();

        // check if all competencies are answered start
        var i;
        for (i = 1; i <= 24; i++) { 
          if (!$("input[name='group"+i+"[]']:checked").is(":checked")) {
            // scoresArray.push("Unchecked"+i);
            checkUnchecked.push("\nCompetency: "+i);
              // alert("Please answer the Quesion "+i);
            }
          }
      // check if all competencies are answered end
        if (checkUnchecked.length === 0) {
          // if all are checked
          // alert("All are checked!");
          for (i = 1; i <= 24; i++) { 
            $.each($("input[name='group"+i+"[]']:checked"), function(){
              scoresArray.push($(this).val());
            });
          }
          // alert(employees_id);
          // alert(inputName.val());

          if (!isEmptyOrSpaces(name) && !isEmptyOrSpaces(department)) {
          
            $.post('personnelCompetenciesSurvey_proc.php', {
              success: true,
              employees_id: employees_id,
              inputName: name,
              scoresArray: scoresArray
            }, function(data, textStatus, xhr) {
              $(submittedForm);
            });

          } else {
            alert('Please don\'t leave a field empty.');
          }
          // alert("Form Submitted!");
          
        } else {
          // if not all are checked
          // alert("Not all are checked! Please Check: "+checkUnchecked);
          $("#incompleteMsgContainer").html("Not all were answered! Please Check: "+checkUnchecked);
          $(incompleteForm);
        }
        // alert(scoresArray);
        // alert(scoresArray);
      });
    });

    function isEmptyOrSpaces(str){
      return str === null || str.match(/^ *$/) !== null;
    } 


     function cancelSurvey(){
        $('#cancelSurvey').modal({
          closable  : false,
          onDeny    : function(){
            // window.alert('Wait not yet!');
            // $(this).modal("close");
            // return false;
          },
          onApprove : function() {
            // window.alert('Approved!');
            // window.close();
            window.location.href = "index.php";
          }
        }).modal('show');
      }
      function incompleteForm(){
        $('#incompleteForm').modal({
          closable:false,
          onApprove:function() {
             $(this).modal("close");
          }
        }).modal('show');
      }
      function submittedForm(){
        $("#submittedForm").modal({
          closable:false,
          onApprove:function(){

            window.scrollTo(0,0);
            window.location.reload();
          }
        }).modal('show');
        // window.location.href = "personnelCompetenciesSurvey_done.php";
      }

      function alreadyDone(){
        $("#alreadyDone").modal({
          closable:false,
          onApprove:function(){
            window.location.reload();
          }
        }).modal('show');
      }
  </script>
  
  <div id="alreadyDone" class="ui tiny modal">
    <div class="header">Already Done!</div>
    <div class="content">
      <p id="alreadyDoneMsgContainer" style="color: black; font-weight: normal;"></p>
    </div>
    <div class="actions">
      <div class="ui approve button blue">Back</div>
    </div>
  </div>  

  <div id="submittedForm" class="ui mini modal">
    <div class="header">Submitted!</div>
    <div class="content">
      <p style="color: black; font-weight: normal;">Form successfully submitted for analysis. Results will be available in the personnel profile.</p>
    </div>
    <div class="actions">
      <div class="ui approve button blue">Ok</div>
    </div>
  </div>

  <div id="cancelSurvey" class="ui mini modal">
    <div class="header">Cancel Survey?</div>
    <div class="content">
      <p style="color: black; font-weight: normal;">Everything you have inputted will be trashed, unsaved and you will be redirected to the homepage. Are you sure?</p>
    </div>
    <div class="actions">
      <div class="ui approve button blue">Yes</div>
      <div class="ui cancel button red">No</div>
    </div>
  </div>

  <div id="incompleteForm" class="ui mini modal">
    <div class="header">Form Incomplete</div>
    <div class="content">
      <p id="incompleteMsgContainer" style="color: black; font-weight: normal;"></p>
    </div>
    <div class="actions">
      <div class="ui approve button blue">Back</div>
    </div>
  </div>

  <!-- survey content starts here -->
  <div class="ui fluid container basic segment section centerPrint" id="contextSurvey" style="width: 820px; margin-bottom: 300px">
    <!-- left rail starts here -->
    <div class="right ui rail noprint" style="left: 760px; width: 285px;">
      <div class="ui sticky" style="padding-top: 20px; width: 160px !important; height: 262.531px !important; left: 274.5px;">
        <!-- <h3 class="ui header">Stuck Content</h3> -->
        <div class="ui segment">
          <button class="ui mini fluid button" onclick="window.scrollTo(0,0);"><i class="arrow alternate circle up icon large teal"></i>Top</button>
            <br>
          <button onclick="cancelSurvey()" class="ui mini fluid button red">Cancel / Close</button>
            <br>
          <button class="ui mini fluid button blue" form="comptForm">Submit</button>
            <br>
          <a class="ui mini fluid button" href="#bottomPage"><i class="arrow alternate circle down icon large teal"></i>Bottom</a>
        </div>
      </div>
    </div>
    <!-- left rail ends here -->
    <!-- right rail ends here -->
<style type="text/css">
  .item {
    color: black !important;
  }
  .active {
    color: #607d8b !important;
  }
  td {
    padding: 5px;
  }
</style>

    <div class="left ui rail noprint" style="left: -250px">
      <div class="ui sticky" style="padding-top: 20px;width: 272px !important;">
        <h3 class="ui header" style="color: #607d8b;">JOB COMPETENCY PROFILE</h3>

        <div class="ui link list" style="margin-left: 20px">
          <a href="#contextSurvey" class="item active">Top</a>
          <a href="#adaptability" class="item">1.) Adaptability</a>
          <a href="#continousLearning" class="item">2.) Continous Learning</a>
          <a href="#communication" class="item">3.) Communication</a>
          <a href="#organizationAwareness" class="item">4.) Organizational Awareness</a>
          <a href="#creativeThinking" class="item">5.) Creative Thinking</a>
          <a href="#networkingRelationshipBuilding" class="item">6.) Networking/Relationship Building</a>
          <a href="#conflictManagement" class="item">7.) Conflict Management</a>
          <a href="#stewardshipOfResources" class="item">8.) Stewardship of Resources</a>
          <a href="#riskManagement" class="item">9.) Risk Management</a>
          <a href="#stressManagement" class="item">10.) Stress Management</a>
          <a href="#influence" class="item">11.) Influence</a>
          <a href="#initiative" class="item">12.) Initiative</a>
          <a href="#teamLeadership" class="item">13.) Team Leadership</a>
          <a href="#changeLeadership" class="item">14.) Change Leadership</a>
          <a href="#clientFocus" class="item">15.) Client Focus</a>
          <a href="#partnering" class="item">16.) Partnering</a>
          <a href="#developingOthers" class="item">17.) Developing Others</a>
          <a href="#planningAndOrganizing" class="item">18.) Planning and Organizing</a>
          <a href="#decisionMaking" class="item">19.) Decision Making</a>
          <a href="#analyticalThinking" class="item">20.) Analytical Thinking</a>
          <a href="#resultsOrientation" class="item">21.) Results Orientation</a>
          <a href="#teamwork" class="item">22.) Teamwork</a>
          <a href="#valuesAndEthics" class="item">23.) Values and Ethics</a>
          <a href="#visioningAndStrategicDirection" class="item">24.) Visioning and Strategic Direction</a>
          <a href="#SubmitBtn" class="item">Submit</a>
        </div>
      </div>
    </div>
    <!-- right rail ends here -->
    <form id="comptForm" action="#" method="GET">
      <div class="ui labeled fluid input">
        <div class="ui label" style="background-color: #607d8b; color: white;">
          NAME:
        </div>
        <input id="fullName" type="text" required="" name="name" placeholder="Please search and select your name from here." style="display: inline-block;">
      </div>
      <br>
      <div class="ui labeled fluid input">
        <div class="ui label" style="background-color: #607d8b; color: white;">
          DEPARTMENT:
        </div>
        <input id="department" class="w3-input" type="text" required="" autocomplete="off" name="department" style="display: inline-block;">
      </div>
      <br>
      <div id="adaptability" class="section" style="page-break-inside: avoid; font-size: 12px;">
        <br>
        <div>

          <header class="ui block header" style="background-color: #607d8b; color: white;">
            <h4>COMPETENCY: ADAPTABILITY</h4>
          </header>
          <div class="ui container">
            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th>(CHECK)</th>
                  <th style="text-align: center; vertical-align: middle;">LEVEL</th>
                  <!-- <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th> -->
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group1[]"></td>
                  <td>
                    LEVEL 1<br>
                  </td>
                  <td>Recognizes how change will affect work</td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group1[]"></td>
                  <td>
                    LEVEL 2<br>
                  </td>
                  <td>Adapts one's work to a situation</td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group1[]"></td>
                  <td>
                    LEVEL 3<br>
                  </td> 
                  <td>Adapts to a variety of changes</td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group1[]"></td>
                  <td>
                    LEVEL 4<br>
                  </td>
                  <td>Adapts to large, complex and/or frequent changes</td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group1[]"></td>
                  <td>
                    LEVEL 5<br>
                  </td>
                  <td>Adapts organizational strategies</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div id="continousLearning" class="section" style="page-break-inside: avoid; font-size: 12px;" style="page-break-inside: avoid; font-size: 12px;">
        <br>
        <div>

          <header class="ui block header" style="background-color: #607d8b; color: white;">
            <h4>COMPETENCY: CONTINUOUS LEARNING</h4>
          </header>

          <div class="ui container">
            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th>(CHECK)</th>
                  <th style="text-align: center; vertical-align: middle;">LEVEL</th>
                  <!-- <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th> -->
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group2[]"></td>
                  <td>
                    LEVEL 1<br>
                  </td>
                  <td>
                    Assesses and monitors oneself to maintain personal effectiveness
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group2[]"></td>
                  <td>
                    LEVEL 2<br>
                  </td>
                  <td>
                    Seeks to improve personal effectiveness in current situation
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group2[]"></td>
                  <td>
                    LEVEL 3<br>
                  </td>
                  <td>
                    Seeks learning opportunities beyond current requirements
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group2[]"></td>
                  <td>
                    LEVEL 4<br>
                  </td>
                  <td>
                    Aligns personal development with objectives of organization
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group2[]"></td>
                  <td>
                    LEVEL 5<br>
                  </td>
                  <td>
                    Aligns personal learning with anticipated change in organizational strategy
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div id="communication" class="section" style="page-break-inside: avoid; font-size: 12px;">
        <br>
        <div>

          <header class="ui block header" style="background-color: #607d8b; color: white;">
            <h4>COMPETENCY: COMMUNICATION</h4>
          </header>

          <div class="ui container">
            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th>(CHECK)</th>
                  <th style="text-align: center; vertical-align: middle;">LEVEL</th>
                  <!-- <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th> -->
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group3[]"></td>
                  <td>
                    LEVEL 1<br>
                  </td>
                  <td>
                    Listens & clearly presents information
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group3[]"></td>
                  <td>
                    LEVEL 2<br>
                  </td>
                  <td>
                    Fosters two-way communication
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group3[]"></td>
                  <td>
                    LEVEL 3<br>
                  </td>
                  <td>
                    Adapts communication to others
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group3[]"></td>
                  <td>
                    LEVEL 4<br>
                  </td>
                  <td>
                    Communicates complex messages
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group3[]"></td>
                  <td>
                    LEVEL 5<br>
                  </td>
                  <td>
                    Communicates strategically
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div id="organizationAwareness" class="section" style="page-break-inside: avoid; font-size: 12px;">
        <br>
        <div>
          
          <header class="ui block header" style="background-color: #607d8b; color: white;">
            <h4>COMPETENCY: ORGANIZATIONAL AWARENESS</h4>
          </header>

          <div class="ui container">

            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th>(CHECK)</th>
                  <th style="text-align: center; vertical-align: middle;">LEVEL</th>
                  <!-- <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th> -->
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group4[]"></td>
                  <td>
                    LEVEL 1<br>
                  </td>
                  <td>
                    Understands formal structure
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group4[]"></td>
                  <td>
                    LEVEL 2<br>
                  </td>
                  <td>
                    Understands informal structure and culture
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group4[]"></td>
                  <td>
                    LEVEL 3<br>
                  </td>
                  <td>
                    Effectively operates in external environments
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group4[]"></td>
                  <td>
                    LEVEL 4<br>
                  </td>
                  <td>
                    Understands organizational politics, issues and external influences
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group4[]"></td>
                  <td>
                    LEVEL 5<br>
                  </td>
                  <td>
                    Operates effectively in a broad spectrum of political, cultural and social milieu
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div id="creativeThinking" class="section" style="page-break-inside: avoid; font-size: 12px;">
        <br>
        <div>

          <header class="ui block header" style="background-color: #607d8b; color: white;">
            <h4>COMPETENCY: CREATIVE THINKING</h4>
          </header>

          <div class="ui container">
            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th>(CHECK)</th>
                  <th style="text-align: center; vertical-align: middle;">LEVEL</th>
                  <!-- <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th> -->
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group5[]"></td>
                  <td>
                    LEVEL 1<br>
                  </td>
                  <td>
                    Acknowledges the need for new approaches
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group5[]"></td>
                  <td>
                    LEVEL 2<br>
                  </td>
                  <td>
                    Modifies current approaches
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group5[]"></td>
                  <td>
                    LEVEL 3<br>
                  </td>
                  <td>
                    Introduces new approaches
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group5[]"></td>
                  <td>
                    LEVEL 4<br>
                  </td>
                  <td>
                    Creates new concepts
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group5[]"></td>
                  <td>
                    LEVEL 5<br>
                  </td>
                  <td>
                    Nurtures creativity
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div id="networkingRelationshipBuilding" class="section" style="page-break-inside: avoid; font-size: 12px;">
        <br>
        <div>

          <header class="ui block header" style="background-color: #607d8b; color: white;">
            <h4>COMPETENCY: NETWORKING/RELATIONSHIP BUILDING</h4>
          </header>

          <div class="ui container">
            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th>(CHECK)</th>
                  <th style="text-align: center; vertical-align: middle;">LEVEL</th>
                  <!-- <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th> -->
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group6[]"></td>
                  <td>
                    LEVEL 1<br>
                  </td>
                  <td>
                    Accesses sources of information
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group6[]"></td>
                  <td>
                    LEVEL 2<br>
                  </td>
                  <td>
                    Builds key contacts
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group6[]"></td>
                  <td>
                    LEVEL 3<br>
                  </td>
                  <td>
                    Seeks new networking opportunities for self and others
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group6[]"></td>
                  <td>
                    LEVEL 4<br>
                  </td>
                  <td>
                    Strategically expands networks
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group6[]"></td>
                  <td>
                    LEVEL 5<br>
                  </td>
                  <td>
                    Creates networking opportunities
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div id="conflictManagement" class="section" style="page-break-inside: avoid; font-size: 12px;">
        <br>
        <div>

          <header class="ui block header" style="background-color: #607d8b; color: white;">
            <h4>COMPETENCY: CONFLICT MANAGEMENT</h4>
          </header>

          <div class="ui container">
            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th>(CHECK)</th>
                  <th style="text-align: center; vertical-align: middle;">LEVEL</th>
                  <!-- <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th> -->
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group7[]"></td>
                  <td>
                    LEVEL 1<br>
                  </td>
                  <td>
                    Identifies conflict
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group7[]"></td>
                  <td>
                    LEVEL 2<br>
                  </td>
                  <td>
                    Addresses existing conflict
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group7[]"></td>
                  <td>
                    LEVEL 3<br>
                  </td>
                  <td>
                    Anticipates and addresses sources of potential conflict
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group7[]"></td>
                  <td>
                    LEVEL 4<br>
                  </td>
                  <td>
                    Introduces strategies for resolving existing and potential conflict
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group7[]"></td>
                  <td>
                    LEVEL 5<br>
                  </td>
                  <td>
                    Creates an environment where conflict is resolved appropriately
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div id="stewardshipOfResources" class="section" style="page-break-inside: avoid; font-size: 12px;">
        <br>
        <div>

          <header class="ui block header" style="background-color: #607d8b; color: white;">
            <h4>COMPETENCY: STEWARDSHIP OF RESOURCES</h4>
          </header>

          <div class="ui container">

            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th>(CHECK)</th>
                  <th style="text-align: center; vertical-align: middle;">LEVEL</th>
                  <!-- <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th> -->
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group8[]"></td>
                  <td>
                    LEVEL 1<br>
                  </td>
                  <td>
                    Uses resources effectively
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group8[]"></td>
                  <td>
                    LEVEL 2<br>
                  </td>
                  <td>
                    Ensures effective use of resources
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group8[]"></td>
                  <td>
                    LEVEL 3<br>
                  </td>
                  <td>
                    Controls resource use
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group8[]"></td>
                  <td>
                    LEVEL 4<br>
                  </td>
                  <td>
                    Implements systems to ensure stewardship of resources
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group8[]"></td>
                  <td>
                    LEVEL 5<br>
                  </td>
                  <td>
                    Ensures strategic stewardship of RESOURCES
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div id="riskManagement" class="section" style="page-break-inside: avoid; font-size: 12px;">
        <br>
        <div>

          <header class="ui block header" style="background-color: #607d8b; color: white;">
            <h4>COMPETENCY: RISK MANAGEMENT</h4>
          </header>

          <div class="ui container">

            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th>(CHECK)</th>
                  <th style="text-align: center; vertical-align: middle;">LEVEL</th>
                  <!-- <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th> -->
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group9[]"></td>
                  <td>
                    LEVEL 1<br>
                  </td>
                  <td>
                    Identifies possible risks
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group9[]"></td>
                  <td>
                    LEVEL 2<br>
                  </td>
                  <td>
                    Takes calculated risks
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group9[]"></td>
                  <td>
                    LEVEL 3<br>
                  </td>
                  <td>
                    Personally takes significant risks
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group9[]"></td>
                  <td>
                    LEVEL 4<br>
                  </td>
                  <td>
                    Designs strategies for dealing with high-risk initiatives
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group9[]"></td>
                  <td>
                    LEVEL 5<br>
                  </td>
                  <td>
                    Provides organizational guidance on risk
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div id="stressManagement" class="section" style="page-break-inside: avoid; font-size: 12px;">
        <br>
        <div>

          <header class="ui block header" style="background-color: #607d8b; color: white;">
            <h4>COMPETENCY: STRESS MANAGEMENT</h4>
          </header>

          <div class="ui container">

            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th>(CHECK)</th>
                  <th style="text-align: center; vertical-align: middle;">LEVEL</th>
                  <!-- <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th> -->
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group10[]"></td>
                  <td>
                    LEVEL 1<br>
                  </td>
                  <td>
                    Works in low level stress situations
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group10[]"></td>
                  <td>
                    LEVEL 2<br>
                  </td>
                  <td>
                    Adjusts to temporary peaks in stress levels
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group10[]"></td>
                  <td>
                    LEVEL 3<br>
                  </td>
                  <td>
                    Adapts to prolonged stress
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group10[]"></td>
                  <td>
                    LEVEL 4<br>
                  </td>
                  <td>
                    Employs stress management strategies
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group10[]"></td>
                  <td>
                    LEVEL 5<br>
                  </td>
                  <td>
                    Deals with stress affecting the organization
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div id="influence" class="section" style="page-break-inside: avoid; font-size: 12px;">
        <br>
        <div>

          <header class="ui block header" style="background-color: #607d8b; color: white;">
            <h4>COMPETENCY: INFLUENCE</h4>
          </header>

          <div class="ui container">

            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th>(CHECK)</th>
                  <th style="text-align: center; vertical-align: middle;">LEVEL</th>
                  <!-- <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th> -->
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group11[]"></td>
                  <td>
                    LEVEL 1<br>
                  </td>
                  <td>
                    Uses facts and available information to persuade
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group11[]"></td>
                  <td>
                    LEVEL 2<br>
                  </td>
                  <td>
                    Adapts rationale to influence others
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group11[]"></td>
                  <td>
                    LEVEL 3<br>
                  </td>
                  <td>
                    Demonstrates the benefit of ideas
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group11[]"></td>
                  <td>
                    LEVEL 4<br>
                  </td>
                  <td>
                    Builds coalitions, strategic relationships and networks
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group11[]"></td>
                  <td>
                    LEVEL 5<br>
                  </td>
                  <td>
                    Designs complex influence strategies
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div id="initiative" class="section" style="page-break-inside: avoid; font-size: 12px;">
        <br>
        <div>

          <header class="ui block header" style="background-color: #607d8b; color: white;">
            <h4>COMPETENCY: INITIATIVE</h4>
          </header>

          <div class="ui container">

            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th>(CHECK)</th>
                  <th style="text-align: center; vertical-align: middle;">LEVEL</th>
                  <!-- <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th> -->
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group12[]"></td>
                  <td>
                    LEVEL 1<br>
                  </td>
                  <td>
                    Addresses current issues
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group12[]"></td>
                  <td>
                    LEVEL 2<br>
                  </td>
                  <td>
                    Addresses imminent issues
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group12[]"></td>
                  <td>
                    LEVEL 3<br>
                  </td>
                  <td>
                    Acts promptly in a crisis situation
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group12[]"></td>
                  <td>
                    LEVEL 4<br>
                  </td>
                  <td>
                    Looks to the future
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group12[]"></td>
                  <td>
                    LEVEL 5<br>
                  </td>
                  <td>
                    Encourages initiative in others
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div id="teamLeadership" class="section" style="page-break-inside: avoid; font-size: 12px;">
        <br>
        <div>

          <header class="ui block header" style="background-color: #607d8b; color: white;">
            <h4>COMPETENCY: TEAM LEADERSHIP</h4>
          </header>

          <div class="ui container">

            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th>(CHECK)</th>
                  <th style="text-align: center; vertical-align: middle;">LEVEL</th>
                  <!-- <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th> -->
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group13[]"></td>
                  <td>
                    LEVEL 1<br>
                  </td>
                  <td>
                    Keeps the team informed
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group13[]"></td>
                  <td>
                    LEVEL 2<br>
                  </td>
                  <td>
                    Ensures the needs of the team and of members are met
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group13[]"></td>
                  <td>
                    LEVEL 3<br>
                  </td>
                  <td>
                    Ensures team member input
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group13[]"></td>
                  <td>
                    LEVEL 4<br>
                  </td>
                  <td>
                    Empowers the team
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group13[]"></td>
                  <td>
                    LEVEL 5<br>
                  </td>
                  <td>
                    Inspires team members
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div id="changeLeadership" class="section" style="page-break-inside: avoid; font-size: 12px;">
        <br>
        <div>

          <header class="ui block header" style="background-color: #607d8b; color: white;">
            <h4>COMPETENCY: CHANGE LEADERSHIP</h4>
          </header>

          <div class="ui container">

            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th>(CHECK)</th>
                  <th style="text-align: center; vertical-align: middle;">LEVEL</th>
                  <!-- <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th> -->
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group14[]"></td>
                  <td>
                    LEVEL 1<br>
                  </td>
                  <td>
                    Makes others aware of change
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group14[]"></td>
                  <td>
                    LEVEL 2<br>
                  </td>
                  <td>
                    Underscores the positive nature of change
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group14[]"></td>
                  <td>
                    LEVEL 3<br>
                  </td>
                  <td>
                    Manages the process for change
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group14[]"></td>
                  <td>
                    LEVEL 4<br>
                  </td>
                  <td>
                    Aligns change initiatives with organizational objectives
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group14[]"></td>
                  <td>
                    LEVEL 5<br>
                  </td>
                  <td>
                    Champions change
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div id="clientFocus" class="section" style="page-break-inside: avoid; font-size: 12px;">
        <br>
        <div>

          <header class="ui block header" style="background-color: #607d8b; color: white;">
            <h4>COMPETENCY: CLIENT FOCUS</h4>
          </header>

          <div class="ui container">

            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th>(CHECK)</th>
                  <th style="text-align: center; vertical-align: middle;">LEVEL</th>
                  <!-- <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th> -->
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group15[]"></td>
                  <td>
                    LEVEL 1<br>
                  </td>
                  <td>
                    Responds to client requests
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group15[]"></td>
                  <td>
                    LEVEL 2<br>
                  </td>
                  <td>
                    Builds positive client Relations
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group15[]"></td>
                  <td>
                    LEVEL 3<br>
                  </td>
                  <td>
                    Anticipates and adapts to client needs
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group15[]"></td>
                  <td>
                    LEVEL 4<br>
                  </td>
                  <td>
                    Fosters a client-focused culture
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group15[]"></td>
                  <td>
                    LEVEL 5<br>
                  </td>
                  <td>
                    Considers the strategic direction of client focus
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div id="partnering" class="section" style="page-break-inside: avoid; font-size: 12px;">
        <br>
        <div>

          <header class="ui block header" style="background-color: #607d8b; color: white;">
            <h4>COMPETENCY: PARTNERING</h4>
          </header>

          <div class="ui container">
            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th>(CHECK)</th>
                  <th style="text-align: center; vertical-align: middle;">LEVEL</th>
                  <!-- <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th> -->
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group16[]"></td>
                  <td>
                    LEVEL 1<br>
                  </td>
                  <td>
                    Operates effectively within partnerships
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group16[]"></td>
                  <td>
                    LEVEL 2<br>
                  </td>
                  <td>
                    Manages existing partnerships
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group16[]"></td>
                  <td>
                    LEVEL 3<br>
                  </td>
                  <td>
                    Seeks out partnership opportunities
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group16[]"></td>
                  <td>
                    LEVEL 4<br>
                  </td>
                  <td>
                    Facilitates partnerships
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group16[]"></td>
                  <td>
                    LEVEL 5<br>
                  </td>
                  <td>
                    Sets strategic direction for partnering
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div id="developingOthers" class="section" style="page-break-inside: avoid; font-size: 12px;">
        <br>
        <div>

          <header class="ui block header" style="background-color: #607d8b; color: white;">
            <h4>COMPETENCY: DEVELOPING OTHERS</h4>
          </header>

          <div class="ui container">

            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th>(CHECK)</th>
                  <th style="text-align: center; vertical-align: middle;">LEVEL</th>
                  <!-- <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th> -->
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group17[]"></td>
                  <td>
                    LEVEL 1<br>
                  </td>
                  <td>
                    Shares expertise with others
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group17[]"></td>
                  <td>
                    LEVEL 2<br>
                  </td>
                  <td>
                    Supports individual development and improvement
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group17[]"></td>
                  <td>
                    LEVEL 3<br>
                  </td>
                  <td>
                    Promotes ongoing learning and development
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group17[]"></td>
                  <td>
                    LEVEL 4<br>
                  </td>
                  <td>
                    Provides opportunities for development
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group17[]"></td>
                  <td>
                    LEVEL 5<br>
                  </td>
                  <td>
                    Creates a continuous learning and development environment
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div id="planningAndOrganizing" class="section" style="page-break-inside: avoid; font-size: 12px;">
        <br>
        <div>

          <header class="ui block header" style="background-color: #607d8b; color: white;">
            <h4>COMPETENCY: PLANNING AND ORGANIZING</h4>
          </header>

          <div class="ui container">

            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th>(CHECK)</th>
                  <th style="text-align: center; vertical-align: middle;">LEVEL</th>
                  <!-- <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th> -->
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group18[]"></td>
                  <td>
                    LEVEL 1<br>
                  </td>
                  <td>
                    Plans tasks and organizes own work
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group18[]"></td>
                  <td>
                    LEVEL 2<br>
                  </td>
                  <td>
                    Applies planning principles to achieve work goals
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group18[]"></td>
                  <td>
                    LEVEL 3<br>
                  </td>
                  <td>
                    Develops plans for the business unit
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group18[]"></td>
                  <td>
                    LEVEL 4<br>
                  </td>
                  <td>
                    Integrates and evaluates plans to achieve business goals.
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group18[]"></td>
                  <td>
                    LEVEL 5<br>
                  </td>
                  <td>
                    Plans and organizes at a strategic levelv
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div id="decisionMaking" class="section" style="page-break-inside: avoid; font-size: 12px;">
        <br>
        <div>

          <header class="ui block header" style="background-color: #607d8b; color: white;">
            <h4>COMPETENCY: DECISION-MAKING</h4>
          </header>

          <div class="ui container">

            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th>(CHECK)</th>
                  <th style="text-align: center; vertical-align: middle;">LEVEL</th>
                  <!-- <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th> -->
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group19[]"></td>
                  <td>
                    LEVEL 1<br>
                  </td>
                  <td>
                    Makes decisions based solely on rules
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group19[]"></td>
                  <td>
                    LEVEL 2<br>
                  </td>
                  <td>
                    Makes decisions by interpreting rules
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group19[]"></td>
                  <td>
                    LEVEL 3<br>
                  </td>
                  <td>
                    Makes decisions in situations where there is scope for interpretation of rules
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group19[]"></td>
                  <td>
                    LEVEL 4<br>
                  </td>
                  <td>
                    Makes complex decisions in the absence of rules
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group19[]"></td>
                  <td>
                    LEVEL 5<br>
                  </td>
                  <td>
                    Makes high-risk decisions in complex and ambiguous situations
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div id="analyticalThinking" class="section" style="page-break-inside: avoid; font-size: 12px;">
        <br>
        <div>

          <header class="ui block header" style="background-color: #607d8b; color: white;">
            <h4>COMPETENCY: ANALYTICAL THINKING</h4>
          </header>

          <div class="ui container">

            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th>(CHECK)</th>
                  <th style="text-align: center; vertical-align: middle;">LEVEL</th>
                  <!-- <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th> -->
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group20[]"></td>
                  <td>
                    LEVEL 1<br>
                  </td>
                  <td>
                    Analyzes and synthesizes information
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group20[]"></td>
                  <td>
                    LEVEL 2<br>
                  </td>
                  <td>
                    Identifies critical relationships
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group20[]"></td>
                  <td>
                    LEVEL 3<br>
                  </td>
                  <td>
                    Analyses complex relationships
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group20[]"></td>
                  <td>
                    LEVEL 4<br>
                  </td>
                  <td>
                    Applies broad analysis
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group20[]"></td>
                  <td>
                    LEVEL 5<br>
                  </td>
                  <td>
                    Applies a systems perspective to the analysis of enterprise-wide issues
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div id="resultsOrientation" class="section" style="page-break-inside: avoid; font-size: 12px;">
        <br>
        <div>

          <header class="ui block header" style="background-color: #607d8b; color: white;">
            <h4>COMPETENCY: RESULTS ORIENTATION</h4>
          </header>

          <div class="ui container">
 
            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th>(CHECK)</th>
                  <th style="text-align: center; vertical-align: middle;">LEVEL</th>
                  <!-- <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th> -->
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group21[]"></td>
                  <td>
                    LEVEL 1<br>
                  </td>
                  <td>
                    Strives to meet work expectations
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group21[]"></td>
                  <td>
                    LEVEL 2<br>
                  </td>
                  <td>
                    Consistently meets established expectations
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group21[]"></td>
                  <td>
                    LEVEL 3<br>
                  </td>
                  <td>
                    Surpasses established expectations
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group21[]"></td>
                  <td>
                    LEVEL 4<br>
                  </td>
                  <td>
                    Seeks out significant challenges
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group21[]"></td>
                  <td>
                    LEVEL 5<br>
                  </td>
                  <td>
                    Pursues excellence on an organizational level
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div id="teamwork" class="section" style="page-break-inside: avoid; font-size: 12px;">
        <br>
        <div>

          <header class="ui block header" style="background-color: #607d8b; color: white;">
            <h4>COMPETENCY: TEAMWORK</h4>
          </header>

          <div class="ui container">

            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th>(CHECK)</th>
                  <th style="text-align: center; vertical-align: middle;">LEVEL</th>
                  <!-- <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th> -->
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group22[]"></td>
                  <td>
                    LEVEL 1<br>
                  </td>
                  <td>
                    Participates as a team member
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group22[]"></td>
                  <td>
                    LEVEL 2<br>
                  </td>
                  <td>
                    Fosters teamwork
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group22[]"></td>
                  <td>
                    LEVEL 3<br>
                  </td>
                  <td>
                    Demonstrates leadership in teams
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group22[]"></td>
                  <td>
                    LEVEL 4<br>
                  </td>
                  <td>
                    Capitalizes on teamwork opportunities
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group22[]"></td>
                  <td>
                    LEVEL 5<br>
                  </td>
                  <td>
                    Builds bridges between teams
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div id="valuesAndEthics" class="section" style="page-break-inside: avoid; font-size: 12px;">
        <br>
        <div>

          <header class="ui block header" style="background-color: #607d8b; color: white;">
            <h4>COMPETENCY: VALUES AND ETHICS</h4>
          </header>

          <div class="ui container">

            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th>(CHECK)</th>
                  <th style="text-align: center; vertical-align: middle;">LEVEL</th>
                  <!-- <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th> -->
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group23[]"></td>
                  <td>
                    LEVEL 1<br>
                  </td>
                  <td>
                    Demonstrates behaviors consistent with the organization’s values
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group23[]"></td>
                  <td>
                    LEVEL 2<br>
                  </td>
                  <td>
                    Identifies ethical implications
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group23[]"></td>
                  <td>
                    LEVEL 3<br>
                  </td>
                  <td>
                    Aligns team with organization’s values and ethics
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group23[]"></td>
                  <td>
                    LEVEL 4<br>
                  </td>
                  <td>
                    Promotes the organization’s values and ethics
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group23[]"></td>
                  <td>
                    LEVEL 5<br>
                  </td>
                  <td>
                    Exemplifies and demonstrates the organization’s values and ethics
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div id="visioningAndStrategicDirection" class="section" style="page-break-inside: avoid; font-size: 12px;">
        <br>
        <div>

          <header class="ui block header" style="background-color: #607d8b; color: white;">
            <h4>COMPETENCY: VISIONING AND STRATEGIC DIRECTION</h4>
          </header>

          <div class="ui container">

            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th>(CHECK)</th>
                  <th style="text-align: center; vertical-align: middle;">LEVEL</th>
                  <!-- <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th> -->
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group24[]"></td>
                  <td>
                    LEVEL 1<br>
                  </td>
                  <td>
                    Demonstrates personal work alignment
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group24[]"></td>
                  <td>
                    LEVEL 2<br>
                  </td>
                  <td>
                    Promotes team alignment
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group24[]"></td>
                  <td>
                    LEVEL 3<br>
                  </td>
                  <td>
                    Aligns program/operational goals and plans
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group24[]"></td>
                  <td>
                    LEVEL 4<br>
                  </td>
                  <td>
                    Influences strategic direction
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group24[]"></td>
                  <td>
                    LEVEL 5<br>
                  </td>
                  <td>
                    Develops vision
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div id="SubmitBtn" class="ui segment section noprint">
        <button class="ui fluid button blue">SUBMIT</button>
      </div>
    </form>
  </div>
</div>
<!-- survey content ends here -->
<div class="noprint" id="bottomPage"></div>
<script type="text/javascript">
  (function() {
    'use strict';

    var section = document.querySelectorAll(".section");
    var sections = {};
    var i = 0;

    Array.prototype.forEach.call(section, function(e) {
      sections[e.id] = e.offsetTop;
    });

    window.onscroll = function() {
      var scrollPosition = document.documentElement.scrollTop || document.body.scrollTop;

      for (i in sections) {
        if (sections[i] <= scrollPosition) {
          document.querySelector('.active').setAttribute('class', 'item');
          document.querySelector('a[href*=' + i + ']').setAttribute('class', 'item active');
        }
      }
    };
  })(); 
</script>

  <p class="noprint" style="text-align:center; color: grey; font-family: sans-serif;">Human Resource Information System © 2018<br>HRMO LGU Bayawan City</p>

</body>
</html>