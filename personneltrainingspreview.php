<?php $title = "Personnel Training";
require_once "header.php";
$personneltrainings_id = $_GET["personneltrainings_id"];
// $start = $_GET["start"];
?>
<script type="text/javascript">
	var array = [],
		editQueries = [];

	jQuery(document).ready(function($) {
		$(load);
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

		$("#clearBtnEdit").click(function(event) {
			$("#inputTrainingEdit").val("");
		});
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
	});

	function loadListAdded() {
		$(".listAdded").load('personneltrainingspreview_proc.php', {
				loadListAdded: true,
				personneltrainings_id: <?php echo $personneltrainings_id; ?>
			},
			function() {
				/* Stuff to do after the page is loaded */
			});
	}

	function loadListToAdd() {
		$(".listToAdd").load('personneltrainingspreview_proc.php', {
				loadListToAdd: true,
				personneltrainings_id: <?php echo $personneltrainings_id; ?>
			},
			function() {
				/* Stuff to do after the page is loaded */
			});
	}

	function loadPersonnelList() {
		$("#personnelList").load('personneltrainingspreview_proc.php', {
				loadPersonnelList: true,
				personneltrainings_id: <?php echo $personneltrainings_id; ?>
			},
			function() {
				/* Stuff to do after the page is loaded */
			});

	}

	function removeFromList(employees_id) {
		editQueries.push("DELETE FROM `personneltrainingslist` WHERE `employees_id`='" + employees_id + "' AND `personneltrainings_id` = '" + <?php echo $personneltrainings_id; ?> + "'");
		$(".listToAdd").prepend($('#' + employees_id));
		$('#' + employees_id + " button").attr('onclick', "addToList('" + employees_id + "')");
		$('#' + employees_id + " button i").removeClass('times');
		$('#' + employees_id + " button i").addClass('add');
	}

	function addToList(employees_id) {
		editQueries.push("INSERT INTO `personneltrainingslist` (`dateAdded`, `personneltrainings_id`, `employees_id`) VALUES ('<?php echo date('Y-m-d H:m:s'); ?>','" + <?php echo $personneltrainings_id; ?> + "','" + employees_id + "')");
		$(".listAdded").prepend($('#' + employees_id));
		$('#' + employees_id + " button").attr('onclick', 'removeFromList(' + employees_id + ')');
		$('#' + employees_id + " button i").removeClass('add');
		$('#' + employees_id + " button i").addClass('times');
	}

	function load() {
		$.post('personneltrainingspreview_proc.php', {
			load: true,
			personneltrainings_id: <?php echo $personneltrainings_id; ?>
		}, function(data) {
			array = jQuery.parseJSON(data);
			$("#trainingTitle").html(array.training);
			$("#startDate").html(array.startDateFormatted);
			$("#endDate").html(array.endDateFormatted);

			$("#timeDated").html(array.timeStartFormatted + " to " + array.timeEndFormatted);

			$("#numHours").html(array.numHours);
			$("#venue").html(array.venue);
			$("#remarks").html(array.remarks);
			$("#inputTrainingEdit").val(array.training);
			$("#inputDate1Edit").val(array.startDate);
			$("#inputDate2Edit").val(array.endDate);

			$("#inputTime1_edit").val(array.timeStart);
			$("#inputTime2_edit").val(array.timeEnd);

			$("#inputHrsEdit").val(array.numHours);
			$("#inputVenueEdit").val(array.venue);
			$("#inputRemarksEdit").val(array.remarks);

			$(loadListAdded);
			$(loadListToAdd);
			$(loadPersonnelList);
			$(loadAssess);
		});
	}

	function loadAssess() {
		$.post('personneltrainingspreview_proc.php', {
			loadAssess: true,
			personneltrainings_id: <?php echo $personneltrainings_id; ?>,

		}, function(data, textStatus, xhr) {
			/*optional stuff to do after success */
			$("#assContainer").html(data);
		});
	}

	function editFunc() {
		$("#editModal").modal({
			closable: false,
			onDeny: function() {
				// time1 = $("#inputTime1_edit").val();
				// time2 = $("#inputTime2_edit").val();
				// startTime = new Date(time1).getHours();
				// endTime = new Date(time2).getHours();
				// timeTotal = endTime - startTime;

				// alert(timeTotal);
			},
			onApprove:
				// function(){
				// 	alert(editQueries);
				// 	editQueries = [];
				// }
				function() {
					$.post('personneltrainingspreview_proc.php', {
						edit: true,
						personneltrainings_id: <?php echo $personneltrainings_id; ?>,
						training: $("#inputTrainingEdit").val(),
						startDate: $("#inputDate1Edit").val(),
						endDate: $("#inputDate2Edit").val(),
						numHours: $("#inputHrsEdit").val(),
						venue: $("#inputVenueEdit").val(),
						remarks: $("#inputRemarksEdit").val(),
						timeStart: $("#inputTime1_edit").val(),
						timeEnd: $("#inputTime2_edit").val(),
						editQueries: editQueries,
					}, function(data, textStatus, xhr) {
						// alert(data);
						$(load);
						// 	alert(editQueries);
						editQueries = [];
					});
				}
		}).modal("show");
	}

	function deleteFunc() {
		$("#deleteModal").modal({
			onApprove: function() {
				$.post('personneltrainings_proc.php', {
					deleteTraining: true,
					personneltrainings_id: <?= $personneltrainings_id ?>
				}, function(data, textStatus, xhr) {
					// window.location.replace("personnelTrainings.php?deleteSuccess");
					window.location.replace("personnelTrainings.php");
					// $(load(""));
				});
			}
		}).modal("show");
		// $(deleteMsg);
	}
	// get num of hours start
	function date_diff_indays(date1, date2) {
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

	function editAssFunc(id, assessment_index) {

		// $("#teaxtAreaAss").load('personneltrainingspreview_proc.php',{
		// 		getAssessmentText: true,
		// 		personneltrainingseval_id: id,
		// 		assessment_: assessment_index,
		// 	} ,
		// 	function(){

		// });

		$.post('personneltrainingspreview_proc.php', {
			getAssessmentText: true,
			personneltrainingseval_id: id,
			assessment_: assessment_index,
		}, function(data, textStatus, xhr) {
			/*optional stuff to do after success */
			$("#teaxtAreaAss").val(data);
		});

		$("#editAssModal").modal({
			onApprove: function() {
				$.post('personneltrainingspreview_proc.php', {
					editAss: true,
					personneltrainingseval_id: id,
					assessment_: assessment_index,
					assessment_text: $("#teaxtAreaAss").val()
				}, function(data, textStatus, xhr) {
					$(load);
				});
			},
		}).modal("show");
	}
</script>
<!-- delete training start -->
<div id="deleteModal" class="ui mini modal">
	<i class="close icon"></i>
	<div class="header">
		Delete Training
	</div>
	<div class="content">
		<p>Are you sure you want to delete this training entry?</p>
	</div>
	<div class="actions">
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

<!-- edit assessment start -->
<div id="editAssModal" class="ui small modal">
	<div class="header">
		Edit Assessment
	</div>
	<div class="content">
		<textarea id="teaxtAreaAss" rows="10" style="width: 100%;"></textarea>
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
<!-- edit assessment end -->


<!-- edit training start -->
<div id="editModal" class="ui large modal">
	<div class="header">
		Edit Training
	</div>
	<div class="content">
		<div class="ui grid">
			<div class="three column row">
				<div class="eight wide column" style="font-size: 14px;">
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
<!-- edit training end -->
<div class="ui container noBorderPrint">
	<div class="ui borderless blue inverted mini menu">
		<div class="left item" style="margin-right: 0px !important;">
			<a href="personneltrainings.php" class="blue ui icon button noprint" title="Back" style="width: 65px;">
				<i class="icon chevron left"></i> Back
			</a>
		</div>
		<div class="item">
			<h1><i class="certificate icon"></i><i id="trainingTitle"></i></h1>
		</div>
		<div class="right item noprint">
			<button onclick="editFunc()" class="blue ui icon button" title="Edit Training" style="margin-right: 5px;">
				<i class="icon edit outline"></i> Edit
			</button>
			<button onclick="print()" class="blue ui icon button" title="Print" style="margin-right: 5px;">
				<i class="icon print"></i> Print
			</button>
			<button onclick="deleteFunc()" class="blue ui icon button" title="Delete" style="margin-right: 5px;">
				<i class="icon trash"></i> Delete
			</button>
			<!-- 			<a class="ui blue icon button" title="Evaluation Report" style="margin-right: 5px;">
				<i class="icon chart bar"></i> Evaluation Report
			</a> -->
		</div>
	</div>
	<div class="ui container">
		<div class="ui segment blue">
			<!-- <label><b>Start Date:</b></label>&nbsp; <i id="startDate"></i><br>
			<label><b>End Date:</b></label>&nbsp; <i id="endDate"></i><br>
			<label><b>Time:</b></label>&nbsp; <i id="timeDated"></i><br>
			<label><b>Number of Hours:</b></label>&nbsp; <i id="numHours"></i><br>
			<label><b>Venue:</b></label>&nbsp; <i id="venue"></i><br>
			<label><b>Remarks:</b></label>&nbsp; <i id="remarks"></i><br> -->

			<table class="ui compact structured celled table" style="font-size: 18px;">
				<tr style="line-height: 10px;">
					<td width="200"><b>Start Date:</b> </td>
					<td><i id="startDate"></i></td>
				</tr>
				<tr style="line-height: 10px;">
					<td><b>End Date:</b></td>
					<td><i id="endDate"></i></td>
				</tr>
				<tr style="line-height: 10px;">
					<td><b>Time:</b></td>
					<td><i id="timeDated"></i></td>
				</tr>
				<tr style="line-height: 10px;">
					<td><b>Number of Hours:</b></td>
					<td> <i id="numHours"></i></td>
				</tr>

				<tr style="line-height: 10px;">
					<td><b>Venue:</b></td>
					<td><i id="venue"></i></td>
				</tr>
				<tr style="line-height: 10px;">
					<td><b>Remarks:</b></td>
					<td> <i id="remarks"></i></td>
				</tr>
			</table>


		</div>
		<!-- <div class="ui segment"> -->
		<div class="ui segment noBorderPrint">
			<div class="ui container" style="font-size: 18px;">
				<h5 class="ui header block blue"><i class="icon users"></i> PERSONNELS INVOLVED:</h5>
				<ol id="personnelList" class="ui list" style="display: inline-block; width: 770px;"></ol>
			</div>
			<div style="page-break-inside: -avoid;">
				<h5 class="ui header block blue"><i class="icon chart bar"></i> EVALUATION REPORT:</h5>
				<div class="ui grid">
					<div class="four wide column noprint">
						<a href="personneltrainingsevaluation.php?personneltrainings_id=<?php echo $personneltrainings_id; ?>" class="ui button blue mini noprint	">Add Entry</a>
					</div>
					<div class="twelve wide column">
						Number of Entries: <?php $sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id'";
											$result = $mysqli->query($sql);
											echo $result->num_rows;
											?>

					</div>
				</div>
				<?php
				$nums1 = array();
				$nums2 = array();
				$nums3 = array();
				$nums4 = array();
				$nums5 = array();
				?>
				<table class="ui very compact blue small table">
					<thead>
						<tr>
							<th>ITEMS FOR EVALUATION</th>
							<th colspan="5" style="text-align: center;">RATING</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td></td>
							<td>1</td>
							<td>2</td>
							<td>3</td>
							<td>4</td>
							<td>5</td>
						</tr>
						<!-- section -->
						<tr style="background-color: #e2f9f8;">
							<td colspan="6"><i class="icon pencil alternate"></i> SUBJECT MATTER</td>
						</tr>
						<tr>
							<td>Interesting</td>
							<?php
							for ($i = 1; $i <= 5; $i++) {
								echo "<td>";
								$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `subj_matter_1_rating` = '$i'";
								$result = $mysqli->query($sql);
								if (!$result->num_rows) {
									echo $num_rows = 0;
								} else {
									echo $num_rows = $result->num_rows;
								}
								array_push(${'nums' . $i}, $num_rows);
								echo "</td>";
							}
							?>
						</tr>
						<tr>
							<td>Relevant to my job</td>
							<?php
							for ($i = 1; $i <= 5; $i++) {
								echo "<td>";
								$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `subj_matter_2_rating` = '$i'";
								$result = $mysqli->query($sql);
								if (!$result->num_rows) {
									echo $num_rows = 0;
								} else {
									echo $num_rows = $result->num_rows;
								}
								array_push(${'nums' . $i}, $num_rows);
								echo "</td>";
							}
							?>
						</tr>
						<tr>
							<td>Easy to understands</td>
							<?php
							for ($i = 1; $i <= 5; $i++) {
								echo "<td>";
								$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `subj_matter_3_rating` = '$i'";
								$result = $mysqli->query($sql);
								if (!$result->num_rows) {
									echo $num_rows = 0;
								} else {
									echo $num_rows = $result->num_rows;
								}
								array_push(${'nums' . $i}, $num_rows);
								echo "</td>";
							}
							?>
						</tr>
						<tr>
							<td>Appropriate to course objectives</td>
							<?php
							for ($i = 1; $i <= 5; $i++) {
								echo "<td>";
								$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `subj_matter_4_rating` = '$i'";
								$result = $mysqli->query($sql);
								if (!$result->num_rows) {
									echo $num_rows = 0;
								} else {
									echo $num_rows = $result->num_rows;
								}
								array_push(${'nums' . $i}, $num_rows);
								echo "</td>";
							}
							?>
						</tr>
						<!-- section -->
						<!-- section -->
						<tr style="background-color: #e2f9f8;">
							<td colspan="6"><i class="icon pencil alternate"></i> PRESENTATION</td>
						</tr>
						<tr>
							<td>Length of the activity</td>
							<?php
							for ($i = 1; $i <= 5; $i++) {
								echo "<td>";
								$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `presentation_1_rating` = '$i'";
								$result = $mysqli->query($sql);
								if (!$result->num_rows) {
									echo $num_rows = 0;
								} else {
									echo $num_rows = $result->num_rows;
								}
								array_push(${'nums' . $i}, $num_rows);
								echo "</td>";
							}
							?>
						</tr>
						<tr>
							<td>Sequence of topics</td>
							<?php
							for ($i = 1; $i <= 5; $i++) {
								echo "<td>";
								$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `presentation_2_rating` = '$i'";
								$result = $mysqli->query($sql);
								if (!$result->num_rows) {
									echo $num_rows = 0;
								} else {
									echo $num_rows = $result->num_rows;
								}
								array_push(${'nums' . $i}, $num_rows);
								echo "</td>";
							}
							?>
						</tr>
						<tr>
							<td>Visual/Training Aids used</td>
							<?php
							for ($i = 1; $i <= 5; $i++) {
								echo "<td>";
								$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `presentation_3_rating` = '$i'";
								$result = $mysqli->query($sql);
								if (!$result->num_rows) {
									echo $num_rows = 0;
								} else {
									echo $num_rows = $result->num_rows;
								}
								array_push(${'nums' . $i}, $num_rows);
								echo "</td>";
							}
							?>
						</tr>
						<tr>
							<td>Group/Individual Exercises</td>
							<?php
							for ($i = 1; $i <= 5; $i++) {
								echo "<td>";
								$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `presentation_4_rating` = '$i'";
								$result = $mysqli->query($sql);
								if (!$result->num_rows) {
									echo $num_rows = 0;
								} else {
									echo $num_rows = $result->num_rows;
								}
								array_push(${'nums' . $i}, $num_rows);
								echo "</td>";
							}
							?>
						</tr>
						<tr>
							<td>Methods used were appropriate and helpful</td>
							<?php
							for ($i = 1; $i <= 5; $i++) {
								echo "<td>";
								$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `presentation_5_rating` = '$i'";
								$result = $mysqli->query($sql);
								if (!$result->num_rows) {
									echo $num_rows = 0;
								} else {
									echo $num_rows = $result->num_rows;
								}
								array_push(${'nums' . $i}, $num_rows);
								echo "</td>";
							}
							?>
						</tr>
						<!-- section -->
						<!-- section -->
						<tr style="background-color: #e2f9f8;">
							<td colspan="6"><i class="icon pencil alternate"></i> RESOURCE PERSON/S</td>
						</tr>
						<tr>
							<td>Knowledge of the subject matter</td>
							<?php
							for ($i = 1; $i <= 5; $i++) {
								echo "<td>";
								$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `resource_pip_1_rating` = '$i'";
								$result = $mysqli->query($sql);
								if (!$result->num_rows) {
									echo $num_rows = 0;
								} else {
									echo $num_rows = $result->num_rows;
								}
								array_push(${'nums' . $i}, $num_rows);
								echo "</td>";
							}
							?>
						</tr>
						<tr>
							<td>Style of Presentation</td>
							<?php
							for ($i = 1; $i <= 5; $i++) {
								echo "<td>";
								$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `resource_pip_2_rating` = '$i'";
								$result = $mysqli->query($sql);
								if (!$result->num_rows) {
									echo $num_rows = 0;
								} else {
									echo $num_rows = $result->num_rows;
								}
								array_push(${'nums' . $i}, $num_rows);
								echo "</td>";
							}
							?>
						</tr>
						<tr>
							<td>Clarity of presentation</td>
							<?php
							for ($i = 1; $i <= 5; $i++) {
								echo "<td>";
								$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `resource_pip_3_rating` = '$i'";
								$result = $mysqli->query($sql);
								if (!$result->num_rows) {
									echo $num_rows = 0;
								} else {
									echo $num_rows = $result->num_rows;
								}
								array_push(${'nums' . $i}, $num_rows);
								echo "</td>";
							}
							?>
						</tr>
						<tr>
							<td>Sensitivity to participant's needs/questions</td>
							<?php
							for ($i = 1; $i <= 5; $i++) {
								echo "<td>";
								$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `resource_pip_4_rating` = '$i'";
								$result = $mysqli->query($sql);
								if (!$result->num_rows) {
									echo $num_rows = 0;
								} else {
									echo $num_rows = $result->num_rows;
								}
								array_push(${'nums' . $i}, $num_rows);
								echo "</td>";
							}
							?>
						</tr>
						<tr>
							<td>Effective overall</td>
							<?php
							for ($i = 1; $i <= 5; $i++) {
								echo "<td>";
								$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `resource_pip_5_rating` = '$i'";
								$result = $mysqli->query($sql);
								if (!$result->num_rows) {
									echo $num_rows = 0;
								} else {
									echo $num_rows = $result->num_rows;
								}
								array_push(${'nums' . $i}, $num_rows);
								echo "</td>";
							}
							?>
						</tr>
						<!-- section -->
						<!-- section -->
						<tr style="background-color: #e2f9f8;">
							<td colspan="6"><i class="icon pencil alternate"></i> ADMINISTRATIVE</td>
						</tr>
						<tr>
							<td>Secretariat/Traning Staff</td>
							<?php
							for ($i = 1; $i <= 5; $i++) {
								echo "<td>";
								$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `administrative_1_rating` = '$i'";
								$result = $mysqli->query($sql);
								if (!$result->num_rows) {
									echo $num_rows = 0;
								} else {
									echo $num_rows = $result->num_rows;
								}
								array_push(${'nums' . $i}, $num_rows);
								echo "</td>";
							}
							?>
						</tr>
						<tr>
							<td>Registration Procedures</td>
							<?php
							for ($i = 1; $i <= 5; $i++) {
								echo "<td>";
								$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `administrative_2_rating` = '$i'";
								$result = $mysqli->query($sql);
								if (!$result->num_rows) {
									echo $num_rows = 0;
								} else {
									echo $num_rows = $result->num_rows;
								}
								array_push(${'nums' . $i}, $num_rows);
								echo "</td>";
							}
							?>
						</tr>
						<tr>
							<td>Venue is conducive to venue </td>
							<?php
							for ($i = 1; $i <= 5; $i++) {
								echo "<td>";
								$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `administrative_3_rating` = '$i'";
								$result = $mysqli->query($sql);
								if (!$result->num_rows) {
									echo $num_rows = 0;
								} else {
									echo $num_rows = $result->num_rows;
								}
								array_push(${'nums' . $i}, $num_rows);
								echo "</td>";
							}
							?>
						</tr>
						<tr>
							<td>Facilities</td>
							<?php
							for ($i = 1; $i <= 5; $i++) {
								echo "<td>";
								$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `administrative_4_rating` = '$i'";
								$result = $mysqli->query($sql);
								if (!$result->num_rows) {
									echo $num_rows = 0;
								} else {
									echo $num_rows = $result->num_rows;
								}
								array_push(${'nums' . $i}, $num_rows);
								echo "</td>";
							}
							?>
						</tr>
						<!-- section -->
						<!-- section -->
						<tr style="background-color: #e2f9f8;">
							<td colspan="6"><i class="icon pencil alternate"></i> OVERALL ASSESSMENT</td>
						</tr>
						<tr>
							<td>This training helped me do a better job in the office</td>
							<?php
							for ($i = 1; $i <= 5; $i++) {
								echo "<td>";
								$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `overall_ass_1` = '$i'";
								$result = $mysqli->query($sql);
								if (!$result->num_rows) {
									echo $num_rows = 0;
								} else {
									echo $num_rows = $result->num_rows;
								}
								array_push(${'nums' . $i}, $num_rows);
								echo "</td>";
							}
							?>
						</tr>
						<tr>
							<td>This seminar helped me identify areas I need to develop</td>
							<?php
							for ($i = 1; $i <= 5; $i++) {
								echo "<td>";
								$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `overall_ass_2` = '$i'";
								$result = $mysqli->query($sql);
								if (!$result->num_rows) {
									echo $num_rows = 0;
								} else {
									echo $num_rows = $result->num_rows;
								}
								array_push(${'nums' . $i}, $num_rows);
								echo "</td>";
							}
							?>
						</tr>
						<tr>
							<td>The seminar was worthy of my time</td>
							<?php
							for ($i = 1; $i <= 5; $i++) {
								echo "<td>";
								$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `overall_ass_3` = '$i'";
								$result = $mysqli->query($sql);
								if (!$result->num_rows) {
									echo $num_rows = 0;
								} else {
									echo $num_rows = $result->num_rows;
								}
								array_push(${'nums' . $i}, $num_rows);
								echo "</td>";
							}
							?>
						</tr>
						<tr>
							<td>The program as a whole was a worthwhile educational experience</td>
							<?php
							for ($i = 1; $i <= 5; $i++) {
								echo "<td>";
								$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `overall_ass_4` = '$i'";
								$result = $mysqli->query($sql);
								if (!$result->num_rows) {
									echo $num_rows = 0;
								} else {
									echo $num_rows = $result->num_rows;
								}
								array_push(${'nums' . $i}, $num_rows);
								echo "</td>";
							}
							?>
						</tr>
						<tr>
							<td>Overall, the seminar was effective</td>
							<?php
							for ($i = 1; $i <= 5; $i++) {
								echo "<td>";
								$sql = "SELECT `personneltrainingseval_id` FROM `personneltrainingseval` WHERE `personneltrainings_id` = '$personneltrainings_id' AND `overall_ass_5` = '$i'";
								$result = $mysqli->query($sql);
								if (!$result->num_rows) {
									echo $num_rows = 0;
								} else {
									echo $num_rows = $result->num_rows;
								}
								array_push(${'nums' . $i}, $num_rows);
								echo "</td>";
							}
							?>
						</tr>
						<!-- section -->
					<tfoot>
						<tr style="background-color: #f5f5a1;">
							<td>TOTAL</td>
							<?php
							$sumPerPoints = array();
							for ($i = 1; $i <= 5; $i++) {
								$total = 0;
								echo "<td>";
								foreach (${'nums' . $i} as $value) {
									$total += $value;
								}
								echo $sumPerPoints[$i - 1] = $total;
								echo "</td>";
							}
							?>
						</tr>
						<tr style="background-color: #c7fdc7;">
							<td>ANALYSIS</td>
							<?php
							$suma = 0;
							$percPerPoints = array();
							for ($i = 1; $i <= 5; $i++) {
								$total = 0;
								foreach (${'nums' . $i} as $value) {
									$total += $value;
								}
								$suma += $total;
							}
							for ($i = 1; $i <= 5; $i++) {
								$total = 0;
								echo "<td>";
								foreach (${'nums' . $i} as $value) {
									$total += $value;
								}
								if ($total != 0) {
									$percentage = ($total / $suma) * 100;
								} else {
									$percentage = 0;
								}
								// $percentage = ($total/$suma)*100;
								$percPerPoints[$i - 1] = $percentage;
								echo number_format($percentage, 2, '.', '') . "%";
								// echo $suma += $total;
								echo "</td>";
							}
							?>
						</tr>
					</tfoot>
					</tbody>
				</table>
			</div>
			<canvas id="myChart" width="400" height="200"></canvas>
			<div class="ui segment center aligned">
				<p><?php print number_format($percPerPoints[4], 2, '.', '') . "%"; ?> of the participants rated the undertaking <i style="color: rgb(153, 102, 255, 1);">Excellent</i>.</p>
				<p><?php print number_format($percPerPoints[3], 2, '.', '') . "%"; ?> of the participants rated the undertaking <i style="color: rgb(0, 204, 0, 1);">Very Good</i>.</p>
				<p><?php print number_format($percPerPoints[2], 2, '.', '') . "%"; ?> of the participants rated the undertaking <i style="color: rgb(75, 192, 192, 1);">Good</i>.</p>
				<p><?php print number_format($percPerPoints[1], 2, '.', '') . "%"; ?> of the participants rated the undertaking <i style="color: rgb(255, 153, 0, 1);">Poor</i>.</p>
				<p><?php print number_format($percPerPoints[0], 2, '.', '') . "%"; ?> of the participants rated the undertaking <i style="color: rgb(255, 0, 0, 1);">Fail</i>.</p>
			</div>
			<div style="page-break-inside: -avoid;">
				<h5 class="ui header blue block">ASSESSMENT ON THE FOLLOWING</h5>
				<div id="assContainer" class="ui form"></div>
			</div>
		</div>

	</div>
	<script type="text/javascript">
		var titleTR = "";
		var ctx = document.getElementById("myChart");
		var myChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: ["Fail", "Poor", "Good", "Very Good", "Excellent"],
				datasets: [{
					label: 'Total Points',
					data: <?php echo json_encode($sumPerPoints); ?>, //12, 19, 3, 5, 2],
					backgroundColor: [
						'rgba(255, 0, 0, 0.5)',
						'rgb(255, 153, 0, 0.5)',
						'rgba(75, 192, 192, 0.5)',
						'rgba(0, 204, 0, 0.5)',
						'rgba(153, 102, 255, 0.5)'
					],
					borderColor: [
						'rgba(255, 0, 0, 1)',
						'rgb(255, 153, 0, 1)',
						'rgba(75, 192, 192, 1)',
						'rgba(0, 204, 0, 1)',
						'rgba(153, 102, 255, 1)'
					],
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						scaleLabel: {
							display: true,
							labelString: 'Total Ratings'
						},
						ticks: {
							beginAtZero: true,
							max: <?php echo $suma; ?>
						}
					}]
				}, //end of scales
				title: {
					display: true,
					text: titleTR
				},
				legend: {
					display: false,
				}

			}
		});
	</script>
	<?php require_once "footer.php"; ?>