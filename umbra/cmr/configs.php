<?php
require_once "../../_connect.db.php";
if (isset($_POST['AddPeriod'])) {
	$year = $_POST['year'];
	$checksql = "SELECT * FROM cmr where cmr_period = $year";
	$checksql = $mysqli->query($checksql);
	$checksql = $checksql->num_rows;
	if($checksql>0){
		echo "Period Already Exist";
	}else{
		$sql ="INSERT INTO `cmr` (`cmr_id`, `cmr_period`, `comments`) VALUES (NULL, '$year', '')";
		$store = $mysqli->query($sql);
		if (!$store) {
			echo mysql_error();
		}else{
			echo "1";
		}
	}
}elseif (isset($_POST['viewPeriod'])) {
	$view = "";
	$info ="SELECT * from cmr ORDER BY cmr_period DESC";
	$info = $mysqli->query($info);
	$check = $info->num_rows;
	if($check<1){
		$view ="<tr style='text-align:center;color:gray'><th colspan='2'><h1>Database is Empty</h1></th></tr>";
	}else{
		while ($row = $info->fetch_assoc()) {
			$view .="<tr>
			<td><a href='?cmReport=$row[cmr_period]&cmr=$row[cmr_id]'><button class='ui basic icon button'><i class='folder icon'></i></button></a></td>
			<td>$row[cmr_period]</td>
			</tr>";
		}
	}
	echo $view;
}elseif (isset($_POST['cmr'])) {
	$cmrId = $_POST['cmr'];
	$empId = $_POST['empId'];
	$check = "SELECT * from cmremp where emp_id='$empId' and cmr_id='$cmrId'";
	$check = $mysqli->query($check);
	$check = $check->num_rows;
	if ($check<1&&$empId!=0) {
		$sql = "INSERT INTO `cmremp` (`cmrEmp_id`, `emp_id`, `cmr_id`) VALUES (NULL, '$empId', '$cmrId')";
		$sql =  $mysqli->query($sql);
		if (!$sql) {
			echo mysql_error();
		}else{
			echo "1";
		}
	}else{
		echo "Already Exist!!";
	}
}elseif (isset($_POST['cmpEmpView'])) {
	$cmrId = $_POST['cmrId'];
	$sql = "SELECT * from cmremp where cmr_id=$cmrId ORDER BY cmrEmp_id DESC";
	$sql = $mysqli->query($sql);
	$view = "";
	while ($row = $sql->fetch_assoc()){
		// query for remove btn
		// remove btn will show if employee dont have data yet
		$removeBtn = "SELECT * from cmrempdata where cmremp_id='$row[cmrEmp_id]'";
		$removeBtn = $mysqli->query($removeBtn);
		if($removeBtn->num_rows<1){
			$rmbtn = "<button class='ui icon red mini button' onclick='removecmr($row[cmrEmp_id],$cmrId)' style='margin-right: 10px; width: 70px;'>Remove</button>";
		}else{
			$rmbtn = "";
		}
		//query  for selected empoyees for coaching
		$empsql = "SELECT * from employees left join department on employees.department_id=department.department_id left join positiontitles on employees.position_id=positiontitles.position_id where employees.employees_id='$row[emp_id]'";
		$empsql = $mysqli->query($empsql);
		$empsql = $empsql->fetch_assoc();
		$view .="
		<tr>
		<td class='noprint'>
		<a href='employeeinfo.php?employees_id=$empsql[employees_id]&spms' title='Open'> <i class='icon folder'></i> </a>
		</td>
		<td>$empsql[lastName]</td>
		<td>$empsql[firstName]</td>
		<td>$empsql[middleName]</td>
		<td>$empsql[extName]</td>
		<td>$empsql[department]</td>
		<td>$empsql[position]</td>
		<td>
		<button class='ui icon green mini button' id='addcmrbtn' onclick='modal(this,$row[cmrEmp_id],\"\")'  style='margin-right: 10px; width: 70px;'>ADD</button>
		$rmbtn
		</td>
		</tr>
		";
	}
	echo $view;
}elseif (isset($_POST['addcmrbtnModal'])) {
	$cmrEmpId = $_POST['cmrEmpId'];
	$sql = "SELECT * from cmremp left join employees on cmremp.emp_id=employees.employees_id  where cmrEmp_id =$cmrEmpId";
	$sql = $mysqli->query($sql);
	$sql = $sql->fetch_assoc();
	$tr = "SELECT* from cmrempdata where cmremp_id='$cmrEmpId'";
	$tr = $mysqli->query($tr);
	$checkRows =  $tr->num_rows;
	$formView="block";
	$btnView = "block";
	$hideBtn = "";
	if ($checkRows>0) {
		$table = addcmrbtnModal($tr,$sql['cmr_id']);
		$formView = "none";
		$hideBtn = "<div class='ui blue button' id='cmrformbtnhide' onclick='showModalForm(this)'>HIDE</div>";
	}else{
		$btnView = "none";
		$table="";
	}
	$view = "
	<div class='header' style='background:#52b9e5;color:white;font-family:Arial Black;letter-spacing:2pt;font-size:25pt;'>$sql[lastName] $sql[firstName]</div>
	<div class='content' >
	<div id='addcmrdata' style='display:$formView'>
	<div class='ui form'>
	<div class='field'>
	<label>Date Conducted</label>
	<input id='crmData_date' type='date'>
	</div>
	<div class='field'>
	<label>Content/Highlight</label>
	<textarea rows='2' id='crmData_content'></textarea>
	</div>
	<div class='field'>
	<label>Note/Comments</label>
	<textarea rows='2' id='crmData_note'></textarea>
	</div>
	</div>
	<br>
	<div class='ui green button' onclick='cmrEmpData($cmrEmpId,$sql[cmr_id])' >SAVE</div>
	$hideBtn
	</div >
	<div class='ui blue button' id='btnformModal' style='display:$btnView' onclick='showModalForm(this)'>SHOW FORM</div>
	";
	$view .=$table;
	$view .=" </div>
	<div class='actions'>
	<div class='ui cancel red button'>Close</div>
	</div>
	";
	echo $view;
}elseif (isset($_POST['cmrEmpData'])){
	$cmrempId = $_POST['cmrempId'];
	$date = $_POST['date'];
	$content = addslashes($_POST['content']);
	$note = addslashes($_POST['note']);
	$sql = "INSERT INTO `cmrempdata` (`cmrEmpData_id`, `cmremp_id`, `date`, `content`, `note`) VALUES (NULL, '$cmrempId', '$date', '$content', '$note')";
	$sql = $mysqli->query($sql);
	if (!$sql) {
		echo "error";
	}else{
		echo '1';
	}
}elseif (isset($_POST['removeEmp'])) {
	$sql = "DELETE FROM `cmremp` WHERE `cmremp`.`cmrEmp_id` = $_POST[cmrEmp]";
	$sql = $mysqli->query($sql);
	if(!$sql){
		echo "error";
	}else{
		echo '1';
	}
}elseif (isset($_POST['cmrempdataremove'])) {
	$sql = "DELETE FROM `cmrempdata` WHERE `cmrempdata`.`cmrEmpData_id` = $_POST[dataId]";
	$sql = $mysqli->query($sql);
	if (!$sql) {
		echo "error";
	}else{
		echo '1';
	}

}elseif (isset($_POST['cmrempDataEditView'])) {
	$sql="SELECT * from cmrempdata where cmrEmpData_id='$_POST[dataId]'";
	$sql = $mysqli->query($sql);
	$sql = $sql->fetch_assoc();
	$view="
	<div class='header' style='background:#52b9e5;color:white;font-family:Arial Black;letter-spacing:2pt;font-size:25pt;'>Edit</div>
	<div class='content'>
	<div class='ui form'>
	<div class='field'>
	<label>Date</label>
	<input type='date' id='editcmr_date' value='$sql[date]'>
	</div>
	<div class='field'>
	<label>Content/Highlight</label>
	<textarea rows='4' id='editcmr_content'>$sql[content]</textarea>
	</div>
	<div class='field'>
	<label>Note/Comments</label>
	<textarea id='editcmr_note'>$sql[note]</textarea>
	</div>
	<div class='field'>
	<button class='ui blue button' onclick='saveEditedcmrData($_POST[dataId],$_POST[cmrempId])'>SAVE</button>
	<button class='ui red button' onclick='addcmrbtnModalCont($_POST[cmrempId])'>CANCEL</button>
	</div>
	</div>
	</div>
	";
	echo $view;
}elseif (isset($_POST['saveEditedcmrData'])) {
	$date = $_POST['date'];
	$content = addslashes($_POST['content']);
	$note = addslashes($_POST['note']);
	$dataId = $_POST['dataId'];
	$sql = "UPDATE `cmrempdata` SET `date` = '$date', `content` = '$content', `note` = '$note' WHERE `cmrempdata`.`cmrEmpData_id` = $dataId";
	$sql = $mysqli->query($sql);
	if (!$sql) {
		echo $mysqli->error;
	}else{
		echo '1';
	}

}elseif (false) {
}else{
	echo "<h1>Something Went Wrong!!!</h1><br><p>programmers guide:\$_POST value not found on configs.php cmr folder</p>";
}
// functions
function addcmrbtnModal($tr,$cmr){
	$view="";

	$view .="
	<table class='ui celled table'>
	<thead>
	<tr style='text-align:center'>
	<th style='width:10%'>Date</th>
	<th>Content/Highlight</th>
	<th>Note/Comments</th>
	<th>Options</th>
	</tr>
	</thead>
	<tbody>
	";
	while ($row = $tr->fetch_assoc()) {
		$note = nl2br($row['note']);
		$content = nl2br($row['content']);
		$date = new DateTime($row['date']);
		$strDate = $date->format('M d, Y');
		$view .="
		<tr>
		<td>$strDate</td>
		<td>$content</td>
		<td>$note</td>
		<td>
		<div class='ui green icon button' onclick='cmrempDataEditView($row[cmrEmpData_id],$row[cmremp_id])' ><i class='pencil icon'> </i></div>
		<div class='ui red icon button' onclick='cmrempdataremove($row[cmrEmpData_id],$row[cmremp_id],$cmr)' ><i class='window close icon'> </i></div>
		</td>
		</tr>
		";
	}
	$view .= "
	</tbody>
	</table>
	";
	return $view;
}


?>
