<?php $title = "NOSA (Casual)";
require_once "header.php";
?>

<div id="nosa-app" class="ui fluid container" style="padding: 5px;">
    <template>
        <div class="ui borderless blue inverted mini menu">
            <div class="left item" style="margin-right: 0px !important;">
                <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
                    <i class="icon chevron left"></i> Back
                </button>
            </div>
            <div class="item">
                <h3><i class="users icon"></i> Notice of Salary Adjustment</h3>
            </div>

            <div class="right item">
                <!-- <a href="print_employee_list.php" class="ui button " style="margin-right: 10px;">Print</a> -->
                <button onclick="addModalFunc()" class="green ui icon fluid button" style="margin-right: 10px;" title="Add Personnel">
                    <i class="icon user plus"></i> Add
                </button>
                <!-- <div class="ui icon input">
                <input id="employee_search" type="text" placeholder="Search...">
                <i class="search icon"></i>
            </div> -->
            </div>
        </div>
        <!-- list of NOSA folders start-->

        <div class="ui fluid segment">
            <h1>Notice of Salary Adjustment (Casual)</h1>

            <?php

            if (!isset($_GET["folder"])) {

            ?>

                <table class="ui table" style="width: 900px;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th></th>
                            <th>Letter Date</th>
                            <th>New Salary</th>
                            <th>Old Salary</th>
                            <th>Date Effectivity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="folder, i in folders" :key="folder.id">
                            <td>{{i+1}}</td>
                            <td><a href="nosa.php?folder=1" class="ui mini primary button"><i class="ui icon folder"></i> Open</a></td>
                            <td>{{folder.dateString}}</td>
                            <td>{{folder.default_new_salary}}</td>
                            <td>{{folder.default_salary}}</td>
                            <td>{{folder.date_effective}}</td>
                        </tr>
                    </tbody>
                </table>

            <?php
            } else {
            ?>
                <!-- {{numSelected}} -->
                <!--folder records show here start -->
                <!-- <a href="forms/notice_of_salary_adjustment_casual.pdf.php?ids=1,2,3,4" target="_blank">Test Print</a> -->
                <button class="ui button primary" @click="getChecked()"><i class="ui icon print"></i> Print Selected</button>
                <table class="ui compact table" style="width: 1000px;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>New Rate</th>
                            <th>Old Rate</th>
                            <th>Checked</th>
                            <th>Option</th>
                            <th>Created at</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item,i in items" :key="item.id" :style="item.is_checked?'background-color: #d5f5d9;':''">
                            <td>{{i+1}}.)</td>

                            <td>{{item.honorific}} {{item.full_name}}</td>
                            <td>{{item.new_salary}}</td>
                            <td>{{item.old_salary}}</td>
                            <td style="text-align: center;">
                                <div class="ui large checkbox">
                                    <input type="checkbox" name="example" :value="item.id" ref="checks" :checked="item.is_checked" @change="(e)=>{changeCheck(e,item)}">
                                    <label></label>
                                </div>
                            </td>
                            <td>
                                <button @click="editItem(item)" class="ui basic mini button" style="width: 100px;"><i class="ui icon edit"></i> Edit</button>
                            </td>
                            <td>{{item.created_at}}</td>
                        </tr>
                    </tbody>
                </table>


                <!--folder records show here end -->
            <?php
            }
            ?>


        </div>

        <!-- list of NOSA folders end-->


        <div class="ui mini modal" id="editItemModal">
            <div class="header">
                Edit Details
            </div>
            <div class="content">

                <div class="ui form">
                    <div class="field">
                        <label>Title:</label>
                        <select name="title" id="title" v-model="editItemModel.honorific">
                            <option value="" disabled>Select title</option>
                            <option value="MR.">MR.</option>
                            <option value="MS.">MS.</option>
                            <option value="MRS.">MRS.</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Full Name:</label>
                        <input type="text" name="full_name" placeholder="Full name e.g JOHN C. DOE" v-model="editItemModel.full_name">
                    </div>
                    <div class="two fields">
                        <div class="field">
                            <label>New Salary:</label>
                            <input type="number" name="newSalary" v-model="editItemModel.new_salary">
                        </div>
                        <div class="field">
                            <label>Old Salary:</label>
                            <input type="number" name="oldSalary" v-model="editItemModel.old_salary">
                        </div>
                    </div>
                </div>


            </div>
            <div class="actions">
                <button class="ui deny button">
                    Cancel
                </button>
                <button class="ui right labeled icon button" @click="saveEdit()">
                    Save
                    <i class="save icon"></i>
                </button>
            </div>
        </div>


    </template>
</div>


<script>
    new Vue({
        el: "#nosa-app",
        data: {
            folders: [],
            folderInfo: {},
            items: [],
            checkedValues: [],
            editItemModel: {}
        },

        computed: {
            numSelected() {
                return this.checkedValues.length
            },
        },
        methods: {

            getChecked() {
                this.checkedValues = Array.from(this.$refs.checks)
                    .filter(c => c.checked)
                    .map(c => c.value);
                console.log(this.checkedValues);
                var ids = "";
                window.open("forms/notice_of_salary_adjustment_casual.pdf.php?ids=" + this.checkedValues.join(","), "_blank");
            },

            getFolders() {
                $.ajax({
                    type: "post",
                    url: "nosa.proc.php",
                    data: {
                        getFolders: true,
                    },
                    dataType: "json",
                    success: (response) => {
                        // console.log("get folders: ", response);
                        this.folders = response
                    },
                    async: false
                });
            },


            getFolderRecords() {
                const folderId = this.getFolderId();
                if (!folderId) return false;
                // console.log("folderId: ", folderId);
                this.getItems(folderId);

            },

            getItems(id) {
                $.ajax({
                    type: "post",
                    url: "nosa.proc.php",
                    data: {
                        getItems: true,
                        id: id
                    },
                    dataType: "json",
                    success: (response) => {
                        this.items = response
                        console.log("items:", this.items);
                    },
                    async: false
                });
            },

            getFolderId() {
                const urlParams = new URLSearchParams(window.location.search)
                const id = urlParams.get('folder')
                if (id) {
                    return id;
                } else return false
            },

            editItem(item) {
                // console.log(item);
                this.editItemModel = item;
                $("#editItemModal").modal({
                    closable: false
                }).modal('show')
            },

            changeCheck(e, item) {
                // console.log(e.target.value, e.target.checked);
                item.is_checked = e.target.checked
                $.ajax({
                    type: "post",
                    url: "nosa.proc.php",
                    data: {
                        changeCheck: true,
                        id: e.target.value,
                        is_checked: e.target.checked
                    },
                    dataType: "json",
                    // success: (response) => {
                    //     // this.items = response
                    //     console.log("response:", response);
                    // },
                    async: false
                });
            },

            saveEdit() {
                $.ajax({
                    type: "post",
                    url: "nosa.proc.php",
                    data: {
                        saveEdit: true,
                        details: this.editItemModel
                    },
                    dataType: "json",
                    success: (response) => {
                        $("#editItemModal").modal('hide')
                        // this.items = response
                        // console.log("response:", response);
                    },
                    async: false
                });
            }

        },
        mounted() {
            this.getFolders()
            this.getFolderRecords()

        }
    });
</script>

<?php require_once "footer.php"; ?>