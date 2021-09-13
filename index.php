<?php
$title = "Home";
require 'header.php';

require_once "libs/Auth.php";
$auth = new Auth;
// echo json_encode($auth->is_hr);
if ($auth->is_hr) {
	// header("location: employeeinfo.v2.php?employees_id=".$auth->employee_id);
	// die();
//   }
?>

<style type="text/css">
	.item {
		color: black !important;
	}

	.item:hover {
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
										<a class="item" href="rnrplan.php">R&R Plan (Yearly)</a>
										<a class="item" href="rnr_system_review.php">System Review</a>
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
				<div style="width: 360px; height: 300px; background-color: green; margin-bottom: 5px;">
					<div class="ui move up reveal">
						<div class="visible content" style="height: 300px; width: 360px;">
							<!-- <p style="padding: 20px;">RECRUITMENT, SELECTION, AND PLACEMENT</p> -->
							<img src="assets/images/rsp-cover.png" style="height: 300px; width: 410px;">
						</div>
						<div class="hidden content">
							<div class="ui green segment" style="height: 300px; width: 360px;">
								<div class="content" style="color: green; font-weight: bold; font-style: italic;">
									RECRUITMENT, SELECTION, AND PLACEMENT (RSP)
								</div>
								<hr>
								<div class="content">
									<div class="ui animated list">
										<a class="item" href="plantilla.php">Plantilla (Permanent)</a>
										<a class="item" href="plantilla_vacantpos.php">Publications</a>
										<a class="item" href="comparativeData.php">Comparative Data</a>
										<a class="item" href="indTurnAroundTime.php">Individual Turn Around Time</a>
										<a class="item" href="">System of Ranking Position</a>
										<a class="item" href="">Staffing Plan</a>
										<!-- <a class="item" href="">Turn Around</a> -->
										<!-- <a class="item" href="personnelCompetenciesSurveyEncoder.php">Personnel Competency Encode</a>
										<a class="item" target="_blank" href="personnelCompetenciesSurvey.php">Personnel Competency Form</a>
										<a class="item" href="personnelCompetenciesReport.php">Personnel Competency Report</a> -->

										<div class="dropdown item">
											<a class="item">Personnel Competency <i class="caret down icon"></i></a>
											<div class="dropdown-content">
												<div class="ui animated list">
													<a class="item" href="personnelCompetenciesSurveyEncoder.php">- Encoder's Tool</a>
													<a class="item" target="_blank" href="personnelCompetenciesSurvey.php">- Survey Form</a>
													<a class="item" href="personnelCompetenciesReport.php">- Summary Report</a>
												</div>
											</div>
										</div>

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
										<a class="item" href="spmsFeedback_main.php">Feedback and Monitoring Report</a>
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
										<a class="item" href="supervisor_assessment_reports.php">Supervisor Assessment Reports</a>
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
<style>
	.dropdown {
		position: relative;
		display: inline-block;
	}

	.dropdown-content {
		display: none;
		position: absolute;
		/* background-color: #f9f9f9; */
		min-width: 360px;
		/* box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2); */
		/* padding: 12px 16px; */
		z-index: 1;
	}

	.dropdown:hover .dropdown-content {
		display: block;
	}
</style>

<?php
}
require "footer.php";
?>