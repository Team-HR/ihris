<?php
$title = "Common Trainings";
require_once 'header.php';
?>
<!-- development version, includes helpful console warnings -->
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="moment.js"></script>

<!-- production version, optimized for size and speed -->
<!-- <script src="https://cdn.jsdelivr.net/npm/vue"></script> -->

<div class="ui container">
	<div class="ui borderless blue inverted mini menu noprint">
		<div class="left item" style="margin-right: 0px !important;">
			<button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
				<i class="icon chevron left"></i> Back
			</button>
		</div>
		<div class="item">
			<h3><i class="users icon"></i> Common Trainings</h3>
		</div>
		<div class="right item">

			<div class="ui right input">
				<button onclick="print()" class="green ui icon mini button" title="Print" style="margin-right: 5px;">
					<i class="icon print"></i> Print
				</button>
			</div>
		</div>
	</div>
	<div id="app">
		<div class="ui segment">
				<template v-for="(report,id) in reports" >
					<h4>{{ id+1 }}.) {{ report.title }}</h4>
					<h5>Number of Trainings: {{ report.total }}</h5>
						<table class="ui compact small table">
							<thead>
								<tr>
									<th>#</th>
									<th>Start Date</th>
									<th>End Date</th>
									<th>Hrs</th>
									<th>Venue</th>
									<th>Remarks/Involved</th>
								</tr>
							</thead>
							<tbody>
								<template v-for="(training,id) in report.trainings" >
									<tr>
										<td>{{id+1}}</td>
										<td>{{formatDate(training.startDate)}}</td>
										<td>{{formatDate(training.endDate)}}</td>
										<td>{{training.numHours}}</td>
										<td>{{training.venue}}</td>
										<td>{{training.remarks}}</td>
									</tr>
								</template>
							</tbody>
						</table>
				</template>
		</div>
	</div>
	

</div>

<script>
// $(document).ready(function () {
// 	load();
// });

// function load(){

// }

var app = new Vue({
  el: '#app',
  data: {
    reports: [],
  },
  created: function () {
	this.load()
	// console.log(this.reports);
	// "2016-01-08T00:00:00-06:00"
	this.formatDate('2016-01-01')
  },
  methods: {
	  load: function (){
		$.post("trainingreport_gen_proc.php",{
				load: true
			}, (data)=>{
					this.reports = data
					console.log(this.reports);
					// sorting indexed array start 
					data.sort(function(a,b){
						if(a.total > b.total) return -1;
						if(a.total < b.total) return 1;
						return 0;
					});
					// sorting indexed array end 
					
				},
			"json"
		);
	},
	formatDate: function(date){
		var a = moment(date); 
		return a.format("MMM Do YY")
	}
  },
})
</script>

<?php require_once 'footer.php' ?>