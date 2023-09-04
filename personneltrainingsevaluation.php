<?php $title="Training Evaluation"; require_once "header.php";
require_once "_connect.db.php";
$personneltrainings_id = $_GET["personneltrainings_id"];
// $personneltrainings_id = "Evaluation Form";
$sql = "SELECT * FROM `personneltrainings` WHERE `personneltrainings_id` = '$personneltrainings_id'";
$result = $mysqli->query($sql);

$row = $result->fetch_assoc();

$training_id = $row["training_id"];
$startDate = $row["startDate"];
$endDate = $row["endDate"];
$numHours = $row["numHours"];
$venue = $row["venue"];
$remarks = $row["remarks"];

$sql = "SELECT `training` FROM `trainings` WHERE `training_id` = '$training_id'";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$training = $row["training"];

?>
<script type="text/javascript">
	var value = [];

	
	$(document).ready(function() {
		$("#trainingTitle").html('<?php echo $training;?>');

		for (var i = 0; i <= 22; i++) {
			value[i] = 0;
			var item = new getValues(i);
		}

		$("#buttonID").click(function(event) {
			var comment1 = $("#comment1").val(),
			comment2 = $("#comment2").val(),
			comment3 = $("#comment3").val(),
			comment4 = $("#comment4").val(),
			ass1 = $("#ass1").val(),
			ass2 = $("#ass2").val(),
			ass3 = $("#ass3").val(),
			ass4 = $("#ass4").val(),
			ass5 = $("#ass5").val(),
			checkUnchecked = [];

			// check for unanswered item
			// alert(value.length+"\n"+value);
			if (value.length == 23) {

				for (var i = 0; i < 23; i++) {
					if (value[i] == 0) {
						checkUnchecked.push(i);
					}
				}

			if (checkUnchecked.length > 0) {
				alert("Please complete the survey!");
			} else {
					value.push(comment1,comment2,comment3,comment4,ass1,ass2,ass3,ass4,ass5);
					arraymove(value,23,4);
					arraymove(value,24,10);
					arraymove(value,25,16);
					arraymove(value,26,21);
					$(addEntry);
				}
			}
		});

	});

	function addEntry(){
		$.post('personneltrainingsevaluation_proc.php', {
			addEntry: true,
			personneltrainings_id: <?php echo $personneltrainings_id;?>,
			value: value,
		}, function(data, textStatus, xhr) {
				alert("Survey completed!");
				// $(msg_added);
				window.location.reload();
				value = [];
		});
	}

	function getValues(index){
		$('input[name="group'+index+'[]"]').click(function(event) {
		
				value[index] = $(this).val();

			$.each($('input[name="group'+index+'[]"]'), function(index, val) {
				 $(this).removeClass('blue');
			});

			$(this).addClass('blue');
		});
	}


	function arraymove(arr, fromIndex, toIndex){
		var element = arr[fromIndex];
		arr.splice(fromIndex,1);
		arr.splice(toIndex,0,element);
	}

</script>

<style type="text/css">
	.clicked{
		background-color: green;
	}
</style>

<div class="ui container">
	<div class="ui borderless blue inverted menu">
		<div class="item">
			<h5><i class="certificate icon"></i><i id="trainingTitle"></i></h5>
		</div>
		<div class="right item">
			<button onclick="window.history.back();" class="blue ui icon button" title="Back" style="margin-right: 5px;">
				<i class="icon chevron left"></i> Back
			</button>
		</div>
	</div>
	<!-- <div class="ui container" style="min-height: 1000px;"> -->
		<div class="ui mini segment blue">
			<label><b>Start Date:</b></label>&nbsp; <i id="startDate"><?php echo $startDate;?></i><br>
			<label><b>End Date:</b></label>&nbsp; <i id="endDate"><?php echo $endDate;?></i><br>
			<label><b>Number of Hours:</b></label>&nbsp; <i id="numHours"><?php echo $numHours;?></i><br>
			<label><b>Venue:</b></label>&nbsp; <i id="venue"><?php echo $venue;?></i><br>
			<label><b>Remarks:</b></label>&nbsp; <i id="remarks"><?php echo $remarks;?></i><br>
		</div>
	<!-- </div> -->
	<div class="ui mini segment blue">
	<div class="ui container" style="width: 699px; margin-left: auto; margin-right: auto;">
		<table class="ui very compact collapsing large basic table">
			<thead>
				<tr class="blue">
					<th>ITEMS FOR EVALUATION</th>
					<th colspan="5" style="text-align: center;">RATING</th>
					<th style="text-align: center;">REMARKS/COMMENTS</th>
				</tr>
			</thead>
			<tbody>
