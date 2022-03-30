<?php $title = "Request and Communications";
require_once "header.php";
require_once "_connect.db.php";
$comm_id = $_GET['id'];
?>
<!-- <div id="app" style="padding: 20px;">
	<div class="ui fluid container">
		<div class="ui borderless blue inverted mini menu">
			<div class="left item" style="margin-right: 0px !important;">
				<button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
					<i class="icon chevron left"></i> Back
				</button>
			</div>
			<div class="item">
				<h3><i class="icon fax"></i> Requests and Communications - {{comm.control_number}}</h3>
			</div>
			<div class="right item">
				<div class="ui right input">
					<button class="ui icon mini green button" style="margin-right: 5px;"><i class="icon edit"></i> Edit</button>
				</div>
			</div>
		</div>
	</div>
	<div class="ui container">
		<div class="ui form">
			<div class="fields">
				<div class="field">
					<label for="">Control Number:</label>
					<input type="text" v-model="comm.control_number" readonly>
				</div>
				<div class="field">
					<label for="">Date Received:</label>
					<input type="text" v-model="comm.date_received" readonly>
				</div>
			</div>
			<div class="field">
				<label for="">Source:</label>
				<input type="text" v-model="comm.source" placeholder="Source (Agency/Organization)">
			</div>
			<div class="field">
				<label for="">Subject:</label>
				<textarea v-model="comm.subject" rows="3"></textarea>
			</div>







			<div class="fields">
				<div class="eight wide field">
					<label for="">Department/s Concerened:</label>
					<div id="departmentsMenu" class="ui fluid multiple selection dropdown">
						<input type="hidden">
						<i class="dropdown icon"></i>
						<div class="default text">Select Department/s</div>
						<div class="menu">
							<div v-for="department in departments" class="item" :data-value="department.department_id">{{department.department}}</div>
						</div>
					</div>
					<ol class="ui list">
						<li v-for="department in comm.departments_involved">{{department}}</li>
					</ol>
				</div>
				<div class="eight wide field">
					<label for="">Personnel Involved:</label>
					<input type="text">
					<div class="ui middle aligned divided list">
						<div v-for="employee in comm.personnels_involved" class="item">
							<div class="left floated content">
								<a href="javascript:void(0)">remove</a>
							</div>
							<div class="content">
								{{employee}}
							</div>
						</div>
					</div>
				</div>
			</div>








			<div class="fields">
				<div class="field">
					<label for="">From:</label>
					<input type="date" v-model="comm.start_date">
				</div>
				<div class="field">
					<label for="">To:</label>
					<input type="date" v-model="comm.end_date">
				</div>
			</div>
			<div class="four wide field">
				<label for="">Type:</label>
				<select id="typesMenu" class="ui dropdown compact search">
					<option value="">eg. Meeting, Training, etc...</option>
					<option v-for="type in types" :value="type.type">{{ type.name }}</option>
				</select>
			</div>
			<div class="field">
				<label for="">Venue:</label>
				<textarea v-model="comm.venue" rows="3"></textarea>
			</div>

		</div>
	</div>

</div> -->

<div id="employeeLister">
	<!-- selections -->

	<h5>Employees:</h5>
	<label for="">Filter by Department:</label>
	<select v-model="selectedDepartment" @change="filter(selectedDepartment)">
		<option value="" disabled selected>Select department</option>
		<option value="all">All</option>
		<option v-for="i in 10" :value="i">{{'Department '+i}}</option>
	</select>
	<div v-if="filteredEmployees == ''">--None--</div>
	<div v-for="employee in filteredEmployees">{{employee.name}} 
		<a href="javascript:void(0)" @click="add(employee.id); ">Add</a>
	</div>
	<h5>Selected Employees:</h5>
	<!-- selected -->
	<div v-if="list == ''">--Empty--</div>
	<div v-for="employee in list">{{employee.name}} 
		<a href="javascript:void(0)" @click="remove(employee.id); ">Remove</a>
	</div>
</div>


<script>
	new Vue({
		el: "#employeeLister",
		data: {
			selectedDepartment: "",
			employees: [
				{id: 192, name: 'Joe, Jane V.', department_id: 1},
				{id: 30, name: 'Lucas, George N.', department_id: 1},
				{id: 891, name: 'Barbie, Sabi K.', department_id: 2},
			],
			filteredEmployees:[],
			list: []
		},
		watch: {
			// selectedDepartment: (department_id)=>{
			// 	this.filterByDepartment(department_id);
			// }
		},
		methods: {
			filter(department_id){
				this.filteredEmployees = [];
				if (department_id == '' || department_id == 'all') {
					this.filteredEmployees = this.employees;
					// return false;
					console.log(this.employees);
				} else {
					$.each(this.employees,(i, employee)=>{ 
						if (employee.department_id == department_id) {
							this.filteredEmployees.push(employee);
						}
					});
				}
			},
			add(id){
				$.each(this.filteredEmployees, (index, employee)=>{ 
					if (employee.id == id) {
						this.list.push(this.filteredEmployees[index]);
						this.filteredEmployees.splice(index,1);
						return false;
					}
				});
			},
			remove(id){
				$.each(this.list, (index, employee)=>{ 
					if (employee.id == id) {
						this.filteredEmployees.push(this.list[index]);
						this.list.splice(index,1);
						return false;
					}
				});
			},
		},
		mounted(){
			this.filter('all');
		}

	});
	var app = new Vue({
		el: "#app",
		data: {
			id: 0,
			comm: [],
			departments: [],
			types: [],
		},
		methods: {
			showData() {
				$.getJSON("comms.ajax.php", {
						showData: true,
						id: this.id
					},
					(data, textStatus, jqXHR) => {
						this.comm = data
						this.getDepartments()
						this.getTypes()
					});
			},
			getDepartments() {
				$.getJSON("comms.ajax.php", {
						getDepartments: true
					},
					(data, textStatus, jqXHR) => {
						this.departments = data
					});
			},
			getTypes() {
				$.getJSON("comms.ajax.php", {
						getTypes: true
					},
					(data, textStatus, jqXHR) => {
						this.types = data
					});
			},

		},
		mounted() {
			this.id = <?= $comm_id ?>;
			this.showData();
			$('.dropdown').dropdown();
			loopCheck = setInterval(() => {
				if (document.readyState == 'complete') {
					$('#departmentsMenu').dropdown("set exactly", this.comm.department_ids_involved);
					$('#typesMenu').dropdown("set selected", this.comm.type);
					clearInterval(loopCheck);
				}
			}, 50);
		}
	})
</script>
<style>
	.valigntop {
		vertical-align: top !important;
	}

	.nowrap {
		white-space: nowrap !important;
	}

	input,
	textarea,
	.dropdown {
		background-color: ivory !important;
	}
</style>


<?php require_once "footer.php"; ?>