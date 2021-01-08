<?php
$title = "Signatories Setup";
require_once "header.php";
?>
<div id="app">
    <div class="ui fluid container" style="margin: 5px;">
        <div class="ui borderless blue inverted mini menu">
            <div class="left item" style="margin-right: 0px !important;">
                <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
                    <i class="icon chevron left"></i> Back
                </button>
            </div>
            <div class="item">
                <h3><i class="icon fancy pen"></i>Signatories</h3>
            </div>
            <div class="right item">

                <div class="ui right input">
                    <!-- <button class="ui icon mini green button" onclick="addModalFunc()" style="margin-right: 5px;" title="Add Detail"><i class="icon plus"></i>Add New Plantilla</button>
                    <a class="ui icon mini green button" href="plantilla_vacantpos.php" style="margin-right: 5px;" title="Create Publications"><i class="icon highlighter"></i> Create Publications</a>
                    <a class="ui icon mini green button" href="plantilla_report.php" style="margin-right: 5px;" title="Print Plantilla"><i class="icon print"></i> Print Plantilla</a>
                    <div class="ui icon fluid input" style="width: 300px;">
                        <input id="data_search" type="text" placeholder="Search...">
                        <i class="search icon"></i>
                    </div> -->
                </div>
            </div>
        </div>
    </div>

    <div class="ui container">
        <div class="ui segment">

            <h5 class="ui header block top attached">Current Signatory Setup</h5>
            <table class="ui celled structured compact small table bottom attached">
                <thead>
                    <tr class="center aligned">
                        <th>Options</th>
                        <th>Assigned</th>
                        <th>Position</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <template>
                        <tr class="center aligned" v-for="(role, index) in roles" :key="index">
                            <td>
                                <button class="ui icon mini green button" title="" @click="edit_mode(role)">
                                    <i class="icon edit"></i>
                                </button>
                            </td>
                            <td v-if="role.name">{{role.name}}</td>
                            <td v-if="role.name">{{role.position}}</td>
                            <td v-else colspan="2">UNASSIGNED</td>
                            <td>{{role.role}}</td>
                        </tr>
                    </template>
                    <tr class="center aligned">
                        <td colspan="3"></td>
                        <td>
                            <button class="ui icon mini green button" style="margin-right: 5px;" title="Add New Role" @click="add_new_role_modal"><i class="icon plus"></i>Add New Role</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- 
            <h5 class="ui header block top attached">History</h5>
            <table class="ui celled structured compact small table bottom attached">
                <thead>
                    <tr class="center aligned">
                        <th>Assigned</th>
                        <th>Position</th>
                        <th>Role</th>
                        <th>Period</th>
                    </tr>
                </thead>
                <tbody>
                    <template>
                        <tr class="center aligned" v-for="(signatoree, index) in signatorees" :key="index">
                            <td>{{signatoree.name}}</td>
                            <td>{{signatoree.position}}</td>
                            <td>{{signatoree.role}}</td>
                            <td>---</td>
                        </tr>
                    </template>
                </tbody>
            </table> -->
        </div>
        <!-- add modal start -->
        <div class="ui mini modal" id="add_new_role_modal">
            <div class="header">Add New Role</div>
            <div class="content">
                <form class="ui form" id="add_new_role_form" @submit.prevent="add_new_role_form_submit">
                    <div class="field">
                        <label>Role Title</label>
                        <input type="text" placeholder="Role Title" v-model="role_new">
                    </div>
                </form>
            </div>
            <div class="actions">
                <button form="add_new_role_form" type="submit" class="ui approve primary mini button"><i class="icon save"></i> Save</button>
                <button class="ui cancel red mini button"><i class="icon cancel"></i> Cancel</button>
            </div>
        </div>
        <!-- add modal end -->
        <!-- edit modal start -->
        <div class="ui mini modal" id="edit_role_assignment_modal">
            <div class="header">Edit Role Assignment</div>
            <div class="content">
                <form class="ui form" id="edit_role_assignment_form" @submit.prevent="edit_role_assignment_form_submit">
                    <div class="inline fields">
                        <!-- <label>Select from:</label> -->
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="is_internal" :value="1" v-model="signatory.is_internal">
                                <label>LGU Bayawan Personnel</label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="is_internal" :value="0" v-model="signatory.is_internal">
                                <label>External Personnel</label>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label>Signatory Role Title</label>
                        <input type="text" placeholder="Role Title" v-model="signatory.role" disabled>
                    </div>
                    <div :hidden="signatory.is_internal == 0">
                        <!-- <h4 class="ui dividing header">LGU Bayawan Personnel</h4> -->
                        <div class="field">
                            <label>Select Employee</label>
                            <select class="ui search dropdown" id="employees_dropdown">
                                <option value="">Name</option>
                                <template v-for="(employee, index) in employee_list">
                                    <option :value="employee.id" :key="index">{{employee.name}}</option>
                                </template>
                            </select>
                        </div>
                    </div>
                    <div :hidden="signatory.is_internal == 1">
                        <h4 class="ui dividing header">External Personnel</h4>
                        <div class="field">
                            <label>Name</label>
                            <input type="text" placeholder="Name" v-model="signatory.name">
                        </div>
                        <div class="field">
                            <label>Position</label>
                            <input type="text" placeholder="Position Title" v-model="signatory.position">
                        </div>
                    </div>

                </form>
            </div>
            <div class="actions">
                <button form="edit_role_assignment_form" type="submit" class="ui approve primary mini button"><i class="icon save"></i> Save</button>
                <button class="ui cancel red mini button"><i class="icon cancel"></i> Cancel</button>
            </div>
        </div>
        <!-- edit modal end -->

    </div>
