<!DOCTYPE>
<html>
<head>
	<title></title>
</head>
<body style="text-align:center;">
	<h3 id="cont">
	<span id="done">done</span>
	left of
	<span id="not">not</span>
	</h3>
</body>

  <script src="../jquery/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
	(function(){
		'use strict'
		function _(el){
			return document.getElementById(el);
		}
		function checkEmpty(){
			$.post('config.php',{
				checkEmpty:true,
			},function(data,textStatus,xhr){
				_('not').innerHTML = data;
				if(data>0){
					checkLeft();
					editApp();
				}				
			});
		}
		function checkLeft(){
			var countLeft = setInterval(function(){
			$.post('config.php',{
				checkEmpty:true,
			},function(data,textStatus,xhr){
				if(data==0){
					clearInterval(countLeft);
				}
				console.log(data);
				_('done').innerHTML = data;
			})
			},100);
		}
		function editApp(){
			$.post('config.php',{
				aditApp:true,
			},function(data,textStatus,xhr){
				console.log(data);
			});
		}
		var load = setInterval(function(){
		 	console.log(document.readyState);
		 	if(document.readyState == "complete"){
		 		clearInterval(load);
		 		checkEmpty();
		 	}
		},100);
	})();
</script>
</html>