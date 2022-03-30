<?php $title = "Entries - Training Needs Analysis (TNA)";
require_once "header.php"; ?>
<div id="tna-entries-app">
    <template>
        <div class="ui container">
            <div class="ui borderless blue inverted mini menu noprint">
                <div class="left item" style="margin-right: 0px !important;">
                    <button onclick="window.history.back();" class="blue ui icon mini button" title="Back"
                        style="width: 65px;">
                        <i class="icon chevron left"></i> Back
                    </button>
                </div>
                <div class="item">
                    <h3><i class="icon compass outline"></i> L&D Training Needs Analysis /Entries</h3>
                </div>
                <div class="right item">
                    <div class="ui right input">
                        <a :href="'tna_report.php?id='+personneltraining.personneltrainings_id"  class="ui icon green mini button " style="margin-right: 5px;">
                            <i class="file alternate outline icon">
                            </i>View Report</a>
                    </div>
                </div>
            </div>
            <!-- content start -->

            <div class="ui segment">
                <h1>{{personneltraining.training}}</h1>
                <p>
                    <strong>Start:</strong> {{personneltraining.startDate}} <br />
                    <strong>End:</strong> {{personneltraining.endDate}} <br />
                    <strong>Venue:</strong> {{personneltraining.venue}} <br />
                    <strong>Remarks:</strong> {{personneltraining.remarks}}
                </p>
            </div>

            <div class="ui segment">
                <form class="ui form" @submit.prevent="submitEntry()">
                    <div class="field">
                        <label>1.) What are the highlights of your accomplishment as a team / unit / section?</label>
                        <textarea type="text" v-model="formData.highlights" name="highlights"
                            placeholder="Type here..."></textarea>
                    </div>

                    <div class="field">
                        <label>2.) Please identify three employee performance issues within your department?</label>

                        <div v-for="(issue, i) in performance_issues_options" :key="i">
                            <div class="ui checkbox">
                                <input v-model="formData.performance_issues" type="checkbox" :value="issue" tabindex="0"
                                    class="hidden">
                                <label>{{issue}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label>
                            Others:
                        </label>
                        <input v-model="formData.others" type="text" name="others" placeholder="Type here...">
                    </div>
                    <div class="field">
                        <label> 3.) Areas for improvement that you wish to address in the strategic planning workshop?
                        </label>
                        <input v-model="formData.areas_of_improvement" type="text" name="areas_of_improvement"
                            placeholder="Type here...">
                    </div>

                    <button class="ui button green" type="submit">
                        Submit
                    </button>
                    <!-- <div class="ui basic icon button" @click="deleteEntry(item.id)"><i class="ui icon trash alternate red outline"></i></div> -->
                </form>

                
            </div>
            <!-- content end -->
        </div>
</div>


</template>
</div>


<script>
var tnaentries = new Vue({
    el: "#tna-entries-app",
    data() {
        return {
            id: new URLSearchParams(window.location.search).get("id"),
            personneltraining: {},
            items: [],
            performance_issues_options: [
                'Initiative',
                'Resourcefulness',
                'Efficiency',
                'Teamwork',
                'Attitude Towards Colleagues',
                'Time and Cost consciousness in Delivery of Service',
                'Professionalism in Delivery of Service',
                'Customer-Friendliness',
                'Responsiveness',
                'Panctuality',
            ],
            formData: {
                highlights: '',
                performance_issues: [],
                others: '',
                areas_of_improvement: ''
            },
            formDataCleared: {
                highlights: '',
                performance_issues: [],
                others: '',
                areas_of_improvement: ''
            }
        }
    },
    methods: {
        async deleteEntry(id) {
            await $.post("tna_entries_proc.php", {
                    deleteEntry: true,
                    id: id
                },
                (data, textStatus, jqXHR) => {
                    this.getEntries()
                },
                "json"
            );
        },
        async getEntries() {
            await $.post("tna_entries_proc.php", {
                    getEntries: true,
                    personneltrainings_id: this.id
                },
                (data, textStatus, jqXHR) => {
                    this.items = data
                },
                "json"
            );
        },
        submitEntry() {
            this.addNewEntry().then(() => {
                this.getEntries()
                this.formData = JSON.parse(JSON.stringify(this.formDataCleared))
            })
        },
        async addNewEntry() {
            await $.post("tna_entries_proc.php", {
                    addNewEntry: true,
                    personneltrainings_id: this.id,
                    formData: this.formData
                },
                (data, textStatus, jqXHR) => {
                    // console.log(data);
                },
                "json"
            );
        },
        getPersonnelTraining() {
            $.post("tna_entries_proc.php", {
                    getPersonnelTraining: true,
                    personneltrainings_id: this.id
                },
                (data, textStatus, jqXHR) => {
                    this.personneltraining = data
                },
                "json"
            );
        }

    },
    mounted() {
        this.getPersonnelTraining()
        this.getEntries()
        $('.ui.checkbox').checkbox();
    }
})
</script>




<?php require_once "footer.php"; ?>