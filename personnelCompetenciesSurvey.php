<!-- <?php require_once "_connect.db.php";?>

<!DOCTYPE html>
<html>
<head>
  <title>Personnel Competencies Survey</title>
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
<div class="ui container center aligned">
<div class="ui red segment" style="margin-top: 200px;">
  Sorry, Survey is temporarily unavailable. Will be back shortly... 
</div>
</div>
</body>
</html> -->

<?php require_once "_connect.db.php";?>

<!DOCTYPE html>
<html>
<head>
  <title>Personnel Competencies Survey</title>
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
      var req = <?php require_once 'autocompleteName.php'; ?>;
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
            $(this).modal("close");
            // return false;
          },
          onApprove : function() {
            // window.alert('Approved!');
            window.close();
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
        // $("#submittedForm").modal({
        //   closable:false,
        //   onApprove:function(){

        //     window.scrollTo(0,0);
            // window.location.reload();
        //   }
        // }).modal('show');
        window.location.href = "personnelCompetenciesSurvey_done.php";
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
    <div class="header">Success!</div>
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
      <p style="color: black; font-weight: normal;">Everything you have inputted will be trashed, unsaved and this page will ne closed. Are you sure?</p>
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
      <div style="page-break-inside: avoid; font-size: 12px;">
        <div>
          <header class="ui block center aligned header" style="background-color: #607d8b; color: white;">
            <h3>JOB COMPETENCY PROFILE</h3>
          </header>
          <div class="ui container">
            <i style="font-size: 14px;">
              <p>Competencies are observable abilities, skills, knowledge, motivations or traits defined in terms of the behaviors needed for successful job performance.</p>

              <h4 style="font-weight: bold">PROFICIENCY/MASTERY LEVEL</h4>

              <p><b>Level 1 (Introductory)</b>: Demonstrates introductory understanding and ability and, with guidance, applies the competency in a few simple situations.</p>

              <p><b>Level 2 (Basic)</b>: Demonstrates basic knowledge and ability and, with guidance, can apply the competency in common situations that present limited difficulties.</p>

              <p><b>Level 3 (Intermediate)</b>: Demonstrates solid knowledge and ability, and can apply the competency with minimal or no guidance in the full range of typical situations. Would require guidance to handle novel or more complex situations.</p>

              <p><b>Level 4 (Advanced)</b>: Demonstrates advanced knowledge and ability, and can apply the competency in new or complex situations. Guides other professionals.</p>

              <p><b>Level 5 (Expert)</b>: Demonstrates expert knowledge and ability, and can apply the competency in the most complex situations. Develops new approaches, methods or policies in the area. Is recognized as an expert, internally and/or externally. Leads the guidance of other professionals.</p>

              <h4 style="font-weight: bold; display: inline-block;">INSTRUCTION:</h4>
              <p style="display: inline-block;"> Please check the proficiency/mastery level of each competency classifications you belive you are qualified.</p>
            </i>
          </div>
        </div>
      </div>
      <div id="adaptability" class="section" style="page-break-inside: avoid; font-size: 12px;">
        <br>
        <div>

          <header class="ui block header" style="background-color: #607d8b; color: white;">
            <h4>COMPETENCY: ADAPTABILITY</h4>
          </header>
          <div class="ui container">
            <p>Adjusting own behaviors to work efficiently and effectively in light of new information, changing situations and/or different environments.</p>
            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th></th>
                  <th style="text-align: center; vertical-align: middle;">PROFICIENCY/MASTERY LEVEL</th>
                  <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group1[]"></td>
                  <td>
                    LEVEL 1<br>
                    Recognizes how change will affect work
                  </td>
                  <td>
                    <ul>
                      <li>Accepts that things will change.</li>
                      <li>Seeks clarification when faced with ambiguity or uncertainty.</li>
                      <li>Demonstrates willingness to try new approaches.</li>
                      <li>Suspends judgment; thinks before acting.</li>
                      <li>Acknowledges the value of others’ contributions regardless of how they are presented.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group1[]"></td>
                  <td>
                    LEVEL 2<br>
                    Adapts one's work to a situation
                  </td>
                  <td>
                    <ul>
                      <li>Adapts personal approach to meet the needs of different or new situations.</li>
                      <li>Seeks guidance in adapting behavior to the needs of a new or different situation.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group1[]"></td>
                  <td>
                    LEVEL 3<br>
                    Adapts to a variety of changes
                  </td> 
                  <td>
                    <ul>
                      <li>Adapts to new ideas and initiatives across a wide variety of issues or situations.</li>
                      <li>Shifts priorities, changes style and responds with new approaches as needed to deal with new or changing demands.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group1[]"></td>
                  <td>
                    LEVEL 4<br>
                    Adapts to large, complex and/or frequent changes
                  </td>
                  <td>
                    <ul>
                      <li>Publicly supports and adapts to major/fundamental changes that show promise of improving established ways of operating.</li>
                      <li>Seeks opportunities for change in order to achieve improvement in work processes, systems, etc.</li>
                      <li>Maintains composure and shows self control in the face of challenges and change.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group1[]"></td>
                  <td>
                    LEVEL 5<br>
                    Adapts organizational strategies
                  </td>
                  <td>
                    <ul>
                      <li>Anticipates change and makes large or long-term adaptations in organization in response to the needs of the situation.</li>
                      <li>Performs effectively amidst continuous change, ambiguity and, at times, apparent chaos.</li>
                      <li>Shifts readily between dealing with macro-strategic issues and critical details.</li>
                    </ul>
                  </td>
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
            <p>Identifying and addressing individual strengths and weaknesses, developmental needs and changing circumstances to enhance personal and organizational performance.</p>
            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th></th>
                  <th style="text-align: center; vertical-align: middle;">PROFICIENCY/MASTERY LEVEL</th>
                  <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group2[]"></td>
                  <td>
                    LEVEL 1<br>
                    Assesses and monitors oneself to maintain personal effectiveness
                  </td>
                  <td>
                    <ul>
                      <li>Continually self-assesses and seeks feedback from others to identify strengths and weaknesses and ways of improving.</li>
                      <li>Pursues learning opportunities and ongoing development</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group2[]"></td>
                  <td>
                    LEVEL 2<br>
                    Seeks to improve personal effectiveness in current situation
                  </td>
                  <td>
                    <ul>
                      <li>Tries new approaches to maximize learning in current situation.</li>
                      <li>Takes advantage of learning opportunities (e.g., courses, observation of others, assignments, etc.).</li>
                      <li>Integrates new learning into work methods.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group2[]"></td>
                  <td>
                    LEVEL 3<br>
                    Seeks learning opportunities beyond current requirements
                  </td>
                  <td>
                    <ul>
                      <li>Sets challenging goals and standards of excellence for self in view of growth beyond current job.</li>
                      <li>Actively pursues self-development on an ongoing basis (technically and personally).</li>
                      <li>Pursues assignments designed to challenge abilities.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group2[]"></td>
                  <td>
                    LEVEL 4<br>
                    Aligns personal development with objectives of organization
                  </td>
                  <td>
                    <ul>
                      <li>Designs personal learning objectives based on evolving needs of the portfolio or business unit.</li>
                      <li>Uses organizational change as an opportunity to develop new skills and knowledge.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group2[]"></td>
                  <td>
                    LEVEL 5<br>
                    Aligns personal learning with anticipated change in organizational strategy
                  </td>
                  <td>
                    <ul>
                      <li>Identifies future competencies and expertise required by the organization and develops and pursues learning plans accordingly.</li>
                      <li>Continuously scans the environment to keep abreast of emerging developments in the broader work context.</li>
                    </ul>
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

            <p>Listening to others and communicating in an effective manner that fosters open communication</p>
            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th></th>
                  <th style="text-align: center; vertical-align: middle;">PROFICIENCY/MASTERY LEVEL</th>
                  <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group3[]"></td>
                  <td>
                    LEVEL 1<br>
                    Listens & clearly presents information
                  </td>
                  <td>
                    <ul>
                      <li>Makes self-available and clearly encourages others to initiate communication.</li>
                      <li>Listens actively and objectively without interrupting.</li>
                      <li>Checks own understanding of others’ communication (e.g., repeats or paraphrases, asks additional questions).</li>
                      <li>Presents appropriate information in a clear and concise manner, both orally and in writing.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group3[]"></td>
                  <td>
                    LEVEL 2<br>
                    Fosters two-way communication
                  </td>
                  <td>
                    <ul>
                      <li>Elicits comments or feedback on what has been said.</li>
                      <li>Maintains continuous open and consistent communication with others.</li>
                      <li>Openly and constructively discusses diverse perspectives that could lead to misunderstandings.</li>
                      <li>Communicates decisions or recommendations that could be perceived negatively, with sensitivity and tact.</li>
                      <li>Supports messages with relevant data, information, examples and demonstrations.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group3[]"></td>
                  <td>
                    LEVEL 3<br>
                    Adapts communication to others
                  </td>
                  <td>
                    <ul>
                      <li>Adapts content, style, tone and medium of communication to suit the target audience’s language, cultural background and level of understanding.</li>
                      <li>Takes others’ perspectives into account when communicating, negotiating or presenting arguments (e.g., presents benefits from all perspectives).</li>
                      <li>Responds to and discusses issues/questions in an understandable manner without being defensive and while maintaining the dignity of others.</li>
                      <li>Anticipates reactions to messages and adapts communications accordingly.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group3[]"></td>
                  <td>
                    LEVEL 4<br>
                    Communicates complex messages
                  </td>
                  <td>
                    <ul>
                      <li>Handles complex on-the-spot questions (e.g., from senior public officials, special interest groups or the media).</li>
                      <li>Communicates complex issues clearly and credibly with widely varied audiences.</li>
                      <li>Uses varied communication systems, methodologies and strategies to promote dialogue and shared understanding.</li>
                      <li>Delivers difficult or unpopular messages with clarity, tact and diplomacy.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group3[]"></td>
                  <td>
                    LEVEL 5<br>
                    Communicates strategically
                  </td>
                  <td>
                    <ul>
                      <li>Communicates strategically to achieve specific objectives (e.g., considering such aspects as the optimal message to present, timing and forum of communication).</li>
                      <li>Identifies and interprets departmental policies and procedures for superiors, subordinates and peers.</li>
                      <li>Acknowledges success and the need for improvement.</li>
                    </ul>
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

            <p>Understanding the workings, structure and culture of the organization as well as the political, social and economic issues, to achieve results</p>
            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th></th>
                  <th style="text-align: center; vertical-align: middle;">PROFICIENCY/MASTERY LEVEL</th>
                  <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group4[]"></td>
                  <td>
                    LEVEL 1<br>
                    Understands formal structure
                  </td>
                  <td>
                    <ul>
                      <li>Monitors work to ensure it aligns with formal procedures and the organization’s accountabilities.</li>
                      <li>Recognizes and uses formal structure, rules, processes, methods or operations to accomplish work.</li>
                      <li>Actively supports the public service mission and goals.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group4[]"></td>
                  <td>
                    LEVEL 2<br>
                    Understands informal structure and culture
                  </td>
                  <td>
                    <ul>
                      <li>Uses informal structures; can identify key decision-makers and influencers.</li>
                      <li>Effectively uses both formal and informal channels or networks for acquiring information, assistance and accomplishing work goals.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group4[]"></td>
                  <td>
                    LEVEL 3<br>
                    Effectively operates in external environments
                  </td>
                  <td>
                    <ul>
                      <li>Achieves solutions acceptable to varied parties based on understanding of issues, climates and cultures in own and other organizations.</li>
                      <li>Accurately describes the issues and culture of external stakeholders. Uses this information to negotiate goals and initiatives.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group4[]"></td>
                  <td>
                    LEVEL 4<br>
                    Understands organizational politics, issues and external influences
                  </td>
                  <td>
                    <ul>
                      <li>Anticipates issues, challenges and outcomes and effectively operates to best position the organization.</li>
                      <li>Supports the changing culture and methods of operating, if necessary, for the success of the organization.</li>
                      <li>Ensures due diligence by keeping informed of business and operational plans and practices.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group4[]"></td>
                  <td>
                    LEVEL 5<br>
                    Operates effectively in a broad spectrum of political, cultural and social milieu
                  </td>
                  <td>
                    <ul>
                      <li>Demonstrates broad understanding of social and economic context within which the organization operates.</li>
                      <li>Understands and anticipates the potential trends of the political environment and the impact these might have on the organization.</li>
                      <li>Operates successfully in a variety of social, political and cultural environments.</li>
                      <li>Uses organizational culture as a means to influence and lead the organization.</li>
                    </ul>
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

            <p>Questioning conventional approaches, exploring alternatives and responding to challenges with innovative solutions or services, using intuition, experimentation and fresh perspectives.</p>
            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th></th>
                  <th style="text-align: center; vertical-align: middle;">PROFICIENCY/MASTERY LEVEL</th>
                  <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group5[]"></td>
                  <td>
                    LEVEL 1<br>
                    Acknowledges the need for new approaches
                  </td>
                  <td>
                    <ul>
                      <li>Is open to new ideas.</li>
                      <li>Questions the conventional approach and seeks alternatives.</li>
                      <li>Recognizes when a new approach is needed; integrates new information quickly while considering different options.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group5[]"></td>
                  <td>
                    LEVEL 2<br>
                    Modifies current approaches
                  </td>
                  <td>
                    <ul>
                      <li>Analyzes strengths and weaknesses of current approaches.</li>
                      <li>Modifies and adapts current methods and approaches to better meet needs.</li>
                      <li>Identifies alternate solutions based on precedent.</li>
                      <li>Identifies an optimal solution after weighing the advantages and disadvantages of alternative approaches.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group5[]"></td>
                  <td>
                    LEVEL 3<br>
                    Introduces new approaches
                  </td>
                  <td>
                    <ul>
                      <li>Searches for ideas or solutions that have worked in other environments and applies them to the organization.</li>
                      <li>Uses existing solutions in innovative ways to solve problems.</li>
                      <li>Sees long-term consequences of potential solutions.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group5[]"></td>
                  <td>
                    LEVEL 4<br>
                    Creates new concepts
                  </td>
                  <td>
                    <ul>
                      <li>Integrates and synthesizes relevant concepts into a new solution for which there is no previous experience.</li>
                      <li>Creates new models and methods for the organization.</li>
                      <li>Identifies flexible and adaptable solutions while still recognizing professional and organizational standards.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group5[]"></td>
                  <td>
                    LEVEL 5<br>
                    Nurtures creativity
                  </td>
                  <td>
                    <ul>
                      <li>Develops an environment that nurtures creative thinking, questioning and experimentation.</li>
                      <li>Encourages challenges to conventional approaches.</li>
                      <li>Sponsors experimentation to maximize potential for innovation.</li>
                    </ul>
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

            <p>Building and actively maintaining working relationships and/or networks of contacts to further the organization’s goals.</p>
            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th></th>
                  <th style="text-align: center; vertical-align: middle;">PROFICIENCY/MASTERY LEVEL</th>
                  <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group6[]"></td>
                  <td>
                    LEVEL 1<br>
                    Accesses sources of information
                  </td>
                  <td>
                    <ul>
                      <li>Seeks information from others (e.g., colleagues, customers).</li>
                      <li>Maintains personal contacts in other parts of the organization with those who can provide work-related information.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group6[]"></td>
                  <td>
                    LEVEL 2<br>
                    Builds key contacts
                  </td>
                  <td>
                    <ul>
                      <li>Seeks out the expertise of others and develops links with experts and information sources.</li>
                      <li>Develops and nurtures key contacts as a source of information.</li>
                      <li>Participates in networking and social events internal and external to the organization.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group6[]"></td>
                  <td>
                    LEVEL 3<br>
                    Seeks new networking opportunities for self and others
                  </td>
                  <td>
                    <ul>
                      <li>Seeks opportunities to partner and transfer knowledge (e.g., by actively participating in trade shows, conferences, meetings, committees, multi-stakeholder groups and/or seminars).</li>
                      <li>Cultivates personal networks in different parts of the organization and effectively uses contacts to achieve results.</li>
                      <li>Initiates and develops diverse relationships.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group6[]"></td>
                  <td>
                    LEVEL 4<br>
                    Strategically expands networks
                  </td>
                  <td>
                    <ul>
                      <li>Builds networks with parties that can enable the achievement of the organization’s strategy.</li>
                      <li>Brings informal teams of experts together to address issues/needs, share information and resolve differences, as required.</li>
                      <li>Uses knowledge of the formal or informal structure and the culture to further strategic objectives.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group6[]"></td>
                  <td>
                    LEVEL 5<br>
                    Creates networking opportunities
                  </td>
                  <td>
                    <ul>
                      <li>Creates and facilitates forums to develop new alliances and formal networks.</li>
                      <li>Identifies areas to build strategic relationships.</li>
                      <li>Contacts senior officials to identify potential areas of mutual, long-term interest.</li>
                    </ul>
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

            <p>Preventing, managing and resolving conflicts.</p>
            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th></th>
                  <th style="text-align: center; vertical-align: middle;">PROFICIENCY/MASTERY LEVEL</th>
                  <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group7[]"></td>
                  <td>
                    LEVEL 1<br>
                    Identifies conflict
                  </td>
                  <td>
                    <ul>
                      <li>Recognizes that there is a conflict between two or more parties.</li>
                      <li>Brings conflict to the attention of the appropriate individual(s).</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group7[]"></td>
                  <td>
                    LEVEL 2<br>
                    Addresses existing conflict
                  </td>
                  <td>
                    <ul>
                      <li>Listens to differing points of view and emphasizes points of agreement as a starting point to resolving differences.</li>
                      <li>Openly identifies shared areas of interest in a respectful and timely manner.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group7[]"></td>
                  <td>
                    LEVEL 3<br>
                    Anticipates and addresses sources of potential conflict
                  </td>
                  <td>
                    <ul>
                      <li>Anticipates and takes action to avoid/reduce potential conflict (e.g., by encouraging and supporting the various parties to get together and attempt to address the issues themselves).</li>
                      <li>Refocuses teams on the work and end-goals, and away from personality issues.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group7[]"></td>
                  <td>
                    LEVEL 4<br>
                    Introduces strategies for resolving existing and potential conflict
                  </td>
                  <td>
                    <ul>
                      <li>Provides consultation to or obtains consultation / mediation for those who share few common interests and who are having a significant disagreement.</li>
                      <li>Introduces innovative strategies for effectively dealing with conflict (e.g., mediation, collaborative and "mutual gains" strategies).</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group7[]"></td>
                  <td>
                    LEVEL 5<br>
                    Creates an environment where conflict is resolved appropriately
                  </td>
                  <td>
                    <ul>
                      <li>Creates a conflict-resolving environment by anticipating and addressing areas where potential misunderstanding and disruptive conflict could emerge.</li>
                      <li>Models constructive approaches to deal with opposing views when personally challenging the status quo and when encouraging others to do so as well.</li>
                    </ul>
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

            <p>Ensures the effective, efficient and sustainable use of government resources and assets (physical, human and financial resources).</p>
            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th></th>
                  <th style="text-align: center; vertical-align: middle;">PROFICIENCY/MASTERY LEVEL</th>
                  <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group8[]"></td>
                  <td>
                    LEVEL 1<br>
                    Uses resources effectively
                  </td>
                  <td>
                    <ul>
                      <li>Protects and uses resources and assets in a conscientious and effective manner.</li>
                      <li>Identifies wasteful practices and opportunities for optimizing resource use.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group8[]"></td>
                  <td>
                    LEVEL 2<br>
                    Ensures effective use of resources
                  </td>
                  <td>
                    <ul>
                      <li>Monitors and ensures the efficient and appropriate use of resources and assets.</li>
                      <li>Explores ways of leveraging funds to expand program effectiveness.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group8[]"></td>
                  <td>
                    LEVEL 3<br>
                    Controls resource use
                  </td>
                  <td>
                    <ul>
                      <li>Allocates and controls resources and assets within own area.</li>
                      <li>Implements ways of more effectively utilizing resources and assets.</li>
                      <li>Assigns and communicates roles and accountabilities to maximize team effectiveness; manages workload.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group8[]"></td>
                  <td>
                    LEVEL 4<br>
                    Implements systems to ensure stewardship of resources
                  </td>
                  <td>
                    <ul>
                      <li>Identifies gaps in resources that impact on the organization’s effectiveness.</li>
                      <li>Develops strategies to address resource gaps/issues.</li>
                      <li>Ensures alignment of authority, responsibility and accountability with organizational objectives.</li>
                      <li>Ensures that information and knowledge sharing is integrated into all programs and processes.</li>
                      <li>Acts on audit, evaluation and other objective project team performance information.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group8[]"></td>
                  <td>
                    LEVEL 5<br>
                    Ensures strategic stewardship of RESOURCES
                  </td>
                  <td>
                    <ul>
                      <li>Directs resources to those areas where they will most effectively contribute to long-term goals.</li>
                      <li>Sets overall direction for how resources and assets are to be used in order to achieve the vision and values.</li>
                      <li>Institutes organization-wide mechanisms and processes to promote and support resource management.</li>
                    </ul>
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

            <p>Identifying, assessing and managing risk while striving to attain objectives.</p>
            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th></th>
                  <th style="text-align: center; vertical-align: middle;">PROFICIENCY/MASTERY LEVEL</th>
                  <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group9[]"></td>
                  <td>
                    LEVEL 1<br>
                    Identifies possible risks
                  </td>
                  <td>
                    <ul>
                      <li>Describes risk factors related to a situation/activity.</li>
                      <li>Uses past experience and best practices to identify underlying issues, potential problems and risks.</li>
                      <li>Plans for contingencies.</li>
                      <li>Identifies possible cause-effect relationships.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group9[]"></td>
                  <td>
                    LEVEL 2<br>
                    Takes calculated risks
                  </td>
                  <td>
                    <ul>
                      <li>Takes calculated risks with minor, but non-trivial, consequences of error (e.g., risks involving potential loss of some time or money but which can be rectified).</li>
                      <li>Makes decisions based on risk analysis.</li>
                      <li>Makes decisions in the absence of complete information.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group9[]"></td>
                  <td>
                    LEVEL 3<br>
                    Personally takes significant risks
                  </td>
                  <td>
                    <ul>
                      <li>Personally takes calculated risks with significant consequences (e.g., significant loss of time or money) but which can be rectified.</li>
                      <li>Anticipates the risks involved in taking action.</li>
                      <li>Identifies possible scenarios regarding outcomes of various options for action.</li>
                      <li>Conducts ongoing risk analysis, looking ahead for contingent liabilities and opportunities and astutely identifying the risks involved.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group9[]"></td>
                  <td>
                    LEVEL 4<br>
                    Designs strategies for dealing with high-risk initiatives
                  </td>
                  <td>
                    <ul>
                      <li>Implements initiatives with high potential for pay-off to the organization, where errors cannot be rectified, or only rectified at significant cost.</li>
                      <li>Conducts risk assessment when identifying or recommending strategic and tactical options.</li>
                      <li>Encourages responsible risk taking, recognizing that every risk will not pay off.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group9[]"></td>
                  <td>
                    LEVEL 5<br>
                    Provides organizational guidance on risk
                  </td>
                  <td>
                    <ul>
                      <li>Provides a supportive environment for responsible risk taking (e.g., by supporting decisions of others).</li>
                      <li>Oversees the development of guidelines, principles and approaches to assist decision-making when risk is a factor.</li>
                      <li>Provides guidance on the organizational tolerance for risk.</li>
                      <li>Develops broad strategies that reflect in-depth understanding and assessment of operational, organizational, and political realities and risks.</li>
                    </ul>
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

            <p>Maintaining effectiveness in the face of stress.</p>
            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th></th>
                  <th style="text-align: center; vertical-align: middle;">PROFICIENCY/MASTERY LEVEL</th>
                  <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group10[]"></td>
                  <td>
                    LEVEL 1<br>
                    Works in low level stress situations
                  </td>
                  <td>
                    <ul>
                      <li>Keeps functioning effectively during periods of on-going low intensity stress.</li>
                      <li>Maintains focus during situations involving limited stress.</li>
                      <li>Seeks to balance work responsibilities and personal life responsibilities.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group10[]"></td>
                  <td>
                    LEVEL 2<br>
                    Adjusts to temporary peaks in stress levels
                  </td>
                  <td>
                    <ul>
                      <li>Maintains composure when dealing with short but intense stressful situations.</li>
                      <li>Understands personal stressors and takes steps to limit their impact.</li>
                      <li>Keeps issues and situations in perspective and reacts appropriately (e.g., does not overreact to situations, what others say, etc.).</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group10[]"></td>
                  <td>
                    LEVEL 3<br>
                    Adapts to prolonged stress
                  </td>
                  <td>
                    <ul>
                      <li>Effectively withstands the effects of prolonged exposure to one or few stressors by modifying work methods.</li>
                      <li>Maintains sound judgment and decision making despite on-going stressful situations.</li>
                      <li>Controls strong emotions or other stressful responses and takes action to respond constructively to the source of the problem.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group10[]"></td>
                  <td>
                    LEVEL 4<br>
                    Employs stress management strategies
                  </td>
                  <td>
                    <ul>
                      <li>Develops and applies stress reduction strategies to cope with long exposure to numerous stressors or stressful situations.</li>
                      <li>Recognizes personal limits for workload and negotiates adjustments to minimize the effects of stress, while still ensuring appropriate levels of productivity.</li>
                      <li>Controls own emotions and calms others in stressful situations.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group10[]"></td>
                  <td>
                    LEVEL 5<br>
                    Deals with stress affecting the organization
                  </td>
                  <td>
                    <ul>
                      <li>Demonstrates behaviors that help others remain calm, yet focused and energized during periods of extreme stress affecting the organization.</li>
                      <li>Maintains composure and shows self-control in the face of significant challenge facing the organization.</li>
                      <li>Suspends judgment; thinks before acting.</li>
                      <li>Identifies and consistently models ways of releasing or limiting stress within the organization.</li>
                    </ul>
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

            <p>Gaining support from and convincing others to advance the objectives of the organization.</p>
            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th></th>
                  <th style="text-align: center; vertical-align: middle;">PROFICIENCY/MASTERY LEVEL</th>
                  <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group11[]"></td>
                  <td>
                    LEVEL 1<br>
                    Uses facts and available information to persuade
                  </td>
                  <td>
                    <ul>
                      <li>Uses appeals to reason, data, facts and figures.</li>
                      <li>Uses concrete examples, visual aids and demonstrations to make a point.</li>
                      <li>Describes the potential impact of own actions on others and how it will affect their perception of self.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group11[]"></td>
                  <td>
                    LEVEL 2<br>
                    Adapts rationale to influence others
                  </td>
                  <td>
                    <ul>
                      <li>Anticipates the effect of one’s approach or chosen rationale on the emotions and sensitivities of others.</li>
                      <li>Adapts discussions and presentations to appeal to the needs or interests of others.</li>
                      <li>Uses the process of give-and-take to gain support.</li>
                      <li>Builds relationships through fair, honest and consistent behavior.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group11[]"></td>
                  <td>
                    LEVEL 3<br>
                    Demonstrates the benefit of ideas
                  </td>
                  <td>
                    <ul>
                      <li>Builds on successful initiatives and best practices internal and external to the organization to gain acceptance for ideas.</li>
                      <li>Presents pros and cons and detailed analyses to emphasize the value of an idea.</li>
                      <li>Persuades others by drawing from experience and presenting multiple arguments in order to support a position.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group11[]"></td>
                  <td>
                    LEVEL 4<br>
                    Builds coalitions, strategic relationships and networks
                  </td>
                  <td>
                    <ul>
                      <li>Assembles coalitions, builds behind-the-scenes support for ideas and initiatives.</li>
                      <li>Develops an extensive network of contacts.</li>
                      <li>Uses group process skills to lead or direct a group.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group11[]"></td>
                  <td>
                    LEVEL 5<br>
                    Designs complex influence strategies
                  </td>
                  <td>
                    <ul>
                      <li>Designs strategies that position and promote ideas and concepts to stakeholders.</li>
                      <li>Uses indirect strategies to persuade, such as establishing alliances, using experts or third parties.</li>
                      <li>Gains support by capitalizing on understanding of political forces affecting the organization.</li>
                    </ul>
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

            <p>Identifying and dealing with issues proactively and persistently; seizing opportunities that arise.</p>
            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th></th>
                  <th style="text-align: center; vertical-align: middle;">PROFICIENCY/MASTERY LEVEL</th>
                  <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group12[]"></td>
                  <td>
                    LEVEL 1<br>
                    Addresses current issues
                  </td>
                  <td>
                    <ul>
                      <li>Recognizes and acts on present issues.</li>
                      <li>Offers ideas to address current situations or issues.</li>
                      <li>Works independently. Completes assignments without constant supervision</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group12[]"></td>
                  <td>
                    LEVEL 2<br>
                    Addresses imminent issues
                  </td>
                  <td>
                    <ul>
                      <li>Takes action to avoid imminent problem or to capitalize on imminent opportunity.</li>
                      <li>Looks for ways to achieve greater results or add value.</li>
                      <li>Works persistently as needed and when not required to do so.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group12[]"></td>
                  <td>
                    LEVEL 3<br>
                    Acts promptly in a crisis situation
                  </td>
                  <td>
                    <ul>
                      <li>Acts quickly to address a crisis situation drawing on appropriate resources and experience with similar situations.</li>
                      <li>Implements contingency plans when crises arise.</li>
                      <li>Exceeds requirements of job; takes on extra tasks.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group12[]"></td>
                  <td>
                    LEVEL 4<br>
                    Looks to the future
                  </td>
                  <td>
                    <ul>
                      <li>Takes action to avoid or minimize potential problems or maximize potential opportunities in the future by drawing on extensive personal experience.</li>
                      <li>Defines and addresses high-level challenges that have the potential to advance the state-of-the art in an area.</li>
                      <li>Starts and carries through on new projects.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group12[]"></td>
                  <td>
                    LEVEL 5<br>
                    Encourages initiative in others
                  </td>
                  <td>
                    <ul>
                      <li>Fosters an environment that anticipates and acts upon potential threats and/or opportunities.</li>
                      <li>Coaches others to spontaneously recognize and appropriately act on upcoming opportunities.</li>
                      <li>Gets others involved in supporting efforts and initiatives.</li>
                    </ul>
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

            <p>Leading and supporting a team to achieve results.</p>
            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th></th>
                  <th style="text-align: center; vertical-align: middle;">PROFICIENCY/MASTERY LEVEL</th>
                  <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group13[]"></td>
                  <td>
                    LEVEL 1<br>
                    Keeps the team informed
                  </td>
                  <td>
                    <ul>
                      <li>Ensures that team members have the necessary information to operate effectively.</li>
                      <li>Establishes the direction/goal(s) for the team.</li>
                      <li>Lets team members affected by a decision know exactly what is happening and gives a clear rationale for the decision.</li>
                      <li>Sets an example for team members (e.g., respect of others’ views, team loyalty, cooperating with others).</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group13[]"></td>
                  <td>
                    LEVEL 2<br>
                    Ensures the needs of the team and of members are met
                  </td>
                  <td>
                    <ul>
                      <li>Makes sure the practical needs of the team and team members are met.</li>
                      <li>Makes decisions by taking into account the differences among team members, and overall team requirements and objectives.</li>
                      <li>Ensures that the team’s tasks are completed.</li>
                      <li>Accepts responsibility for the team’s actions and results.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group13[]"></td>
                  <td>
                    LEVEL 3<br>
                    Ensures team member input
                  </td>
                  <td>
                    <ul>
                      <li>Values and encourages others’ input and suggestions.</li>
                      <li>Stimulates constructive discussion of different points of view, focusing on the organization’s strategic objectives, vision or values.</li>
                      <li>Builds cooperation, loyalty and helps achieve consensus.</li>
                      <li>Provides constructive feedback and recognizes all contributions.</li>
                      <li>Ensures the respective strengths of team members are used in order to achieve the team’s overall objectives.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group13[]"></td>
                  <td>
                    LEVEL 4<br>
                    Empowers the team
                  </td>
                  <td>
                    <ul>
                      <li>Communicates team successes and organization-wide contribution to other organizational members.</li>
                      <li>Encourages the team to promote their work throughout the organization.</li>
                      <li>Establishes the team’s credibility with internal and external stakeholders.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group13[]"></td>
                  <td>
                    LEVEL 5<br>
                    Inspires team members
                  </td>
                  <td>
                    <ul>
                      <li>Builds the commitment of the team to the organization’s mission, goals and values.</li>
                      <li>Aligns team objectives and priorities with the broader objectives of the organization.</li>
                      <li>Ensures that appropriate linkages/partnerships between teams are maintained.</li>
                      <li>Creates an environment where team members consistently push to improve team performance and productivity.</li>
                    </ul>
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

            <p>Managing, leading and enabling the process of change and transition while helping others deal with their effects.</p>
            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th></th>
                  <th style="text-align: center; vertical-align: middle;">PROFICIENCY/MASTERY LEVEL</th>
                  <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group14[]"></td>
                  <td>
                    LEVEL 1<br>
                    Makes others aware of change
                  </td>
                  <td>
                    <ul>
                      <li>Identifies and accepts the need and processes for change.</li>
                      <li>Explains the process, implications and rationale for change to those affected by it.</li>
                      <li>Invites discussion of views on the change</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group14[]"></td>
                  <td>
                    LEVEL 2<br>
                    Underscores the positive nature of change
                  </td>
                  <td>
                    <ul>
                      <li>Promotes the advantages of change.</li>
                      <li>Clarifies the potential opportunities and consequences of proposed changes.</li>
                      <li>Explains how change affects current practices.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group14[]"></td>
                  <td>
                    LEVEL 3<br>
                    Manages the process for change
                  </td>
                  <td>
                    <ul>
                      <li>Identifies important / effective practices that should continue after change is implemented</li>
                      <li>Anticipates specific reasons underlying resistance to change and implements approaches that address resistance.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group14[]"></td>
                  <td>
                    LEVEL 4<br>
                    Aligns change initiatives with organizational objectives
                  </td>
                  <td>
                    <ul>
                      <li>Links projects/objectives to department’s/public service’s change initiatives and describes the impact on operational goals.</li>
                      <li>Presents realities of change and, together with staff, develops strategies for managing it.</li>
                      <li>Identifies future needs for change that will promote progress toward identified objectives.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group14[]"></td>
                  <td>
                    LEVEL 5<br>
                    Champions change
                  </td>
                  <td>
                    <ul>
                      <li>Creates an environment that promotes and encourages change or innovation.</li>
                      <li>Shares and promotes successful change efforts throughout the organization.</li>
                      <li>Personally communicates a clear vision of the broad impact of change.</li>
                    </ul>
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

            <p>Identifying and responding to current and future client needs; providing service excellence to internal and external clients.</p>
            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th></th>
                  <th style="text-align: center; vertical-align: middle;">PROFICIENCY/MASTERY LEVEL</th>
                  <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group15[]"></td>
                  <td>
                    LEVEL 1<br>
                    Responds to client requests
                  </td>
                  <td>
                    <ul>
                      <li>Identifies client needs and expectations.</li>
                      <li>Responds to requests efficiently and effectively.</li>
                      <li>Takes action beyond explicit request within established service standards.</li>
                      <li>Refers complex questions to a higher decision-making level.</li>
                      <li>Meets client needs in a respectful, helpful and responsive manner.</li>
                      <li>Seeks feedback to develop a clear understanding of client needs and outcomes.</li>
                      <li>Uses client satisfaction monitoring methodologies to ensure client satisfaction.</li>
                      <li>Adjusts service based on client feedback.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group15[]"></td>
                  <td>
                    LEVEL 2<br>
                    Builds positive client Relations
                  </td>
                  <td>
                    <ul>
                      <li>Contacts clients to follow up on services, solutions or products to ensure that their needs have been correctly and effectively met.</li>
                      <li>Understands issues from the client’s perspective.</li>
                      <li>Keeps clients up-to-date with information and decisions that affect them.</li>
                      <li>Monitors services provided to clients and makes timely adjustments as required.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group15[]"></td>
                  <td>
                    LEVEL 3<br>
                    Anticipates and adapts to client needs
                  </td>
                  <td>
                    <ul>
                      <li>Maintains ongoing communication with clients.</li>
                      <li>Regularly and systematically contacts clients or prospective clients to determine their needs.</li>
                      <li>Uses understanding of client’s perspective to identify constraints and advocate on their behalf.</li>
                      <li>Works with clients to adapt services, products or solutions to meet their needs.</li>
                      <li>Encourages co-workers and teams to achieve a high standard of service excellence.</li>
                      <li>Anticipates areas where support or influence will be required and discusses situation/concerns with appropriate individuals.</li>
                      <li>Proposes new, creative and sound alternatives to improve client service.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group15[]"></td>
                  <td>
                    LEVEL 4<br>
                    Fosters a client-focused culture
                  </td>
                  <td>
                    <ul>
                      <li>Tracks trends and developments that will affect own organization’s ability to meet current and future client needs.</li>
                      <li>Identifies benefits for clients; looks for ways to add value.</li>
                      <li>Seeks out and involves clients or prospective clients in assessing services, solutions or products to identify ways to improve.</li>
                      <li>Establishes service standards and develops strategies to ensure staff meet them.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group15[]"></td>
                  <td>
                    LEVEL 5<br>
                    Considers the strategic direction of client focus
                  </td>
                  <td>
                    <ul>
                      <li>Communicates the organization’s mission, vision and values to external clients.</li>
                      <li>Strategically and systematically evaluates new opportunities to develop client relationships.</li>
                      <li>Creates an environment in which concern for client satisfaction is a key priority.</li>
                      <li>Links a comprehensive and in-depth understanding of clients’ long-term needs and strategies with current and proposed projects/initiatives.</li>
                      <li>Recommends/ determines strategic business direction to meet projected needs of clients and prospective clients.</li>
                    </ul>
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

            <p>Seeking and building strategic alliances and collaborative arrangements through partnerships to advance the objectives of the organization.</p>
            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th></th>
                  <th style="text-align: center; vertical-align: middle;">PROFICIENCY/MASTERY LEVEL</th>
                  <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group16[]"></td>
                  <td>
                    LEVEL 1<br>
                    Operates effectively within partnerships
                  </td>
                  <td>
                    <ul>
                      <li>Understands the roles played by partners. Identifies and refers to areas of mutual interest as a means of establishing a business relationship.</li>
                      <li>Communicates openly, builds trust and treats partners fairly, ethically and as valued allies.</li>
                      <li>Meets partner needs by responding to requests efficiently and effectively.</li>
                      <li>Recognizes the contributions of partners.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group16[]"></td>
                  <td>
                    LEVEL 2<br>
                    Manages existing partnerships
                  </td>
                  <td>
                    <ul>
                      <li>Works with existing partners, honoring established agreements/ contracts.</li>
                      <li>Monitors partnership arrangements to ensure that the objectives of the partnership remain on target.</li>
                      <li>Seeks input from partners to ensure that objectives are achieved.</li>
                      <li>Seeks mutually beneficial solutions with partners.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group16[]"></td>
                  <td>
                    LEVEL 3<br>
                    Seeks out partnership opportunities
                  </td>
                  <td>
                    <ul>
                      <li>Initiates partnership arrangements that promote organizational objectives.</li>
                      <li>Assesses the value of entering into partner relationships in terms of both short- and long- term return on investment.</li>
                      <li>Develops new and mutually beneficial partnerships that also serve the interests of the broader community.</li>
                      <li>Identifies benefits of a partnership and looks for ways to add value for the partner.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group16[]"></td>
                  <td>
                    LEVEL 4<br>
                    Facilitates partnerships
                  </td>
                  <td>
                    <ul>
                      <li>Provides advice and direction on the types of partner relationships to pursue, as well as ground rules for effective partner relationships.</li>
                      <li>Supports staff in taking calculated risks in partner relationships.</li>
                      <li>Negotiates, as necessary, to assist others to address issues or resolve problems surrounding partner relationships.</li>
                      <li>Identifies when modifications and terminations of partnerships are needed and takes appropriate measures.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group16[]"></td>
                  <td>
                    LEVEL 5<br>
                    Sets strategic direction for partnering
                  </td>
                  <td>
                    <ul>
                      <li>Provides strategic direction on partnerships that the organization should be pursuing.</li>
                      <li>Sets up an infrastructure that supports effective partner arrangements (e.g., principles and frameworks for assessing the value of partnerships; expert assistance in aspects of partnering).</li>
                      <li>Takes advantage of opportunities to showcase excellent examples of partner arrangements throughout the organization.</li>
                      <li>Creates and acts on opportunities for interactions that lead to strong partnerships within and external to the organization.</li>
                    </ul>
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

            <p>Fostering the development of others by providing a supportive environment for enhanced performance and professional growth.</p>
            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th></th>
                  <th style="text-align: center; vertical-align: middle;">PROFICIENCY/MASTERY LEVEL</th>
                  <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group17[]"></td>
                  <td>
                    LEVEL 1<br>
                    Shares expertise with others
                  </td>
                  <td>
                    <ul>
                      <li>Regularly shares expertise with team members to support continuous learning and improvement.</li>
                      <li>Advises, guides and coaches others by sharing experiences and discussing how to handle current or anticipated concerns.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group17[]"></td>
                  <td>
                    LEVEL 2<br>
                    Supports individual development and improvement
                  </td>
                  <td>
                    <ul>
                      <li>Provides performance feedback and support, reinforcing strengths and identifying areas for improvement.</li>
                      <li>Encourages staff to develop and apply their skills.</li>
                      <li>Suggests to individuals ways of improving performance and competence.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group17[]"></td>
                  <td>
                    LEVEL 3<br>
                    Promotes ongoing learning and development
                  </td>
                  <td>
                    <ul>
                      <li>Helps team members develop their skills and abilities.</li>
                      <li>Engages in development and career planning dialogues with employees.</li>
                      <li>Works with employees and teams to define realistic yet challenging work goals.</li>
                      <li>Encourages team members to develop learning and career plans and follows-up to guide development and measure progress.</li>
                      <li>Advocates and commits to ongoing training and development to foster a learning culture.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group17[]"></td>
                  <td>
                    LEVEL 4<br>
                    Provides opportunities for development
                  </td>
                  <td>
                    <ul>
                      <li>Ensures that resources and time are available for development activities.</li>
                      <li>Ensures that all employees have equitable access to development opportunities.</li>
                      <li>Provides opportunities for development through tools, assignments, mentoring and coaching relationships etc.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group17[]"></td>
                  <td>
                    LEVEL 5<br>
                    Creates a continuous learning and development environment
                  </td>
                  <td>
                    <ul>
                      <li>Provides long-term direction regarding learning needs for staff and how to pursue the attainment of this learning.</li>
                      <li>Institutes organization-wide mechanisms and processes to promote and support continuous learning and improvement.</li>
                      <li>Manages the learning process to ensure it occurs by design rather than by chance.</li>
                    </ul>
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

            <p>Defining tasks and milestones to achieve objectives, while ensuring the optimal use of resources to meet those objectives.</p>
            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th></th>
                  <th style="text-align: center; vertical-align: middle;">PROFICIENCY/MASTERY LEVEL</th>
                  <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group18[]"></td>
                  <td>
                    LEVEL 1<br>
                    Plans tasks and organizes own work
                  </td>
                  <td>
                    <ul>
                      <li>Identifies requirements and uses available resources to meet own work objectives in optimal fashion.</li>
                      <li>Completes tasks in accordance with plans.</li>
                      <li>Monitors the attainment of own work objectives and/or quality of the work completed.</li>
                      <li>Sets priorities for tasks in order of importance.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group18[]"></td>
                  <td>
                    LEVEL 2<br>
                    Applies planning principles to achieve work goals
                  </td>
                  <td>
                    <ul>
                      <li>Establishes goals and organizes work by bringing together the necessary resources.</li>
                      <li>Organizes work according to project and time management principles and processes.</li>
                      <li>Practices and plans for contingencies to deal with unexpected events or setbacks.</li>
                      <li>Makes needed adjustments to timelines, steps and resource allocation.</li>
                      <li>Directs issues to appropriate bodies when unable to resolve them within own area of responsibility.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group18[]"></td>
                  <td>
                    LEVEL 3<br>
                    Develops plans for the business unit
                  </td>
                  <td>
                    <ul>
                      <li>Considers a range of factors in the planning process (e.g., costs, timing, customer needs, resources available, etc.).</li>
                      <li>Identifies and plans activities that will result in overall improvement to services.</li>
                      <li>Challenges inefficient or ineffective work processes and offers constructive alternatives.</li>
                      <li>Anticipates issues and revise plans as required.</li>
                      <li>Helps to remove barriers by providing resources and encouragement as needed.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group18[]"></td>
                  <td>
                    LEVEL 4<br>
                    Integrates and evaluates plans to achieve business goals.
                  </td>
                  <td>
                    <ul>
                      <li>Establishes alternative courses of action, organizes people and prioritizes the activities of the team to achieve results more effectively.</li>
                      <li>Ensures that systems are in place to effectively monitor and evaluate progress.</li>
                      <li>Evaluates processes and results and makes appropriate adjustments to the plan.</li>
                      <li>Sets, communicates and regularly assesses priorities.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group18[]"></td>
                  <td>
                    LEVEL 5<br>
                    Plans and organizes at a strategic level
                  </td>
                  <td>
                    <ul>
                      <li>Develops strategic plans considering short-term requirements as well as long-term direction.</li>
                      <li>Plans work and deploys resources to deliver organization-wide results.</li>
                      <li>Secures and allocates program or project resources in line with strategic direction.</li>
                      <li>Sets and communicates priorities within the broader organization.</li>
                      <li>Ensures sufficient resources are available to achieve set objectives.</li>
                    </ul>
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

            <p>Making decisions and solving problems involving varied levels of complexity, ambiguity and risk.</p>
            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th></th>
                  <th style="text-align: center; vertical-align: middle;">PROFICIENCY/MASTERY LEVEL</th>
                  <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group19[]"></td>
                  <td>
                    LEVEL 1<br>
                    Makes decisions based solely on rules
                  </td>
                  <td>
                    <ul>
                      <li>Makes straightforward decisions based on pre-defined options using clear criteria/procedures.</li>
                      <li>Consults with others or refers an issue/situation for resolution when criteria are not clear.</li>
                      <li>Deals with exceptions within established parameters using clearly specified rules and procedures.</li>
                      <li>Makes decisions involving little or no consequence of error.</li>
                      <li>Verifies that the decision/resolution is correct.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group19[]"></td>
                  <td>
                    LEVEL 2<br>
                    Makes decisions by interpreting rules
                  </td>
                  <td>
                    <ul>
                      <li>Applies guidelines and procedures that require some interpretation when dealing with exceptions.</li>
                      <li>Makes straight - forward decisions based on information that is generally clear and adequate.</li>
                      <li>Considers the risks and consequences of action and/or decisions.</li>
                      <li>Makes decisions involving minor consequence of error.</li>
                      <li>Seeks guidance as needed when the situation is unclear.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group19[]"></td>
                  <td>
                    LEVEL 3<br>
                    Makes decisions in situations where there is scope for interpretation of rules
                  </td>
                  <td>
                    <ul>
                      <li>Applies guidelines and procedures that leave considerable room for discretion and interpretation.</li>
                      <li>Makes decisions by weighing several factors, some of which are partially defined and entail missing pieces of critical information.</li>
                      <li>As needed, involves the right people in the decision-making process.</li>
                      <li>Balances the risks and implications of decisions across multiple issues.</li>
                      <li>Develops solutions that address the root cause of the problem and prevent recurrence.</li>
                      <li>Recognizes, analyzes and solves problems across projects and in complex situations.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group19[]"></td>
                  <td>
                    LEVEL 4<br>
                    Makes complex decisions in the absence of rules
                  </td>
                  <td>
                    <ul>
                      <li>Simplifies complex information from multiple sources to resolve issues.</li>
                      <li>Makes complex decisions for which there are no set procedures.</li>
                      <li>Considers a multiplicity of interrelated factors for which there is incomplete and contradictory information.</li>
                      <li>Balances competing priorities in reaching decisions.</li>
                      <li>Develops solutions to problems, balancing the risks and implications across multiple projects.</li>
                      <li>Recommends solutions in an environment of risk and ambiguity.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group19[]"></td>
                  <td>
                    LEVEL 5<br>
                    Makes high-risk decisions in complex and ambiguous situations
                  </td>
                  <td>
                    <ul>
                      <li>Makes high-risk strategic decisions that have significant consequences.</li>
                      <li>Balances a commitment to excellence with the best interests of clients and the organization whenmaking decisions.</li>
                      <li>Uses principles, values and sound business sense to make decisions.</li>
                      <li>Makes decisions in a volatile environment in which weight given to any factor can change rapidly.</li>
                      <li>Reaches decisions assuredly in an environment of public scrutiny.</li>
                      <li>Assesses external and internal environments in order to make a well-informed decision.</li>
                      <li>Identifies the problem based on many factors, often complex and sweeping, difficult to define and contradictory (e.g., fiscal responsibility, the public good).</li>
                    </ul>
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

            <p>Interpreting, linking, and analyzing information in order to understand issues.</p>
            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th></th>
                  <th style="text-align: center; vertical-align: middle;">PROFICIENCY/MASTERY LEVEL</th>
                  <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group20[]"></td>
                  <td>
                    LEVEL 1<br>
                    Analyzes and synthesizes information
                  </td>
                  <td>
                    <ul>
                      <li>Breaks down concrete issues into parts and synthesizes succinctly.</li>
                      <li>Collects and analyses information from a variety of appropriate sources.</li>
                      <li>Identifies the links between situations and information.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group20[]"></td>
                  <td>
                    LEVEL 2<br>
                    Identifies critical relationships
                  </td>
                  <td>
                    <ul>
                      <li>Sees connections, patterns or trends in the information available.</li>
                      <li>Identifies the implications and possible consequences of trends or events.</li>
                      <li>Draws logical conclusions, providing options and recommendations.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group20[]"></td>
                  <td>
                    LEVEL 3<br>
                    Analyses complex relationships
                  </td>
                  <td>
                    <ul>
                      <li>Analyses complex situations, breaking each into its constituent parts.</li>
                      <li>Recognizes and assesses several likely causal factors or ways of interpreting the information available.</li>
                      <li>Identifies connections between situations that are not obviously related.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group20[]"></td>
                  <td>
                    LEVEL 4<br>
                    Applies broad analysis
                  </td>
                  <td>
                    <ul>
                      <li>Integrates information from diverse sources, often involving large amounts of information.</li>
                      <li>Thinks several steps ahead in deciding on best course of action, anticipating likely outcomes.</li>
                      <li>Develops and recommends policy framework based on analysis of emerging trends.</li>
                      <li>Gathers information from many sources, including experts, in order to completely understand a problem/situation.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group20[]"></td>
                  <td>
                    LEVEL 5<br>
                    Applies a systems perspective to the analysis of enterprise-wide issues
                  </td>
                  <td>
                    <ul>
                      <li>Identifies multiple relationships and disconnects in processes in order to identify options and reach conclusions.</li>
                      <li>Adopts a systems perspective, assessing and balancing vast amounts of diverse information on the varied systems and sub-systems that comprise and affect the working environment.</li>
                      <li>Thinks beyond the organization and into the future, balancing multiple perspectives when setting direction or reaching conclusions (e.g., social, economic, partner, stakeholder interests, short- and longterm benefits, national and global implications).</li>
                    </ul>
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

            <p>Focusing personal efforts on achieving results consistent with the organization’s objectives.</p>
            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th></th>
                  <th style="text-align: center; vertical-align: middle;">PROFICIENCY/MASTERY LEVEL</th>
                  <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group21[]"></td>
                  <td>
                    LEVEL 1<br>
                    Strives to meet work expectations
                  </td>
                  <td>
                    <ul>
                      <li>Sets goals and works to meet established expectations; maintains performance levels.</li>
                      <li>Pursues organizational objectives with energy and persistence. Sets high personal standards for performance.</li>
                      <li>Adapts working methods in order to achieve objectives.</li>
                      <li>Accepts ownership of and responsibility for own work.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group21[]"></td>
                  <td>
                    LEVEL 2<br>
                    Consistently meets established expectations
                  </td>
                  <td>
                    <ul>
                      <li>Consistently achieves established expectations through personal commitment.</li>
                      <li>Makes adjustments to activities/processes based on feedback.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group21[]"></td>
                  <td>
                    LEVEL 3<br>
                    Surpasses established expectations
                  </td>
                  <td>
                    <ul>
                      <li>Exceeds current expectations and pushes for improved results in own performance.</li>
                      <li>Takes on new roles and responsibilities when faced with unexpected changes.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group21[]"></td>
                  <td>
                    LEVEL 4<br>
                    Seeks out significant challenges
                  </td>
                  <td>
                    <ul>
                      <li>Seeks significant challenges outside of current job scope.</li>
                      <li>Works on new projects or assignments that add value without compromising current accountabilities.</li>
                      <li>Guides staff to achieve tasks, goals, processes and performance standards.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group21[]"></td>
                  <td>
                    LEVEL 5<br>
                    Pursues excellence on an organizational level
                  </td>
                  <td>
                    <ul>
                      <li>Models excellence and motivates fellow organizational members to follow his/her example.</li>
                      <li>Encourages constructive questioning of policies and practices; sponsors experimentation and innovation.</li>
                      <li>Holds staff accountable for achieving standards of excellence and results for the organization.</li>
                    </ul>
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

            <p>Working collaboratively with others to achieve common goals and positive results.</p>
            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th></th>
                  <th style="text-align: center; vertical-align: middle;">PROFICIENCY/MASTERY LEVEL</th>
                  <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group22[]"></td>
                  <td>
                    LEVEL 1<br>
                    Participates as a team member
                  </td>
                  <td>
                    <ul>
                      <li>Assumes personal responsibility and follows up to meet commitments to others.</li>
                      <li>Understands the goals of the team and each team member’s role within it.</li>
                      <li>Deals honestly and fairly with others, showing consideration and respect.</li>
                      <li>Willingly gives support to co-workers and works collaboratively rather than competitively.</li>
                      <li>Shares experiences, knowledge and best practices with team members.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group22[]"></td>
                  <td>
                    LEVEL 2<br>
                    Fosters teamwork
                  </td>
                  <td>
                    <ul>
                      <li>Assumes responsibility for work activities and coordinating efforts.</li>
                      <li>Promotes team goals.</li>
                      <li>Seeks others’ input and involvement and listens to their viewpoints.</li>
                      <li>Shifts priorities, changes style and responds with new approaches as needed to meet team goals.</li>
                      <li>Suggests or develops methods and means for maximizing the input and involvement of team members.</li>
                      <li>Acknowledges the work of others.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group22[]"></td>
                  <td>
                    LEVEL 3<br>
                    Demonstrates leadership in teams
                  </td>
                  <td>
                    <ul>
                      <li>Builds relationships with team members and with other work units.</li>
                      <li>Fosters team spirit and collaboration within teams .</li>
                      <li>Discusses problems/ issues with team members that could affect results.</li>
                      <li>Communicates expectations for teamwork and collaboration.</li>
                      <li>Facilitates the expression of diverse points of view to enhance teamwork.</li>
                      <li>Capitalizes on the strengths of all members.</li>
                      <li>Gives credit for success and acknowledges contributions and efforts of individuals to team effectiveness.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group22[]"></td>
                  <td>
                    LEVEL 4<br>
                    Capitalizes on teamwork opportunities
                  </td>
                  <td>
                    <ul>
                      <li>Initiates collaboration with other groups/ organizations on projects or methods of operating.</li>
                      <li>Capitalizes on opportunities and addresses challenges presented by the diversity of team talents.</li>
                      <li>Supports and encourages other team members to achieve objectives.</li>
                      <li>Encourages others to share experience, knowledge and best practices with the team.</li>
                      <li>Encourages the team to openly discuss what can be done to create a solution or alternative.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group22[]"></td>
                  <td>
                    LEVEL 5<br>
                    Builds bridges between teams
                  </td>
                  <td>
                    <ul>
                      <li>Facilitates collaboration across the organization and with other organizations to achieve a common goal.</li>
                      <li>Builds strong teams that capitalize on differences in expertise, competencies and background.</li>
                      <li>Breaks down barriers (structural, functional, cultural) between teams, facilitating the sharing of expertise and resources.</li>
                    </ul>
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

            <p>Fostering and supporting the principles and values of the organization and public service as a whole.</p>
            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th></th>
                  <th style="text-align: center; vertical-align: middle;">PROFICIENCY/MASTERY LEVEL</th>
                  <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group23[]"></td>
                  <td>
                    LEVEL 1<br>
                    Demonstrates behaviors consistent with the organization’s values
                  </td>
                  <td>
                    <ul>
                      <li>Treats others fairly and with respect.</li>
                      <li>Takes responsibility for own work, including problems and issues.</li>
                      <li>Uses applicable professional standards and established procedures, policies and/or legislation when taking action and making decisions.</li>
                      <li>Identifies ethical dilemmas and conflict of interest situations and takes action to avoid and prevent them.</li>
                      <li>Anticipates and prevents breaches in confidentiality and/or security.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group23[]"></td>
                  <td>
                    LEVEL 2<br>
                    Identifies ethical implications
                  </td>
                  <td>
                    <ul>
                      <li>Identifies and considers different ethical aspects of a situation when making decisions.</li>
                      <li>Identifies and balances competing values when selecting approaches or recommendations for dealing with a situation.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group23[]"></td>
                  <td>
                    LEVEL 3<br>
                    Aligns team with organization’s values and ethics
                  </td>
                  <td>
                    <ul>
                      <li>Fosters a climate of trust within the work team.</li>
                      <li>Implements processes and structures to deal with difficulties in confidentiality and/or security.</li>
                      <li>Ensures that decisions take into account ethics and values of the organization and Public Service as a whole.</li>
                      <li>Interacts with others fairly and objectively.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group23[]"></td>
                  <td>
                    LEVEL 4<br>
                    Promotes the organization’s values and ethics
                  </td>
                  <td>
                    <ul>
                      <li>Advises others in maintaining fair and consistent dealings with others and in dealing with ethical dilemmas.</li>
                      <li>Deals directly and constructively with lapses of integrity (e.g., intervenes in a timely fashion to remind others of the need to respect the dignity of others).</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group23[]"></td>
                  <td>
                    LEVEL 5<br>
                    Exemplifies and demonstrates the organization’s values and ethics
                  </td>
                  <td>
                    <ul>
                      <li>Defines, communicates and consistently exemplifies the organization’s values and ethics.</li>
                      <li>Ensures that standards and safeguards are in place to protect the organization’s integrity (e.g., professional standards for financial reporting, integrity/ security of information systems).</li>
                      <li>Identifies underlying issues that impact negatively on people and takes appropriate action to rectify the issues (e.g., systemic discrimination).</li>
                    </ul>
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

            <p>Developing and inspiring commitment to a vision of success; supporting, promoting and ensuring alignment with the organization’s vision and values.</p>
            <table class="w3-table w3-bordered">
              <thead>
                <tr>
                  <th></th>
                  <th style="text-align: center; vertical-align: middle;">PROFICIENCY/MASTERY LEVEL</th>
                  <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="1" class="w3-check" name="group24[]"></td>
                  <td>
                    LEVEL 1<br>
                    Demonstrates personal work alignment
                  </td>
                  <td>
                    <ul>
                      <li>Sets personal work goals in line with operational goals of work area.</li>
                      <li>Continually evaluates personal progress and actions to ensure alignment with organizational vision and operational goals.</li>
                      <li>Liaises with others to ensure alignment with the business goals and vision of the organization.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="2" class="w3-check" name="group24[]"></td>
                  <td>
                    LEVEL 2<br>
                    Promotes team alignment
                  </td>
                  <td>
                    <ul>
                      <li>Effectively communicates and interprets the strategic vision to employees within area of responsibility.</li>
                      <li>Clearly articulates and promotes the significance and impact of employee contributions to promoting and achieving organizational goals.</li>
                      <li>Monitors work of team to ensure alignment with strategic direction, vision and values for the organization.</li>
                      <li>Identifies potential future directions for work area in line with vision.</li>
                      <li>Proactively helps others to understand the importance of the strategy and vision.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="3" class="w3-check" name="group24[]"></td>
                  <td>
                    LEVEL 3<br>
                    Aligns program/operational goals and plans
                  </td>
                  <td>
                    <ul>
                      <li>Works with teams to set program/operational goals and plans in keeping with the strategic direction.</li>
                      <li>Regularly promotes the organization, its vision and values to clients, stakeholders and partners.</li>
                      <li>Works with staff to set strategic goals for own sector of the organization.</li>
                      <li>Assesses the gap between the current state and desired future direction and establishes effective ways for closing the gap in own sector.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="4" class="w3-check" name="group24[]"></td>
                  <td>
                    LEVEL 4<br>
                    Influences strategic direction
                  </td>
                  <td>
                    <ul>
                      <li>Foresees obstacles and opportunities for the organization and acts accordingly.</li>
                      <li>Defines issues, generates options and selects solutions, which are consistent with the strategy and vision.</li>
                      <li>Scans, seeks out and assesses information on potential future directions.</li>
                      <li>Provides direction and communicates the vision to encourage alignment within the organization.</li>
                      <li>Energetically and persistently promotes strategic objectives with colleagues in other business lines.</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="width: 100px; text-align: center;"><input type="checkbox" value="5" class="w3-check" name="group24[]"></td>
                  <td>
                    LEVEL 5<br>
                    Develops vision
                  </td>
                  <td>
                    <ul>
                      <li>Leads the development of the vision for the organization.</li>
                      <li>Defines and continuously articulates the vision and strategy in the context of wider government priorities.</li>
                      <li>Describes the vision and values in compelling terms to develop understanding and promote acceptance/ commitment among staff and stakeholders.</li>
                      <li>Identifies, conceptualizes and synthesizes new trends or connections between organizational issues and translates them into priorities for the organization.</li>
                    </ul>
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