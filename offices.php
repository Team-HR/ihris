<?php 
    if (!isset($_GET['dat'])) {
        header("location:departmentsetup.php");
    }


	$title = "Offices"; 
    require_once "header.php";
?>
<div class="ui container" id="app">
    <div class="ui modal tiny" id='officeModal'>
        <div class="header">Office Form</div>
        <div class="content">
                <form class="ui form" @submit.prevent="office_setup">
                    <div class="field">
                        <label>Office Name</label>
                        <input type="text" v-model="OfficeName" required>
                    </div>
                    <div class="field">
                        <label>Section Head</label>
                        <select class="ui search dropdown" id="sectionHead" v-model="selectedEmp">
                            <option value="">Search </option>
                            <option v-for="(emp,index) in Employees" :key="index" :value="emp.employees_id">{{ emp.lastName }} {{ emp.firstName }} {{ emp.middleName }}  {{ emp.extName }} </option>
                        </select>
                    </div>
                    <button class="ui button primary">Save</button>
                </form>
        </div>
    </div>
    <div class="ui borderless blue inverted mini menu">
        <div class="left item" style="margin-right: 0px !important;">
            <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
                <i class="icon chevron left"></i> Back
            </button>
        </div>
        <div class="item">
            <h3><i class="building icon"></i><?=$_GET['dep']?></h3>
        </div>
        <div class="right item">
            <div class="ui right input">
                <button class="ui icon mini green button" @click="openModal" style="margin-right: 5px;" title="Add New Department"><i class="icon plus"></i> Create an Office</button>
                <!-- <div class="ui icon fluid input" style="width: 300px;">
                    <input id="dept_search" type="text" placeholder="Search...">
                    <i class="search icon"></i>
                </div> -->
            </div>
        </div>
    </div>
    <div class='ui segment' :class="loading">
        <table class="ui table" ref="listOffice" data-id="<?=$_GET['dat']?>">
                <tr style="font-weight: bold">
                    <td>Office</td>
                    <td>Supervisors</td>
                    <td style="text-align: center;">Options</td>
                </tr>
            <template v-if="Offices.length">
                <tr v-for="(office,index) in Offices" :key="index">
                    <td> {{ office.office_name }} </td>
                    <td> {{ office.lastName }}  {{ office.firstName }} {{ office.middleName }} {{ office.extName }}</td>
                    <td style="text-align: center"> 
                        <div class="ui buttons">
                            <button class="ui button icon tiny green " @click="editOffice(index)"><i class="icon edit"></i></button>
                            <button class="ui button icon tiny red " @click="deleteOffice(office.id)"><i class="icon trash"></i></button>
                        </div>
                     </td>
                </tr>
            </template>
            <template v-else>
                <tr  style="text-align: center;color: lightgrey;">
                    <td colspan="3"><h3>No Office Created</h3></td>
                </tr>
            </template>
        </table>
    </div>
</div>
<script src="umbra/office/config.js"></script>
<?php 
	require_once "footer.php";
?>

