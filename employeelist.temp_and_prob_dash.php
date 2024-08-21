<?php $title = "Temporary/Probationary Dashboard";
require_once "header.php";
?>

<div id="emplistTempApp" class="ui fluid container" style="padding: 5px;" v-cloak>
	<div class="ui borderless blue inverted mini menu">
		<div class="left item" style="margin-right: 0px !important;">
			<button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
				<i class="icon chevron left"></i> Back
			</button>
		</div>
		<div class="item">
			<h3><i class="users icon"></i> Temporary/Probationary</h3>
		</div>

		<div class="item">
			<button @click="addEdit" class="green ui icon fluid button" style="margin-right: 10px;" title="Add Personnel">
				<i class="icon user plus"></i> Add
			</button>
		</div>

		<!-- <div class="item" style="margin-right: 10px;" title="Total"><i class="icon large users"></i>TOTAL:<span id="total_rows" style="margin-left: 5px;font-size: 14px;">0</span>
		</div> -->

		<div class="right item">
			<!-- <a href="print_employee_list.php" class="ui button " style="margin-right: 10px;">Print</a> -->
			<!-- <div class="ui icon input">
				<input id="employee_search" type="text" placeholder="Search...">
				<i class="search icon"></i>
			</div> -->
		</div>
	</div>

	<table id="employees_table" class="ui small very compact celled selectable striped blue table" style="font-size: 12px;">
		<thead>
			<tr>
				<th>Options</th>
				<th>Id</th>
				<th>Name</th>
				<th>Employment Status</th>
				<th>Position Title</th>
				<th>Date of Appointment</th>
				<th>Date for Renewal</th>
				<th>Dates Renewed</th>
			</tr>
		</thead>
		<tbody id="tableBody">
			<tr v-for="item in personnel" :key="item.id">
				<td class="center aligned"><button class="ui mini button" @click="addEdit(item)">Edit</button></td>
				<td>{{ item.employees_id }}</td>
				<td>{{ item.lastName }}, {{ item.firstName }} {{ item.middleName }}{{ item.extName ? ', '+item.extName:'' }}</td>
				<td>{{ item.employmentStatus }}</td>
				<td>{{ item.positionTitle.position }} {{item.positionTitle.functional ? ' - '+item.positionTitle.functional: ''}}</td>
				<td class="center aligned">{{ item.temp_date_of_appointment != '0000-00-00' && item.temp_date_of_appointment ? item.temp_date_of_appointment_formatted : '' }}</td>
				<td class="center aligned">{{ item.temp_due_for_renewal != '0000-00-00' && item.temp_due_for_renewal ? item.temp_due_for_renewal_formatted : '' }}
				</td>
				<td>
					<!-- {{ item.temp_dates_renewed }} -->
					<div v-for="date, d in item.temp_dates_renewed" :key="d" style="margin-right: 5px;"> {{formatDate(date)}}</div>

				</td>
			</tr>
			<tr v-if="personnel.length < 1">
				<td colspan="8" style="text-align: center; font-size: 32px; color: lightgrey; padding: 100px;">
					-- No RECORDS --
				</td>
			</tr>
		</tbody>
		<tfoot></tfoot>
	</table>

	<div id="addEditModal" class="ui tiny modal">
		<!-- <i class="close icon"></i> -->
		<div class="header">
			Add/Edit Personnel
		</div>
		<div class="image content">
			<form class="ui form" @submit.prevent="saveEdit" id="saveEditForm">
				<div class="field">
					<div class="four fields">
						<div class="five wide field">
							<label>Last Name:</label>
							<input type="text" placeholder="Last Name" v-model="employeeEdit.lastName" required>
						</div>
						<div class="five wide field">
							<label>First Name:</label>
							<input type="text" placeholder="First Name" v-model="employeeEdit.firstName" required>
						</div>
						<div class="five wide field">
							<label>Middle Name:</label>
							<input type="text" placeholder="Middle Name" v-model="employeeEdit.middleName">
						</div>
						<div class="three wide field">
							<label>ext:</label>
							<input type="text" placeholder="ext." v-model="employeeEdit.extName">
						</div>
					</div>
				</div>
				<div class="fields">
					<div class="eight wide field">
						<label>Employment Status:</label>
						<select v-model="employeeEdit.employmentStatus" id="employmentStatus" class="ui search selection clearable dropdown">
							<option value="">Select Status</option>
							<option value="TEMPORARY">TEMPORARY</option>
							<option value="PROBATIONARY">PROBATIONARY</option>
						</select>
					</div>
					<div class="eight wide field">
						<label>Date of Appointment:</label>
						<input type="date" v-model="employeeEdit.temp_date_of_appointment" name="temp_date_of_appointment">
					</div>
				</div>
				<!-- <div class="fields">
					<div class="sixteen wide field">
						<label for="departmentModal">Department:</label>
						<select v-model="employeeEdit.department_id" id="departmentModal" class="ui search selection clearable dropdown" autocomplete="off">
							<option value="">Select Department Assigned</option>
							<option v-for="department in departments" :value="department.department_id">{{department.department}}</option>
						</select>
					</div>
				</div> -->
				<div class="fields">
					<div class="sixteen wide field">
						<label>Position:</label>
						<select v-model="employeeEdit.position_id" id="position_id" class="ui search selection clearable dropdown" autocomplete="off" name="position_id">
							<option value="">Select Position</option>
							<option v-for="position in positions" :value="position.position_id" v-html="`${position.position} ${position.functional ? '<i>('+position.functional+')</i>':''}`"></option>
						</select>

					</div>
				</div>
				<div class="fields">
					<div class="eight wide field">
						<label>Dates Renewed:</label>
						<div class="ui action input">
							<input type="date" v-model="dateRenewed">
							<button class="ui icon button" type="button" @click="addDateRenewed" :disabled="!dateRenewed">
								<i class="add icon"></i>
							</button>
						</div>
					</div>
				</div>
				<div class="fields" style="margin-left: 20px;">
					<span v-for="date, i in employeeEdit.temp_dates_renewed" :key="i" style="padding: 5px;">{{ formatDate(date) }} <i class="icon times link" @click="removeFromList(i)"></i></span>
				</div>
			</form>
		</div>
		<div class="actions">
			<div class="ui deny button mini">
				Cancel
			</div>
			<button form="saveEditForm" class="ui blue right labeled icon button mini">
				Save
				<i class="checkmark icon"></i>
			</button>
		</div>
	</div>


