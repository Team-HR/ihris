<div id="pds_voluntary">
<div id="form_pds_voluntary" class="ui tiny form">
    <button @click="goUpdate" id="btn_pds_voluntary_update" class="ui mini blue button"><i class="icon edit"></i> Update</button>

    <div class="btns_pds_voluntary_update ui mini buttons" style="display:none">
        <button @click="goSave" class="ui green button"><i class="icon save"></i> Save</button>
            <div class="or"></div>
        <button @click="goCancel" class="ui red button"><i class="icon trash"></i> Discard</button>
    </div>

    <h4 class="ui header">VI. VOLUNTARY WORKS</h4>
    <hr>
    <table class="ui very small compact structured celled table">
        <thead>
        <tr class="center aligned">
            <th rowspan="2">Name & Address of Organization</th>
            <th colspan="2">Inclusive Dates</th>
            <th rowspan="2">Number of Hours</th>
            <th rowspan="2">Position/ Nature of Work</th>
            <th rowspan="2"></th>
        </tr>
        <tr>
            <th>From</th>
            <th>To</th>
        </tr>
        </thead>
        <tbody>


        <template v-if="vols.length != 0">
        <tr v-for="(vol,i) in vols" :key="i">
            <td><input :readonly="readonly" :class="{readOnly: readonly}" type="text" v-model="vol.vw_organization"></td>
            <td><input :readonly="readonly" :class="{readOnly: readonly}" type="date" v-model="vol.vw_from"></td>
            <td><input :readonly="readonly" :class="{readOnly: readonly}" type="date" v-model="vol.vw_to"></td>
            <td><input :readonly="readonly" :class="{readOnly: readonly}" type="number" step="0.01" v-model="vol.vw_hours"></td>
            <td><input :readonly="readonly" :class="{readOnly: readonly}" type="text" v-model="vol.vw_nature_work"></td>
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

    <div class="btns_pds_voluntary_update ui mini buttons" style="display:none">
        <button @click="goSave" class="ui green button"><i class="icon save"></i> Save</button>
            <div class="or"></div>
        <button @click="goCancel" class="ui red button"><i class="icon trash"></i> Discard</button>
    </div>


</div>
</div>

<script src="pds/pds_voluntary.js"></script>