<?php
    $title = "DTR Summary";
    require_once "header.php";
?>
<div id="dtrSummary_app">
    <!-- modal -->
    <div class="ui small modal" id="optionModal">
        <div class="header">TARDINESS INFORMATION</div>
        <div class="content">
         <h4>Name: {{selected_data.lastName}} {{selected_data.firstName}} {{selected_data.middleName}}<br>
                Current month x10 Tardy:{{selected_data.month}}</h4> 
            <table class="ui celled table" style="text-align:center">
                <thead>
                    <tr>
                        <th colspan="2">Tardiness history</th>
                    </tr>
                    <tr>
                        <th>Month</th>
                        <th>Number of times</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(hist,index) in tardayHist">
                        <td>{{hist.month}}</td>
                        <td>{{hist.totalTardy}}</td>
                    </tr>
                </tbody>
            </table>
            <center>
                <button class="ui green button"  @click="letterGen('tardy_warningLetter')">Warning</a>
                <button class="ui blue button"   @click="letterGen('tardy_reprimandLetter')">Reprimand</a>
                <button class="ui yellow button" >Suspension</button>
                <button class="ui red button" >Termination</button>
            </center>
        </div>
    </div>

    <!-- end  -->

    <div class="ui segment noprint"   style="margin:auto;max-width:50%;min-width:500px;">
        <h1>DTR Summary</h1>
        <div class="ui section divider"></div> 
            <form class="ui form" @submit.prevent="getDataNeeded()">
                <div class="field">
                    <label>Month:</label>
                    <input type="month" placeholder="Month" v-model="period" required>
                </div>
                <!-- <div class="field">
                    <label>Type:</label>
                    <select class="ui selection dropdown" v-model="type" required>
                        <option value="TARDY">TARDY</option>
                        <option value="ABSENT">ABSENT</option>
                    </select>
                </div> -->
                <input type="submit" value="Generate" class="ui button blue">
            </form>
            <br>
        <div class="ui section divider"></div>
            <form class="ui form">  
            <h3>Filter:</h3>
                <div class="field">
                    <label>Departments</label>
                    <select multiple="" class="ui fluid search dropdown" v-model="selectedDepartment">
                        <option value="">Departments</option>
                        <template>
                            <option v-for="(department,index) in Departments" :key="index" :value="department.department_id">
                                {{department.department}}
                            </option>
                        </template>
                    </select>
                </div>
                <div class="field">
                    <div class="ui compact inverted segment">
                        <div class="ui inverted checkbox">
                            <input type="checkbox" v-model="tardyLetter">
                            <label>10x TARDY ONLY</label>
                        </div>
                    </div>
                </div>
            </form>
    </div>
    <br>    
    <template>
        <template v-if="filterDepartment.length>0">
        <table class="ui celled table" style="width:95%;margin:auto" v-for="(dep,index) in filterDepartment" :key="index">
                <thead>
                    <tr>
                        <th colspan="11">
                        <h2>Summary table {{period}}</h2>
                        </th>
                    </tr>
                    <tr>
                        <th rowspan="2">Employee</th>
                        <th rowspan="2">Department</th>
                        <th colspan="4" style="text-align:center">TARDY</th>
                        <th colspan="3" style="text-align:center">UNDERTIME</th>
                        <th rowspan="2">Remarks</th>
                        <th rowspan="2">Options</th>
                    </tr>
                    <tr>
                        <th>No. Times</th>
                        <th>Total Mins.</th>
                        <th>Date of Half Day</th>
                        <th>EQUIV</th>
                        <th>Total Mins.</th>
                        <th>Date of Half Day</th>
                        <th>EQUIV</th>
                    </tr>

                </thead>
                <tbody>
                    <tr v-for="(ar,index) in dep.dat">
                        <td>{{ar.firstName}} {{ar.middleName}} {{ar.lastName}}</td>
                        <td>{{ar.department}}</td>
                        <td>{{ar.totalTardy}}</td>
                        <td>{{ar.totalMinsTardy}}</td>
                        <td>{{ar.halfDaysTardy}}</td>
                        <td>{{showEquiv(ar.totalMinsTardy)}}</td>
                        <td>{{ar.totalMinsUndertime}}</td>
                        <td>{{ar.halfDaysUndertime}}</td>
                        <td>{{showEquiv(ar.totalMinsUndertime)}}</td>
                        <td><span v-html="newLine(ar.remarks,',')"></span></td>
                        <td><button class="ui button primary" v-if="parseInt(ar.totalTardy)>=10" @click="showOptionModal(index)">View</button></td>
                    </tr>
                </tbody>
            </table>

            <br>
        </template>
        <template v-else-if="filterTardy.length>0">
        <table class="ui celled table" style="width:95%;margin:auto">
                <thead>
                    <tr>
                        <th colspan="11">
                        <h2>Summary table {{period}}</h2>
                        </th>
                    </tr>
                    <tr>
                        <th rowspan="2">Employee</th>
                        <th rowspan="2">Department</th>
                        <th colspan="4" style="text-align:center">TARDY</th>
                        <th colspan="3" style="text-align:center">UNDERTIME</th>
                        <th rowspan="2">Remarks</th>
                        <th rowspan="2">Options</th>
                    </tr>
                    <tr>
                        <th>No. Times</th>
                        <th>Total Mins.</th>
                        <th>Date of Half Day</th>
                        <th>EQUIV</th>
                        <th>Total Mins.</th>
                        <th>Date of Half Day</th>
                        <th>EQUIV</th>
                    </tr>

                </thead>
                <tbody>
                    <tr v-for="(ar,index) in filterTardy">
                        <td>{{ar.firstName}} {{ar.middleName}} {{ar.lastName}}</td>
                        <td>{{ar.department}}</td>
                        <td>{{ar.totalTardy}}</td>
                        <td>{{ar.totalMinsTardy}}</td>
                        <td>{{ar.halfDaysTardy}}</td>
                        <td>{{showEquiv(ar.totalMinsTardy)}}</td>
                        <td>{{ar.totalMinsUndertime}}</td>
                        <td>{{ar.halfDaysUndertime}}</td>
                        <td>{{showEquiv(ar.totalMinsUndertime)}}</td>
                        <td><span v-html="newLine(ar.remarks,',')"></span></td>
                        <td><button class="ui button primary" v-if="parseInt(ar.totalTardy)>=10" @click="showOptionModal(index)">View</button></td>
                    </tr>
                </tbody>
            </table>

        </template>
        <template v-else>
            <table class="ui celled table" style="width:95%;margin:auto">
                <thead>
                    <tr>
                        <th colspan="11">
                        <h2>Summary table {{period}}</h2>
                        </th>
                    </tr>
                    <tr>
                        <th rowspan="2">Employee</th>
                        <th rowspan="2">Department</th>
                        <th colspan="4" style="text-align:center">TARDY</th>
                        <th colspan="3" style="text-align:center">UNDERTIME</th>
                        <th rowspan="2">Remarks</th>
                        <th rowspan="2">Options</th>
                    </tr>
                    <tr>
                        <th>No. times</th>
                        <th>Total mins.</th>
                        <th>Date of half-day</th>
                        <th>Equiv.</th>
                        <th>Total mins.</th>
                        <th>Date of half-day</th>
                        <th>Equiv.</th>
                    </tr>

                </thead>
                <tbody>
                    <tr v-for="(ar,index) in DataRequest">
                        <td>{{ar.firstName}} {{ar.middleName}} {{ar.lastName}}</td>
                        <td>{{ar.department}}</td>
                        <td>{{ar.totalTardy}}</td>
                        <td>{{ar.totalMinsTardy}}</td>
                        <td>{{ar.halfDaysTardy}}</td>
                        <td>{{showEquiv(ar.totalMinsTardy)}}</td>
                        <td>{{ar.totalMinsUndertime}}</td>
                        <td>{{ar.halfDaysUndertime}}</td>
                        <td>{{showEquiv(ar.totalMinsUndertime)}}</td>
                        <td><span v-html="newLine(ar.remarks,',')"></span></td>
                        <td><button class="ui button primary" v-if="parseInt(ar.totalTardy)>=10" @click="showOptionModal(index)">View</button></td>
                    </tr>
                </tbody>
            </table>
        </template>    
    </template>    
    

</div>
<script src="umbra/dtrManagement/config_summary.js"></script>
<script>
    $(document).ready(function(){
        $('.dropdown').dropdown(
            {
                fullTextSearch: true
            }
        );
    });
</script>
<?php
    require_once "footer.php";
?>