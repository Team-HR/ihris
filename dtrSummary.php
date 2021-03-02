<?php
    $title = "DTR Summary";
    require_once "header.php";
?>
<style>
    th{
        position:sticky;
        top:0
    }
    table{
        position:relative;
    }

</style>

<div id="dtrSummary_app">
    <!-- modal -->
    <div class="ui small modal" id="optionModal">
        <div class="header"></div>
        <div class="content">
            <h3>Name: <u>{{selected_data.lastName}} {{selected_data.firstName}} {{selected_data.middleName}}. {{selected_data.extName}}</u></h3>
            <h3>Current Month Tardy: <u>{{selected_data.month}}</u></h3>
            <table class="ui celled table" style="text-align:center">
                <thead >
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
                <button  class="ui secondary basic button" @click="letterGen('tardyLetter')">Warning</a>
                <button class="ui primary basic button">Reprimand</a>
                <button class="ui positive basic button">Suspension</button>
                <button class="ui negative basic button">Termination</button>
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
        <table class="ui celled selectable compact table" style="width:95%;margin:auto" v-for="(dep,index) in filterDepartment" :key="index">
                <thead>
                    <tr>
                        <th colspan="11">
                          Summary table {{period}}
                        </th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th colspan="4">TARDY</th>
                        <th colspan="3">Undertime</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th >Employee</th>
                        <th>Department</th>
                        <th>No. Times</th>
                        <th>Total Mins.</th>
                        <th>Date of Half Day</th>
                        <th>EQUIV</th>
                        <th>Total Mins.</th>
                        <th>Date of Half Day</th>
                        <th>EQUIV</th>
                        <th>Remarks</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(ar,index) in sortArrays(dep.dat)">
                        <td>{{ar.lastName}} {{ar.firstName}} {{ar.middleName}} {{ar.extName}}</td>
                        <td>{{ar.department}}</td>
                        <td style="background-color:#9ec14b70;color:#086d08">{{ar.totalTardy}}</td>
                        <td style="background-color:#9ec14b70;color:#086d08">{{ar.totalMinsTardy}}</td>
                        <td style="background-color:#9ec14b70;color:#086d08">{{ar.halfDaysTardy}}</td>
                        <td style="background-color:#9ec14b70;color:#086d08">{{showEquiv(ar.totalMinsTardy)}}</td>
                        <td style="background-color:#7accc078;color:#088dad">{{ar.totalMinsUndertime}}</td>
                        <td style="background-color:#7accc078;color:#088dad">{{ar.halfDaysUndertime}}</td>
                        <td style="background-color:#7accc078;color:#088dad">{{showEquiv(ar.totalMinsUndertime)}}</td>
                      <td><span v-html="newLine(ar.remarks,',')"></span></td>
                        <td><button class="ui button primary" v-if="parseInt(ar.totalTardy)>=10" @click="showOptionModal(index)">View Summary</button></td>
                    </tr>
                </tbody>
            </table>

            <br>
        </template>
        <template v-else-if="filterTardy.length>0">
        <table class="ui celled selectable compact table" style="width:95%;margin:auto">
                <thead>
                    <tr>
                        <th colspan="11">
                          Summary table {{period}}
                        </th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th colspan="4">TARDY</th>
                        <th colspan="3">Undertime</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th >Employee</th>
                        <th>Department</th>
                        <th>No. Times</th>
                        <th>Total Mins.</th>
                        <th>Date of Half Day</th>
                        <th>EQUIV</th>
                        <th>Total Mins.</th>
                        <th>Date of Half Day</th>
                        <th>EQUIV</th>
                        <th>Remarks</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(ar,index) in sortArrays(filterTardy)">
                        <td>{{ar.lastName}} {{ar.firstName}} {{ar.middleName}} {{ar.extName}} </td>
                        <td>{{ar.department}}</td>
                        <td style="background-color:#9ec14b70;color:#086d08">{{ar.totalTardy}}</td>
                        <td style="background-color:#9ec14b70;color:#086d08">{{ar.totalMinsTardy}}</td>
                        <td style="background-color:#9ec14b70;color:#086d08">{{ar.halfDaysTardy}}</td>
                        <td style="background-color:#9ec14b70;color:#086d08">{{showEquiv(ar.totalMinsTardy)}}</td>
                        <td style="background-color:#7accc078;color:#088dad">{{ar.totalMinsUndertime}}</td>
                        <td style="background-color:#7accc078;color:#088dad">{{ar.halfDaysUndertime}}</td>
                        <td style="background-color:#7accc078;color:#088dad">{{showEquiv(ar.totalMinsUndertime)}}</td>
                        <td><span v-html="newLine(ar.remarks,',')"></span></td>
                        <td><button class="ui button primary" v-if="parseInt(ar.totalTardy)>=10" @click="showOptionModal(index)">View Summary</button></td>
                    </tr>
                </tbody>
            </table>
        </template>
        <template v-else>
            <table class="ui celled selectable compact table" style="width:95%;margin:auto">
                <thead>
                    <tr>
                        <th colspan="12">
                          Summary table {{period}}
                        </th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th colspan="4">TARDY</th>
                        <th colspan="3">Undertime</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th></th>
                        <th >Employee</th>
                        <th>Department</th>
                        <th>No. Times</th>
                        <th>Total Mins.</th>
                        <th>Date of Half Day</th>
                        <th>EQUIV</th>
                        <th>Total Mins.</th>
                        <th>Date of Half Day</th>
                        <th>EQUIV</th>
                        <th>Remarks</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(ar,index) in sortArrays(DataRequest)" :style="'background-color:'+ar.color">
                        <td>
                            <button v-if="!ar.color" class="ui yellow compact icon mini button" @click="changeColor(ar.dtrSummary_id,'#ead74da8')">
                                <i class="check icon"></i>
                            </button>
                            <button v-else class="ui inverted red compact icon mini button" @click="revertColor(ar.dtrSummary_id)">
                                <i class="close icon"></i>
                            </button>
                            
                        </td>
                        <td>{{ar.lastName}} {{ar.firstName}} {{ar.middleName}} {{ar.extName}}</td>
                        <td>{{ar.department}}</td>
                        <td style="background-color:#9ec14b70;color:#086d08">{{ar.totalTardy}}</td>
                        <td style="background-color:#9ec14b70;color:#086d08">{{ar.totalMinsTardy}}</td>
                        <td style="background-color:#9ec14b70;color:#086d08">{{ar.halfDaysTardy}}</td>
                        <td style="background-color:#9ec14b70;color:#086d08">{{showEquiv(ar.totalMinsTardy)}}</td>
                        <td style="background-color:#7accc078;color:#088dad">{{ar.totalMinsUndertime}}</td>
                        <td style="background-color:#7accc078;color:#088dad">{{ar.halfDaysUndertime}}</td>
                        <td style="background-color:#7accc078;color:#088dad">{{showEquiv(ar.totalMinsUndertime)}}</td>
                        <td><span v-html="newLine(ar.remarks,',')"></span></td>
                        <td><button class="ui button primary" v-if="parseInt(ar.totalTardy)>=10" @click="showOptionModal(index)">View Summary</button></td>
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