<!-- section -->
				<tr>
					<th colspan="7"><i class="icon pencil"></i> SUBJECT MATTER</th>
				</tr>
				<tr>
					<td>Interesting</td>
					<td><input class="ui mini button" type="button" value="1" name="group0[]"></td>
					<td><input class="ui mini button" type="button" value="2" name="group0[]"></td>
					<td><input class="ui mini button" type="button" value="3" name="group0[]"></td>
					<td><input class="ui mini button" type="button" value="4" name="group0[]"></td>
					<td><input class="ui mini button" type="button" value="5" name="group0[]"></td>
					<td rowspan="4"><textarea id="comment1" style="width: 100%;" rows="10"></textarea></td>
				</tr>
				<tr>
					<td>Relevant to my job</td>
					<td><input class="ui mini button" type="button" value="1" name="group1[]"></td>
					<td><input class="ui mini button" type="button" value="2" name="group1[]"></td>
					<td><input class="ui mini button" type="button" value="3" name="group1[]"></td>
					<td><input class="ui mini button" type="button" value="4" name="group1[]"></td>
					<td><input class="ui mini button" type="button" value="5" name="group1[]"></td>
				</tr>
				<tr>
					<td>Easy to understand</td>
					<td><input class="ui mini button" type="button" value="1" name="group2[]"></td>
					<td><input class="ui mini button" type="button" value="2" name="group2[]"></td>
					<td><input class="ui mini button" type="button" value="3" name="group2[]"></td>
					<td><input class="ui mini button" type="button" value="4" name="group2[]"></td>
					<td><input class="ui mini button" type="button" value="5" name="group2[]"></td>
				</tr>
				<tr>
					<td>Appropriate to course objectives</td>
					<td><input class="ui mini button" type="button" value="1" name="group3[]"></td>
					<td><input class="ui mini button" type="button" value="2" name="group3[]"></td>
					<td><input class="ui mini button" type="button" value="3" name="group3[]"></td>
					<td><input class="ui mini button" type="button" value="4" name="group3[]"></td>
					<td><input class="ui mini button" type="button" value="5" name="group3[]"></td>
				</tr>
<!-- section -->
<!-- section -->
				<tr>
					<th colspan="7"><i class="icon pencil"></i> PRESENTATION</th>
				</tr>
				<tr>
					<td>Length of the activity</td>
					<td><input class="ui mini button" type="button" value="1" name="group4[]"></td>
					<td><input class="ui mini button" type="button" value="2" name="group4[]"></td>
					<td><input class="ui mini button" type="button" value="3" name="group4[]"></td>
					<td><input class="ui mini button" type="button" value="4" name="group4[]"></td>
					<td><input class="ui mini button" type="button" value="5" name="group4[]"></td>
					<td rowspan="5"><textarea id="comment2" style="width: 100%;" rows="10"></textarea></td>
				</tr>
				<tr>
					<td>Sequence of topics</td>
					<td><input class="ui mini button" type="button" value="1" name="group5[]"></td>
					<td><input class="ui mini button" type="button" value="2" name="group5[]"></td>
					<td><input class="ui mini button" type="button" value="3" name="group5[]"></td>
					<td><input class="ui mini button" type="button" value="4" name="group5[]"></td>
					<td><input class="ui mini button" type="button" value="5" name="group5[]"></td>
				</tr>
				<tr>
					<td>Visual/Training Aids used</td>
					<td><input class="ui mini button" type="button" value="1" name="group6[]"></td>
					<td><input class="ui mini button" type="button" value="2" name="group6[]"></td>
					<td><input class="ui mini button" type="button" value="3" name="group6[]"></td>
					<td><input class="ui mini button" type="button" value="4" name="group6[]"></td>
					<td><input class="ui mini button" type="button" value="5" name="group6[]"></td>
				</tr>
				<tr>
					<td>Group/Individual Exercises</td>
					<td><input class="ui mini button" type="button" value="1" name="group7[]"></td>
					<td><input class="ui mini button" type="button" value="2" name="group7[]"></td>
					<td><input class="ui mini button" type="button" value="3" name="group7[]"></td>
					<td><input class="ui mini button" type="button" value="4" name="group7[]"></td>
					<td><input class="ui mini button" type="button" value="5" name="group7[]"></td>
				</tr>
				<tr>
					<td>Methods used were appropriate and helpful</td>
					<td><input class="ui mini button" type="button" value="1" name="group8[]"></td>
					<td><input class="ui mini button" type="button" value="2" name="group8[]"></td>
					<td><input class="ui mini button" type="button" value="3" name="group8[]"></td>
					<td><input class="ui mini button" type="button" value="4" name="group8[]"></td>
					<td><input class="ui mini button" type="button" value="5" name="group8[]"></td>
				</tr>
