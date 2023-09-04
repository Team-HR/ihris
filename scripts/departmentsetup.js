$(document).ready(function() {
			  
			  $("#dept_search").on("keyup", function() {
			    var value = $(this).val().toLowerCase();
			    $("#dept_table tr").filter(function() {
			      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			    });
			  });

				$(load);
				$("#newDept").keyup(function(event) {
					/* Act on the event */
					$("#successMsg").hide();
					$("#existingMsg").hide();
				});
				$("#btnAdd").click(function(event) {
					$(addDept);
					// $(addRow);
				});
				$("#clearBtn").click(function(event) {
					/* Act on the event */
					$("#newDept").val("");
				});
	});
	
	function load(){
		$("#tableContent").load("departmentsetup_proc.php",{
			load: true
		});
	}
	
	function addDept(){
		$.post("departmentsetup_proc.php",{
			addDepartment:true,
			newDept: $("#newDept").val()
		},function(data,status){
			// alert(data);
			if (data == 1) {
				$("#successMsg").show();
			} else if (data == 2) {
				$("#existingMsg").show();
			}

			$(load);
			$("#newDept").val("");
		});
	}
	function editDept(department_id,department){
		// alert(department_id+" and "+department);
		$("#editDeptInput").val(department);
		$("#renameModal").modal({
			onApprove: function(){
				// alert($("#editDeptInput").val());
				$.post('departmentsetup_proc.php', {
					editDepartment: true,
					department_id: department_id,
					department: $("#editDeptInput").val(),
				}, function(data, textStatus, xhr) {
					/*optional stuff to do after success */
					// alert(data);
					$(load);
				});

			},
		}).modal('show');

	}
	function deleteRow(department_id){
		$("#deleteModal").modal({
			onApprove: function(){
				$.post('departmentsetup_proc.php', {
					deleteDepartment: true,
					department_id: department_id,
				}, function(data, textStatus, xhr) {
					/*optional stuff to do after success */
					$(load);
				});
			}
		}).modal("show");
	}

	function addModalFunc(){
		$("#addModal").modal("show");
	}