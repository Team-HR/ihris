<?php
$title = "R&R System Review";
require "header.php";
?>

<div id="app" class="ui container">
	<div class="ui basic segment">
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
			<div class="ui two cards">
				<div class="card" v-for="(item, index) in data" :key="index">
					<div class="content">
						<div class="header">{{item[14]?item[14]:'Anonymous'}}</div>
						<div class="meta"><b>{{item[15]}}</b> {{item[16]}}</div>
						<div class="description">
							<template v-for="(qs, i) in questions">
								<div v-if="i <= 5">
									<p :key="i">{{qs}} <b style="color: green;">{{item[i]}}</b></p>
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
			}
		},
		created() {
			this.get_data()
		},
		beforeMount() {},
		mounted() {

		},
	})
	$(document).ready(function() {
		// $('.rating').rating({
		// 	maxRating: 5
		// });
	});
</script>

<?php
require "footer.php";
?>