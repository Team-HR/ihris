<?php 
if (isset($_GET['rec'])) {
		if ($_GET['rec']=="") {
				header("location:?");	
		}
}
require_once "_connect.db.php";
$title = "Turn Around Time";
require_once "header.php";

 ?>

 <script type="text/javascript"></script>

 <div class="ui container">
 	<?php 
 		if (isset($_GET['rec'])) {
 			require_once "umbra/tot/rec.tot.php";
 		}else{
 			require_once "umbra/tot/index.tot.php";
 		}


 	 ?>
 </div>






 <?php require_once "footer.php"; ?>