<?php 

$title = "Coaching and Monitoring Report";
require_once "header.php";
require_once "_connect.db.php";
?>
	<script type="text/javascript" src="umbra/cmr/cmr.js"></script> 
	<script type="text/javascript">
		$(document).ready(function() {
			$("#gender_drop").dropdown();
	});	
	</script>

	<div class="ui container">
		<?php
			if(isset($_GET['cmReport'])){
				require_once 'umbra/cmr/report.cmr.php';
			}else{
				require_once 'umbra/cmr/index.cmr.php';
			}
		?>
	</div>
<?php require_once "footer.php";?>
