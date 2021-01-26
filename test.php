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
                        <td>{{ar.remarks}}</td>
                        <td><button class="ui button primary" v-if="parseInt(ar.totalTardy)>=10" @click="showOptionModal(index)">Open Modal</button></td>
                    </tr>
                </tbody>
            </table>
