<?php $title = "Capability Development Program"; require_once "header.php"; require_once "_connect.db.php";
$act_id = $_GET["act_id"];
?>

<script type="text/javascript">
	$(document).ready(function() {

		$("#_search").on("keyup", function() {
			var value = $(this).val().toLowerCase();
			$("#tableBody tr").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});

		$(load);

	});

	function load(){
		$("#tableBody").load('lgusponsoredtraining_proc.php',{
			load: true,
			act_id: <?php echo $act_id;?>
		},function(){
			$(loadBudget);
			$(loadYear);
		});
	}

	function loadBudget(){
		$.post('lgusponsoredtraining_proc.php', {
			loadBudget: true,
			act_id: <?php echo $act_id;?>
		}, function(data, textStatus, xhr) {
			$("#allocatedBudget").val(data);
			$("#modal_allocatedBudget_input").val(data);
			$("#allocatedBudget_printOnly").html(data);
		});
	}

	function loadYear(){
		$.post('lgusponsoredtraining_proc.php', {
			loadYear: true,
			act_id: <?php echo $act_id;?>
		}, function(data, textStatus, xhr) {
			$("#loadYear").html(data);
			$("#print_title").html("Capability Development Program "+data);
		});	
	}

	function editBudget(act_id){
		$("#modal_allocatedBudget_edit").modal({
			onApprove: function (){
				$.post('lgusponsoredtraining_proc.php', {
					editAllocatedBudget: true,
					act_id: <?php echo $act_id;?>,
					allocatedBudget: $("#modal_allocatedBudget_input").val(),
				}, function(data, textStatus, xhr) {
					$(load);
				});
			},
		}).modal("show");
	}

	function addNew(act_id){
		$("#modal_addNew").modal({
			closable: false,
			onDeny: function(){
				$(clear);
			},
			onApprove: function(){
				$.post('lgusponsoredtraining_proc.php', {
					addNew: true,
					act_id: <?php echo $act_id;?>,
					activityProcess: $("#add0").val(),
					accountablePerson: $("#add1").val(),
					daysNum: $("#add2").val(),
					paxNum: $("#add3").val(),
					venue: $("#add4").val(),
					date: $("#add5").val(),
					budget: $("#add6").val(),
					expectedOutputs: $("#add7").val(),
					remarks: $("#add8").val(),
				}, function(data, textStatus, xhr) {
					$(load);
					$(clear);
				});
			},
		}).modal("show");
	}

	function deleteFunc(row_id){
		$("#deleteModal").modal({
			onApprove: function(){
				$.post('lgusponsoredtraining_proc.php', {
					deleteFunc: true,
					row_id: row_id,
				}, function(data, textStatus, xhr) {
					$(load);
				});
			}
		}).modal("show");
	}

	function editFunc(row_id){
		// load first the values in each input inside modal
		$.post('lgusponsoredtraining_proc.php', {
			loadInit: true,
			row_id: row_id,
		}, function(data, textStatus, xhr) {
			var array = jQuery.parseJSON(data);
			$("#Edit0").val(array.activityProcess);
			$("#Edit1").val(array.accountablePerson);
			$("#Edit2").val(array.daysNum);
			$("#Edit3").val(array.paxNum);
			$("#Edit4").val(array.venue);
			$("#Edit5").val(array.date);
			$("#Edit6").val(array.budget);
			$("#Edit7").val(array.expectedOutputs);
			$("#Edit8").val(array.remarks);
		});

		$("#modal_edit").modal({
			onApprove: function(){
				$.post('lgusponsoredtraining_proc.php', {
					editFunc: true,
					row_id: row_id,
					activityProcess: $("#Edit0").val(),
					accountablePerson: $("#Edit1").val(),
					daysNum: $("#Edit2").val(),
					paxNum: $("#Edit3").val(),
					venue: $("#Edit4").val(),
					date: $("#Edit5").val(),
					budget: $("#Edit6").val(),
					expectedOutputs: $("#Edit7").val(),
					remarks: $("#Edit8").val(),
				}, function(data, textStatus, xhr) {
					$(load);
				});
			},
		}).modal("show");

	}

	function clear(){
		$("#add0").val("");
		$("#add1").val("");
		$("#add2").val("");
		$("#add3").val("");
		$("#add4").val("");
		$("#add5").val("");
		$("#add6").val("");
		$("#add7").val("");
		$("#add8").val("");
	}
</script>

<!-- add new modal start -->
<div class="ui small modal" id="modal_addNew">
	<div class="header">Add Entry</div>
	<div class="content">
		<div class="ui form">
			<div class="field">
				<label>Activities/Processess:</label>
				<input type="text" placeholder="Activities/Processess..." id="add0" name="">
			</div>
			<div class="fields">
				<div class="seven wide field">
					<label>Accountable Person:</label>
					<input type="text" placeholder="Accountable Person..." id="add1" name="">
				</div>
				<div class="two wide field">
					<label>Days:</label>
					<input type="number" placeholder="0" id="add2" name="">
				</div>
				<div class="two wide field">
					<label>Pax:</label>
					<input type="number" placeholder="0" id="add3" name="">
				</div>
				<div class="seven wide field">
					<label>Venue:</label>
					<input type="text" placeholder="Venue..." id="add4" name="">
				</div>
			</div>
			<div class="fields">
				<div class="six wide field">
					<label>Date:</label>
					<input type="text" placeholder="Date..." id="add5" name="">
				</div>
				<div class="six wide field">
					<label>Budget:</label>
					<input type="text" placeholder="&#8369; Budget..." id="add6" name="">
				</div>
			</div>
			<div class="field">
				<label>Expected Output:</label>
				<input type="text" id="add7" placeholder="Expected Output..." name="">
			</div>
			<div class="field">
				<label>Remarks:</label>
				<input type="text" id="add8" placeholder="Remarks..." name="">
			</div>
		</div>
	</div>
	<div class="actions">
		<div class="ui approve tiny basic button">Save</div>
		<div class="ui cancel tiny basic button">Cancel</div>
	</div>
