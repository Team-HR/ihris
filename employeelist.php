<?php $title = "Employee List"; require_once "header.php";

$employees_id = "";
if (isset($_GET["scrollTo"])) {
	$employees_id = $_GET["scrollTo"];
}
?>

<script>
	var dept_filters = "";
	$(document).ready(function() {
		var loading = $("#loading_el");

		$("#mulitipleFilters").dropdown({
			onChange: function (){
				$("#clearFilter").show();
				$("#clearFilter").addClass('loading');
				$("#tableBody").html(loading); 
				dept_filters = $(this).dropdown('get values');
				$(load(dept_filters));
				$("#employee_search").val("");
				if ($(this).dropdown("get value") == "") {
					dept_filters = "";
					$("#clearFilter").hide();
				}
			},
		});

		$("#clearFilter").click(function(event) {
			$('#mulitipleFilters').dropdown('restore defaults');
			$(this).hide();
			dept_filters = "";
		});

		$("#statusModal").dropdown();
		$("#genderModal").dropdown();
		$("#employmentStatusModal").dropdown();
		$("#natureOfAssignmentModal").dropdown();
		$("#departmentModal").dropdown();
		$("#positionModal").dropdown();
		$("#employee_search").on("keyup", function() {
		  var value = $(this).val().toLowerCase();
		  $("#employees_table tr").filter(function() {
		    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		  });
		});
		$(load(dept_filters));
	});

	function load(filters){
			$.post('employeelist_proc.php', {
				load: true,
				filters: filters,
			}, function(data, textStatus, xhr) {
				/*optional stuff to do after success */
				$("#tableBody").html(data);
				$(getNumOfStatus(filters));
				$("#clearFilter").removeClass('loading');
			});
		}

	function addModalFunc(){
		$("#addModal").modal({
				closable: false,
				onApprove : function() {
					$(addPersonnel);
				// save msg animation start	
		      $("#saveMsg").transition({
		      	animation: 'fly down',
		      	onComplete: function () {
		      		setTimeout(function(){ $("#saveMsg").transition('fly down'); }, 1000);
		      	}
		      });
	      // save msg animation end
	    	},
	    	onDeny: function(){
	    		$(clearModal);
	    	}
		}).modal("show");
	}

	function addPersonnel(){
		$.post('employeelist_proc.php', {
			addPersonnel: true,
			firstNameModal: $("#firstNameModal").val(),
			middleNameModal: $("#middleNameModal").val(),
			lastNameModal: $("#lastNameModal").val(),
			extNameModal: $("#extNameModal").val(),
			genderModal: $("#genderModal").val(),
			statusModal: $("#statusModal").val(),
			statusDate: $("#statusDate").val(),
			dateIPCR: $("#dateIPCR").val(),
			employmentStatusModal: $("#employmentStatusModal").val(),
			natureOfAssignmentModal: $("#natureOfAssignmentModal").val(),
			departmentModal: $("#departmentModal").val(),
			positionModal: $("#positionModal").val(),
		}, function(data, textStatus, xhr) {
				$(clearModal);
				$(load(dept_filters));
				// alert(data);
		});
	}

	function clearModal(){
		$("#firstNameModal").val("");
		$("#middleNameModal").val("");
		$("#lastNameModal").val("");
		$("#extNameModal").val("");
		$("#genderModal").dropdown('restore defaults');
		$("#statusModal").dropdown('restore defaults');
		$("#statusDate").val("");
		$("#dateIPCR").val("");
		$("#employmentStatusModal").dropdown('restore defaults');
		$("#natureOfAssignmentModal").dropdown('restore defaults');
		$("#departmentModal").dropdown('restore defaults');
		$("#positionModal").dropdown('restore defaults');
	}

	function getNumOfStatus(filters){
		$.post('employeelist_proc.php', {
			getNumOfStatus: true,
			filters: filters
		}, function(data, textStatus, xhr) {
			var array = jQuery.parseJSON(data);
			$("#total_rows").html(array.total);
		});
	}

	function editStat(employees_id){
		$.post('employeelist_proc.php', {
			get_editStat: true,
			employees_id: employees_id,
		}, function(data, textStatus, xhr) {
			var array = jQuery.parseJSON(data);
				if (array != null) {
					$("#editStat_drop").dropdown({showOnFocus: false,}).dropdown("set selected", array.status);
					$("#editStat_date").val(array.date);
					$("#editStat_dateIPCR").val(array.dateIPCR);
				}
		});
		
		$("#editStat").modal({
			onApprove: function (){
				$.post('employeelist_proc.php', {
					editStat: true,
					employees_id: employees_id,
					status: $("#editStat_drop").dropdown("get value"),
					dateStat: $("#editStat_date").val(),
					dateStartIPCR: $("#editStat_dateIPCR").val(),
				}, function(data, textStatus, xhr) {
					$(load(dept_filters));
				});
			}
		}).modal("show");

	}