</div>

<script>
    new Vue({
        el: "#app",
        data() {
            return {
                role_new: "",
                signatory: {
                    id: 0,
                    role: "",
                    is_internal: 0,
                    employee_id: 0,
                    name: "",
                    position: "",
                },
                roles: [],
                signatorees: [],
                employee_list: []
            }
        },
        methods: {
            add_new_role_modal() {
                $("#add_new_role_modal").modal("show").modal({
                    onDeny: () => {
                        this.role_new = ""
                    }
                });
            },

            add_new_role_form_submit() {
                // on success
                $.post("signatories_proc.php", {
                        add_new_role: true,
                        role: this.role_new
                    },
                    (data, textStatus, jqXHR) => {
                        console.log("submitted");
                        this.role_new = ""
                        this.get_roles()
                    }
                );
            },

            edit_mode(edit_item) {
                this.signatory = Object.assign({}, edit_item)
                // console.log(edit_item);
                $("#employees_dropdown").dropdown("set selected", edit_item.employee_id);

                if (edit_item.is_internal == 1) {
                    this.signatory.name = ""
                    this.signatory.position = ""
                }

                $("#edit_role_assignment_modal").modal("show").modal({
                    onDeny: () => {
                        $("#employees_dropdown").dropdown("clear");
                        this.signatory.employee_id = 0
                        this.signatory.name = ""
                        this.signatory.position = ""
                    },
                });
            },

            edit_role_assignment_form_submit() {
                $.post("signatories_proc.php", {
                        update_assignment: true,
                        data: this.signatory    
                    },
                    (data, textStatus, jqXHR) => {
                        // console.log(data);
                        this.get_roles()
                    },
                    "json"
                );

            },

            get_roles() {
                $.post("signatories_proc.php", {
                        get_roles: true
                    },
                    (data, textStatus, jqXHR) => {
                        this.roles = Object.assign([], data);
                    },
                    "json"
                );
            },

            get_employee_list() {
                $.post("signatories_proc.php", {
                        get_employee_list: true
                    },
                    (data, textStatus, jqXHR) => {
                        this.employee_list = Object.assign([], data);
                    },
                    "json"
                );
            }
        },
        created() {
            // this.init_load()
            this.get_roles()
            this.get_employee_list()
        },
        mounted() {
            $('.ui.checkbox').checkbox();
            $("#employees_dropdown").dropdown({
                showOnFocus: false,
                fullTextSearch: true,
                // allowAdditions: true,
                selectOnKeydown: false,
                forceSelection: false,
                onChange: (value, text, $choice) => {
                    // console.log("onChange", !isNaN(value));
                    this.signatory.employee_id = value;
                },
            });
        },
    })
</script>
<?php
require_once "footer.php";
?>