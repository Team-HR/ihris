<!-- 
 script at: appointments/config.js
-->
     <div class="ui modal" id="assumption-editor-modal">
        <div class="header">
            Certificate of Assumption
        </div>
        <div class="image content">
            <div class="description">

            </div>
        </div>
        <div class="actions">
            <button class="ui mini basic deny button">
                Cancel
            </button>
            <button class="ui mini primary positive button" @click="saveAssumption()">
                <i class="ui icon save"></i>Save
            </button>
            <button class="ui mini blue button" @click="saveAssumption(1)">
                <i class="ui icon print"></i>Print
            </button>
        </div>
    </div>
