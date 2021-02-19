<?php
$title = "R&R System Review";
require "header.php";
?>

<div id="app" class="ui container">
	<div class="ui segment">
		<div class="ui borderless blue inverted mini menu">
			<div class="left item" style="margin-right: 0px !important;">
				<button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
					<i class="icon chevron left"></i> Back
				</button>
			</div>
			<div class="item">
				<h3><i class="certificate icon"></i> ESIB Survey 2020</h3>
			</div>
		</div>

		<!-- start here -->
		<template>

			<!-- <div class="two wide column"><canvas id="AdaptabilityBarChart" style="height: 50px;"></canvas></div> -->
			<h1 class="ui header block">Total Respondents: {{data.length}}</h1>
			<table class="ui compact table">
				<thead>
					<tr>
						<th>Question</th>
						<th>Yes</th>
						<th>No</th>
						<th>Preferred not to answer</th>
					</tr>
				</thead>
				<tbody>
					<template v-for="(qs, k) in questions">
						<tr :key="k" v-if="k <= 5">
							<td>{{qs}}</td>
							<td>{{get_percentage(data2.datus[k].yes)}}</td>
							<td>{{get_percentage(data2.datus[k].no)}}</td>
							<td>{{get_percentage(data2.datus[k].no_answer)}}</td>
						</tr>
					</template>
				</tbody>
			</table>

			<h3 class="ui header block">Effects on Performance</h3>


			<!-- <div class="ui grid">
				<div class="eight wide column"><canvas id="AdaptabilityBarChart" style="height: 50px;"></canvas></div>
			</div> -->


			<table class="ui compact table">
				<thead>
					<tr>
						<th>Performance</th>
						<th>Poor</th>
						<th>Usatisfactory</th>
						<th>Satisfactory</th>
						<th>Very Satisfactory</th>
						<th>Outstanding</th>
					</tr>
				</thead>
				<tbody>
					<template v-for="(perf, p) in performances">
						<tr :key="p" >
							<td>{{perf}}</td>
							<td>{{get_percentage(data2.performances[p][1])}}</td>
							<td>{{get_percentage(data2.performances[p][2])}}</td>
							<td>{{get_percentage(data2.performances[p][3])}}</td>
							<td>{{get_percentage(data2.performances[p][4])}}</td>
							<td>{{get_percentage(data2.performances[p][5])}}</td>
						</tr>
					</template>
				</tbody>
			</table>

			<h3 class="ui header block">Impacts on Employees</h3>
			<table class="ui compact table">
				<thead>
					<tr>
						<th></th>
						<th>Decreased</th>
						<th>No Impact</th>
						<th>Increased</th>
					</tr>
				</thead>
				<tbody>
					<template v-for="(perf, l) in impacts">
						<tr :key="l">
							<td>{{perf}}</td>
							<td>{{get_percentage(data2.impacts[l][1])}}</td>
							<td>{{get_percentage(data2.impacts[l][2])}}</td>
							<td>{{get_percentage(data2.impacts[l][3])}}</td>
						</tr>
					</template>
				</tbody>
			</table>

		<h2>Respondents:</h2>

			<div class="ui two cards">
				<div class="card" v-for="(item, index) in data" :key="index">
					<div class="content">
						<div class="header">{{item[14]?item[14]:'Anonymous'}}</div>
						<div class="meta"><span>{{item[15]?item[15]+" employee":""}}</span> {{item[16]?"from "+item[16]:""}}</div>
						<div class="description">
							<template v-for="(qs, i) in questions">
								<div v-if="i <= 5">
									<p v-if="i == 2 && item[1] == 'No' || i == 3 && item[1] == 'No'" :key="i"></p>
									<p v-else-if="i == 4 && item[4] != 'Yes' || i == 5 && item[5] != 'Yes'" :key="i">
										{{qs}} <b style="color: green;">No, {{item[i]}}</b>
									</p>
									<p v-else :key="i">{{qs}} <b style="color: green;">{{item[i]}}</b></p>
								</div>
								<div v-else-if="i == 6">
									<p :key="i">{{qs}}</p>
									<table class="ui compact table">
										<tbody>
											<tr>
												<td>Dependability</td>
												<td>
													<!-- <div class="ui red rating" data-icon="heart" :data-rating="item[6]"></div> -->
													<div class="ui red rating disabled">
														<i class="heart icon" :class="item[6]>=1?'active':''"></i>
														<i class="heart icon" :class="item[6]>=2?'active':''"></i>
														<i class="heart icon" :class="item[6]>=3?'active':''"></i>
														<i class="heart icon" :class="item[6]>=4?'active':''"></i>
														<i class="heart icon" :class="item[6]>=5?'active':''"></i>
													</div>
												</td>
											</tr>
											<tr>
												<td>Cooperation</td>
												<td>
													<!-- <div class="ui red rating" data-icon="heart" :data-rating="item[7]"></div> -->
													<div class="ui red rating disabled">
														<i class="heart icon" :class="item[7]>=1?'active':''"></i>
														<i class="heart icon" :class="item[7]>=2?'active':''"></i>
														<i class="heart icon" :class="item[7]>=3?'active':''"></i>
														<i class="heart icon" :class="item[7]>=4?'active':''"></i>
														<i class="heart icon" :class="item[7]>=5?'active':''"></i>
													</div>
												</td>
											</tr>
											<tr>
												<td>Commitment</td>
												<td>
													<!-- <div class="ui red rating" data-icon="heart" :data-rating="item[8]"></div> -->
													<div class="ui red rating disabled">
														<i class="heart icon" :class="item[8]>=1?'active':''"></i>
														<i class="heart icon" :class="item[8]>=2?'active':''"></i>
														<i class="heart icon" :class="item[8]>=3?'active':''"></i>
														<i class="heart icon" :class="item[8]>=4?'active':''"></i>
														<i class="heart icon" :class="item[8]>=5?'active':''"></i>
													</div>
												</td>
											</tr>
											<tr>
												<td>Initiative</td>
												<td>
													<!-- <div class="ui red rating" data-icon="heart" :data-rating="item[9]"></div> -->
													<div class="ui red rating disabled">
														<i class="heart icon" :class="item[9]>=1?'active':''"></i>
														<i class="heart icon" :class="item[9]>=2?'active':''"></i>
														<i class="heart icon" :class="item[9]>=3?'active':''"></i>
														<i class="heart icon" :class="item[9]>=4?'active':''"></i>
														<i class="heart icon" :class="item[9]>=5?'active':''"></i>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div v-else-if="i == 7">
									<p :key="i">{{qs}}</p>
									<table class="ui compact table">
										<tbody>
											<tr>
												<td>Morale</td>
												<td>
													<!-- <div class="ui red rating" data-icon="heart" :data-rating="item[10]"></div> -->
													<b v-if="item[10] == 3" style="color: green;">
														<i class="ui angle double up icon green"></i> Increase
													</b>
													<b v-else-if="item[10] == 2" style="color: grey;">
														<i class="ui circle outline icon grey"></i> Neutral
													</b>
													<b v-else-if="item[10] == 1" style="color: red;">
														<i class="ui angle double down icon red"></i> Decrease
													</b>
													<b v-else style="color: grey;">
														<i class="ui circle outline icon grey"></i> Neutral
													</b>
												</td>
											</tr>
											<tr>
												<td>Motivation</td>
												<td>
													<!-- <div class="ui red rating" data-icon="heart" :data-rating="item[11]"></div> -->
													<b v-if="item[11] == 3" style="color: green;">
														<i class="ui angle double up icon green"></i> Increase
													</b>
													<b v-else-if="item[11] == 2" style="color: grey;">
														<i class="ui circle outline icon grey"></i> Neutral
													</b>
													<b v-else-if="item[11] == 1" style="color: red;">
														<i class="ui angle double down icon red"></i> Decrease
													</b>
													<b v-else style="color: grey;">
														<i class="ui circle outline icon grey"></i> Neutral
													</b>
												</td>
											</tr>
											<tr>
												<td>Productivity</td>
												<td>
													<!-- <div class="ui red rating" data-icon="heart" :data-rating="item[12]"></div> -->
													<b v-if="item[12] == 3" style="color: green;">
														<i class="ui angle double up icon green"></i> Increase
													</b>
													<b v-else-if="item[12] == 2" style="color: grey;">
														<i class="ui circle outline icon grey"></i> Neutral
													</b>
													<b v-else-if="item[12] == 1" style="color: red;">
														<i class="ui angle double down icon red"></i> Decrease
													</b>
													<b v-else style="color: grey;">
														<i class="ui circle outline icon grey"></i> Neutral
													</b>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div v-else-if="i == 8">
									<p :key="i">{{qs}}</p>
									<p style="color:green;"><i>{{item[13]?item[13]:'None'}}</i></p>
								</div>
							</template>
						</div>
					</div>
				</div>
			</div>
		</template>



		<!-- end here -->
	</div>
