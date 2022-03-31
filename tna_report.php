<?php $title = "Report - Training Needs Analysis (TNA)";
require_once "header.php"; ?>
<div id="tna-report-app">
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
            <!-- content end -->

            <!-- content report -->
            <div class="ui segment ">
                <div class="ui middle aligned divided list">
                    <table class="ui fixed table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Highlights of Accomplishments as a team /unit / section</th>
                                <th>Employee performance issue within the department</th>
                                <th>Others</th>
                                <th>Improvement planning on workshop</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div class="left floated content">
                                <tr class="item" v-for="(item,i) in items" :key="i"
                                    style="vertical-align: middle !important;">
                                    <td>
                                        <div class="center aligned column w-50px">
                                            <!-- {{ item }} -->
                                            <div class="ui basic icon button" @click="openModal(item.id)"
                                                title="Quick Edit">
                                                <i class="ui green icon edit outline"></i>
                                            </div>
                                            <div class="ui basic icon button" @click="deleteEntry(item.id)"><i
                                                    class="ui icon trash alternate red outline"></i></div>
                                        </div>
                                    </td>
                                    <td>{{item.highlights}}</td>
                                    <td>{{item.performance_issues}}</td>
                                    <td>{{item.performance_issues_others}} </td>
                                    <td>{{item.areas_of_improvement}}</td>
                                </tr>
                            </div>
                        </tbody>
                    </table>
                </div>

                <!-- Modal form -->
                <div class="active">
                    <div class="ui fullscreen modal" id="editModal">
                        <i class="close icon"></i>
                        <div class="header" style="text-align:center">
                            Update Form
                        </div>
                        <div class="ui segment">
                            <form class="ui form" @submit.prevent="">

                                <div class="field">
                                    <label>1.) What are the highlights of your accomplishment as a team / unit /
                                        section?</label>
                                    <textarea type="text" id="highlightsEdit" name="highlights"
                                        v-model="formData.highlights" placeholder="Type here..."
                                        value="<?php echo $row['item.highlights'];?>">  </textarea>
                                </div>
                                <div class="field">
                                    <label>2.) Please identify hree employee performance issues within your
                                        department?</label>

                                    <div v-for="(issue, i) in performance_issues_options" :key="i">
                                        <div class="ui checkbox" style="padding:2px">
                                            <input id="inputCheckboxEdit
                                            " type="checkbox" :value="issue" v-model="formData.performance_issues">
                                            <label>{{issue}}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="field">
                                    <label>
                                        Others:
                                    </label>
                                    <input id="inputOthersEdit" type="text" v-model="formData.performance_issues_others"
                                        name="others" placeholder="Type here...">
                                </div>
                                <div class="field">
                                    <label> 3.) Areas for improvement that you wish to address in the strategic planning
                                        workshop?
                                    </label>
                                    <input id="inputImprovementEdit" type="text" v-model="formData.areas_of_improvement"
                                        name="areas_of_improvement" placeholder="Type here...">
                                </div>

                                <!-- <input type="hidden" name="edit_modal" id="edit_modal" />   -->

                            </form>
                        </div>
                        <div class="actions">
                            <button class="ui approve button green" type="button">
                                Submit
                            </button>
                        </div>
                    </div>

                </div>
                <!-- End Modal Form -->
                <!-- end content report -->
            </div>
    </template>
</div>
<script>
var tnaentries = new Vue({
    el: "#tna-report-app",
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
                performance_issues_others: '',
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
            await $.post("tna_report_proc.php", {
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
            await $.post("tna_report_proc.php", {
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
            // console.log(this);
            this.addNewEntry().then(() => {
                this.getEntries()
                this.formData = JSON.parse(JSON.stringify(this))
            })
        },
        async addNewEntry() {
            await $.post("tna_report_proc.php", {
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
            $.post("tna_report_proc.php", {
                    getPersonnelTraining: true,
                    personneltrainings_id: this.id
                },
                (data, textStatus, jqXHR) => {
                    this.personneltraining = data
                },
                "json"
            );
        },

        
       

        openModal(id) {
            $.ajax({
                url: "tna_report_proc.php",
                method: "GET",
                data: {
                    pull_data: true,
                    training_needs_analysis_entries_id: id
                },
                dataType: "JSON",
                success: (item) => {
                    this.formData = item
                    console.log(item);
                }
            })

    
            $("#editModal").modal({
                onApprove: () => {
                    // console.log(this.formData);
                    $.post('tna_report_proc.php' , {
                        update_data: true,
                        training_needs_analysis_entries_id: id,
                        formData: this.formData
                    }, (data ,textStatus, xhr) => {
                        // this.data();
                        // console.log('test:',data);
                        this.getEntries()
                    });
                }
            }).modal("show")

        },
    },
    mounted() {
        this.getPersonnelTraining()
        this.getEntries()
        $('.ui.checkbox').checkbox();
    }
})
</script>

<?php require_once "footer.php"; ?>