<!-- 
 script at: appointments/config.js
-->
<div class="ui mini modal" id="aoo-editor-modal">
    <div class="header">
        Oath of Office
    </div>
    <div class="image content">
        <div class="description">
            <div class="ui form">
                <div class="field">
                    <label for="address">Address:</label>
                    <!-- <input type="text" name="address" v-model="oathOfOffice.address" placeholder="Enter permanent address..."> -->
                    <textarea name="address" id="address" v-model="oathOfOffice.address" placeholder="Enter permanent address..." rows="3"></textarea>
                </div>
                <div class="field">
                    <label for="govId_type">Government ID Type:</label>
                    <input type="text" name="govId_type" v-model="oathOfOffice.govId_type" placeholder="Enter Government ID Type...">
                </div>
                <div class="field">
                    <label for="govId_no">Government ID No:</label>
                    <input type="text" name="govId_no" v-model="oathOfOffice.govId_no" placeholder="Enter ID number...">
                </div>
                <div class="field">
                    <label for="govId_issued_date">Date Issued:</label>
                    <input type="date" name="govId_issued_date" v-model="oathOfOffice.govId_issued_date">
                </div>
                <div class="field">
                    <label for="sworn_date">Sworn Date:</label>
                    <input type="date" name="sworn_date" v-model="oathOfOffice.sworn_date">
                </div>
                <div class="field">
                    <label for="sworn_in">Sworn In:</label>
                    <input type="text" name="sworn_in" v-model="oathOfOffice.sworn_in" placeholder="Enter address of oath taking...">
                </div>
                <div class="field">
                    <label for="appointing_authority">Appointing Authority:</label>
                    <input type="text" name="appointing_authority" v-model="oathOfOffice.appointing_authority" placeholder="Enter the appointing authority...">
                </div>
            </div>
        </div>
    </div>
    <div class="actions">
        <button class="ui mini basic deny button">
            Cancel
        </button>
        <button class="ui mini primary positive button" @click="saveOathOfOffice()">
            <i class="ui icon save"></i>Save
        </button>
        <button class="ui mini blue button" @click="saveOathOfOffice(1)">
            <i class="ui icon print"></i>Print
        </button>
    </div>
</div>