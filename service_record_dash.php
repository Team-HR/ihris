<div id="app_sr">
        <template>
            <!-- <div class="ui segment"> -->
                <!-- <div>
                </div>
                <div style="float:left">
                    <h2>Service Record</h2>
                </div>
                <div style="clear:both"></div>
                <hr> -->
                <table class="ui very compact small celled structured striped table" style="font-size:11px" id="srTable" data-id="<?= $_GET['employees_id'] ?>">
                    <thead style="text-align:center">
                        <tr>
                            <th colspan="2">SERVICE <br>(inclusive dates)</th>
                            <th colspan="3">RECORD OF APPOINTMENT</th>
                            <th colspan="2">OFFICE / ENTITY / DIVISION</th>
                            <th rowspan="2">SEPARTION L/V <br />ABS W/O PAY</th>
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
                            <td colspan="8" style="font-size:20px;text-align:center;color:#5555557a;padding:20px">EMPTY</td>
                        </tr>
                        <tr v-for="(srDat,index) in records" :key="index">
                            <td class="center aligned">{{format_date(srDat.sr_date_from)}}</td>
                            <td class="center aligned">{{format_date(srDat.sr_date_to)}}</td>
                            <td>{{srDat.sr_designation}}</td>
                            <td>{{srDat.sr_status}}</td>
                            <td class="center aligned">{{srDat.annual_salary}}</td>
                            <td>{{srDat.sr_place_of_assignment}}</td>
                            <td class="center aligned">{{srDat.sr_branch}}</td>
                            <td>{{srDat.sr_remarks}}</td>
                        </tr>
                    </tbody>
                </table>
            <!-- </div> -->
        </template>
    </div>
    <script src="umbra/service_record/config_dash.js"></script>