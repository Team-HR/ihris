<div id="pds_other_information" class="ui tiny form">

    <button @click="readonly=false;" id="go_update_btn" class="ui mini teal button" :style="{display:!readonly?'none':''}"><i class="icon edit"></i> Update</button>

    <div class="ui mini buttons" :style="{display:readonly?'none':''}">
        <button @click="goSave" class="ui green button"><i class="icon save"></i> Save</button>
            <div class="or"></div>
        <button @click="getEmployeeData;readonly=true;" class="ui red button"><i class="icon trash"></i> Discard</button>
    </div>

    <h4 class="ui header">VIII. OTHER INFORMATION</h4>
    <hr>
    <table class="ui very small compact structured celled table">
        <thead>
        <tr class="center aligned">
            <th>Special Skills/ Hobbies</th>
            <th>Non-Academic Distinctions/ Recognition</th>
            <th>Membership in Association/ Organization</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="vertical-align: top; width: 33%;">
                <template>
                    <div v-for="(pds_hobbies_and_skill,i) in pds_hobbies_and_skills" class="ui icon input fluid"  style="margin-bottom: 2px;">
                        <input :readonly="readonly" :class="{readOnly: readonly}" type="text" :key="i" v-model="pds_hobbies_and_skills[i]">
                        <i :class="{times:!readonly}" class="circular link icon" @click="pds_hobbies_and_skills.splice(i,1)"></i>
                    </div>
                    <p v-if="pds_hobbies_and_skills.length === 0" style="text-align:center;">-- N/A --</p>
                    <button @click="pds_hobbies_and_skills.push('')" class="ui mini button blue icon" style="margin-top: 5px;" :style="{display:readonly?'none':''}"><i class="icon add"></i> Add</button>
                </template>
            </td>
            <td style="vertical-align: top; width: 33%;">
                <template>
                    <div v-for="(pds_non_academic_recognition,i) in pds_non_academic_recognitions" class="ui icon input fluid"  style="margin-bottom: 2px;">
                        <input :readonly="readonly" :class="{readOnly: readonly}" type="text" :key="i" v-model="pds_non_academic_recognitions[i]">
                        <i :class="{times:!readonly}" class="circular link icon" @click="pds_non_academic_recognitions.splice(i,1)"></i>
                    </div>
                    <p v-if="pds_non_academic_recognitions.length === 0" style="text-align:center;">-- N/A --</p>
                    <button @click="pds_non_academic_recognitions.push('')" class="ui mini button blue icon" style="margin-top: 5px;" :style="{display:readonly?'none':''}"><i class="icon add"></i> Add</button>
                </template>
            </td>
            <td style="vertical-align: top; width: 33%;">
            <template>
                    <div v-for="(pds_org_membership,i) in pds_org_memberships" class="ui icon input fluid"  style="margin-bottom: 2px;">
                        <input :readonly="readonly" :class="{readOnly: readonly}" type="text" :key="i" v-model="pds_org_memberships[i]">
                        <i :class="{times:!readonly}" class="circular link icon" @click="pds_org_memberships.splice(i,1)"></i>
                    </div>
                    <p v-if="pds_org_memberships.length === 0" style="text-align:center;">-- N/A --</p>
                    <button @click="pds_org_memberships.push('')" class="ui mini button blue icon" style="margin-top: 5px;" :style="{display:readonly?'none':''}"><i class="icon add"></i> Add</button>
                </template>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<script src="pds/pds_other_information.js"></script>