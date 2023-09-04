<?php    
$title = "Salary Schedule";
require_once "header.php";
    $dataId = $_GET['dat'];
?>
<div id="app" class="ui container">
    <div class="ui modal" id="salaryModalSetup" style="width:300px; margin-top: 20px !important;">
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

  <div class="ui borderless blue inverted mini menu">
    <div class="left item" style="margin-right: 0px !important;">
      <a href="salary_adjustment.php" class="blue ui icon button" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </a>
    </div>
    <div class="item">
      <h3><i class="icon money check alternate"></i> Salary Schedule Setup</h3>
    </div>
    <div class="right item">
    <div class="ui right input">
      <button class="ui icon mini green button" @click="showModal()" style="margin-right: 5px;" title="Add New Department"><i class="icon plus"></i>Add</button>
    </div>
    </div>
  </div>


    <div class="ui segment" :class="load" style="min-height:400px">
        <table class="ui mini compact celled table" id="setup_table" data-id="<?=$_GET['dat']?>">
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
                        <td>{{ "Php. "+formatNumber(d.monthly_salary) }}</td>
                        <td>
                            <button class="ui mini button primary" @click="setup_update(index)">Edit</button>
                            <button class="ui mini button red" @click="removeSetup(d.id)">Delete</button>
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