</script>
<!-- editStat start -->

<div class="ui mini modal" id="editStat">
	<!-- <div class="header">Active/Inactive</div> -->
	<div class="content">
		<div class="ui form">
			<div class="fields">
			<div class="seven wide field">
				<label>Status:</label>
				<div class="ui selection dropdown compact" id="editStat_drop">
				  <input type="hidden" name="status">
				  <i class="dropdown icon"></i>
				  <div class="default text">Select Active/Inactive</div>
				  <div class="menu">
				    <div class="item" data-value="ACTIVE">Active</div>
				    <div class="item" data-value="INACTIVE">Inactive</div>
				  </div>
				</div>
			</div>
			<div class="nine wide field">
				<label>Since:</label>
				<input type="date" name="" id="editStat_date">	
			</div>
			</div>
			<div class="fields">
				<div class="seven wide field"></div>
				<div class="nine wide field">
					<label>IPCR Starts/Started In:</label>
					<input type="date" name="" id="editStat_dateIPCR">	
				</div>
			</div>
		</div>
	</div>
	<div class="actions">
		<button class="ui mini blue button approve">Save</button>
		<button class="ui mini button deny">Cancel</button>
	</div>
</div>

<!-- editStat end -->

<!-- savae msg alert start -->
<div id="saveMsg" class="" style="top: 15px; display: none; position: fixed; z-index: 10; width: 100%; left: 0; text-align: center;">
	<div class="ui center green inverted aligned segment" style="width: 100px; margin-left: auto; margin-right: auto;">
		<i class="checkmark icon"></i> Added!
	</div>
</div>
<!-- savae msg alert end -->
<div id="addModal" class="ui tiny modal">
<!-- <i class="close icon"></i> -->
  <div class="header">
    Add Personnel
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
   <div class="four wide field">
     <label>Gender:</label>
     <select id="genderModal" class="ui fluid dropdown">
     	<option value="">Gender</option>
      <option value="MALE">MALE</option>
   		<option value="FEMALE">FEMALE</option>
     </select>
   </div>
   <div class="four wide field">
   		<label>Status:</label>
    	<select id="statusModal" class="ui fluid dropdown">
    		<option value="">---</option>
    		<option value="ACTIVE">ACTIVE</option>
    		<option value="INACTIVE">INACTIVE</option>
    	</select>
  	</div>
   <div class="six wide field">
   		<label>Since:</label>
   		<input type="date" name="" id="statusDate">
  	</div>
  </div>
  <div class="fields">
   	<div class="five wide field">
   		<label>Employment Status:</label>
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
    	<select id="natureOfAssignmentModal" class="ui fluid dropdown">
    		<option value="">Select Assignment</option>
      	<option value="RANK &	 FILE">RANK AND FILE</option>
   			<option value="SUPERVISORY">SUPERVISORY</option>
     	</select>
  	</div>
  	<div class="five wide field">
   		<label>IPCR Starts/Started In:</label>
   		<input type="date" name="" id="dateIPCR">
  	</div>
  </div>
  <div class="fields">
   	<div class="sixteen wide field">
   		<label>Department:</label>
    	<!-- <input id="departmentModal" type="text" name="department"> -->
				<!-- <input id="departmentModal" list="deptList" name="department" placeholder="Select Department"> -->
				<select id="departmentModal">
					<option value="">Select Department Assigned</option>
				<?php
				require_once "_connect.db.php";
				$resultDepts = $mysqli->query("SELECT * FROM `department` ORDER BY `department` ASC");
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
    	<!-- <input id="postList" type="text" name="position"> -->
			<!-- <input id="positionModal" list="postList" name="position"> -->
			<select id="positionModal">
				<option value="">Select Position</option>
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
    <div class="ui deny button mini">
      Cancel
    </div>
    <div class="ui approve blue right labeled icon button mini">
      Save
      <i class="checkmark icon"></i>
    </div>
  </div>
