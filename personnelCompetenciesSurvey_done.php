<!DOCTYPE html>
<html>
<head>
	<title>Survey Completed!</title>
	 <meta charset="UTF-8" name="google" value="notranslate" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	 <meta name="viewport" content="width=device-width, initial-scale=1">
	 <link rel="stylesheet" type="text/css" href="ui/dist/semantic.min.css">
	 <script src="jquery/jquery-3.3.1.min.js"></script>
	 <script src="ui/dist/semantic.min.js"></script>
</head>
<body>
<script type="text/javascript">
	$(document).ready(function() {
		history.pushState(null, null, location.href);
	    window.onpopstate = function () {
	        history.go(1);
	    };
	});

	function goBack(){
		window.location.href = "personnelCompetenciesSurvey.php";
	}
</script>

<div class="ui container center aligned" style="margin-top: 100px;">
	
	<h1 class="ui header block green"><i class="icon check"></i> Survey Completed!</h1>
	<div class="ui segment">
		<p>Form successfully submitted for analysis. Thank you for completing the survey. You may now close this page or have another personnel take the survey.</p>
		<button class="ui button green" onclick="goBack()">Back to Survey</button>
	</div>
</div>

</body>
<p class="noprint" style="margin: 50px; text-align: center; color: grey; font-size: 8px;">
	Human Resource Information System ©2018 HRMO LGU Bayawan City
</p>
</html>