<!-- section -->
<!-- section -->
				<tr>
					<th colspan="7"><i class="icon pencil"></i> RESOURCE PERSON/S</th>
				</tr>
				<tr>
					<td>Knowledge of the subject matter</td>
					<td><input class="ui mini button" type="button" value="1" name="group9[]"></td>
					<td><input class="ui mini button" type="button" value="2" name="group9[]"></td>
					<td><input class="ui mini button" type="button" value="3" name="group9[]"></td>
					<td><input class="ui mini button" type="button" value="4" name="group9[]"></td>
					<td><input class="ui mini button" type="button" value="5" name="group9[]"></td>
					<td rowspan="5"><textarea id="comment3" style="width: 100%;" rows="10"></textarea></td>
				</tr>
				<tr>
					<td>Style of Presentation</td>
					<td><input class="ui mini button" type="button" value="1" name="group10[]"></td>
					<td><input class="ui mini button" type="button" value="2" name="group10[]"></td>
					<td><input class="ui mini button" type="button" value="3" name="group10[]"></td>
					<td><input class="ui mini button" type="button" value="4" name="group10[]"></td>
					<td><input class="ui mini button" type="button" value="5" name="group10[]"></td>
				</tr>
				<tr>
					<td>Clarity of presentation</td>
					<td><input class="ui mini button" type="button" value="1" name="group11[]"></td>
					<td><input class="ui mini button" type="button" value="2" name="group11[]"></td>
					<td><input class="ui mini button" type="button" value="3" name="group11[]"></td>
					<td><input class="ui mini button" type="button" value="4" name="group11[]"></td>
					<td><input class="ui mini button" type="button" value="5" name="group11[]"></td>
				</tr>
				<tr>
					<td>Sensitivity to participant's needs/questions</td>
					<td><input class="ui mini button" type="button" value="1" name="group12[]"></td>
					<td><input class="ui mini button" type="button" value="2" name="group12[]"></td>
					<td><input class="ui mini button" type="button" value="3" name="group12[]"></td>
					<td><input class="ui mini button" type="button" value="4" name="group12[]"></td>
					<td><input class="ui mini button" type="button" value="5" name="group12[]"></td>
				</tr>
				<tr>
					<td>Effective overall</td>
					<td><input class="ui mini button" type="button" value="1" name="group13[]"></td>
					<td><input class="ui mini button" type="button" value="2" name="group13[]"></td>
					<td><input class="ui mini button" type="button" value="3" name="group13[]"></td>
					<td><input class="ui mini button" type="button" value="4" name="group13[]"></td>
					<td><input class="ui mini button" type="button" value="5" name="group13[]"></td>
				</tr>
<!-- section -->
<!-- section -->
				<tr>
					<th colspan="7"><i class="icon pencil"></i> ADMINISTRATIVE</th>
				</tr>
				<tr>
					<td>Secretariat/Training Staff</td>
					<td><input class="ui mini button" type="button" value="1" name="group14[]"></td>
					<td><input class="ui mini button" type="button" value="2" name="group14[]"></td>
					<td><input class="ui mini button" type="button" value="3" name="group14[]"></td>
					<td><input class="ui mini button" type="button" value="4" name="group14[]"></td>
					<td><input class="ui mini button" type="button" value="5" name="group14[]"></td>
					<td rowspan="4"><textarea id="comment4" style="width: 100%;" rows="10"></textarea></td>
				</tr>
				<tr>
					<td>Registration Procedures</td>
					<td><input class="ui mini button" type="button" value="1" name="group15[]"></td>
					<td><input class="ui mini button" type="button" value="2" name="group15[]"></td>
					<td><input class="ui mini button" type="button" value="3" name="group15[]"></td>
					<td><input class="ui mini button" type="button" value="4" name="group15[]"></td>
					<td><input class="ui mini button" type="button" value="5" name="group15[]"></td>
				</tr>
				<tr>
					<td>Venue is conducive to venue</td>
					<td><input class="ui mini button" type="button" value="1" name="group16[]"></td>
					<td><input class="ui mini button" type="button" value="2" name="group16[]"></td>
					<td><input class="ui mini button" type="button" value="3" name="group16[]"></td>
					<td><input class="ui mini button" type="button" value="4" name="group16[]"></td>
					<td><input class="ui mini button" type="button" value="5" name="group16[]"></td>
				</tr>
				<tr>
					<td>Facilities</td>
					<td><input class="ui mini button" type="button" value="1" name="group17[]"></td>
					<td><input class="ui mini button" type="button" value="2" name="group17[]"></td>
					<td><input class="ui mini button" type="button" value="3" name="group17[]"></td>
					<td><input class="ui mini button" type="button" value="4" name="group17[]"></td>
					<td><input class="ui mini button" type="button" value="5" name="group17[]"></td>
				</tr>
