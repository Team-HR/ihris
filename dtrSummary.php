<?php
    $title = "DTR Summary";
    require_once "header.php";
?>
<div id="dtrSummary_app">
    <!-- modal -->
    <div class="ui small modal" id="optionModal">
        <div class="header"></div>
        <div class="content">
            <h3>Name: <u>{{selected_data.lastName}} {{selected_data.firstName}} {{selected_data.middleName}}</u></h3>
            <h3>Current Month Tardiness: <u>{{selected_data.month}}</u></h3>
            <table class="ui celled table">
                <thead>
                    <tr>
                        <th colspan="2">TARDINESS History</th>
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
                <button class="ui secondary basic button">Secondary</button>
                <button class="ui primary basic button">Primary</button>
                <button class="ui positive basic button">Positive</button>
                <button class="ui negative basic button">Negative</button>
            </center>
        </div>
    </div>

    <!-- end  -->

    <div class="ui segment"   style="margin:auto;max-width:50%;min-width:500px;">
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
                        <th colspan="6">
                            <h2>{{dep.department}}</h2>
                        </th>
                    </tr>
                    <tr>
                        <th>Employee</th>
                        <th>No. Times Tardy</th>
                        <th>Total Mins. Tardy</th>
                        <th>Total Mins. Undertime.</th>
                        <th>Options</th>
                    </tr>                
                </thead>
                <tbody>
                    <tr v-for="(a,index) in dep.dat">
                        <td>{{a.firstName}} {{a.middleName}} {{a.lastName}}</td>
                        <td>{{a.totalTardy}}</td>
                        <td>{{a.totalMinsTardy}}</td>
                        <td>{{a.totalMinsUndertime}}</td>
                        <td><button class="ui button primary" @click="showOptionModal(index)">Open Modal</button></td>
                    </tr>
                </tbody>
            </table>
            <br>
        </template>
        <template v-else-if="filterTardy.length>0">
            <table class="ui celled table" style="width:95%;margin:auto">
                <thead>
                    <tr>
                        <th colspan="6">
                            <h2>Summary table {{period}}</h2>
                        </th>
                    </tr>
                    <tr>
                        <th>Employee</th>
                        <th>Department</th>
                        <th>No. Times Tardy</th>
                        <th>Total Mins. Tardy</th>
                        <th>Total Mins. Undertime.</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(ar,index) in filterTardy">
                        <td>{{ar.firstName}} {{ar.middleName}} {{ar.lastName}}</td>
                        <td>{{ar.department}}</td>
                        <td>{{ar.totalTardy}}</td>
                        <td>{{ar.totalMinsTardy}}</td>
                        <td>{{ar.totalMinsUndertime}}</td>
                        <td><button class="ui button primary" @click="showOptionModal(index)">Open Modal</button></td>
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
                        <th colspan="3" style="text-align:center">Undertime</th>
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
                        <td>{{ar.remarks}}</td>
                        <td><button class="ui button primary" v-if="parseInt(ar.totalTardy)>=10" @click="showOptionModal(index)">Open Modal</button></td>
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