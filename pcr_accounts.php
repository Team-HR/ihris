<?php $title = "PCR Manage Account"; require_once "header.php";?>

<script type="text/javascript">
	$(document).ready(function() {
		$("#dropdown_users").dropdown();
	});
</script>

<div class="ui container">
<div class="ui borderless blue inverted mini menu">
    <div class="left item" style="margin-right: 0px !important;">
      <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
    </div>
  <div class="item">
  	<h3><i class="icon id card outline"></i> PCR Account Setup</h3>
  </div>
  <div class="right item">
    <div class="ui right input">
      <button class="ui icon mini green button" onclick="addModalFunc()" style="margin-right: 5px;" title="Add New Department"><i class="icon plus"></i>Add</button>
      <div class="ui icon fluid input" style="width: 300px;">
        <input id="dept_search" type="text" placeholder="Search...">
        <i class="search icon"></i>
    </div>
    </div>
  </div>
</div>

<div class="ui modal">
	<div class="content">
		
	</div>
	<div class="actions">
		<button class="ui approve small button">Add</button>
		<button class="ui deny small button">Cancel</button>
	</div>
</div>

<div class="ui form">
	<div class="eight wide field">
		<label>Search User/Employee:</label>


<div class="ui fluid search selection dropdown" id="dropdown_users">
  <input type="hidden" name="user">
  <i class="dropdown icon"></i>
  <div class="default text">Select Users</div>
  <div class="menu">
  <!-- <div class="item" data-value="af"><i class="af flag"></i>Afghanistan</div> -->
  <?php
require '_connect.db.php';

$sql = "SELECT * FROM `employees` WHERE `employees_id` NOT IN (SELECT `employees_id` FROM `accounts`) ORDER BY `lastName`";
$result = $mysqli->query($sql);
while ($row = $result->fetch_assoc()) {

	$employees_id = $row["employees_id"];
	$lastName = $row["lastName"];
	$firstName = $row["firstName"];
	$middleName = $row["middleName"];
	$extName = $row["extName"];

	if ($middleName === "" OR $middleName === ".") {
		$middleName = "";
	}
	if ($extName === "" OR $extName === ".") {
		$middleName = "";
	}
	$fullName = mb_convert_case("$lastName, $firstName $middleName $extName",MB_CASE_UPPER);
	echo "<div class='item' data-value='$employees_id'>$fullName</div>";
}

  ?>
</div>
 </div>



	</div>
</div>

</div>
<?php require_once "footer.php";?>

