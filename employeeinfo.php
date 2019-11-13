<?php
$employees_id = $_GET["employees_id"];
require_once "_connect.db.php";

$sql = "SELECT * FROM `employees` WHERE `employees_id` = '$employees_id'";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$lastName = $row["lastName"];
$firstName = $row["firstName"];
$middleName = $row["middleName"];
$extName = $row["extName"];

$title = $lastName.", ".$firstName." $middleName"." ".$extName;

require_once "header.php";

require_once "employeeinfo_proc.php";


if (isset($_GET["spms"])) {
?>
<script type="text/javascript">
	$(document).ready(function() {
		$("#rsp").removeClass('active');
	$("#rsp0").removeClass('active');
	$("#spms").addClass('active');
	$("#spms0").addClass('active');
	$("#spms01").removeClass('active');
	$("#spms02").addClass('active');
	});
</script>
<?php
}


?>
<!-- <script src="employeeinfo.js"></script> -->
<script type="text/javascript">
	$(document).ready(function() {
		$(load);
		$("#editStat_drop").dropdown();
		$("#genderModal").dropdown();
		$("#natureOfAssignmentModal").dropdown();
		$("#departmentModal").dropdown();
		$("#positionModal").dropdown({
			fullTextSearch: true,
		});
		$('#context1 .menu .item').tab({
		    context: $('#context1')
		  })
	});
	function editModalFunc(){
		$("#editModal").modal({
			onDeny: function(){
    			$(load);
			},
				onApprove : function() {
				$(update);
				// save msg animation start
	      $("#saveMsg").transition({
	      	animation: 'fly down',
	      	onComplete: function () {
	      		setTimeout(function(){ $("#saveMsg").transition('fly down'); }, 1000);
	      	}
	      });
	      // save msg animation end
	    }
		}).modal("show");
	}

	function load(){
		$.post('employeeinfo_proc.php', {
			loadProfile: true,
			employees_id: <?php echo $employees_id;?>
		}, function(data, textStatus, xhr) {
			var array = jQuery.parseJSON(data);
			// alert(array.employees_id);
			$("#employeeName").html(array.fullname);
			$("#firstNameModal").val(array.firstName);
			$("#middleNameModal").val(array.middleName);
			$("#lastNameModal").val(array.lastName);
			$("#extNameModal").val(array.extName);
			$("#genderModal").val(array.gender).change();
			$("#employees_idModal").val(array.employees_id);
			$("#editStat_drop").dropdown("set selected",array.status);
			$("#editStat_date").val(array.statusDate);
			$("#editStat_dateIPCR").val(array.dateIPCR);
			$("#employmentStatusModal").dropdown("set selected",array.employmentStatus);
			$("#natureOfAssignmentModal").val(array.natureOfAssignment).change();
			$("#departmentModal").val(array.department_id).change();
			$("#positionModal").val(array.position_id).change();
			$("#categoryModal").val(array.category);
			$("#levelModal").val(array.level);
			$("#salaryGradeModal").val(array.salaryGrade);

		// for table start
			$("#status").html(array.status);
			$("#statusDate").html(array.statusDateStr);
			$("#dateIPCRView").html(array.dateIPCRView);
			$("#employees_idView").html(array.employees_id_padded);
			$("#departmentView").html(array.department);
			$("#levelView").html(array.level);
			$("#genderView").html(array.gender);
			$("#positionView").html(array.position);
			$("#categoryView").html(array.category);
			$("#employmentStatusView").html(array.employmentStatus);
			$("#natureOfAssignmentView").html(array.natureOfAssignment);
			$("#salaryGradeView").html(array.salaryGrade);
		// for table end
		});
	}

	function update(){
		$.post('employeeinfo_proc.php', {
			update: true,
			employees_id: <?php echo $employees_id;?>,
			firstName: $("#firstNameModal").val(),
			middleName: $("#middleNameModal").val(),
			lastName: $("#lastNameModal").val(),
			extName: $("#extNameModal").val(),
			status: $("#editStat_drop").dropdown("get value"),
			statusDate: $("#editStat_date").val(),
			dateIPCR: $("#editStat_dateIPCR").val(),
			gender: $("#genderModal").val(),
			employmentStatus: $("#employmentStatusModal").dropdown("get value"),
			natureOfAssignment: $("#natureOfAssignmentModal").val(),
			department_id: $("#departmentModal").val(),
			position_id: $("#positionModal").val()
		}, function(data, textStatus, xhr) {
			/*optional stuff to do after success */
			$(load);
		});

	}
