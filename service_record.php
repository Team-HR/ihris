    <div id="app_sr">
        <div class="ui modal" id="addSR">
            <div class="header">SERVICE RECORD BUILDUP</div>
            <div class="content">
                <form class='ui form' @submit.prevent="save_form_data(<?=$_GET['employees_id']?>)">
                    <div class="field">
                        <label>Service Record Type:</label>
                        <select class="ui search dropdown" v-model="sr_form" id="sr_form">
                            <option value="">Type here...</option>
                            <option v-for="(sr,index) in srtype_array" :key="index" :value="sr">{{ sr }}</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>DESIGNATION</label>
                        <textarea rows="2" v-model="designation_form"></textarea>
                        <!-- <select class="ui search dropdown" v-model="designation_form">
                            <option value="">Type here...</option>
                            <option v-for="(desig,index) in designation_array" :key='index' :value="desig.position_id">{{ desig.position }} - {{ desig.functional }}</option>
                        </select> -->
                    </div>
                    <div class="field">
                        <label>Status</label>
                        <select class="ui search dropdown" v-model="status_form" id="status_form">
                            <option value="">Type here...</option>
                            <option v-for="(stat,index) in status_array" :key="index" :value="stat">{{ stat }}</option>   
                        </select>
                    </div>
                    <div class="fields">
                        <div class="six wide field">
                            <label>Annual Salary Rate</label>
                            <input type="number" placeholder="000.00" v-model="salaryAnnual">
                        </div>
                        <div class="six wide field">
                            <label>Session</label>
                            <select class="ui search dropdown" v-model="session_form" id="session_form">
                                <option value=""></option>
                                <option value="0">-------</option>
                                <option value="1">Per Session</option>
                            </select>
                        </div>
                        <div class="six wide field">
                            <label>Rate on Schedule</label>
                            <select class="ui search dropdown" v-model="salaryPerSchedule">
                                <option value="">SELECT salary</option>
                                <option value="0">-------</option>
                                <option v-for="(sal,index) in salary_array" :value="sal.monthly_salary">{{"Php."+formatNumber(sal.monthly_salary) }}</option>
                                
                            </select>
                        </div>
                    </div>
                    <div class="fields">
                        <div class="eight wide field">
                            <label>Date From</label>
                            <input type="date" v-model="from_form">
                        </div>
                        <div class="eight wide field">
                            <label>Date To</label>
                            <input type="date" v-model="to_form">
                        </div>
                    </div>
                    <div class="fields">
                        <div class="eight wide field">
                            <label> Place of Assignment </label>
                            <input type="text" v-model="assign_form">
                        </div>
                        <div class="eight wide field">
                            <label>Branch</label>
                            <select class="ui search dropdown" v-model="branch_form" id="branch_form">
                                <option value="">Type here...</option>
                                <option value="Local">Local</option>
                                <option value="National">National</option>
                                <option value="Province">Province</option>
                            </select>
                        </div>
                    </div>
                    <div class="field">
                        <label>Remarks</label>
                        <textarea rows="2" v-model="remarks_form"></textarea>
                    </div>
                    <div class="field">
                        <label>MEMO</label>
                        <textarea rows="4" v-model="memo_form"></textarea>
                    </div>
                    <button class="ui button primary">SAVE</button>
                </form>
            </div>
        </div>        
        <div class="ui segment">
            <div>
            </div>

            <div style="float:left">
                <h2>Service Record</h2>
            </div>
            <div style="float:right">
                <button class="ui button tiny icon primary" @click="openAddSr()">
                    <i class="add icon"></i>
                </button>
            </div>
            <div style="clear:both"></div>
            <hr>
            <table class="ui table" style="font-size:11px" border="1px" id="srTable" data-id="<?=$_GET['employees_id']?>">
                <thead style="text-align:center">
                    <tr>
                        <th colspan="2">SERVICE (inclusive dates)</th>
                        <th colspan="3">RECORD of appointment</th>
                        <th colspan="2">OFFICE / ENTITY / DIVISION</th>
                        <th rowspan="2">SEPARTION L/V ABS W/O PAY</th>
                        <th rowspan="2">OPTIONS</th>
                    </tr>
                    <tr>
                        <th>FROM</th>
                        <th>TO</th>
                        <th>Designation</th>
                        <th>Status</th>
                        <th>Annual Salary</th>
                        <th>Station / Place of Assignment</th>
                        <th>Branch</th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="sr_data.length<1">
                        <tr>
                            <td colspan="9" style="font-size:20px;text-align:center;color:#5555557a;padding:20px">EMPTY</td>
                        </tr>
                    </template>
                    <template v-else>
                        <tr v-for="(srDat,index) in sr_data" :key="index">
                            <td>{{srDat.sr_from}}</td>
                            <td>{{srDat.sr_to}}</td>
                            <td>{{srDat.sr_designation}}</td>
                            <td>{{srDat.status}}</td>
                            <td>{{"Php."+formatNumber(srDat.sr_salary_rate)}}</td>
                            <td>{{srDat.sr_place_of_assignment}}</td>
                            <td>{{srDat.sr_branch}}</td>
                            <td>{{srDat.remarks}}</td>
                            <td>
                                <div class="ui buttons">
                                    <button class="ui tiny button icon green" @click="editor(index)"><i class="edit icon"></i></button>
                                    <button class="ui tiny button icon" @click="removeSr(srDat.id)"><i class="trash icon"></i></button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
    <script src="umbra/service_record/config.js"></script>