</div>
<!-- add new modal end -->

<!-- edit modal start -->
<div class="ui small modal" id="modal_edit">
	<div class="header">Edit Entry</div>
	<div class="content">
		<div class="ui form">
			<div class="field">
				<label>Activities/Processess:</label>
				<input type="text" placeholder="Activities/Processess..." id="Edit0" name="">
			</div>
			<div class="fields">
				<div class="seven wide field">
					<label>Accountable Person:</label>
					<input type="text" placeholder="Accountable Person..." id="Edit1" name="">
				</div>
				<div class="two wide field">
					<label>Days:</label>
					<input type="number" placeholder="0" id="Edit2" name="">
				</div>
				<div class="two wide field">
					<label>Pax:</label>
					<input type="number" placeholder="0" id="Edit3" name="">
				</div>
				<div class="seven wide field">
					<label>Venue:</label>
					<input type="text" placeholder="Venue..." id="Edit4" name="">
				</div>
			</div>
			<div class="fields">
				<div class="six wide field">
					<label>Date:</label>
					<input type="text" placeholder="Date..." id="Edit5" name="">
				</div>
				<div class="six wide field">
					<label>Budget:</label>
					<input type="text" placeholder="&#8369; Budget..." id="Edit6" name="">
				</div>
			</div>
			<div class="field">
				<label>Expected Output:</label>
				<input type="text" id="Edit7" placeholder="Expected Output..." name="">
			</div>
			<div class="field">
				<label>Remarks:</label>
				<input type="text" id="Edit8" placeholder="Remarks..." name="">
			</div>
		</div>
	</div>
	<div class="actions">
		<div class="ui approve tiny basic button">Save</div>
		<div class="ui cancel tiny basic button">Cancel</div>
	</div>
</div>
<!-- edit modal end -->

<!-- edit allocated budget start -->
<div class="ui mini modal" id="modal_allocatedBudget_edit">
	<div class="header">Edit Allocated Budget</div>
	<div class="content">
		<div class="ui form">
			<div class="ui labeled input fluid">
				<label for="amount" class="ui label">$</label>
				<input type="text" placeholder="Amount" id="modal_allocatedBudget_input">
			</div>
		</div>
	</div>
	<div class="actions">
		<div class="ui approve tiny basic button">Save</div>
		<div class="ui cancel tiny basic button">Cancel</div>
	</div>
</div>
<!-- edit allocated budget end -->

<!-- delete modal start -->
<div id="deleteModal" class="ui mini modal">
  <i class="close icon"></i>
  <div class="header">
    Delete Entry
  </div>
  <div class="content">
    <p>Are you sure you want to delete this entry?</p>
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
<!-- delete modal end -->

<!-- menu starts here -->
<div class="ui container">
	<div class="ui borderless blue inverted mini menu noprint">
    <div class="left item" style="margin-right: 0px !important;">
      <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
    </div>
		<div class="item">
			<!-- TITLE -->
			<h3><i class="icon book"></i> Capability Development Program <span id="loadYear"></span></h3>
		</div>
		<div class="right item">
			<button class="ui icon mini green button" onclick="addNew('<?php echo $act_id;?>')"><i class="icon plus"></i>Add</button>
			<button class="ui icon blue button" onclick="print()" style="margin-right: 10px; width: 70px;"><i class="icon print"></i> Print</button>
      <div class="ui icon fluid input" style="width: 300px;">
        <input id="_search" type="text" placeholder="Search...">
        <i class="search icon"></i>
      </div>
		</div>
	</div>

</div>
<!-- menu ends here -->

<!-- content here start -->
<div class="ui container">
	<div class="ui basic segment">
		<div class="noprint">
			<label style="color: white;">Allocated Budget: </label>
			<div class="ui right labeled action input">
				<label for="amount" class="ui label">&#8369;</label>
				<input type="text" placeholder="Amount" id="allocatedBudget" readonly="">
				<!-- <div class="ui basic label">.00</div> -->
				<button onclick="editBudget('<?php echo $act_id;?>')" class="ui icon button" title="Edit"><i class="edit outline icon"></i></button>
			</div>
		</div>
		<h4 class="printOnly" id="print_title" style="text-align: center;"></h4>
		<div class="printOnly">
			<label>Allocated Budget: &#8369;</label>
			<tt id=allocatedBudget_printOnly></tt>
		</div>
		<style type="text/css">
		  .headers {
		    padding: 2px !important;
		    font-size: 12px !important;
		  }
		</style>
  		<table class="ui very compact celled structured small selectable table">
			<thead> 
				<tr style="text-align: center;">
					<th class="headers" rowspan="2">Activities/Processess</th>
					<th class="headers" rowspan="2">Accountable Person</th>
					<th class="headers" colspan="3">Activity</th>
					<th class="headers" rowspan="2">Date</th>
					<th class="headers" rowspan="2">Budget</th>
					<th class="headers" rowspan="2">Expected Output</th>
					<th class="headers" rowspan="2">Remarks</th>
					<th class="headers noprint" rowspan="2"></th>
				</tr>
				<tr style="text-align: center;">
					<th class="headers">Days</th>
					<th class="headers">Pax</th>
					<th class="headers">Venue</th>
				</tr>
				</thead>
				<tbody id="tableBody"></tbody>
			</table>
		</div>
	</div>
	<!-- content here end -->


	<?php require_once "footer.php";?>
