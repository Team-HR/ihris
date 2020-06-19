<?php    
$title = "Salary Schedule";
require_once "header.php";
    $dataId = $_GET['dat'];
?>
<div id="app" style="padding:10px">
    <div class="ui modal" id="salaryModalSetup" style="width:300px">
    <br>
        <i class="close icon"></i>
        <div class="header">
            Setup Form
        </div>
        <div class="content">
            <form class="ui form"  @submit.prevent="sumbitSetupForm(<?=$_GET['dat']?>)">
                <div class="field">
                    <label>Salary Grade</label>
                    <input type="number" v-model="salary_grade" active>
                </div>
                <div class="field">
                    <label>Step No.</label>
                    <input type="number" v-model="step_no">
                </div>
                <div class="field">
                    <label>Monthly Salary</label>
                    <input type="number" v-model="monthly_salary">
                </div>
                <div class="field">
                    <input type="submit" class="ui button primary" value="Save">
                </div>
                
            </form>

        </div>
    </div>
    <div class="ui segment" :class="load" style="min-height:400px">
        <h1>Salary Adjustment Setup</h1>
        <div class="ui button primary" @click="showModal()">
            <i class="add icon"></i> Add
        </div>
        <hr>
        <table class="ui celled table" id="setup_table" data-id="<?=$_GET['dat']?>" style="width:500px;margin:auto">
            <thead>
                <tr>
                    <th>Salary Grade</th>
                    <th>Step No.</th>
                    <th>Monthly Salary</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <template v-if="dat.length<1">
                    <tr>
                        <td colspan="4" style="padding:20px;text-align:center;color:#00000045"><h1>No Data</h1></td>
                    </tr>
                </template>
                <template v-else>
                    <tr v-for="(d,index) in dat">
                        <td>{{ d.salary_grade }}</td>
                        <td>{{ d.step_no }}</td>
                        <td>{{ d.monthly_salary }}</td>
                        <td>
                            <button class="ui button primary" @click="setup_update(index)">Edit</button>
                            <button class="ui button red" @click="removeSetup(d.id)">Delete</button>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>  
</div>
<script src="umbra/salary_adjustment/config_setup.js"></script>
<?
require_once "footer.php";
?>  