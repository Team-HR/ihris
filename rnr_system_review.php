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
				<h3><i class="certificate icon"></i> System Review Summary</h3>
			</div>
		</div>
		<!-- starts here -->
		<div class="ui segment">
			<div class="ui centered grid">
				<div class="ui eight wide column">
					<table class="ui mini compact selectable table" width="500">
						<thead>
							<tr>
								<th>#</th>
								<th class="center aligned">Link</th>
								<th>Title</th>
								<th>Year</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td class="center aligned">
									<a class="ui icon basic button" href="rnr_esib_2020.php">
										<i class="ui icon folder green"></i>
									</a>
								</td>
								<td>ESIB</td>
								<td>2020</td>
								<td>Exemplary Service Incentive Bonus</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- ends here -->
	</div>
</div>


<script>
	new Vue({
		el: "#app",
		data() {
			return {
				survey: [{

				}]
			}
		},
		methods: {
			// 
		},
		created() {
			// 
		},
		mounted() {
			// 
		},

	})
</script>

<?php
require "footer.php";
?>