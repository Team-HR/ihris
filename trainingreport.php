<?php 
$title = "Training Report"; 
require_once "header.php";
?>
<script type="text/javascript">

	var json = [];
	var ldnLsaCharts;
	var ldnLsaCharts2;
	var ldnLsaCharts_total;
	var ldnLsaCharts2_total;
	$(document).ready(function() {
		
		var sortBbyDept = "all",
		departmentText = "All Departments",
		sortBbyYear = "all",
		loading_el = $("#loading_el"),
		tbody = $("#tbody");
		// $("#reportDepartment").html("All Departments");
		tbody.html(loading_el.show());

		$(load(sortBbyDept,sortBbyYear));

		$("#sortYear").dropdown({
			onChange: function(value,text){
				ldnLsaCharts.destroy();
				ldnLsaCharts_total.destroy();
				ldnLsaCharts2.destroy();
				ldnLsaCharts2_total.destroy();
				tbody.html(loading_el.show());
				sortBbyYear = value;
				console.log('check', sortBbyDept+" and "+sortBbyYear);
				if (sortBbyDept === "all" && sortBbyYear !== "all") {
					$("#reportDepartment").html(departmentText + " of "+ sortBbyYear);
				} else if(sortBbyDept !== "all" && sortBbyYear === "all"){
					$("#reportDepartment").html(departmentText + " of all years");
				} else if (sortBbyDept !== "all" && sortBbyYear !== "all") {
					$("#reportDepartment").html(departmentText +" of "+ sortBbyYear);
				} else {
					$("#reportDepartment").html(departmentText + " of all years");
				}
				load(sortBbyDept,sortBbyYear);
				}
			});
		$("#sortDept").dropdown({
			onChange: function(value,text){
				ldnLsaCharts.destroy();
				ldnLsaCharts_total.destroy();
				ldnLsaCharts2.destroy();
				ldnLsaCharts2_total.destroy();
				tbody.html(loading_el.show());
				sortBbyDept = value;
				if (text !== "all") {
					departmentText = text;
				} else {
					departmentText = "All Departments";	
				}
				
				load(sortBbyDept,sortBbyYear);
				if (sortBbyYear !== "all") {
					html = departmentText + " of "+sortBbyYear;
					console.log(sortBbyYear)
				} else {
					html = departmentText + " of all years";
				}
				$("#reportDepartment").html(html);
			}
		});
	});
	
	function load (department_id, year) {
  		

		$.post('trainingreport_proc.php', {
			load_graph: true,
			department_id: department_id,
			year: year,
		}, function(data, textStatus, xhr) {
			/*optional stuff to do after success */
			json = $.parseJSON(data);
			console.log(json[0]);
			console.log([json[0][0]+json[0][1],json[0][2]+json[0][3]]);
			

var ctx = $("#graph_permanent");
var ctx_total = $("#graph_permanent_total");
var ctx2 = $("#graph_casual");
var ctx2_total = $("#graph_casual_total");
var config = {
				type: 'horizontalBar',
                        data: {
                            labels: [
                            "Male w/ TR",
                            "Female w/ TR",
                            "Male w/o TR",
                            "Female w/o TR",
                            ],
                            datasets: [{
                                label: 'Personnels',
                                data: json[0],
                                backgroundColor: [
                                  '#4075a9',
                                  '#4075a9',
                                  '#989da2',
                                  '#989da2',
                                ],
                                borderColor: [
                                // '#00000',
                                // '#00000',
                                // '#055bc8',
                                // '#055bc8',
                                ],
                                fill: true,
                                borderWidth: 2,
                            }]
                        },
                        options: {
                            
                                title: {
                                    display: true,
                                    text: "Permanent With and Without Trainings (M/F)"
                                },
                                legend: {
                                    display: false,  
                                },
								scales:{
									xAxes:[{
										ticks:{
											beginAtZero: true
										}
									}]
								}
    }
};
var config_total = {
				type: 'horizontalBar',
                        data: {
                            labels: [
                            "Employees w/ TR",
                            "Employees w/o TR",
                            ],
                            datasets: [{
                                label: 'Personnels',
                                data: [json[0][0]+json[0][1],json[0][2]+json[0][3]],
                                backgroundColor: [
                                  '#4075a9',
                                  '#4075a9',
                                ],
                                borderColor: [
                                // '#00000',
                                // '#00000',
                                ],
                                fill: true,
                                borderWidth: 2,
                            }]
                        },
                        options: {
                            
                                title: {
                                    display: true,
                                    text: "Permanent Employees With vs Without Trainings"
                                },
                                legend: {
                                    display: false,  
                                },
								scales:{
									xAxes:[{
										ticks:{
											beginAtZero: true
										}
									}]
								}
    }
};
var config2 = {
				type: 'horizontalBar',
                        data: {
                            labels: [
                            "Male w/ TR",
                            "Female w/ TR",
                            "Male w/0 TR",
                            "Female w/0 TR",
                            ],
                            datasets: [{
                                label: 'Personnels',
                                data: json[1],
                                backgroundColor: [
                                  '#4075a9',
                                  '#4075a9',
                                  '#989da2',
                                  '#989da2',
                                ],
                                borderColor: [
                                // '#00000',
                                // '#00000',
                                // '#055bc8',
                                // '#055bc8',
                                ],
                                fill: true,
                                borderWidth: 2,
                            }]
                        },
                        options: {
                            
                                title: {
                                    display: true,
                                    text: "Casual With and Without Trainings (M/F)"
                                },
                                legend: {
                                    display: false,  
                                },
								scales:{
									xAxes:[{
										ticks:{
											beginAtZero: true
										}
									}]
								}
    }
};
var config2_total = {
				type: 'horizontalBar',
                        data: {
                            labels: [
                            "Employees w/ TR",
                            "Employees w/o TR",
                            ],
                            datasets: [{
                                label: 'Personnels',
                                data: [json[1][0]+json[1][1],json[1][2]+json[1][3]],
                                backgroundColor: [
                                  '#4075a9',
                                  '#4075a9',
                                ],
                                borderColor: [
                                // '#00000',
                                // '#00000',
                                ],
                                fill: true,
                                borderWidth: 2,
                            }]
                        },
                        options: {
                            
                                title: {
                                    display: true,
                                    text: "Casual Employees With vs Without Trainings"
                                },
                                legend: {
                                    display: false,  
                                },
								scales:{
									xAxes:[{
										ticks:{
											beginAtZero: true
										}
									}]
								}
    }
};
	ldnLsaCharts = new Chart(ctx, config);
	ldnLsaCharts_total = new Chart(ctx_total, config_total);
	ldnLsaCharts2 = new Chart(ctx2, config2);
	ldnLsaCharts2_total = new Chart(ctx2_total, config2_total);

		});


		$("#tbody").load('trainingreport_proc.php',{
			load: true,
			department_id: department_id,
			year: year
		} ,
		function(){
			/* Stuff to do after the page is loaded */
			$(load2(department_id));
		});	
	}

	function load2 (department_id){
		$("#load2Container").load('trainingreport_proc.php',{
			load2: true,
			department_id: department_id
		} ,
		function(){
			/* Stuff to do after the page is loaded */
		});

	}

