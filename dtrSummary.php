<?php
$title = "DTR Summary";
require_once "header.php";
?>
<style>
    th.a {
        position: sticky;
        top: 89px;
        z-index: 100
    }

    th.ab {
        position: sticky;
        top: 50px;
        z-index: 100
    }

    th.abc {
        position: sticky;
        top: 0;
        z-index: 100
    }

    table {
        position: relative;
    }
</style>

<div id="dtrSummary_app">
    <!-- modal -->
    <div class="ui small modal" id="optionModal">
        <div class="content">

            <table class="ui celled table">
                <thead>
                    <tr>
                        <th colspan="2" style="background:#004d26; color:white; text-align:center">Tardiness Information</th>
                    </tr>
                    <tr>
                        <th style="width:30%; text-align:right">Name:</th>
                        <th> {{selected_data.firstName}} {{selected_data.middleName}} {{selected_data.lastName}} {{selected_data.extName}}</th>
                    </tr>
                    <tr>
                        <th style="width:30%; text-align:right">Current month tardy:</th>
                        <th> {{selected_data.month}}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(hist,index) in tardayHist">
                        <td>{{hist.month}}</td>
                        <td>{{hist.totalTardy}}</td>
                    </tr>
                </tbody>
            </table>

            <table class="ui celled table" style="text-align:center">
                <thead>
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
                <button class="ui green button" @click="letterGen('tardy_warningLetter')">Warning</a>
                    <button class="ui blue button" @click="letterGen('tardy_reprimandLetter')">Reprimand</a>
                        <button class="ui yellow button">Suspension</button>
                        <button class="ui red button">Termination</button>
            </center>
        </div>
    </div>

    <!-- end  -->

    <div class="ui segment noprint" style="margin:auto;max-width:50%;min-width:500px;">
        <h1>DTR Summary</h1>
        <div class="ui section divider"></div>
        <form class="ui form" @submit.prevent="getDataNeeded()">
            <div class="field">
                <label>Select month:</label>
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
            <h3><i class="filter icon"></i> Filter: </h3>
            <div class="field">
                <label>by department</label>
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
                        <label>Show 10x tardy ONLY</label>
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
                        <th class="abc" colspan="7">
                            Summary table {{period}}
                        </th>
                        <th colspan="5" class="abc">
                            <div class="ui icon input fluid" style="visibility:hidden">
                                <i class="search icon"></i>
                                <input type="text" placeholder="Search..." v-model="findInTable">
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th class="ab"></th>
                        <th class="ab"></th>
                        <th class="ab"></th>
                        <th class="ab" colspan="4" style="text-align: center">TARDY</th>
                        <th class="ab" colspan="3" style="text-align: center">UNDERTIME</th>
                        <th class="ab"></th>
                        <th class="ab"></th>
                    </tr>
                    <tr>
                        <th class="a"></th>
                        <th class="a">Employee</th>
                        <th class="a">Department</th>
                        <th class="a">No. of times</th>
                        <th class="a">Total mins.</th>
                        <th class="a">Date of half-day</th>
                        <th class="a">Equiv.</th>
                        <th class="a">Total mins.</th>
                        <th class="a">Date of half-day</th>
                        <th class="a">Equiv.</th>
                        <th class="a" style="text-align: center">Remarks</th>
                        <th class="a" style="text-align: center">Options</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(ar,index) in sortArrays(dep.dat)" :style="'background-color:'+ar.color">
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
                        <td><button class="ui button primary" v-if="parseInt(ar.totalTardy)>=10" @click="showOptionModal(ar)">View</button></td>
                    </tr>
                </tbody>
            </table>

            <br>
        </template>
        <template v-else-if="filterTardy.length>0">
            <table class="ui celled selectable compact table" style="width:95%;margin:auto">
                <thead>
                    <tr>

                        <th colspan="12" class="abc">
                            Summary table {{period}}
                        </th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th colspan="4" style="text-align: center">TARDY</th>
                        <th colspan="3" style="text-align: center">UNDERTIME</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th></th>
                        <th>Employee</th>
                        <th>Department</th>
                        <th>No. of times</th>
                        <th>Total mins.</th>
                        <th>Date of half-day</th>
                        <th>Equiv.</th>
                        <th>Total mins.</th>
                        <th>Date of half-day</th>
                        <th>Equiv.</th>
                        <th style="text-align: center">Remarks</th>
                        <th style="text-align: center">Options</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(ar,index) in sortArrays(filterTardy)" :style="'background-color:'+ar.color">
                        <td>
                            <button v-if="!ar.color" class="ui yellow compact icon mini button" @click="changeColor(ar.dtrSummary_id,'#ead74da8')">
                                <i class="check icon"></i>
                            </button>
                            <button v-else class="ui inverted red compact icon mini button" @click="revertColor(ar.dtrSummary_id)">
                                <i class="close icon"></i>
                            </button>

                        </td>
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
                        <td><button class="ui button primary" v-if="parseInt(ar.totalTardy)>=10" @click="showOptionModal(ar)">View</button></td>
                    </tr>
                </tbody>
            </table>
        </template>
        <template v-else>
            <table class="ui celled selectable compact table" style="width:95%;margin:auto" v-if="DataRequest.length>0">
                <thead>
                    <tr>
                        <th colspan="6" class="abc">
                            Summary table {{period}}
                        </th>
                        <th colspan="5" class="abc">
                            <div class="ui icon input fluid">
                                <i class="search icon"></i>
                                <input type="text" placeholder="Search..." v-model="findInTable">
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th class="ab"></th>
                        <th class="ab"></th>
                        <th class="ab"></th>
                        <th class="ab" colspan="4" style="text-align: center">TARDY</th>
                        <th class="ab" colspan="3" style="text-align: center">UNDERTIME</th>
                        <th class="ab"></th>
                        <th class="ab"></th>
                    </tr>
                    <tr>
                        <th class="a"></th>
                        <th class="a">Employee</th>
                        <th class="a">Department</th>
                        <th class="a">No. of times</th>
                        <th class="a">Total mins.</th>
                        <th class="a">Date of half-day</th>
                        <th class="a">Equiv.</th>
                        <th class="a">Total mins.</th>
                        <th class="a">Date of half-day</th>
                        <th class="a">Equiv.</th>
                        <th class="a" style="text-align: center">Remarks</th>
                        <th class="a" style="text-align: center">Options</th>
                    </tr>
                </thead>
                <tbody id="allDataTable">
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
                        <td><button style="margin: 2px;" class="ui mini button primary" v-if="parseInt(ar.totalTardy)>=10" @click="showOptionModal(ar)">View</button>
                            <button style="margin: 2px;" class="ui mini icon button primary" @click="refreshDtrSummary(ar)"><i class="ui icon refresh"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </template>
    </template>
</div>
<script src="umbra/dtrManagement/config_summary.js"></script>
<script>
    $(document).ready(function() {
        $('.dropdown').dropdown({
            fullTextSearch: true
        });
    });
</script>
<?php
require_once "footer.php";
?>