<?php
	// Initialize the session
	// session_start();

	// // Check if the user is logged in, if not then redirect him to login page
	// if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	//   header("location: login.php");
	//   exit;
	// }
	$title = "Home";

?>
<!-- <!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	 <meta charset="UTF-8" name="google" value="notranslate" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	 <meta name="viewport" content="width=device-width, initial-scale=1">
	 <link rel="stylesheet" type="text/css" href="ui/dist/semantic.css">
	 <script src="jquery/jquery-3.3.1.min.js"></script>
	 <script src="ui/dist/semantic.min.js"></script>
</head>
<body> -->
<?php
	require 'header.php';
	// require "navbar.php";
?>


<style type="text/css">
	.item {
		color: black !important;
	}
	.item:hover{
		color: green !important;
	}
</style>
<div class="ui container centered aligned">
	<div class="ui middle aligned four column centered grid">
		<div class="row">
			<div class="five wide column" style="padding: 0px; margin: 5px;">
				<!-- REWARDS AND RECOGNITION START -->
				<div style="width: 360px; height: 250px; background-color: green;">
			<div class="ui move up reveal" style="width: 360px;">
				<div class="visible content" style="height: 250px; width: 360px;">
					<!-- <p style="padding: 20px;">REWARDS AND RECOGNITION</p> -->
					<img src="assets/images/r&r-cover.png" style="height: 250px; width: 360px;">
				</div>
				<div class="hidden content">
					<div class="ui green segment" style="height: 250px; width: 360px;">
						<div class="content" style="color: green; font-weight: bold; font-style: italic;">
							REWARDS AND RECOGNITION (R&R)
						</div>
						<hr>
						<div class="content">
							<div class="ui animated list">
					<a class="item" href="personnelrecognition.php">Personnel Recognition</a>
          			<a class="item" href="">R&R Plan (Yearly)</a>
          			<a class="item" href="">System Review</a>
          			<a class="item" href="">Search for Outstanding Employees</a>
							</div>
						</div>
					</div>
				</div>
			</div>
				</div>
				<!-- REWARDS AND RECOGNITION END -->
			</div>
			<div class="five wide column" style="padding: 0px; margin: 0px;">
				<!-- RECRUITMENT, SELECTION AND PLANNING START -->
				<div style="width: 360px; height: 250px; background-color: green; margin-bottom: 5px;">
			<div class="ui move up reveal">
				<div class="visible content" style="height: 250px; width: 360px;">
					<!-- <p style="padding: 20px;">RECRUITMENT, SELECTION, AND PLACEMENT</p> -->
					<img src="assets/images/rsp-cover.png" style="height: 250px; width: 360px;">
				</div>
				<div class="hidden content">
					<div class="ui green segment" style="height: 250px; width: 360px;">
						<div class="content" style="color: green; font-weight: bold; font-style: italic;">
							RECRUITMENT, SELECTION, AND PLACEMENT (RSP)
						</div>
						<hr>
						<div class="content">
							<div class="ui animated list">
								<!-- <a class="item" href="comparativedata.php">Comparative Assessment</a> -->
						<!-- 		<a class="item" href="vacantpositionsetup.php">Setup Vacant Positions</a> -->
								<!-- <a class="item" href="applicantsProfile.php">Applicants' Profile</a> -->
								<a class="item" href="comparativeData.php">Comparative Data</a>
								<a class="item" href="indTurnAroundTime.php">Individual Turn Around Time</a>
								<a class="item" href="">System of Ranking Position</a>
								<a class="item" href="">Staffing Plan</a>
								<a class="item" href="">Turn Around</a>
								<a class="item" href="personnelCompetenciesSurveyEncoder.php">Personnel Competency Encode</a>
								<a class="item" target="_blank" href="personnelCompetenciesSurvey.php">Personnel Competency Form</a>
								<a class="item" href="personnelCompetenciesReport.php">Personnel Competency Report</a>
							</div>
						</div>
					</div>
				</div>
			</div>
				</div>
				<!-- RECRUITMENT, SELECTION AND PLANNING END -->
				<!-- PERFORMANCE MANAGEMENT SYSTEM START -->
				<div style="width: 360px; height: 250px; background-color: green;">
			<div class="ui move up reveal">
				<div class="visible content" style="height: 250px; width: 360px;">
					<!-- <p style="padding: 20px;">STRATEGIC PERFORMANCE MANAGEMENT SYSTEM</p> -->
					<img src="assets/images/pms-cover.png" style="height: 250px; width: 360px;">
				</div>
				<div class="hidden content">
					<div class="ui green segment" style="height: 250px; width: 360px;">
						<div class="content" style="color: green; font-weight: bold; font-style: italic;">
							STRATEGIC PERFORMANCE MANAGEMENT SYSTEM (SPMS)
						</div>
						<hr>
						<div class="content">
							<div class="ui animated list">
          			<a class="item" href="performanceratingreport.php">Performance Rating Report</a>
          			<a class="item" href="cmr.php">Coaching and Mentoring Report</a>
          			<a class="item" href="spmsFeedback.php">Feedback Mechanism Report</a>
          			<a class="item" href="tot.php">Turn Around Time</a>
          			<a class="item" href="cdp.php">Summary of Comments for Development Intervention</a>
							</div>
						</div>
					</div>
				</div>
			</div>
				</div>
				<!-- PERFORMANCE MANAGEMENT SYSTEM END -->
			</div>
			<div class="five wide column" style="padding: 0px; margin: 5px;">
				<!-- LEARNING AND DEVELOPMENT START -->
				<div style="width: 360px; height: 250px; background-color: green;">
			<div class="ui move up reveal" style="width: 360px;">
				<div class="visible content" style="height: 250px; width: 360px;">
					<!-- <p style="padding: 20px;">LEARNING AND DEVELOPMENT</p> -->
					<img src="assets/images/l&d-cover.png" style="height: 250px; width: 360px;">
				</div>
				<div class="hidden content">
					<div class="ui green segment" style="height: 250px; width: 360px;">
						<div class="content" style="color: green; font-weight: bold; font-style: italic;">
							LEARNING AND DEVELOPMENT (L&D)
						</div>
						<hr>
						<div class="content">
							<div class="ui animated list">
          			<a class="item" href="reqsandcoms.php">Training/Seminar Invitation/Communication</a>
          			<a class="item" href="personneltrainings.php">Training Schedule/Evaluation</a>
          			<a class="item" href="ldprofile.php">L&D Profile</a>
          			<a class="item" href="ldplan.php">L&D Plan</a>
          			<a class="item" href="ldactivities.php">L&D Activities</a>
          			<!-- <a class="item" href="tna.php">L&D Training Needs Assessment</a> -->
					  <a class="item" href="dna.php">Development Needs Assessment</a>
          			<a class="item" href="trainingreport.php">Training Report</a>
          			<a class="item" href="">Talent Assessment Report</a>
          			<!-- <a class="item" href="">System Review</a> -->
							</div>
						</div>
					</div>
				</div>
			</div>
				</div>
				<!-- LEARNING AND DEVELOPMENT END -->
			</div>
		</div>
	</div>
</div>

<?php
	require "footer.php";
?>