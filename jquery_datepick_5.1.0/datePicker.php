<link href="jquery_datepick_5.1.0/css/redmond.datepick.css" rel="stylesheet">	
<script src="jquery_datepick_5.1.0/js/jquery.plugin.min.js"></script>
<script src="jquery_datepick_5.1.0/js/jquery.datepick.js"></script>

<script type="text/javascript">
$(document).ready(function() {
$('.datepickerBtn').datepick({
	showOnFocus: false,
	dateFormat: 'yyyy-mm-dd',
	multiSelect: 999,
		onSelect: function (){
			dates = $(this).datepick("getDate");
			arr = [];
			for (var i = 0; i < dates.length; i++) { 
				arr.push($.datepick.formatDate('yyyy-mm-dd',dates[i])); 
			} 
			console.log(arr);
			// alert(arr);
			$.post('test2_proc.php', {
				compactDates: true,
				dates: arr,
			}, function(data, textStatus, xhr) {
				// json = $.parseJSON(data);
				$(".dateContainer").html(data);
			});

		},
    	showTrigger: '<button type="button" class="trigger">' + 
    '<img src="jquery_datepick_5.1.0/img/calendar.gif" alt="Popup"></button>'
	});
});
</script>