</div>


<script>
	new Vue({
		el: "#app",
		data() {
			return {
				data: [],
				data2: [],
				configs: [],
				performances: [
					"Dependability",
					"Cooperation",
					"Commitment",
					"Initiative",
				],
				impacts: [
					"Morale",
					"Motivation",
					"Productivity",
				],
				questions: [
					"Are you aware of the Ordinance authorizing the grant and prescribing the guidelines of the exemplary Service Incentive?",
					"Have you read the guidelines in the granting of incentive bonus?",
					"Are the guidelines clear and agreeable?",
					"Is the guidelines fair to all?",
					"Are you satisfied with the ratings you received from your superior?",
					"Do you think the overall ranking is fair & objective?",
					"How does the grant of incentives affect your job performance?",
					"What are your general observation of the impact of the grant?",
					"Any recommendation/suggestion to further improve the system?"
				]
			}
		},
		methods: {
			get_data() {
				$.post("rnr_system_review_proc.php", {
						get_data: true,
					}, (data, textStatus, jqXHR) => {
						console.log(data)
						this.data = Object.assign([], data)
					},
					"json"
				);
			},
			get_data_summary() {
				// $.post("rnr_system_review_proc.php", {
				// 		get_data_summary: true,
				// 	}, (data, textStatus, jqXHR) => {
				// 		console.log(data)
				// 		this.data2 = Object.assign([], data)
				// 	},
				// 	"json",
				// 	async: false
				// );
				$.ajax({
					type: "POST",
					url: "rnr_system_review_proc.php",
					data: {
						get_data_summary: true
					},
					dataType: "json",
					success: (response) => {
						this.data2 = Object.assign([], response)
						console.log(response);
					},
					async: false

				});
			},
			get_percentage(num) {

				if (num) {
					var percent = ((num / this.data.length) * 100).toFixed(0)
					return percent + "%"
				}
				return "0%"

			}
		},
		created() {
			this.get_data()
			this.get_data_summary()
		},
		mounted() {
			var ctx2 = $("#AdaptabilityBarChart");

			this.data2.performances.forEach((element, key) => {

				var config2 = {
					type: 'bar',
					data: {
						labels: [
							"Poor ",
							"Usatisfactory ",
							"Satisfactory ",
							"Very Satisfactory ",
							"Outstanding "
						],
						datasets: [{
							label: this.performances[0],
							data: [3, 1, 3, 2, 5],
							backgroundColor: [
								'rgba(255, 99, 132, 0.2)',
								'rgba(255, 206, 86, 0.2)',
								'rgba(75, 192, 192, 0.2)',
								'rgba(54, 162, 235, 0.2)',
								'rgba(153, 102, 255, 0.2)',

							],
							borderColor: [
								'rgba(255, 99, 132, 1)',
								'rgba(255, 206, 86, 1)',
								'rgba(75, 192, 192, 1)',
								'rgba(54, 162, 235, 1)',
								'rgba(153, 102, 255, 1)',

							],
							fill: true,
							borderWidth: 2,
						}]
					},
					options: {
						scales: {
							yAxes: [{
								scaleLabel: {
									display: true,
									labelString: 'Number of Personnels'
								},
								ticks: {
									display: false,
									beginAtZero: true,
									// max: 100,
									stepSize: 1
								}
							}],

						}, //end of scales

						title: {
							display: true,
							text: "Dependability",
							fontSize: 20
						},
						legend: {
							display: false,
						},

					},

				};


				this.configs.push = config2;
			});



			ldnLsaBarCharts = new Chart(ctx2, this.configs[0]);

		},

	})

	$(document).ready(function() {


	});
</script>

<?php
require "footer.php";
?>