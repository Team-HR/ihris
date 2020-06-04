<div id="pds_family">
<div id="form_pds_family" class="ui tiny form">
    <button @click="goUpdate" id="btn_pds_family_update" class="ui mini teal button"><i class="icon edit"></i> Update</button>

    <div id="btns_pds_family_update" class="ui mini buttons" style="display:none">
        <button @click="goSave" class="ui green button"><i class="icon save"></i> Save</button>
            <div class="or"></div>
        <button @click="goCancel" class="ui red button"><i class="icon trash"></i> Discard</button>
    </div>

    <h4 class="ui header">II. FAMILY BACKGROUND</h4>
    <i>Spouse's Informaion</i>
    <hr>
    <div class="four fields">
        <div class="field">
            <label for="">Lastname:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.spouse_last_name" type="text" placeholder="--- N/A ---">
        </div>
        <div class="field">
            <label for="">Firstname:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.spouse_first_name" type="text" placeholder="--- N/A ---">
        </div>
        <div class="field">
            <label for="">Middlename:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.spouse_middle_name" type="text" placeholder="--- N/A ---">
        </div>
        <div class="field">
            <label for="">Name extension:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.spouse_ext_name" type="text" placeholder="--- N/A ---">
        </div>
    </div>
    <div class="three fields">
        <div class="field">
            <label for="">Occupation:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.spouse_occupation" type="text" placeholder="--- N/A ---">
        </div>
        <div class="field">
            <label for="">Employeer/Business Name:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.spouse_employeer" type="text" placeholder="--- N/A ---">
        </div>
        <div class="field">
            <label for="">Employeer/Business Address:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.spouse_business_address" type="text" placeholder="--- N/A ---">
        </div>
        <div class="field">
            <label for="">Mobile No.:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.spouse_mobile" type="text" placeholder="--- N/A ---">
        </div>
    </div>

    <i>Father's Name</i>
    <hr>
    <div class="four fields">
        <div class="field">
            <label for="">Lastname:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.father_last_name" type="text" placeholder="--- N/A ---">
        </div>
        <div class="field">
            <label for="">Firstname:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.father_first_name" type="text" placeholder="--- N/A ---">
        </div>
        <div class="field">
            <label for="">Middlename:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.father_middle_name" type="text" placeholder="--- N/A ---">
        </div>
        <div class="field">
            <label for="">Name extension:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.father_ext_name" type="text" placeholder="--- N/A ---">
        </div>
    </div>
    <i>Mother's Maiden Name</i>
    <hr>
    <div class="three fields">
        <div class="field">
            <label for="">Lastname:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.mother_last_name" type="text" placeholder="--- N/A ---">
        </div>
        <div class="field">
            <label for="">Firstname:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.mother_first_name" type="text" placeholder="--- N/A ---">
        </div>
        <div class="field">
            <label for="">Middlename:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.mother_middle_name" type="text" placeholder="--- N/A ---">
        </div>
    </div>
    <i>Children</i>
    <hr>
    

    <table class="ui very small compact structured celled table">
        <thead>
            <tr>
                <th>Name of the Child</th>
                <th>Date of Birth</th>
            </tr>
        </thead>
        <tbody>
        <template v-if="numOfChildren > 0">
        <tr v-for="child in employee.children">
            <td>{{child.child_name}}</td>
            <td>{{child.child_birthdate}}</td>
        </tr>
        </template>
        <template v-else>
            <tr class="center aligned" style="color:lightgrey">
                <td colspan="2">-- N/A--</td>
            </tr>
        </template>
        

        </tbody>
    </table>
</div>
</div>