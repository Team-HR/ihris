<?php $title = "Entries - Training Needs Analysis (TNA)";
require_once "header.php"; ?>
<div id="tna-entries-app">
    <template>
        <div class="ui container">
            <div class="ui borderless blue inverted mini menu noprint">
                <div class="left item" style="margin-right: 0px !important;">
                    <button onclick="window.history.back();" class="blue ui icon mini button" title="Back" style="width: 65px;">
                        <i class="icon chevron left"></i> Back
                    </button>
                </div>
                <div class="item">
                    <h3><i class="icon compass outline"></i> L&D Training Needs Analysis /Entries</h3>
                </div>
                <div class="right item">
                    <div class="ui right input">
                        <a :href="'tna_report.php?id='+id" class="ui icon green mini button" style="margin-right: 5px;">View Report</a>
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

            <form id="myForm" class="ui form" @submit.prevent="submitEntry()">
                <div class="ui segment">
                    <div class="ui middle aligned divided list">
                        <div class="field">
                            <label for="department"> Department:</label>
                            <select id="department_select" class="ui fluid search selection dropdown" v-model="formData.department_id" name="departments">
                                <option value="department">Department</option>
                                <option v-for="data in departments" :value="data.id">{{ data.name }}</option>
                            </select>
                        </div>

                        <div class="field">
                            <label>1.) What are the highlights of your accomplishment as a team / unit / section?</label>
                            <input type="text" v-model="formData.highlights" name="highlights" placeholder="Type here...">
                        </div>

                        <div class="field">
                            <label>2.) Please identify three employee performance issues within your department?</label>`
                            <div v-for="(issue, i) in performance_issues_options" :key="i">
                                <div class="ui checkbox">
                                    <input v-model="formData.performance_issues" type="checkbox" :value="issue" tabindex="0" class="hidden">
                                    <label>{{issue}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label>
                                Others:
                            </label>
                            <input v-model="formData.performance_issues_others" type="text" name="others" placeholder="Type here...">
                        </div>
                        <div class="field">
                            <label> 3.) Areas for improvement that you wish to address in the strategic planning workshop?
                            </label>
                            <input v-model="formData.areas_of_improvement" type="text" name="areas_of_improvement" placeholder="Type here...">
                        </div>
                    </div>
                    <button class="ui button" type="submit" id="myBtn">Submit</button>
                    <button class="reset-btn ui button one" type='button' value="submit" disabled id="dis_myBtn" @click="update()" onclick="enableBtn2();enableBtn1();myFunction()">Update</button>
                </div>
            </form>

            <div class="ui segment container">
                <div class="ui middle aligned divided list">
                    <div class="item" v-for="(item,i) in items" :key="i" style="vertical-align: middle !important;">
                        <!-- <div class="left floated content">
                            <div class="ui basic icon button" @click="edit(item.id)"><i class="ui green icon edit outline"></i></div>
                        </div> -->
                        <div class="right floated content">
                            <div class="ui basic icon button" @click="get_Entries(item.id)" onclick="scrollToTop();disableBtn();enableBtn() ">
                                <i class="ui green icon edit outline"></i>
                            </div>
                            <div class="ui basic icon button" @click="deleteEntry(item.id)">
                                <i class="ui icon trash alternate red outline"></i>
                            </div>
                        </div>
                        <div class="content">
                            <span>{{item.departments}}</span><br>
                            <span><strong>Highlights: </strong>{{item.highlights}}</span><br>
                            <span><strong>Performance Issue: </strong>{{item.performance_issues}}</span><br>
                            <span><strong>Others: </strong>{{item.performance_issues_others}}</span><br>
                            <span><strong>Improvement: </strong>{{item.areas_of_improvement}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content end -->
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
                    'Punctuality',
                ],
                departments: [],

                formData: {
                    // entry_id:'',
                    department_id: '',
                    department_name: '',
                    highlights: '',
                    performance_issues: [],
                    performance_issues_others: '',
                    areas_of_improvement: ''
                },
                formDataCleared: {
                    department_id: '',
                    highlights: '',
                    performance_issues: [],
                    performance_issues_others: '',
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
            getDepartments() {
                $.post("tna_entries_proc.php", {
                        getDepartments: true,
                    },
                    (data, textStatus, jqXHR) => {
                        this.departments = data
                        console.log(data);
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
                console.log(this.formData);
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
            },

            get_Entries(id) {
                $.ajax({
                    url: "tna_entries_proc.php",
                    method: "GET",
                    data: {
                        pull_data: true,
                        training_needs_analysis_entries_id: id
                    },
                    dataType: "JSON",
                    success: (item) => {
                        this.formData = item
                        console.log(item);
                        $('#department_select').dropdown('set selected', item.department_id)
                    }
                })
            },

            update() {
                $.post('tna_entries_proc.php', {
                    update_data: true,
                    department_id: this.id,
                    training_needs_analysis_entries_id: this.formData.id,
                    formData: this.formData
                }, (data, textStatus, xhr) => {
                    this.getEntries()
                    this.formData = JSON.parse(JSON.stringify(this.formDataCleared))
                });
                console.log(this.formData);
            },
        },
        mounted() {
            this.getPersonnelTraining()
            this.getEntries()
            this.getDepartments()
            $('.ui.checkbox').checkbox();
        },
    })

    //JS functions
    $('.button.one').on('click', function() {
        $('.ui.dropdown').dropdown('restore defaults');
    });
    $('select.dropdown')
        .dropdown({
            fullTextSearch: 'exact'
        });

    function scrollToTop() {
        $(window).scrollTop(180);
    }

    function disableBtn() {
        document.getElementById("myBtn").disabled = true;
    }

    function enableBtn() {
        document.getElementById("dis_myBtn").disabled = false;
    }

    function enableBtn1() {
        document.getElementById("dis_myBtn").disabled = true;
        document.getElementById("myForm").reset();
    }

    function enableBtn2() {
        document.getElementById("myBtn").disabled = false;
        document.getElementById("myForm").reset();
    }

    function myFunction() {
        document.getElementById("myForm").reset();
    }
</script>

<?php require_once "footer.php"; ?>