<div id="pds_exp">
<div id="form_pds_exp" class="ui tiny form">
    <button @click="goUpdate" id="btn_pds_exp_update" class="ui mini blue button"><i class="icon edit"></i> Update</button>

    <div class="btns_pds_exp_update ui mini buttons" style="display:none">
        <button @click="goSave" class="ui green button"><i class="icon save"></i> Save</button>
            <div class="or"></div>
        <button @click="goCancel" class="ui red button"><i class="icon trash"></i> Discard</button>
    </div>
    
    <h4 class="ui header">V. WORK EXPERIENCE</h4>
    <hr>
    <table class="ui very small compact structured celled table">
        <thead>
        <tr class="center aligned">
            <!-- <th class="th-nopadding" rowspan="2"></th> -->
            <th class="th-nopadding" colspan="2">Inclusive Dates</th>
            <th class="th-nopadding" rowspan="2">Position/ Title</th>
            <th class="th-nopadding" rowspan="2">Department/ Agency/ Office/ Company</th>
            <th class="th-nopadding" rowspan="2">Monthly Salary</th>
            <th class="th-nopadding" rowspan="2">SG-Step</th>
            <th class="th-nopadding" rowspan="2">Status of Appointment</th>
            <th class="th-nopadding" rowspan="2">Gov't Service (Yes/No)</th>
            <th :hidden="readonly" class="th-nopadding" rowspan="2"></th>
        </tr>
        <tr>
            <th>From</th>
            <th>To</th>
        </tr>
        </thead>
        <tbody>

 <template v-if="exps.length != 0">
        <tr v-for="(exp,i) in exps" :key="i">
            <td><input :readonly="readonly" :class="{readOnly: readonly}" type="date" v-model="exp.exp_from"></td>
            <td>
                <input :readonly="readonly" :style="{display:nullDate(exp.exp_to)&&readonly?'none':''}" :class="{readOnly: readonly}" type="date" v-model="exp.exp_to" >

                <div class="ui checkbox" :style="{display:readonly?'none':''}">
                    <input :checked="nullDate(exp.exp_to)" type="checkbox" @change="exp.exp_to=null">
                    <label>PRESENT</label>
                </div>

                <span :hidden="!nullDate(exp.exp_to) || !readonly">PRESENT</span>
            </td>
            <td><input :readonly="readonly" :class="{readOnly: readonly}" type="text" v-model="exp.exp_position"></td>
            <td><input :readonly="readonly" :class="{readOnly: readonly}" type="text" v-model="exp.exp_company"></td>
            <td><input :readonly="readonly" :class="{readOnly: readonly}" type="text" v-model="exp.exp_monthly_salary"></td>
            <td><input :readonly="readonly" :class="{readOnly: readonly}" type="text" v-model="exp.exp_sg"></td>
            <td><input :readonly="readonly" :class="{readOnly: readonly}" type="text" v-model="exp.exp_status_of_appointment"></td>
            <td><input :readonly="readonly" :class="{readOnly: readonly}" type="text" v-model="exp.exp_govt"></td>
            <td :hidden="readonly">
                <button class="ui mini button red icon" @click="removeItem(i)"> 
                    <i class="icon times"></i>
                </button>
            </td>
        </tr>
        </template>
        <template  v-else>
            <tr class="center aligned" style="color:lightgrey">
                <td colspan="9">-- N/A --</td>
            </tr>
        </template>
        <template v-if="!readonly">
            <tr>
                <td colspan="9">
                    <button class="ui mini icon button blue" @click="addItem">
                        <i class="icon add"></i> Add
                    </button>
                </td>
            </tr>
        </template>



        </tbody>
    </table>
    <div class="btns_pds_exp_update ui mini buttons" style="display:none">
        <button @click="goSave" class="ui green button"><i class="icon save"></i> Save</button>
            <div class="or"></div>
        <button @click="goCancel" class="ui red button"><i class="icon trash"></i> Discard</button>
    </div>

</div>
</div>
<script src="pds/pds_work_experience.js"></script>