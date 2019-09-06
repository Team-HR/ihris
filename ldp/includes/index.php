<!DOCTYPE html>
<html>
<head>
	<title>Hello World</title>
</head>
<body>
<table>
		<thead>
			<tr>
				<th>Name</th>
				<!-- <th>Gender</th> -->
				<th>Status</th>
				<th>Position</th>
				<th>Trainings Seminar</th>
				<th>Start</th>
				<th>End</th>
				<th>Hrs</th>
				<th>Remarks</th>
			</tr>
		</thead>
		<tbody id="tbody">
			

<?php
include "_Report.php";

$report = new Report;
$report->getReports("all","PERMANENT","MALE");

?>
		</tbody>
</table>
</body>
</html>