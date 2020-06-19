<?php    
$title = "Salary Schedule";
require_once "header.php";
?>
<style>
    table ,th ,td ,tr{
        margin:auto;
        border:1px solid #757272; 
        border-collapse:collapse;
        font-family:'Calibri';
    }
    table{
            width:85%;
    }
    th{
        font-size:15px;
        padding:7px;
        background:#7572721f;
    }
    td{
        padding:4px;
    }
</style>
<div id="app">
    <div class="ui segment" :class="loader">
        <div class="ui modal" id="salaryAdjustmentModal">
                <i class="close icon"></i>
            <div class="header">
                Update Your Settings
            </div>
            <div class="content">
            <form class="ui form" @submit.prevent="addData()">
                    <div class="field">
                        <label>Notation </label>
                        <textarea rows="2" v-model="notation" required></textarea>
                    </div>
                    <div class="three fields">
                        <div class="field">
                            <label>Date Approved</label>
                            <input type="date" placeholder="First Name" v-model="date_approved" required>
                        </div>
                        <div class="field">
                            <label>Effectivity Date</label>
                            <input type="date" placeholder="Middle Name" v-model="effectivity_date" required>
                        </div>
                        <div class="field">
                            <label>Schedule</label>
                            <select v-model="schedule" required>
                                <option value="1">1st Class City Schedule( City Health and City Veterinary Office )</option>
                                <option value="2">2nd Class City Schedule</option>
                            </select>
                        </div>
                    </div>
                    <div class="ui grid">
                    <div class="two wide column">
                        <div class="field" style="padding-top:9px">
                            <div class="ui toggle checkbox" id='activeCheckBox'>
                                <input type="checkbox" tabindex="0" class="hidden" @change="active_check" >
                                <label>Active</label>
                            </div>
                            <label></label>
                        </div>
                    </div>
                    <div class="four wide column">
                        <input class="ui primary button" type="submit" value="Save">
                    </div>
                    </div>
                </form>
            </div>
        </div>
        <h1 class="ui header">Salary Schedule</h1>
        <div class="ui button primary" tabindex="0" @click="openform()">
            <i class="icon add"></i> Add
        </div>
        <hr>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="6">SALARY SCHEDULE EFFECTIVITY</th>
                    </tr>
                    <tr>
                        <th>Date Approved</th>
                        <th>Effectivity Date</th>
                        <th>Schedule</th>
                        <th>Notation</th>
                        <th>Active</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="salary_adjustments.length<1">
                        <tr>
                            <td colspan="6" style="text-align:center;padding:20px;color:gray"><h2>Empty</h2></td>
                        </tr>
                    </template>
                    <template v-else>
                        <tr v-for="(salary_adjustment,index) in salary_adjustments" :key="index">
                            <td>{{ salary_adjustment.date_approved }} </td>
                            <td>{{ salary_adjustment.effectivity_date }}</td>
                            <td>
                                <div v-if="salary_adjustment.schedule==1">1st Class</div>
                                <div v-else-if="salary_adjustment.schedule==2">2nd Class</div>
                                <div v-else >Undefined</div>
                            </td>
                            <td>{{ salary_adjustment.notation }}</td>
                            <td style="text-align:center">
                                <div v-if="salary_adjustment.active==1" style="color:green;;font-weight:bold"> YES </div>
                                <div v-else style="color:red;font-weight:bolder">NO</div>
                            </td>
                            <td style="text-align:center">
                                <div class="ui button primary" @click='gotopage(salary_adjustment.id)'>Open </div>
                                <div class="ui button " @click = "editData(index)">Edit</div>
                                <div class="ui button red" @click = "removeData(index)">Remove</div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>

        </div>
    </div>
</div>
<script src="umbra/salary_adjustment/config.js"></script>
<?
require_once "footer.php";
?>  