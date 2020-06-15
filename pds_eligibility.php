<div id="pds_elig">
<div id="form_pds_elig" class="ui tiny form">
    <button @click="goUpdate" id="btn_pds_elig_update" class="ui mini teal button"><i class="icon edit"></i> Update</button>

    <div class="btns_pds_elig_update ui mini buttons" style="display:none">
        <button @click="goSave" class="ui green button"><i class="icon save"></i> Save</button>
            <div class="or"></div>
        <button @click="goCancel" class="ui red button"><i class="icon trash"></i> Discard</button>
    </div>

    <h4 class="ui header">IV. ELIGIBILITY</h4>
    <hr>
    <table class="ui very small compact structured celled table">
        <thead>
        <tr class="center aligned">
            <th rowspan="2">Career Service/ RA 1080 (Board/ BAR) Under Special Laws/ CES/ CSEE 
            Career Service/ RA 1080 (Board/ BAR)</th>
            <th rowspan="2">Rating</th>
            <th rowspan="2">Date of Examination / Conferment</th>
            <th rowspan="2">Place of Examination / Conferment</th>
            <th colspan="2">License</th>
            <th rowspan="2" :hidden="readonly"></th>
        </tr>
        <tr>
            <th>Number</th>
            <th>Date of Release</th>
        </tr>
        </thead>
        <tbody>
        <template v-if="eligs.length != 0">
        <tr v-for="(elig,i) in eligs" :key="i">
            <td><input :readonly="readonly" :class="{readOnly: readonly}" type="text" v-model="elig.elig_title"></td>
            <td><input :readonly="readonly" :class="{readOnly: readonly}" type="text" v-model="elig.rating"></td>
            <td><input :readonly="readonly" :class="{readOnly: readonly}" type="date" v-model="elig.exam_date"></td>
            <td><input :readonly="readonly" :class="{readOnly: readonly}" type="text" v-model="elig.exam_place"></td>
            <td><input :readonly="readonly" :class="{readOnly: readonly}" type="text" v-model="elig.license_id"></td>
            <td><input :readonly="readonly" :class="{readOnly: readonly}" type="date" v-model="elig.release_date"></td>
            <td :hidden="readonly">
                <button class="ui mini button red icon" @click="removeItem(i)"> 
                    <i class="icon times"></i>
                </button>
            </td>
        </tr>
        </template>
        <template  v-else>
            <tr class="center aligned" style="color:lightgrey">
                <td colspan="7">-- N/A --</td>
            </tr>
        </template>
        <template v-if="!readonly">
            <tr>
                <td colspan="7">
                    <button class="ui mini icon button blue" @click="addItem">
                        <i class="icon add"></i> Add
                    </button>
                </td>
            </tr>
        </template>
        </tbody>
    </table>

    <div class="btns_pds_elig_update ui mini buttons" style="display:none">
        <button @click="goSave" class="ui green button"><i class="icon save"></i> Save</button>
            <div class="or"></div>
        <button @click="goCancel" class="ui red button"><i class="icon trash"></i> Discard</button>
    </div>
    
</div>
</div>

<script src="pds/pds_eligibility.js"></script>