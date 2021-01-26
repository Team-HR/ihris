<?php
$title = "Personnel Recognition";
require_once 'header.php';
?>

<script type="text/javascript">
	$(document).ready(function() {
		$(loadlist);
		$("#employee_search").on("keyup", function() {
		  var value = $(this).val().toLowerCase();
		  $("#employees_table tr").filter(function() {
		    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		  });
		});
	});

	function loadlist(){
		$.post('personnelrecognition_proc.php', {
			loadlist: true}, function(data, textStatus, xhr) {
			/*optional stuff to do after success */
			$("#tableBody").html(data);
		});
	}

	function addModalFunc(){
		$("#addEntryModal").modal({
			closable: false
		}).modal('show');
	}


	var item  = '<div class="item">'+
	  	'<div class="ui icon fluid input">'+
		  '<input class="inputItem" type="text" placeholder="Enter Award...">'+
		  '<i id="removeInputBtn" class="circular minus link icon" title="Remove" onclick="removeEntry($(this))"></i>'+
		'</div>'+
  	'</div>';

  	var emptyItem = '<div class="item empty"><i style="color: grey;">-- None --</i> </div>';


	function updateFunc(id,name){

		$("#updateID").html(id);
		$("#updateName").html(name);
		$("#recognitionTextarea").val("");

// populate input textarea start
		
		$.post('personnelrecognition_proc.php', {
			loadEntry: true,
			employees_id: id
		}, function(data, textStatus, xhr) {
			arr = $.parseJSON(data);
			listPopulator(arr);		
		});
// populate input textarea end

		$("#updateEntryModal").modal({
			closable: false,
			onApprove: function(){
				var recogs = [];
		
		$.each($(".inputItem"), function(index, val) {
			 if (!isEmptyOrSpaces($(val).val())) {
			 	recogs.push($(val).val());
			 }
		});
	
				$.post('personnelrecognition_proc.php', {
					updateEntry: true,
					employees_id: id,
					recognition: recogs
				}, function(data, textStatus, xhr) {
					$(loadlist);
				});
			}
		}).modal('show');
	}

	function listPopulator(arr){
		$(".listContainer").html("");
		if (arr.length > 0) {
			
			$.each(arr, function(index, val) {
				 $(".listContainer").append(item);
			});	
			$.each($(".inputItem"), function(index, val) {
				 $(this).val(arr[index]);
			});
		} else {
			$(".listContainer").append(emptyItem);
		}
		
	}

	function addEntry(){
		if ($(".empty")) {
			$(".empty").remove();
		}
		var naayEmpty = false;
		$.each($(".inputItem"), function(index, val) {
			 if (isEmptyOrSpaces($(val).val())) {
			 	naayEmpty = true;
			 }
		});
		if (!naayEmpty) {
			$(".listContainer").append(item);
		}
	}

	function removeEntry(el){
		// if (!$(".inputItem")) {
		// 	// $(".listContainer").append(emptyItem);	

		// }
		// console.log($(".listContainer").length);
		var counter = 0;
		$.each($(".inputItem"), function(index, val) {
			counter++;
		});
		console.log(counter);
		if (counter === 1) {
			$(".listContainer").append(emptyItem);
		}
		$(el).parent('div').parent('div').remove();	
	}

// check if string is empty or whitespaces start
	function isEmptyOrSpaces(str){
    	return str === null || str.match(/^ *$/) !== null;
	}
// check if string is empty or whitespaces ends

	
</script>

<div id="updateEntryModal" class="ui tiny modal">
  <div class="header"> <span id="updateID"></span> - <span id="updateName"></span></div>
  <div class="content">

<!-- <textarea id="recognitionTextarea" rows="10" style="width: 100% !important"></textarea> -->


<div class="ui list listContainer">
	
<!--   <div class="item">
  	<div class="ui icon fluid input">
	  <input type="text" placeholder="Enter Award...">
	  <i class="circular minus link icon" title="Remove"></i>
	</div>
  </div>
  <div class="item">
  	<div class="ui icon fluid input">
	  <input type="text" placeholder="Enter Award...">
	  <i class="circular minus link icon" title="Remove"></i>
	</div>
  </div> -->
</div>
<button onclick="addEntry()" class="ui basic circular icon button"><i class="icon plus"></i> Add </button>

  </div>
  <div class="actions">
  	<div class="ui mini approve blue button"><i class="icon check"></i> Save</div>
    <div class="ui mini deny red button"><i class="icon times"></i> Cancel</div>
  </div>
</div>

<div class="ui basic segment" style="">

	<div class="ui borderless blue inverted mini menu">
    <div class="left item" style="margin-right: 0px !important;">
      <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
    </div>
	  <div class="item">
	  	<h3><i class="certificate icon"></i> Personnel Recognition</h3>
	  </div>
	  <!-- <div class="item" style="margin-right: 10px;" title="Total"><i class="icon large users"></i>
	  	TOTAL:<span id="total_rows" style="margin-left: 5px;font-size: 14px;">0</span>
	  </div> -->
	  <div class="right item" style="width: 500px;">
<!-- 	  	<button onclick="addModalFunc()" class="green ui icon button" style="margin-right: 10px; width: 100px;" title="Add Entry">
			<i class="icon certificate"></i> Add
			</button> -->
			<div class="ui icon input">
			  <input id="employee_search" type="text" placeholder="Search Employee...">
			  <i class="search icon"></i>
			</div>
	  </div>
	</div>


		<table id="employees_table" class="ui small very compact celled selectable striped blue table" style="font-size: 12px;">
			<thead>
				<tr>
					<th class="center aligned">Id</th>
					<th></th>
					<th>Name</th>
					<th>Recognition</th>
					<th>Position</th>
					<th>Department</th>
					
				</tr>
			</thead>
			<tbody id="tableBody">
				<tr id="loading_el">
					<td colspan="6" style="text-align: center; font-size: 32px; color: lightgrey; padding: 100px;"><!-- FETCHING DATA... -->
						<img src="assets/images/loading.gif" style="height: 50px; margin-top: -100px;">
						<br>
						<span>Fetching data...</span>
					</td>
				</tr>
			</tbody>
			<tfoot></tfoot>
		</table>
	</div>

<?php
require_once 'footer.php';
?>