</script>
<div class="ui container">
	<div class="ui borderless blue inverted mini menu noprint">
		<div class="left item" style="margin-right: 0px !important;">
			<button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
				<i class="icon chevron left"></i> Back
			</button>
		</div>
		<div class="item">
			<h3><i class="users icon"></i> Training Report</h3>
		</div>
		<div class="right item">

			<div class="ui right input">
				<a href="trainingreport_gen.php" class="green ui icon mini button" title="Generate Report" style="margin-right: 5px;">
					<i class="icon print"></i> Common Trainings
				</a>
				<button onclick="print()" class="green ui icon mini button" title="Print" style="margin-right: 5px;">
					<i class="icon print"></i> Print
				</button>

				<select id="sortYear" class="ui dropdown"> 
					<option value="">Filter by Year</option>
					<option value="all">All</option>
					<?php
					include "_connect.db.php";
					$sql = "SELECT DISTINCT year(startDate) AS year FROM `personneltrainings` UNION SELECT DISTINCT year(fromDate) AS year FROM `requestandcoms` ORDER BY year DESC";
					$result = $mysqli->query($sql);
					while ($row = $result->fetch_assoc()) {
						$year = $row["year"];
						echo "<option value=\"$year\">$year</option>";
					}
					?>
				</select>

				<div style="width: 500px; margin-left: 10px;">
					<select id="sortDept" class="ui compact fluid dropdown">
						<option value="">Filter by Department</option>
						<option value="all">All</option>
						<?php
			// include "_connect.db.php";
						$sql = "SELECT * FROM `department`";
						$result = $mysqli->query($sql);
						while ($row = $result->fetch_assoc()) {
							$department_id = $row["department_id"];
							$department = $row["department"];
							echo "<option value=\"$department_id\">$department</option>";
						}
						?>
					</select>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="" style="padding: 20px;">




	<h2 class="ui header center aligned" id="reportDepartment" style="color: white;">All Departments of all years</h2>

<!-- graph start -->

	<div class="ui grid">
	  <div class="eight wide column">
	  	<div class="ui segment">
	  		<canvas id="graph_permanent_total" height="70"></canvas>
	  	</div>
	  	<div class="ui segment">
	  		<canvas id="graph_permanent" height="70"></canvas>
	  	</div>
	  </div>
	  <div class="eight wide column">
	  <div class="ui segment">
	  		<canvas id="graph_casual_total" height="70"></canvas>
	  	</div>
	  	<div class="ui segment">
	  		<canvas id="graph_casual" height="70"></canvas>
	  	</div>
	  </div>
	</div>
<!-- graph end -->


	<div id="tbody"></div>
	<br>
	<!-- <div id="load2Container"></div> -->
</div>

		<div id="loading_el" class="ui container" style="display: none;">
			<div style="text-align: center; font-size: 32px; color: lightgrey; padding: 100px;"><!-- FETCHING DATA... -->
				<img src="assets/images/loading.gif" style="height: 50px; margin-top: -100px; margin-bottom: 20px; margin-left: 10px;">
				<br>
				<span>Generating Table...</span>
			</div>
		</div>

<script type="text/javascript">



</script>


<?php 
require_once "footer.php";
?>