</script>
<div id="saveMsg" class="" style="top: 15px; display: none; position: fixed; z-index: 10; width: 100%; left: 0; text-align: center;">
	<div class="ui center green inverted aligned segment" style="width: 100px; margin-left: auto; margin-right: auto;">
		<i class="checkmark icon"></i> Saved!
	</div>
</div>
<!-- custom sidebar start -->
<div id="editModal" class="ui modal">
<!-- <i class="close icon"></i> -->
  <div class="header">
    Edit Personnel Profile
  </div>
  <div class="image content">
<form class="ui form">
  <div class="field">
    <label>Name:</label>
    <div class="four fields">
      <div class="five wide field">
        <input id="firstNameModal" type="text" placeholder="First Name">
      </div>
      <div class="five wide field">
        <input id="middleNameModal" type="text" placeholder="Middle Name">
      </div>
      <div class="five wide field">
        <input id="lastNameModal" type="text" placeholder="Last Name">
      </div>
      <div class="three wide field">
        <input id="extNameModal" type="text" placeholder="ext.">
      </div>
    </div>
  </div>
  <div class="fields">
  	<div class="three wide field">
		<label>Status:</label>
		<div class="ui selection dropdown compact" id="editStat_drop">
		  <input type="hidden" name="status">
		  <i class="dropdown icon"></i>
		  <div class="default text">Active/Inactive</div>
		  <div class="menu">
		    <div class="item" data-value="ACTIVE">Active</div>
		    <div class="item" data-value="INACTIVE">Inactive</div>
		  </div>
		</div>
  	</div>
  	<div class="four wide field">
  		<label>Date Active/Inactive:</label>
  		<input type="date" name="" id="editStat_date">
  	</div>
  	<div class="four wide field">
  		<label>IPCR Starts/Started In:</label>
  		<input type="date" name="" id="editStat_dateIPCR">
  	</div>
  </div>
  <div class="fields">
   <div class="four wide field">
     <label>Gender:</label>
     <select id="genderModal" class="ui fluid dropdown genderModal">
		<option value="">Gender</option>
      	<option value="MALE">MALE</option>
   		<option value="FEMALE">FEMALE</option>
     </select>
   </div>
   <div class="three wide field">
   		<label>ID No.</label>
    	<input id="employees_idModal" type="text" name="employees_id" readonly="">
  	</div>
   	<div class="four wide field">
   		<label>Status:</label>
    	<select id="employmentStatusModal" class="ui fluid dropdown">
    		<option value="">Select Status</option>
    		<option value="CASUAL">CASUAL</option>
    		<option value="PERMANENT">PERMANENT</option>
    		<option value="ELECTIVE">ELECTIVE</option>
    		<option value="COTERMINUS">COTERMINUS</option>
    	</select>

  	</div>
  	<div class="six wide field">
   		<label>Nature of Assignemt:</label>
    	<select id="natureOfAssignmentModal" class="ui fluid dropdown natureOfAssignmentModal">
    		<option value="">Select Rank</option>
      		<option value="RANK & FILE">RANK AND FILE</option>
   			<option value="SUPERVISORY">SUPERVISORY</option>
     	</select>
  	</div>
  </div>
  <div class="fields">
   	<div class="sixteen wide field">
   		<label>Department:</label>
				<select id="departmentModal">
				<?php $resultDepts = $mysqli->query("SELECT * FROM `department` ORDER BY `department` ASC");
				while ($resultsDeptsArray=mysqli_fetch_array($resultDepts)) {
					print "<option value=\"{$resultsDeptsArray['department_id']}\">{$resultsDeptsArray['department']}</option>";
						}
					?>
				</select>
  	</div>
  </div>

<div class="fields">
	<div class="sixteen wide field">
   		<label>Position:</label>
			<select id="positionModal" class="ui search normal">
				<?php $result = $mysqli->query("SELECT * FROM `positiontitles` ORDER BY `position` ASC");
				while ($row= $result->fetch_assoc()){
							$position_id = $row["position_id"];
							$position = $row["position"];
							if ($row["functional"] == "") {
								$functional = $row["functional"];
							} else {
								$functional = " - ".$row["functional"];
							}
							print "<option value=\"{$position_id}\">$position $functional</option>";
						}
					?>
			</select>
  </div>
