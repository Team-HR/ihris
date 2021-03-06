<div id="pds_personal">
<div id="form_pds_personal" class="ui tiny form">
    <button @click="goUpdate" id="btn_pds_personal_update" class="ui mini blue button"><i class="icon edit"></i> Update</button>

    <div id="btns_pds_personal_update" class="ui mini buttons" style="display:none">
        <button @click="goSave" class="ui green button"><i class="icon save"></i> Save</button>
            <div class="or"></div>
        <button @click="goCancel" class="ui red button"><i class="icon trash"></i> Discard</button>
    </div>

    <h4 class="ui header">I. PERSONAL INFORMATION</h4>
    <!-- <div class="ui mini header block blue">Bio</div> -->
    <a class="ui teal ribbon label">Bio</a>
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
            <input :style="{display: !readonly?'none':''}" type="text" class="readOnly" readonly :value="employee.gender" placeholder="--- N/A ---">
            <div :style="{display: readonly?'none':''}" v-bind:class="{editState:!readonly,readOnly:readonly}" class="ui selection dropdown" id="pds_gender">
                <input type="hidden" name="gender">
                <i class="dropdown icon"></i>
                <div class="default text">Gender</div>
                <div class="menu">
                    <div class="item" data-value="MALE">MALE</div>
                    <div class="item" data-value="FEMALE">FEMALE</div>
                </div>
            </div>
        </div>
        <div class="field">
            <label>Civil Status:</label>
            <input :style="{display: !readonly?'none':''}" type="text" class="readOnly" readonly :value="employee.civil_status" placeholder="--- N/A ---">
            <div :style="{display: readonly?'none':''}" v-bind:class="{editState:!readonly,readOnly:readonly}" class="ui selection fluid dropdown" id="pds_civil_status">
                <input type="hidden" name="civil_status">
                <i class="dropdown icon"></i>
                <div class="default text">Civil Status</div>
                <div class="menu">
                    <div class="item" data-value="MARRIED">MARRIED</div>
                    <div class="item" data-value="SINGLE">SINGLE</div>
                    <div class="item" data-value="WIDOWED">WIDOWED</div>
                    <div class="item" data-value="SEPARATED">SEPARATED</div>
                    <div class="item" data-value="DIVORCED">DIVORCED</div>
                </div>
            </div>
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
            <!-- <input v-bind:class="{editState:!readonly,readOnly:readonly}" :readonly = "readonly" v-model="employee.blood_type" type="text" placeholder="--- N/A ---">  -->

            <input :style="{display: !readonly?'none':''}" type="text" class="readOnly" readonly :value="employee.blood_type" placeholder="--- N/A ---">
            <div :style="{display: readonly?'none':''}" v-bind:class="{editState:!readonly,readOnly:readonly}" class="ui selection fluid dropdown" id="pds_blood_type">
                <input type="hidden" name="blood_type">
                <i class="dropdown icon"></i>
                <div class="default text">Blood Type</div>
                <div class="menu">
                    <div class="item" data-value="A+">A+</div>
                    <div class="item" data-value="A-">A-</div>
                    <div class="item" data-value="B+">B+</div>
                    <div class="item" data-value="B-">B-</div>
                    <div class="item" data-value="O+">O+</div>
                    <div class="item" data-value="O-">O-</div>
                    <div class="item" data-value="AB+">AB+</div>
                    <div class="item" data-value="AB-">AB-</div>
                </div>
            </div>





        </div>
    </div>
    <!-- <i>Government Agency Details</i> -->
    <a class="ui teal ribbon label">Government Agency Details</a>
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
    <!-- <i>Residential Address</i>  -->
    <a class="ui teal ribbon label">Residential Address</a>
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
    <!-- <i>Permanent Address</i>  -->
    <a class="ui teal ribbon label">Permanent Address</a>
    <hr>
    <div class="ui checkbox" style="margin-top: 20px; margin-bottom: 20px;">
      <input :readonly="readonly" type="checkbox" @change="employee.permadd_resadd_same=!employee.permadd_resadd_same" :checked="employee.permadd_resadd_same">
      <label>Same as Residential Address</label>
    </div>
    <br>
    <div :hidden="employee.permadd_resadd_same">
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
    </div>
    <!-- <i>Contact Details:</i> -->
    <a class="ui teal ribbon label">Contact Details</a>
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
<script src="pds/pds_personal.js"></script>