<!-- section -->
			</tbody>
		</table>
		</div>
		<h5 class="ui header blue block">OVERALL ASSESSMENT</h5>
		<table class="ui very compact table">
			<thead>
				<tr>
					<th colspan="5">Please rate your overall assessment of the activity on a scale of 1-5 where:</th>
				</tr>
				<tr style="text-align: center;">
					<th>1-Strongly Disagree</th>
					<th>2-Disagree</th>
					<th>3-Neutral</th>
					<th>4-Agree</th>
					<th>5-Strongly Agree</th>
				</tr>
			</thead>
		</table>
		<div class="ui container" style="width: 670px; margin-left: auto; margin-right: auto;">
		<table class="ui very compact large collapsing table">
			<tbody>
<!-- section -->
				<tr>
					<td>This training helped me do a better job in the office</td>
					<td><input class="ui mini button" type="button" value="1" name="group18[]"></td>
					<td><input class="ui mini button" type="button" value="2" name="group18[]"></td>
					<td><input class="ui mini button" type="button" value="3" name="group18[]"></td>
					<td><input class="ui mini button" type="button" value="4" name="group18[]"></td>
					<td><input class="ui mini button" type="button" value="5" name="group18[]"></td>
				</tr>
				<tr>
					<td>This seminar helped me identify areas I need to develop</td>
					<td><input class="ui mini button" type="button" value="1" name="group19[]"></td>
					<td><input class="ui mini button" type="button" value="2" name="group19[]"></td>
					<td><input class="ui mini button" type="button" value="3" name="group19[]"></td>
					<td><input class="ui mini button" type="button" value="4" name="group19[]"></td>
					<td><input class="ui mini button" type="button" value="5" name="group19[]"></td>
				</tr>
				<tr>
					<td>The seminar was worthy of my time</td>
					<td><input class="ui mini button" type="button" value="1" name="group20[]"></td>
					<td><input class="ui mini button" type="button" value="2" name="group20[]"></td>
					<td><input class="ui mini button" type="button" value="3" name="group20[]"></td>
					<td><input class="ui mini button" type="button" value="4" name="group20[]"></td>
					<td><input class="ui mini button" type="button" value="5" name="group20[]"></td>
				</tr>
				<tr>
					<td>The program as a whole was a worthwhile educational experience</td>
					<td><input class="ui mini button" type="button" value="1" name="group21[]"></td>
					<td><input class="ui mini button" type="button" value="2" name="group21[]"></td>
					<td><input class="ui mini button" type="button" value="3" name="group21[]"></td>
					<td><input class="ui mini button" type="button" value="4" name="group21[]"></td>
					<td><input class="ui mini button" type="button" value="5" name="group21[]"></td>
				</tr>
				<tr>
					<td>Overall, the seminar was effective</td>
					<td><input class="ui mini button" type="button" value="1" name="group22[]"></td>
					<td><input class="ui mini button" type="button" value="2" name="group22[]"></td>
					<td><input class="ui mini button" type="button" value="3" name="group22[]"></td>
					<td><input class="ui mini button" type="button" value="4" name="group22[]"></td>
					<td><input class="ui mini button" type="button" value="5" name="group22[]"></td>
				</tr>
<!-- section -->
			</tbody>
		</table>
		</div>
		<h5 class="ui header blue block">ASSESSMENT ON THE FOLLOWING</h5>
		<div class="ui form">
			<div class="field">
				<p>1.) What was the high point of the whole learning experience?</p>
				<input style="background-color: #d3d3d347;" type="text" id="ass1">
			</div>
			<div class="field">
				<p>2.) What major benefit/s you received from this training/workshop?</p>
				<input style="background-color: #d3d3d347;" type="text" id="ass2">
			</div>
			<div class="field">
				<p>3.) In what specific ways this training/workshop can be improved?</p>
				<input style="background-color: #d3d3d347;" type="text" id="ass3">
			</div>
			<div class="field">
				<p>4.) What other trainings you want HRMO to conduct to make you become more competent in your job?</p>
				<input style="background-color: #d3d3d347;" type="text" id="ass4">
			</div>
			<div class="field">
				<p>5.) Other comments and suggestions:</p>
				<input style="background-color: #d3d3d347;" type="text" id="ass5">
			</div>
		</div>
		<br>
		<input id="buttonID" class="ui button" type="button" name="submit" value="Submit">
	</div>

</div>
<?php require_once "footer.php";?>