</div>
</form>
  </div>
  <div class="actions">
    <div class="ui mini deny button">
      Cancel
    </div>
    <div class="ui mini approve blue right labeled icon button">
      Save
      <i class="checkmark icon"></i>
    </div>
  </div>
</div>

<div class="ui container" style="min-height: 600px;">
	<div class="ui borderless blue inverted mini menu">
    <div class="left item" style="margin-right: 0px !important;">
      <!-- <a href="employeelist.php?scrollTo=<?php echo $employees_id;?>" class="blue ui icon button" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </a> -->
      <button onclick="window.history.back(); console.log(window.history);" class="blue ui icon button" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
      
    </div>
		<div class="item">
			<h3 style="color: white;"><i class="user circle icon"></i> <i id="employeeName"></i></h3>
		</div>
		<div class="right item">
			<button onclick="editModalFunc()" class="ui right floated blue button" style="padding: 10px 10px; font-size: 10px;"><i class="ui icon edit"></i> Edit</button>
		</div>
	</div>

	<div class="ui container">
<style type="text/css">
	.actives{
		background-color: #f2f2f2;
		color: #4075a9;
	}
	.ui.tab.segment{
		min-height: 300px;
	}
</style>
		<table class="ui very compact small celled table" style="font-size: 12px;">
			<tr>
				<td class="actives">STATUS:</td>
				<td id="status"></td>
				<td class="actives">SINCE:</td>
				<td id="statusDate"></td>
				<td class="actives">IPCR STARTS/STARTED IN:</td>
				<td id="dateIPCRView"></td>
			</tr>
			<tr>
				<td class="actives">ID:</td>
				<td id="employees_idView"></td>
				<td class="actives">DEPARTMENT:</td>
				<td id="departmentView"></td>
				<td class="actives">LEVEL:</td>
				<td id="levelView"></td>
			</tr>
			<tr>
				<td class="actives">GENDER:</td>
				<td id="genderView"></td>
				<td class="actives">POSITION:</td>
				<td id="positionView"></td>
				<td class="actives">CATEGORY:</td>
				<td id="categoryView"></td>
			</tr>
			<tr>
				<td class="actives">STATUS:</td>
				<td id="employmentStatusView"></td>
				<td class="actives">NATURE OF ASSIGNMENT:</td>
				<td id="natureOfAssignmentView"></td>
				<td class="actives">SALARY GRADE:</td>
				<td id="salaryGradeView"></td>
			</tr>
		</table>
	</div>


<div class="ui segment">
	<div class="ui grid">
	  <div class="eight wide column">
		<!-- <div class="ui container" style="width: 100%; margin-right: auto; margin-left: auto;"> -->
			<!-- <h5 class="ui blue header centered ">Job Competency Profile</h5> -->
			<canvas id="comptChart" height="210"></canvas>
		<!-- </div> -->
	  </div>
	  <div class="eight wide column">
<!-- 	  	            <div class="ui container" style="margin-right: auto; margin-left: auto;"> -->
               <canvas id="ldnLsaChart" height="210"></canvas>
            <!-- </div> -->
	  </div>
	</div>
</div>

<div class="ui basic segment" style="min-height: 500px;">

<div id="context1">
  <div class="ui top attached pointing blue inverted menu">
    <a id="rsp" class="item active" data-tab="first">Recruitment, Selection, and Placement<br>(RSP)</a>
    <a class="item" data-tab="second">Learning and Development<br>(L&D)</a>
    <a id="spms" class="item" data-tab="third">Strategic Performance Management System<br>(SPMS)</a>
    <a class="item" data-tab="fourth">Rewards and Recognition<br>(R&R)</a>
  </div>
  <div id="rsp0" class="ui bottom attached tab segment active" data-tab="first">
    <div class="ui pointing secondary blue menu">
      <a class="active item" data-tab="first/a">Competency Profile</a>
      <a class="item" data-tab="first/b">Learning Style</a>
<!--       <a class="item" data-tab="first/b">1B</a>
      <a class="item" data-tab="first/c">1C</a> -->
    </div>
    <div class="ui active tab segment" data-tab="first/a">
