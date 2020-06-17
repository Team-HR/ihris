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
                    <p v-if="pds_hobbies_and_skills.length === 0" style="text-align:center; color: lightgrey;">-- N/A --</p>
                    <button @click="pds_hobbies_and_skills.push('')" class="ui mini button blue icon" style="margin-top: 5px;" :style="{display:readonly?'none':''}"><i class="icon add"></i> Add</button>
                </template>
            </td>
            <td style="vertical-align: top; width: 33%;">
                <template>
                    <div v-for="(pds_non_academic_recognition,i) in pds_non_academic_recognitions" class="ui icon input fluid"  style="margin-bottom: 2px;">
                        <input :readonly="readonly" :class="{readOnly: readonly}" type="text" :key="i" v-model="pds_non_academic_recognitions[i]">
                        <i :class="{times:!readonly}" class="circular link icon" @click="pds_non_academic_recognitions.splice(i,1)"></i>
                    </div>
                    <p v-if="pds_non_academic_recognitions.length === 0" style="text-align:center;color: lightgrey;">-- N/A --</p>
                    <button @click="pds_non_academic_recognitions.push('')" class="ui mini button blue icon" style="margin-top: 5px;" :style="{display:readonly?'none':''}"><i class="icon add"></i> Add</button>
                </template>
            </td>
            <td style="vertical-align: top; width: 33%;">
            <template>
                    <div v-for="(pds_org_membership,i) in pds_org_memberships" class="ui icon input fluid"  style="margin-bottom: 2px;">
                        <input :readonly="readonly" :class="{readOnly: readonly}" type="text" :key="i" v-model="pds_org_memberships[i]">
                        <i :class="{times:!readonly}" class="circular link icon" @click="pds_org_memberships.splice(i,1)"></i>
                    </div>
                    <p v-if="pds_org_memberships.length === 0" style="text-align:center;color: lightgrey;">-- N/A --</p>
                    <button @click="pds_org_memberships.push('')" class="ui mini button blue icon" style="margin-top: 5px;" :style="{display:readonly?'none':''}"><i class="icon add"></i> Add</button>
                </template>
            </td>
        </tr>
        </tbody>
    </table>

    <div class="ui segment">
        <p>Are you related by consanguinity or affinity to the appointing or recommending authority, or to the chief of bureau or office or to the person who has immediate supervision over you in the Office, Bureau or Department where you will be apppointed,</p>
        <p>a. within the third degree?</p>  
        <div class="ui checkbox" style="margin-right:15px;">
            <input type="checkbox" name="example">
            <label>Yes</label>
        </div>
        <div class="ui checkbox">
            <input type="checkbox" name="example1">
            <label>No</label>
        </div>
        <p style="margin-top: 15px;">b. within the fourth degree (for Local Government Unit - Career Employees)?</p>
        <div class="ui checkbox" style="margin-right:15px;">
            <input type="checkbox" name="example">
            <label>Yes</label>
        </div>
        <div class="ui checkbox">
            <input type="checkbox" name="example1">
            <label>No</label>
        </div>
        <div class="ui form" style="margin-top: 5px;">
            <div class="field">
                <div class="ui left labeled input">
                        <div class="ui label" style="font-weight: normal;">If YES, give details:</div>
                        <input type="text" placeholder="Please provide the details...">    
                </div>
            </div>
        </div>
    </div>
    <div class="ui segment">    
    <p>Have you ever been found guilty of any administrative offense?</p>
        <div class="ui checkbox" style="margin-right:15px;">
            <input type="checkbox" name="example">
            <label>Yes</label>
        </div>
        <div class="ui checkbox">
            <input type="checkbox" name="example1">
            <label>No</label>
        </div>
        <div class="ui form" style="margin-top: 5px;">
            <div class="field">
                <div class="ui left labeled input">
                        <div class="ui label" style="font-weight: normal;">If YES, give details:</div>
                        <input type="text" placeholder="Please provide the details...">    
                </div>
            </div>
        </div>
    </div>
    <div class="ui segment">    
    <p>Have you been criminally charged before any court?</p>
        <div class="ui checkbox" style="margin-right:15px;">
            <input type="checkbox" name="example">
            <label>Yes</label>
        </div>
        <div class="ui checkbox">
            <input type="checkbox" name="example1">
            <label>No</label>
        </div>
        <div class="ui form" style="margin-top: 5px;">
        <p for="">If YES, give details:</p>
            <div class="two fields">
                <div class="field">
                    <div class="ui left labeled input">
                        <div class="ui label" style="font-weight: normal;">Date Filed:</div>
                        <input type="date">    
                    </div>
                </div>
                <div class="field">
                    <div class="ui left labeled input">
                        <div class="ui label" style="font-weight: normal;">Status of Case/s:</div>
                        <input type="text" placeholder="Status of case/s..">    
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="ui segment">    
    <p>Have you ever been convicted of any crime or violation of any law, decree, ordinance or regulation by any court or tribunal?</p>
        <div class="ui checkbox" style="margin-right:15px;">
            <input type="checkbox" name="example">
            <label>Yes</label>
        </div>
        <div class="ui checkbox">
            <input type="checkbox" name="example1">
            <label>No</label>
        </div>
        <div class="ui form" style="margin-top: 5px;">
            <div class="field">
                <div class="ui left labeled input">
                        <div class="ui label" style="font-weight: normal;">If YES, give details:</div>
                        <input type="text" placeholder="Please provide the details...">    
                </div>
            </div>
        </div>
    </div>
    <div class="ui segment">    
    <p>Have you ever been separated from the service in any of the following modes: resignation, retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or phased out (abolition) in the public or private sector?</p>
        <div class="ui checkbox" style="margin-right:15px;">
            <input type="checkbox" name="example">
            <label>Yes</label>
        </div>
        <div class="ui checkbox">
            <input type="checkbox" name="example1">
            <label>No</label>
        </div>
        <div class="ui form" style="margin-top: 5px;">
            <div class="field">
                <div class="ui left labeled input">
                        <div class="ui label" style="font-weight: normal;">If YES, give details:</div>
                        <input type="text" placeholder="Please provide the details...">    
                </div>
            </div>
        </div>
    </div>
    <div class="ui segment">    
    <p>Have you ever been a candidate in a national or local election held within the last year (except Barangay election)?</p>
        <div class="ui checkbox" style="margin-right:15px;">
            <input type="checkbox" name="example">
            <label>Yes</label>
        </div>
        <div class="ui checkbox">
            <input type="checkbox" name="example1">
            <label>No</label>
        </div>
        <div class="ui form" style="margin-top: 5px;">
            <div class="field">
                <div class="ui left labeled input">
                        <div class="ui label" style="font-weight: normal;">If YES, give details:</div>
                        <input type="text" placeholder="Please provide the details...">    
                </div>
            </div>
        </div>
    </div>
    <div class="ui segment">    
    <p>Have you resigned from the government service during the three (3)-month period before the last election to promote/actively campaign for a national or local candidate?</p>
        <div class="ui checkbox" style="margin-right:15px;">
            <input type="checkbox" name="example">
            <label>Yes</label>
        </div>
        <div class="ui checkbox">
            <input type="checkbox" name="example1">
            <label>No</label>
        </div>
        <div class="ui form" style="margin-top: 5px;">
            <div class="field">
                <div class="ui left labeled input">
                        <div class="ui label" style="font-weight: normal;">If YES, give details:</div>
                        <input type="text" placeholder="Please provide the details...">    
                </div>
            </div>
        </div>
    </div>
    <div class="ui segment">    
    <p>Have you acquired the status of an immigrant or permanent resident of another country?</p>
        <div class="ui checkbox" style="margin-right:15px;">
            <input type="checkbox" name="example">
            <label>Yes</label>
        </div>
        <div class="ui checkbox">
            <input type="checkbox" name="example1">
            <label>No</label>
        </div>
        <div class="ui form" style="margin-top: 5px;">
            <div class="field">
                <div class="ui left labeled input">
                        <div class="ui label" style="font-weight: normal;">If YES, give details:</div>
                        <input type="text" placeholder="Please provide the details...">    
                </div>
            </div>
        </div>
    </div>
    <div class="ui segment">    
    <p>Pursuant to: (a) Indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons (RA 7277); and (c) Solo Parents Welfare Act of 2000 (RA 8972), please answer the following items:</p>

        <p>Are you a member of any indigenous group?</p>
        <div class="ui checkbox" style="margin-right:15px;">
            <input type="checkbox" name="example">
            <label>Yes</label>
        </div>
        <div class="ui checkbox">
            <input type="checkbox" name="example1">
            <label>No</label>
        </div>
        <div class="ui form" style="margin-top: 5px;">
            <div class="field">
                <div class="ui left labeled input">
                        <div class="ui label" style="font-weight: normal;">If YES, give details:</div>
                        <input type="text" placeholder="Please provide the details...">    
                </div>
            </div>
        </div>
        <p style="margin-top: 15px;">Are you a person with disability?</p>
        <div class="ui checkbox" style="margin-right:15px;">
            <input type="checkbox" name="example">
            <label>Yes</label>
        </div>
        <div class="ui checkbox">
            <input type="checkbox" name="example1">
            <label>No</label>
        </div>
        <div class="ui form" style="margin-top: 5px;">
            <div class="field">
                <div class="ui left labeled input">
                        <div class="ui label" style="font-weight: normal;">If YES, please specify ID No:</div>
                        <input type="text" placeholder="Please provide the details...">    
                </div>
            </div>
        </div>
        <p style="margin-top: 15px;">Are you a solo parent?</p>
        <div class="ui checkbox" style="margin-right:15px;">
            <input type="checkbox" name="example">
            <label>Yes</label>
        </div>
        <div class="ui checkbox">
            <input type="checkbox" name="example1">
            <label>No</label>
        </div>
        <div class="ui form" style="margin-top: 5px;">
            <div class="field">
                <div class="ui left labeled input">
                        <div class="ui label" style="font-weight: normal;">If YES, please specify ID No:</div>
                        <input type="text" placeholder="Please provide the details...">    
                </div>
            </div>
        </div>
    </div>
        <h5>REFERENCES</h5>
    <table class="ui very small compact structured celled table">
        <thead>
        <tr class="center aligned">
            <th>Name</th>
            <th>Address</th>
            <th>Telephone No.</th>
            <th :hidden="readonly" style="width: 20px;"></th>
        </tr>
        </thead>
        <tbody>
        <template v-for="(pds_reference,i) in pds_references" :key="i">
            <tr>
                <td><input :readonly="readonly" :class="{readOnly:readonly}" type="text" v-model="pds_reference.ref_name"></td>
                <td><input :readonly="readonly" :class="{readOnly:readonly}" type="text" v-model="pds_reference.ref_address"></td>
                <td><input :readonly="readonly" :class="{readOnly:readonly}" type="text" v-model="pds_reference.ref_tel"></td>



                <td :hidden="readonly"><button @click="pds_references.splice(i,1)" class="ui mini red icon button"><i class="icon times"></i> </button> </td>
            </tr>
        </template>
            <template v-if="pds_references.length === 0">
                <tr style="text-align: center; color: lightgrey;">
                    <td colspan="4">-- N/A --</td>
                </tr>
            </template>
        <tr :hidden="readonly">
            <td colspan="4">
                <button @click="pds_references.push({ref_name: null,ref_address: null,ref_tel: null});" class="ui mini blue icon button"><i class="icon add"></i> Add</button>
            </td>
        </tr>
        </tbody>
    </table>
    <button @click="readonly=false;" id="go_update_btn" class="ui mini teal button" :style="{display:!readonly?'none':''}"><i class="icon edit"></i> Update</button>

    <div class="ui mini buttons" :style="{display:readonly?'none':''}">
        <button @click="goSave" class="ui green button"><i class="icon save"></i> Save</button>
            <div class="or"></div>
        <button @click="getEmployeeData;readonly=true;" class="ui red button"><i class="icon trash"></i> Discard</button>
    </div>
</div>

<script src="pds/pds_other_information.js"></script>