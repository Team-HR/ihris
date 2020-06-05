<div id="pds_personal">
<div id="form_pds_personal" class="ui tiny form">
    <button @click="goUpdate" id="btn_pds_personal_update" class="ui mini teal button"><i class="icon edit"></i> Update</button>

    <div id="btns_pds_personal_update" class="ui mini buttons" style="display:none">
        <button @click="goSave" class="ui green button"><i class="icon save"></i> Save</button>
            <div class="or"></div>
        <button @click="goCancel" class="ui red button"><i class="icon trash"></i> Discard</button>
    </div>

    <h4 class="ui header">I. PERSONAL INFORMATION</h4>
    <i>Bio</i>
    <hr>
    <div class="four fields">
        <div class="field">
            <label>Lastname:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.lastName" type="text" placeholder="--- N/A ---">
        </div>
        <div class="field">
            <label>Firstname:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.firstName" type="text" placeholder="--- N/A ---">
        </div>
        <div class="field">
            <label>Middlename:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.middleName" type="text" placeholder="--- N/A ---">
        </div>
        <div class="field">
            <label>Name extension:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.extName" type="text" placeholder="--- N/A ---">
        </div>
    </div>
    <div class="fields">
        <div class="field">
            <label>Date of Birth:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.birthdate" type="date" placeholder="--- N/A ---"> 
        </div>
        <div class="field">
            <label>Place of Birth:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.birthplace" type="text" placeholder="--- N/A ---"> 
        </div>
        <div class="field">
            <label>Citizenship:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.citizenship" type="text" placeholder="--- N/A ---"> 
        </div>
        <div class="field">
            <label>Sex:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.gender" type="text" placeholder="--- N/A ---"> 
        </div>
        <div class="field">
            <label>Civil Status:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.civil_status" type="text" placeholder="--- N/A ---"> 
        </div>
    </div>
    <div class="fields">
        <div class="field">
            <label>Height (m):</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.height" type="text" placeholder="--- N/A ---"> 
        </div>
        <div class="field">
            <label>Weight (kg):</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.weight" type="text" placeholder="--- N/A ---"> 
        </div>
        <div class="field">
            <label>Blood Type:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.blood_type" type="text" placeholder="--- N/A ---"> 
        </div>
    </div>
    <i>Government Agency Details</i>
    <hr>
    <div class="five fields">
        <div class="field">
            <label>GSIS ID No:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.gsis_id" type="text" placeholder="--- N/A ---"> 
        </div>
        <div class="field">
            <label>PAG-IBIG ID No:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.pag_ibig_id" type="text" placeholder="--- N/A ---"> 
        </div>
        <div class="field">
            <label>PHILHEALTH No:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.philhealth_id" type="text" placeholder="--- N/A ---"> 
        </div>
        <div class="field">
            <label>SSS No:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.sss_id" type="text" placeholder="--- N/A ---"> 
        </div>
        <div class="field">
            <label>TIN No:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.tin_id" type="text" placeholder="--- N/A ---"> 
        </div>
    </div>
    <i>Residential Address</i> 
    <hr>
    <div class="three fields">
        <div class="field">
            <label>House/Block/Lot No.:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.res_house_no" type="text" placeholder="--- N/A ---">
        </div>
        <div class="field">
            <label>Street:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.res_street" type="text" placeholder="--- N/A ---">
        </div>
        <div class="field">
            <label>Subdivision/Village:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.res_subdivision" type="text" placeholder="--- N/A ---">
        </div>
    </div>
    <div class="four fields">
        <div class="field">
            <label>Barangay:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.res_barangay" type="text" placeholder="--- N/A ---">
        </div>
        <div class="field">
            <label>City/Municipality:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.res_city" type="text" placeholder="--- N/A ---">
        </div>
        <div class="field">
            <label>Province:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.res_province" type="text" placeholder="--- N/A ---">
        </div>
        <div class="field">
            <label>Zip Code:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.res_zip_code" type="text" placeholder="--- N/A ---">
        </div>
        <div class="field">
            <label>Tel#:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.res_tel" type="text" placeholder="--- N/A ---">
        </div>
    </div>
    <i>Permanent Address</i> 
    <hr>
    <div class="three fields">
        <div class="field">
            <label>House/Block/Lot No.:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.perm_house_no" type="text" placeholder="--- N/A ---">
        </div>
        <div class="field">
            <label>Street:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.perm_street" type="text" placeholder="--- N/A ---">
        </div>
        <div class="field">
            <label>Subdivision/Village:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.perm_subdivision" type="text" placeholder="--- N/A ---">
        </div>
    </div>
    <div class="four fields">
        <div class="field">
            <label>Barangay:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.perm_barangay" type="text" placeholder="--- N/A ---">
        </div>
        <div class="field">
            <label>City/Municipality:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.perm_city" type="text" placeholder="--- N/A ---">
        </div>
        <div class="field">
            <label>Province:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.perm_province" type="text" placeholder="--- N/A ---">
        </div>
        <div class="field">
            <label>Zip Code:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.perm_zip_code" type="text" placeholder="--- N/A ---">
        </div>
        <div class="field">
            <label>Tel#:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.perm_tel" type="text" placeholder="--- N/A ---">
        </div>
    </div>
    <i>Contact Details:</i>
    <hr>
    <div class="three fields">
        <div class="field">
            <label>Mobile#:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.mobile" type="text" placeholder="--- N/A ---">
        </div>
        <div class="field">
            <label>Email:</label>
            <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.email" type="text" placeholder="--- N/A ---">
        </div>
    </div>
</div>
</div>
