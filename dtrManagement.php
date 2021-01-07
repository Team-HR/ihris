<?php
    $title = "DTR Management";
    require_once "header.php";
?>
<div id="dtr_app">


    <div class="ui segment"   style="margin:auto;max-width:35%;min-width:600px;">
        <div class="ui segment" style="position:fixed;right:0px;width:250px;z-index:10">
            <table>
                <tr>
                    <th style="text-align: right">Total mins Tardy:</th>
                    <th style="color:red">{{totalMinsTardy}}</th>
                </tr>
                <tr>
                    <th style="text-align: right">No. of times Tardy:</th>
                    <th style="color:red">{{totalTimesTardy}}</th>
                </tr>
                <tr>
                    <th style="text-align: right">Total mins Undertime:</th>
                    <th style="color:red">{{totalMinUnderTime}}</th>
                </tr>
            </table>
        </div>
        <form class="ui form" @submit.prevent="setupData()">
            <div class="field">
                <label>Name:</label>
                <select class="ui fluid search dropdown" v-model="emp_id">
                    <option value="">Select Employee</option>
                    <option v-for="(employee,index) in Employees" :key="index" :value="employee.employees_id">
                        {{employee.lastName}} {{employee.firstName}}
                    </option>
                </select>
            </div>
            <div class="field">
                <label>Period</label>
                <input type="month" v-model="period"> 
            </div>
            <div>
                <button type="submit" class="ui button positive" id="seachBtn">Search</button>
            </div>
        </form>
        <hr>
        <div>
        <div class="ui mini modal" id="modalEdit">
            <div class="header">DTR Management Form</div>
            <div class="content">
                <form class="ui form" id="addTimeForm" @submit.prevent="addDTR()">
                    <h5>TARDINESS</h5>
                    <hr>
                    <div class="two fields">
                        <div class="field">
                            <label>AM</label>
                            <input type="number" placeholder="" v-model="amTardy">
                        </div>
                        <div class="field">
                            <label>PM</label>
                            <input type="number" placeholder="" v-model="pmTardy">
                        </div>
                    </div>
                    <h5>UNDERTIME</h5>
                    <hr>    
                    <div class="two fields">
                        <div class="field">
                            <label>AM</label>
                            <input type="number" placeholder="" v-model="amUnder">
                        </div>
                        <div class="field">
                            <label>PM</label>
                            <input type="number" placeholder="" v-model="pmUnder">
                        </div>
                    </div>
                    <div class="field">
                        <label>Others</label>
                        <input type="text" v-model="others">
                    </div>
                    <!-- <div class="inline field">
                        <div class="ui checkbox">
                        <input type="checkbox" tabindex="0" v-model="absent" class="hidden" @change="checkerbox(true)">
                        <label>ABSENT</label>
                        </div>
                    </div>
                    <div class="inline field">
                        <div class="ui checkbox">
                        <input type="checkbox" tabindex="0" v-model="dayoff" class="hidden" @change="checkerbox(false)">
                        <label>DAY-OFF</label>
                        </div>
                    </div> -->
                    <button class="ui button fluid green">Save</button>
                </form>
            </div>
        </div>
            <div v-if="dtr.length">
                <table class="ui celled table" id="example1"> 
                    <thead>
                        <tr>
                            <th colspan="7">Period</th>
                        </tr>
                        <tr>
                            <th rowspan="2">Date</th>
                            <th colspan="2">AM</th>
                            <th colspan="2">PM</th>
                            <th rowspan="2">Remarks</th>
                            <th rowspan="2">Options</th>
                        </tr>
                        <tr>
                            <th>Tardiness</th>
                            <th>Under-Time</th>
                            <th>Tardiness</th>
                            <th>Under-Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(day,index) in dtr" :key="index"> 
                            <td>{{day.date.split('-')[2]}}</td>
                            <td>{{day.amTardy}}</td>
                            <td>{{day.amUnderTime}}</td>
                            <td>{{day.pmTardy}}</td>
                            <td>{{day.pmUnderTime}}</td>
                            <td style="text-align:center;font-weight: bold;color:red">{{day.other}}</td>
                            <td>

                                <button class="ui icon tiny button green" @click="openModal(index)">
                                    <i class="edit icon"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>    
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(".dropdown").dropdown({
            fullTextSearch: true,
        });
        $('.ui.checkbox').checkbox();
    });
</script>
<script src="umbra/dtrManagement/config.js"></script>
<?php
    require_once "footer.php";
?>