<?php
$title = "Personnel Recognition";
require_once 'header.php';
?>
<div id="app">
	<div id="updateEntryModal" class="ui tiny modal">
		<!-- <div class="header"> <span id="updateID"></span> - <span id="updateName"></span></div> -->
		<div class="header"> {{edited_employee.emp_id}} - {{edited_employee.fullName }}</div>
		<div class="content">
			<div class="ui list listContainer">
				<template>
					<div v-for="(rec,index) in edited_entries" :key="index" class="item">
						<div class="ui fluid action input">
							<button class="ui basic icon mini button" @click="moveUp(index)"><i class="ui circular arrow up icon link"></i></button>
							<button class="ui basic icon mini button" @click="moveDown(index)"><i class="ui circular arrow down icon link"></i></button>
							<input v-model="edited_entries[index]" class="right attached" type="text" placeholder="Search...">
							<button class="ui basic icon mini button" @click="removeEntry(index)"><i class="ui circular minus icon link"></i></button>
						</div>
					</div>
				</template>
			</div>
			<button @click="addEntry()" class="ui basic circular icon button"><i class="icon plus"></i> Add </button>
		</div>
		<div class="actions">
			<div class="ui mini approve blue button"><i class="icon check"></i> Save</div>
			<div class="ui mini deny red button"><i class="icon times"></i> Cancel</div>
		</div>
	</div>
	<div class="ui basic segment">
		<div class="ui borderless blue inverted mini menu">
			<div class="left item" style="margin-right: 0px !important;">
				<button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
					<i class="icon chevron left"></i> Back
				</button>
			</div>
			<div class="item">
				<h3><i class="certificate icon"></i> Personnel Recognition</h3>
			</div>
			<div class="right item" style="width: 500px;">
				<div class="ui icon input">
					<input id="employee_search" type="text" placeholder="Search Employee...">
					<i class="search icon"></i>
				</div>
			</div>
		</div>
		<table id="employees_table" class="ui small very compact celled selectable striped blue table" style="font-size: 12px;">
			<thead>
				<tr>
					<th class="center aligned">Id</th>
					<th></th>
					<th>Name</th>
					<th>Award/s and Recognition/s</th>
					<th>Position</th>
					<th>Department</th>
				</tr>
			</thead>
			<tbody id="tableBody">
				<!-- <tr id="loading_el">
				<td colspan="6" style="text-align: center; font-size: 32px; color: lightgrey; padding: 100px;">
					<img src="assets/images/loading.gif" style="height: 50px; margin-top: -100px;">
					<br>
					<span>Fetching data...</span>
				</td>
			</tr> -->
				<template v-for="(employee,i) in employees">
					<tr :key="employee.emp_id">
						<td>{{employee.emp_id}}</td>
						<td class="ui center aligned" style="white-space: nowrap;"> <button class="ui green mini button" @click="edit(i)"><i class="ui edit icon"></i> Edit</button> </td>
						<td>{{employee.fullName}}</td>
						<td>
							<ol>
								<li v-for="(award,index) in employee.recs" :key="index">{{award}}</li>
							</ol>
						</td>
						<td>{{employee.position}}</td>
						<td>{{employee.department}}</td>
					</tr>
				</template>
			</tbody>
			<tfoot></tfoot>
		</table>
	</div>
</div>

<script type="text/javascript">
	new Vue({
		el: '#app',
		data() {
			return {
				employees: [],
				edited_employee: {},
				edited_entries: []
			}
		},
		methods: {
			addEntry() {
				this.edited_entries.push("");
			},
			removeEntry(id) {
				this.edited_entries.splice(id, 1);
			},
			moveUp(id) {
				if (id > 0) {
					const f = this.edited_entries.splice(id, 1)[0];
					const to = id - 1;
					this.edited_entries.splice(to, 0, f);
				}
			},
			moveDown(id) {
				// remove `from` item and store it
				const f = this.edited_entries.splice(id, 1)[0];
				// insert stored item into position `to`
				const to = id + 1;
				this.edited_entries.splice(to, 0, f);
			},
			edit(i) {

				const employee = this.employees[i];

				this.edited_employee = Object.assign({}, employee);
				this.edited_entries = Object.assign([], this.edited_employee.recs);

				$("#updateEntryModal").modal({
					closable: false,
					onApprove: () => {
						// console.log(this.edited_entries);
						// console.log(employee.emp_id);

						const filtered = this.edited_entries.filter(function (el) {
							// return el != "";
							if (el != ""|| el.trim() != "") {
								return el;
							}
						});


						
						$.post('personnelrecognition_proc.php', {
							updateEntry: true,
							employees_id: employee.emp_id,
							recs: filtered
						}, (data, textStatus, xhr) => {
							console.log(data);
							this.employees[i].recs = Object.assign([], filtered);
							this.edited_employee = Object.assign({}, {});
							this.edited_entries = Object.assign([], []);
						});
					},
					onDeny: () => {
						this.edited_employee = Object.assign({}, {});
						this.edited_entries = Object.assign([], []);
					}
				}).modal('show');
			}
		},
		mounted() {
			//   console.log('test');
			$.ajax({
				type: "post",
				url: "personnelrecognition_proc.php",
				data: {
					get_data: true
				},
				dataType: "json",
				success: (res) => {
					this.employees = Object.assign({}, res);
				}
			});
		},
	})
</script>


<?php
require_once 'footer.php';
?>