</div>
	<div class="ui container">

	<div class="ui borderless blue inverted mini menu">
    <div class="left item" style="margin-right: 0px !important;">
      <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
    </div>
	  <div class="item">
	  	<h3><i class="users icon"></i> Employees List</h3>
	  </div>
	  <div class="item" style="margin-right: 10px;" title="Total"><i class="icon large users"></i>TOTAL:<span id="total_rows" style="margin-left: 5px;font-size: 14px;">0</span>
	  </div>
	  <div class="right item">
	  	<button onclick="addModalFunc()" class="green ui icon button" style="margin-right: 10px; width: 100px;" title="Add Personnel">
			<i class="icon user plus"></i> Add
			</button>
			<div class="ui icon input">
			  <input id="employee_search" type="text" placeholder="Search...">
			  <i class="search icon"></i>
			</div>
	  </div>
	</div>

<div class="ui multiple dropdown" id="mulitipleFilters" style="color: white;">
  <input type="hidden" name="filters">
  <button id="clearFilter" style="display: none;" class="ui mini button">Clear</button>
  <i class="filter icon"></i>
  <span class="text">Filter Table</span>
  <div class="menu">
    <div class="ui icon search input">
      <i class="search icon"></i>
      <input type="text" placeholder="Search tags...">
    </div>
    <div class="divider"></div>
    <div class="header">
      <i class="tags icon"></i>
      Tag Label
    </div>
    <div class="scrolling menu">

      <div class="item" data-value="status=ACTIVE">
        <div class="ui green empty circular label"></div>
        Active
      </div>
      <div class="item" data-value="status=INACTIVE">
        <div class="ui black empty circular label"></div>
        Inactive
      </div>
      <div class="item" data-value="gender=MALE">
        <div class="ui blue empty circular label"></div>
        Male
      </div>
      <div class="item" data-value="gender=FEMALE">
        <div class="ui pink empty circular label"></div>
        Female
      </div>
      <div class="item" data-value="type=PERMANENT">
        <div class="ui yellow empty circular label"></div>
        Permanent
      </div>
      <div class="item" data-value="type=CASUAL">
        <div class="ui orange empty circular label"></div>
        Casual
      </div>
      <div class="item" data-value="nature=RANK & FILE">
        <div class="ui green empty circular label"></div>
        Rank & File
      </div>
      <div class="item" data-value="nature=SUPERVISORY">
        <div class="ui purple empty circular label"></div>
        Supervisory
      </div>


<?php
	
	require '_connect.db.php';
	$sql = "SELECT * FROM `department` ORDER BY `department` ASC";
	$result = $mysqli->query($sql);
	while ($row = $result->fetch_assoc()) {
?>

      <div class="item" data-value="<?= "dept_id=".$row['department_id']?>">
        <div class="ui green empty circular label"></div>
        <?= $row['department']?>
      </div>

<?php	}


?>


    </div>
  </div>
</div>

		<table id="employees_table" class="ui small very compact celled selectable striped blue table" style="font-size: 12px;">
			<thead>
				<tr>
					<th colspan="2">Options</th>
					<th>Id</th>
					<th>Name</th>
					<th>Gender</th>
					<th>Department</th>
					<th>Position</th>
					<th>Status</th>
					<th>Assignment</th>
				</tr>
			</thead>
			<tbody id="tableBody">
				<tr id="loading_el">
					<td colspan="10" style="text-align: center; font-size: 32px; color: lightgrey; padding: 100px;"><!-- FETCHING DATA... -->
						<img src="assets/images/loading.gif" style="height: 50px; margin-top: -100px;">
						<br>
						<span>Fetching data...</span>
					</td>
				</tr>
			</tbody>
			<tfoot></tfoot>
		</table>
	</div>




<?php require_once "footer.php";?>

