<div id="pds_training">
<div id="form_pds_training" class="ui tiny form">
    <button @click="goUpdate" id="btn_pds_training_update" class="ui mini blue button"><i class="icon edit"></i> Update</button>

    <div class="btns_pds_training_update ui mini buttons" style="display:none">
        <button @click="goSave" class="ui green button"><i class="icon save"></i> Save</button>
            <div class="or"></div>
        <button @click="goCancel" class="ui red button"><i class="icon trash"></i> Discard</button>
    </div>
    <h4 class="ui header">VII. TRAININGS</h4>
    <hr>
    <table class="ui very small compact structured celled table">
        <thead>
        <tr class="center aligned">
            <th rowspan="2">Title of Seminar/ Conference/ Workshop/ Short Courses</th>
            <th colspan="2">Inclusive Dates</th>
            <th rowspan="2">Number of Hours</th>
            <th rowspan="2">Conducted/ Sponsored By</th>
            <th :hidden="readonly" rowspan="2"></th>
        </tr>
        <tr>
            <th>From</th>
            <th>To</th>
        </tr>
        </thead>
        <tbody>

        <template v-if="trs.length != 0">
        <tr v-for="(tr,i) in trs" :key="i">
            <td><input :readonly="readonly" :class="{readOnly: readonly}" type="text" v-model="tr.tr_title"></td>
            <td><input :readonly="readonly" :class="{readOnly: readonly}" type="date" v-model="tr.tr_from"></td>
            <td><input :readonly="readonly" :class="{readOnly: readonly}" type="date" v-model="tr.tr_to"></td>
            <td><input :readonly="readonly" :class="{readOnly: readonly}" type="number" step="0.01" v-model="tr.tr_hours"></td>
            <td><input :readonly="readonly" :class="{readOnly: readonly}" type="text" v-model="tr.tr_by"></td>
            <td :hidden="readonly">
                <button class="ui mini button red icon" @click="removeItem(i)"> 
                    <i class="icon times"></i>
                </button>
            </td>
        </tr>
        </template>
        <template  v-else>
            <tr class="center aligned" style="color:lightgrey">
                <td colspan="6">-- N/A --</td>
            </tr>
        </template>
        <template v-if="!readonly">
            <tr>
                <td colspan="6">
                    <button class="ui mini icon button blue" @click="addItem">
                        <i class="icon add"></i> Add
                    </button>
                </td>
            </tr>
        </template>







        </tbody>
    </table>
</div>
</div>
<script src="pds/pds_training.js"></script>