</div>


<style>
	[v-cloak] {
		display: none !important;
	}

	input[type=text] {
		text-transform: uppercase;
	}
</style>

<script type="importmap">
	{
    "imports": {
      "vue": "https://unpkg.com/vue@3/dist/vue.esm-browser.js"
    }
  }
</script>

<script type="module">
	import {
		createApp,
		ref,
		onMounted,
		toRaw
	} from 'vue'

	createApp({
		setup() {
			const employeeEdit = ref({
				employees_id: null,
				lastName: "",
				firstName: "",
				middleName: "",
				extName: "",
				employmentStatus: null,
				temp_date_of_appointment: null,
				position_id: null,
				temp_dates_renewed: []
			})

			const personnel = ref([])
			const positions = ref([])
			const dateRenewed = ref(null)

			function addDateRenewed() {
				employeeEdit.value.temp_dates_renewed.push(dateRenewed.value)
				dateRenewed.value = null
			}

			function formatDate(date) {
				var date = new Date(date)
				return moment(date).format('LL');
			}

			function removeFromList(i) {
				employeeEdit.value.temp_dates_renewed.splice(i, 1)
			}

			const addEdit = (item) => {
				if (item.employees_id) {
					employeeEdit.value.employees_id = item.employees_id
					employeeEdit.value.lastName = item.lastName
					employeeEdit.value.firstName = item.firstName
					employeeEdit.value.middleName = item.middleName
					employeeEdit.value.extName = item.extName
					employeeEdit.value.employmentStatus = item.employmentStatus
					$("#employmentStatus").dropdown("set selected", item.employmentStatus);
					employeeEdit.value.temp_date_of_appointment = item.temp_date_of_appointment
					// employeeEdit.value.department_id = null
					employeeEdit.value.position_id = item.position_id
					$("#position_id").dropdown("set selected", item.position_id);
					employeeEdit.value.temp_dates_renewed = item.temp_dates_renewed ? JSON.parse(JSON.stringify(item.temp_dates_renewed)) : [];
				}

				$("#addEditModal").modal({
					onHidden: () => {
						clearEmployeeEdit()
					}
				}).modal("show");
			}



			const clearEmployeeEdit = () => {
				employeeEdit.value.employees_id = null
				employeeEdit.value.lastName = ""
				employeeEdit.value.firstName = ""
				employeeEdit.value.middleName = ""
				employeeEdit.value.extName = ""
				employeeEdit.value.employmentStatus = null
				employeeEdit.value.temp_date_of_appointment = null
				employeeEdit.value.position_id = null
				employeeEdit.value.temp_dates_renewed = []
				$(".dropdown").dropdown("clear");
			}

			async function saveEdit() {
				await $.post("employeelist.temp_and_prob_dash.proc.php", {
					saveEdit: true,
					inputs: employeeEdit.value
				}).then((res) => {
					$("#addEditModal").modal("hide");
					clearEmployeeEdit()
					getPersonnel().then((res) => {
						personnel.value = res
					});

				})
			}

			async function getDepartments() {
				return await $.post("employeelist.temp_and_prob_dash.proc.php", {
					getDepartments: true,
				}, null, 'json')
			}

			async function getPositions() {
				return await $.post("employeelist.temp_and_prob_dash.proc.php", {
					getPositions: true,
				}, null, 'json')
			}

			async function getPersonnel() {
				return await $.post("employeelist.temp_and_prob_dash.proc.php", {
					getPersonnel: true,
				}, null, 'json')
			}

			onMounted(() => {
				getPersonnel().then((res) => {
					personnel.value = res
				});

				// getDepartments().then((res) => {
				// 	departments.value = res
				// });

				getPositions().then((res) => {
					positions.value = res
				});

				$(".dropdown").dropdown({
					fullTextSearch: 'exact'
				});


			})

			return {
				personnel,
				positions,
				dateRenewed,
				addDateRenewed,
				removeFromList,
				formatDate,
				employeeEdit,
				addEdit,
				saveEdit
			}
		}
	}).mount('#emplistTempApp')
</script>

<?php require_once "footer.php"; ?>