<?php
    require_once "_connect.db.php";
    $employees_id = $_GET["employees_id"];
    $sql = "SELECT * FROM `competency` WHERE `employees_id` = '$employees_id'";
    $result = $mysqli->query($sql);

    if ($result->num_rows != 0) {

			$row = $result->fetch_array(MYSQLI_NUM);
			$comptScores = array();

			for ($i=3; $i < 27; $i++) {
				array_push($comptScores, $row[$i]);
			}

			$serializedComptScore = serialize($comptScores);

    } else {
    	$serializedComptScore = null;
    }

    if (empty($serializedComptScore)) {
?>
<div style="text-align: center;">
    <p style="padding: 20px; background-color: lightgrey; color: white;">Personnel has not yet taken the survey.</p>
</div>
<?php
}
	// } else {
			require "employeeinfo_competencyProfile.php";
	// }
?>
    </div>
<div class="ui tab segment" data-tab="first/b">
	
	<?php
		
		$employees_id = $_GET["employees_id"];
		$sql = "SELECT * FROM `ldn_lsa` WHERE `employees_id` = '$employees_id'";
		$result = $mysqli->query($sql);
		$lsa_rows = $result->num_rows;
		 if (!$lsa_rows) {
		 	# code...
		?>
			<div style="text-align: center;">
		    	<p style="padding: 20px; background-color: lightgrey; color: white;">Personnel has not yet taken the survey.</p>
			</div>
		<?php
			$activist = 0;
		 	$reflector = 0;
		 	$theorist = 0;
		 	$pragmatist = 0;
			


		 } else {

		 	$row = $result->fetch_assoc();
		 	$activist = $row['activist'];
		 	$reflector = $row['reflector'];
		 	$theorist = $row['theorist'];
		 	$pragmatist = $row['pragmatist'];
		 	$date_surveyed = $row['date_surveyed'];
		 }
		 require_once "employeeinfo_ldn_lsa.php";
	?>

</div>


<!--     <div class="ui tab segment" data-tab="first/b">1B</div>
    <div class="ui tab segment" data-tab="first/c">1C</div> -->
  </div>
  <div class="ui bottom attached tab segment" data-tab="second">
    <div class="ui pointing secondary blue menu">
      <a class="item active" data-tab="second/a">Trainings Attended</a>
<!--       <a class="item" data-tab="second/b">2B</a>
      <a class="item" data-tab="second/c">2C</a> -->
    </div>
    <div class="ui tab segment active" data-tab="second/a">
    	<?php
    		require_once "employeeinfo_trainingsAttended.php";
    	?>
    </div>
    <!-- <div class="ui  tab segment" data-tab="second/b">2B</div>
    <div class="ui tab segment" data-tab="second/c">2C</div> -->
  </div>
  <div id="spms0" class="ui bottom attached tab segment" data-tab="third">
    <div class="ui pointing secondary blue menu">
      <a id="spms01" class="item active" data-tab="third/a">Individual Development Plan</a>
      <a id="spms02" class="item" data-tab="third/b">IPCR(Recommendation Portion)</a>
      <a class="item" data-tab="third/c">Coaching and Mentoring</a>
      <a class="item" data-tab="third/d">Feedback Mechanism</a>
    </div>
    <div class="ui tab segment active" data-tab="third/a">
    	Individual Development Plan will be implemented here...
    </div>
    <div class="ui tab segment" data-tab="third/b">
			<?php
			// for IPCR (Reccomendation Portion)
				require_once "umbra/IDP/idpTable.php";
			 ?>
    </div>
    <div class="ui tab segment" data-tab="third/c">
    	<!-- Coaching and Mentoring will be implemented here... -->
			<?php
				require_once "umbra/cmr/empCrmInfo.php";
			 ?>
    </div>
    <div class="ui tab segment" data-tab="third/d">
    	Feedback Mechanism will be implemented here...
    </div>
  </div>
  <div class="ui bottom attached tab segment" data-tab="fourth">
    <div class="ui pointing secondary blue menu">
      <a class="item active" data-tab="fourth/a">4A</a>
      <a class="item" data-tab="fourth/b">4B</a>
      <a class="item" data-tab="fourth/c">4C</a>
    </div>
    <div class="ui tab segment active" data-tab="fourth/a">4A</div>
    <div class="ui tab segment" data-tab="fourth/b">4B</div>
    <div class="ui tab segment" data-tab="fourth/c">4C</div>
  </div>
</div>

	</div>
</div>

<?php require_once "footer.php";?>
