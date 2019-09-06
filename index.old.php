<?php
	// Initialize the session
	session_start();

	// Check if the user is logged in, if not then redirect him to login page
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	  header("location: login.php");
	  exit;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	 <meta charset="UTF-8" name="google" value="notranslate" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	 <meta name="viewport" content="width=device-width, initial-scale=1">
	 <link rel="stylesheet" type="text/css" href="ui/dist/semantic.min.css">
	 <script src="jquery/jquery-3.3.1.min.js"></script>
	 <script src="ui/dist/semantic.min.js"></script>
</head>
<body>
<?php
	require_once "navbar.php";
?>




</body>
</html>
