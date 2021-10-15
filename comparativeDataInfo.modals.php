<div id="comparativeDataInfoModal">
    <template>
        <div class="ui modal" id="add_new_applicant_modal">
            <div class="header">Add New Applicant</div>
            <div class="content">

            </div>
        </div>
    </template>
</div>

<script>
    var comparativeDataInfoModal = new Vue({
        el: "#comparativeDataInfoModal",
        data() {
            return {

            }
        },
        methods: {
            add_new_modal(){
                $("#add_new_applicant_modal").modal("show")
            }
        }
    });
</script>