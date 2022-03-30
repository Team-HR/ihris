$(document).ready(function() {
		$("#sidebar1").html($("#rsp_nav"));
		$("#sidebar2").html($("#ld_nav"));
		$("#sidebar3").html($("#spms_nav"));
		$("#sidebar4").html($("#rr_nav"));
		$(load);
	});
	function editModalFunc(){
		$("#editModal").modal({
				onApprove : function() {
	      $("#saveMsg").transition({
	      	animation: 'fly down',
	      	onComplete: function () {
	      		setTimeout(function(){ $("#saveMsg").transition('fly down'); }, 1000);
	      	}
	      });
	    }
		}).modal("show");
	}

	function load(){
		$.post('test.php', {
			loadProfile: true,
			employees_id: <?php echo $employees_id;?>
		}, function(data, textStatus, xhr) {
		});
	}