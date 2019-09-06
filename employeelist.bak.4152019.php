<?php $title = "Employee List"; require_once "header.php";?>

<script>
	$(document).ready(function() {
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
		$(load);
		$(getNumOfStatus);
				
	});

	function load(){
			$.post('employeelist_proc.php', {
				load: true
			}, function(data, textStatus, xhr) {
				/*optional stuff to do after success */
				$("#tableBody").html(data);
			});
		}

	function addModalFunc(){
		$("#addModal").modal({
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
			employmentStatusModal: $("#employmentStatusModal").val(),
			natureOfAssignmentModal: $("#natureOfAssignmentModal").val(),
			departmentModal: $("#departmentModal").val(),
			positionModal: $("#positionModal").val(),
		}, function(data, textStatus, xhr) {
				$(clearModal);
				$(load);
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
		$("#employmentStatusModal").dropdown('restore defaults');
		$("#natureOfAssignmentModal").dropdown('restore defaults');
		$("#departmentModal").dropdown('restore defaults');
		$("#positionModal").dropdown('restore defaults');
	}

	function getNumOfStatus(){
		$.post('employeelist_proc.php', {
			getNumOfStatus: true
		}, function(data, textStatus, xhr) {
			var array = jQuery.parseJSON(data);
			$("#numOfActive").html(array.active);
			$("#numOfInactive").html(array.inactive);
		});
	}

	function editStat(employees_id){
// $("#editStat_drop").dropdown();
		$.post('employeelist_proc.php', {
			get_editStat: true,
			employees_id: employees_id
		}, function(data, textStatus, xhr) {
			var array = jQuery.parseJSON(data);
			// alert(array);
				if (array != null) {
					$("#editStat_drop").dropdown({showOnFocus: false,}).dropdown("set selected", array);
				}
		});
		// alert(employees_id);
		
		$("#editStat").modal({
			onApprove: function (){
				$.post('employeelist_proc.php', {
					editStat: true,
					employees_id: employees_id,
					status: $("#editStat_drop").dropdown("get value"),
				}, function(data, textStatus, xhr) {
					$(load);
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
			<div class="field">
				<label>Status:</label>
				<div class="ui selection dropdown" id="editStat_drop">
				  <input type="hidden" name="status">
				  <i class="dropdown icon"></i>
				  <div class="default text">Select Active/Inactive</div>
				  <div class="menu">
				    <div class="item" data-value="ACTIVE">Active</div>
				    <div class="item" data-value="INACTIVE">Inactive</div>
				  </div>
				</div>
			</div>
		</div>
	</div>
	<div class="actions">
		<button class="ui mini basic button approve">Save</button>
		<button class="ui mini basic button deny">Cancel</button>
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
<i class="close icon"></i>
  <div class="header">
    Add New Personnel
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
  </div>
  <div class="fields">
   	<div class="five wide field">
   		<label>Employment Status:</label>
    	<select id="employmentStatusModal" class="ui fluid dropdown">
    		<option value="">Select Status</option>
    		<option value="CASUAL">CASUAL</option>
    		<option value="PERMANENT">PERMANENT</option>
    	</select>
  	</div>
  	<div class="six wide field">
   		<label>Nature of Assignemt:</label>
    	<select id="natureOfAssignmentModal" class="ui fluid dropdown">
    		<option value="">Select Assignment</option>
      	<option value="RANK AND FILE">RANK AND FILE</option>
   			<option value="SUPERVISORY">SUPERVISORY</option>
     	</select>
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
	<div class="ui container" style="min-height: 25000px;">

	<div class="ui borderless blue inverted mini menu">
    <div class="left item" style="margin-right: 0px !important;">
      <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
    </div>
	  <div class="item">
	  	<h3><i class="users icon"></i> Employees List</h3>
	  </div>
	  <div class="item" style="margin-right: 10px;" title="Active Personnel"><i class="icon eye"></i><i id="numOfActive"></i>
	  </div>
	  <div class="item" style="margin-right: 10px;" title="Inactive Personnel"><i class="icon slash eye"></i><i id="numOfInactive"></i>
	  </div>
	  <div class="right item">
	  	<button onclick="addModalFunc()" class="circular blue ui icon button" style="margin-right: 10px;" title="Add New Personnel">
			  <i class="icon user plus"></i>
			</button>
			<div class="ui icon input">
			  <input id="employee_search" type="text" placeholder="Search...">
			  <i class="search icon"></i>
			</div>
	  </div>
	</div>

		<table id="employees_table" class="ui small very compact selectable striped blue table">
			<thead>
				<tr>
					<th></th>
					<th>Id</th>
					<th></th>
					<th>Name</th>
					<th>Department</th>
					<th>Position</th>
				</tr>
			</thead>
			<tbody id="tableBody">
				<tr>
					<td colspan="6" style="text-align: center; font-size: 32px; color: lightgrey; padding: 100px;">FETCHING DATA...</td>
				</tr>
			</tbody>
			<tfoot></tfoot>
		</table>
	</div>




<?php require_once "footer.php";?>

