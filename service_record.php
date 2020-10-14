    <div id="app_sr">
        <template>
            <div class="ui modal" id="addSR">
                <div class="header">SERVICE RECORD BUILDUP</div>
                <div class="content">
                    <form class="ui form" id="add_edit_form" @submit.prevent="submit_form">
                        <div class="ui two column grid">
                            <div class="column">
                                <!-- column 1 -->
                                <div class="field">
                                    <label>Service Record Type:</label>
                                    <select style="position:relative; z-index: 100;" class="ui selection compact dropdown" v-model="sr_type" id="sr_type">
                                        <option value="">Select Type</option>
                                        <option v-for="(type,index) in record_types" :key="index" :value="type">{{ type }}</option>
                                    </select>
                                </div>
                                <div class="field">
                                    <label>Designation:</label>
                                    <select class="ui fluid search dropdown" v-model="sr_designation" id="sr_designation">
                                        <option value="" disabled>Select</option>
                                        <option v-for="(position,index) in positions" :key='index' :value="position">{{ position }}</option>
                                    </select>
                                </div>
                                <div class="field">
                                    <label>Status:</label>
                                    <select class="ui selection dropdown" v-model="sr_status" id="sr_status">
                                        <option value="">Select Status</option>
                                        <option v-for="(stat,index) in statuses" :key="index" :value="stat">{{ stat }}</option>
                                    </select>
                                </div>
                                <div class="fields">
                                    <div class="field">
                                        <label>Salary Type:</label>
                                        <!-- <input id="sr_salary_rate" type="number" placeholder="000.00" v-model="sr_salary_rate"> -->
                                        <select class="ui selection dropdown" id="sr_salary_type" v-model="sr_salary_type">
                                            <option value="for_buildup" selected>For Buildup</option>
                                            <option value="rate_on_schedule" v-if="sr_status!=='CASUAL'">Rate on Schedule</option>
                                        </select>

                                    </div>
                                    <div class="field">
                                        <label>
                                            <span :hidden="sr_salary_type == 'rate_on_schedule'">For Buildup {{sr_status==='CASUAL'?'(Daily Rate)':'(Annual Rate)'}}:</span>
                                            <span :hidden="sr_salary_type == 'for_buildup'">Rate on Schedule (Annual Rate): </span>
                                        </label>
                                        <div :hidden="sr_salary_type == 'rate_on_schedule'">
                                            <input id="sr_salary_rate" type="number" placeholder="Php. ---" v-model="sr_salary_rate" step="0.01">
                                        </div>
                                        <div :hidden="sr_salary_type == 'for_buildup'">
                                            <select class="ui fluid search dropdown" v-model="sr_rate_on_schedule" id="sr_rate_on_schedule">
                                                <option value="">Select salary</option>
                                                <option v-for="(salary,index) in salaries" :value="salary.value">{{salary.text}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="field">
                                    <label>Session:</label>
                                    <select class="ui compact dropdown" v-model="sr_is_per_session" id="sr_is_per_session">
                                        <option value="" disabled>No</option>
                                        <option value="0">No</option>
                                        <option value="1">Per Session</option>
                                    </select>
                                </div>
                            </div>
                            <div class="column">
                                <!-- column 2 -->

                                <div class="fields">
                                    <div class="eight wide field">
                                        <label>From:</label>
                                        <input id="sr_date_from" type="date" v-model="sr_date_from">
                                    </div>
                                    <div class="eight wide field">
                                        <label>To:</label>
                                        <input type="date" v-model="sr_date_to">
                                    </div>
                                </div>
                                <div class="fields">
                                    <div class="eight wide field">
                                        <label>Place of Assignment:</label>
                                        <select class="ui fluid search selection dropdown" v-model="sr_place_of_assignment" id="sr_place_of_assignment">
                                            <option value="" disabled>Select</option>
                                            <option v-for="(place,index) in place_of_assignments" :key='index' :value="place">{{ place }}</option>
                                        </select>
                                    </div>
                                    <div class="eight wide field">
                                        <label>Branch:</label>
                                        <select class="ui selection dropdown" v-model="sr_branch" id="sr_branch">
                                            <option value="">Select Branch</option>
                                            <option value="LOCAL">LOCAL</option>
                                            <option value="NATIONAL">NATIONAL</option>
                                            <option value="PROVINCE">PROVINCE</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="field">
                                    <label>Remarks:</label>
                                    <textarea id="sr_remarks" rows="2" v-model="sr_remarks" placeholder="Enter remarks"></textarea>
                                </div>
                                <div class="field">
                                    <label>Memo:</label>
                                    <textarea id="sr_memo" rows="4" v-model="sr_memo" placeholder="Enter memo"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="ui error message"></div>
                    </form>
                </div>
                <div class="actions">
                    <!-- @click="submit_form()" -->
                    <button form="add_edit_form" type="submit" class="ui mini button primary"><i class="save icon"></i> Save</button>
                    <button class="ui mini button deny red" @click="clear_form()"><i class="times icon"></i> Cancel</button>
                </div>
            </div>
            <div class="ui segment">
                <div>
                </div>
                <div style="float:left">
                    <h2>Service Record</h2>
                </div>
                <div style="float:right">
                    <button class="ui button tiny icon primary" @click="init_add()" style="width: 100px;">
                        <i class="angle up icon"></i> Build-up
                    </button>
                    <a class="ui button tiny icon green" :class="{disabled:records.length>0?false:true}" style="width: 100px;" href="service_record_print.php?employee_id=<?= $employees_id ?>" target="_blank">
                        <i class="print icon"></i> Print
                    </a>
                </div>
                <div style="clear:both"></div>
                <hr>
                <table class="ui very compact small celled structured striped table" style="font-size:11px" id="srTable" data-id="<?= $_GET['employees_id'] ?>">
                    <thead style="text-align:center">
                        <tr>
                            <th rowspan="2"></th>
                            <th colspan="2">SERVICE (inclusive dates)</th>
                            <th colspan="3">RECORD of appointment</th>
                            <th colspan="2">OFFICE / ENTITY / DIVISION</th>
                            <th rowspan="2">SEPARTION L/V <br/>ABS W/O PAY</th>
                            <th rowspan="2"></th>
                        </tr>
                        <tr>
                            <th>FROM</th>
                            <th>TO</th>
                            <th>Designation</th>
                            <th>Status</th>
                            <th>Salary</th>
                            <th>Station / Place of Assignment</th>
                            <th>Branch</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="records.length < 1">
                            <td colspan="10" style="font-size:20px;text-align:center;color:#5555557a;padding:20px">EMPTY</td>
                        </tr>
                        <tr v-for="(srDat,index) in records" :key="index">
                            <td class="center aligned">
                                <i class="edit icon link" @click="init_edit(index)"></i>
                            </td>
                            <td class="center aligned">{{format_date(srDat.sr_date_from)}}</td>
                            <td class="center aligned">{{format_date(srDat.sr_date_to)}}</td>
                            <td>{{srDat.sr_designation}}</td>
                            <td>{{srDat.sr_status}}</td>
                            <td class="center aligned">{{srDat.annual_salary}}</td>
                            <td>{{srDat.sr_place_of_assignment}}</td>
                            <td class="center aligned">{{srDat.sr_branch}}</td>
                            <td>{{srDat.sr_remarks}}</td>
                            <td class="center aligned">
                                <i class="times icon link" @click="init_delete(index)"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- delete modal start -->
            <div class="ui mini modal" id="delete_modal">
                <div class="header">
                    Confirm Delete?
                </div>
                <div class="content">
                    <div class="description">
                        Are you sure you want to <strong style="color:red">permanently</strong> delete this record?
                    </div>
                </div>
                <div class="actions">
                    <button class="ui mini button primary approve">
                        <i class="icon check"></i> Yes
                    </button>
                    <button class="ui mini button red deny">
                        <i class="icon times"></i> No
                    </button>
                </div>
            </div>

            <!-- delete modal end -->

        </template>
    </div>
    <script src="umbra/service_record/config.js"></script>